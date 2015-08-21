<?php

/**
 * Script migrates the user avatars from DFS to user avatars service
 *
 * @see PLATFORM-1419
 *
 * @author Macbre
 * @ingroup Maintenance
 */

putenv( 'SERVER_ID=177' ); // run in the context of a community wiki

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class AvatarsMigratorException extends Exception {}

/**
 * Maintenance script class
 */
class AvatarsMigrator extends Maintenance {

	public function execute() {
		$this->output( "Getting the list of all accounts...\n" );

		// get all accounts
		global $wgExternalSharedDB;
		$db = $this->getDB( DB_SLAVE, [], $wgExternalSharedDB );

		$res = $db->select(
			'`user`',
			'user_id AS id',
			[],
			__METHOD__
		);

		// process users
		foreach ( $res as $row ) {
			try {
				$this->processUser( User::newFromId( $row->id ) );
			}
			catch ( AvatarsMigratorException $e ) {
				\Wikia\Logger\WikiaLogger::instance()->error( __CLASS__, [
					'exception' => $e,
					'user_id'   => $user->getId(),
				] );

				$this->output( sprintf( "\n\t%s", $e->getMessage() ) );
			}
		}

		$this->output( "Processing {$res->numRows()} users...\n" );
	}

	/**
	 * Migrate the avatar of a given user
	 *
	 * @param User $user
	 * @throws AvatarsMigratorException
	 */
	private function processUser( User $user ) {
		$this->output( sprintf( "\n[User #%d]: ", $user->getId() ) );

		$avatar = $user->getGlobalAttribute( AVATAR_USER_OPTION_NAME );

		// no avatar set, skip this account
		if ( is_null( $avatar ) ) {
			$this->output( 'no avatar set - skipping' );
			return;
		}

		// no need to store default avatars in user properties - remove the entry
		else if ( self::isDefaultAvatar( $avatar ) ) {
			$this->output( 'default avatar set - removing an attribute' );
			$user->removeGlobalPreference( AVATAR_USER_OPTION_NAME );
			$user->saveSettings();
		}
		// TODO: predefined avatar (Avatar*.jpg)
		else if ( false ) {
			$this->output( 'predefined avatar set - setting a full URL' );

			// TODO: // set the full URL using user properties service
		}
		// custom, old avatar - upload via avatars service
		else if ( !self::isNewAvatar( $avatar ) ) {
			$service = new UserAvatarsService( $user->getId() );

			// fetch the user-uploaded avatar
			$masthead = Masthead::newFromUser( $user );
			$avatarUrl = $masthead->getPurgeUrl();
			$avatarContent = Http::get( $avatarUrl );

			$this->output( sprintf( 'uploading <%s>', $avatarUrl ) );

			if ( empty( $avatarContent ) ) {
				throw new AvatarsMigratorException( 'Avatar fetch failed' );
			}

			// store it in temporary file
			$tmpFile = tempnam( wfTempDir(), 'avatar' );
			$res = file_put_contents( $tmpFile, $avatarContent );

			if ( $res === false ) {
				throw new AvatarsMigratorException( 'Avatar save to a temporary file failed' );
			}

			if ( $service->upload( $tmpFile ) !== UPLOAD_ERR_OK ) {
				unlink( $tmpFile );
				throw new AvatarsMigratorException( 'Avatar upload failed' );
			}
			unlink( $tmpFile );
		}
		else {
			$this->output( sprintf( 'avatar set to <%s> - looks like a new URL - skipping', $avatarUrl ) );
		}
	}

	/**
	 * Return true if a given URL is the default one
	 *
	 * See AvatarsMigratorTest for examples
	 *
	 * @param string $url
	 * @returm boolean
	 */
	public static function isDefaultAvatar( $url ) {
		return ( is_null( $url ) ) || ( $url === '' ) || ( strpos( $url, 'Avatar.jpg' ) !== false );
	}

	/**
	 * Is a given URL set for a new avatar (i.e. uploaded via avatars service)
	 *
	 * @param string $url
	 * @return boolean
	 */
	public static function isNewAvatar( $url ) {
		return !self::isDefaultAvatar( $url ) && startsWith( $url, 'http://' );
	}
}

$maintClass = AvatarsMigrator::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
