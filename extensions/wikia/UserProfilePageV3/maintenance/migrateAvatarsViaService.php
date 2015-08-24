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

	private $isDryRun = true;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption('dry-run', 'Don\'t perform any operations [default]');
		$this->addOption( 'force', 'Apply the changes made by the script' );

		$this->mDescription = 'This script migrates the user avatars from DFS to user avatars service';
	}

	public function execute() {
		// read options
		$this->isDryRun = $this->hasOption( 'dry-run' ) || !$this->hasOption( 'force' );

		if ($this->isDryRun) $this->output( "Running in dry-run mode!\n\n" );

		$this->output( "Getting the list of all accounts...\n" );

		// get all accounts
		$db = $this->getDB( DB_SLAVE );

		$res = $db->select(
			'`user`',
			'user_id AS id',
			[],
			__METHOD__
		);

		$rows = $res->numRows();
		$this->output( "Processing {$rows} users...\n" );

		// process users
		foreach ( $res as $n => $row ) {
			try {
				$user = User::newFromId( $row->id );
				$this->output( sprintf( "\n%d (%.2f%%) [User #%d / %s]: ", ($n+1), (($n+1) / $rows * 100), $user->getId(), $user->getName() ) );
				$this->processUser( $user );
			}
			catch ( AvatarsMigratorException $e ) {
				\Wikia\Logger\WikiaLogger::instance()->error( __CLASS__, [
					'exception' => $e,
					'user_id'   => $user->getId(),
				] );

				$this->output( sprintf( "\n\t%s", $e->getMessage() ) );
			}
		}
	}

	/**
	 * Migrate the avatar of a given user
	 *
	 * @param User $user
	 * @throws AvatarsMigratorException
	 */
	private function processUser( User $user ) {
		$avatar = $user->getGlobalAttribute( AVATAR_USER_OPTION_NAME );

		// no avatar set, skip this account
		if ( is_null( $avatar ) ) {
			$this->output( 'no avatar set - skipping' );
			return;
		}

		// no need to store default avatars in user properties - remove the entry
		else if ( self::isDefaultAvatar( $avatar ) ) {
			$this->output( 'default avatar set - removing an attribute' );

			if ($this->isDryRun) return;

			$user->removeGlobalPreference( AVATAR_USER_OPTION_NAME );
			$user->saveSettings();

			$this->getDB( DB_MASTER )->commit( __METHOD__ );
		}
		// TODO: predefined avatar (Avatar*.jpg)
		else if ( false ) {
			$this->output( 'predefined avatar set - setting a full URL' );

			if ($this->isDryRun) return;

			// TODO: // set the full URL using user properties service
		}
		// custom, old avatar - upload via avatars service
		else if ( !self::isNewAvatar( $avatar ) ) {
			$service = new UserAvatarsService( $user->getId() );

			// fetch the user-uploaded avatar
			$masthead = Masthead::newFromUser( $user );
			$avatarUrl = $masthead->getPurgeUrl();

			$this->output( sprintf( 'uploading <%s>', $avatarUrl ) );

			if ($this->isDryRun) return;

			$avatarContent = Http::get( $avatarUrl );
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

	/**
	 * @param int $db DB_SLAVE|DB_MASTER
	 * @return DatabaseBase
	 */
	protected function getDB($db = DB_SLAVE) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}
}

$maintClass = AvatarsMigrator::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
