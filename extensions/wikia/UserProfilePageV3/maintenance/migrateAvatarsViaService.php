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
	private $dfsProxy = '';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t perform any operations [default]' );
		$this->addOption( 'force', 'Perform the migration' );

		$this->addOption( 'from', 'User ID to start the migration from' );
		$this->addOption( 'to', 'User ID to stop the migration at' );
		$this->addOption( 'ids', 'Comma-separated list of user IDs to perform the migration for' );

		$this->addOption( 'dfs-dc', 'DFS cluster to use to get the old avatars [sjc|res]' );

		$this->mDescription = 'This script migrates the user avatars from DFS to user avatars service';
	}

	public function execute() {
		$this->output( date( 'r' ) . "\n" );

		// read options
		// --dry-run
		$this->isDryRun = $this->hasOption( 'dry-run' ) || !$this->hasOption( 'force' );
		if ( $this->isDryRun ) $this->output( "Running in dry-run mode!\n\n" );

		// --dfs-dc=sjc|res
		global $wgFSSwiftDC;
		$dc = $this->getOption( 'dfs-dc', 'sjc' );
		$this->dfsProxy = $wgFSSwiftDC[ $dc ][ 'server' ];
		$this->output( "Will use DFS cluster in '{$dc}' via {$this->dfsProxy}\n\n" );


		$this->output( "Getting the list of all accounts...\n" );

		// handle --from and --to options
		$where = [];

		if ($this->hasOption('from')) $where[] = sprintf( 'user_id >= %d', $this->getOption( 'from' ) );
		if ($this->hasOption('to'))   $where[] = sprintf( 'user_id <= %d', $this->getOption( 'to' ) );
		if ($this->hasOption('ids'))  $where[] = sprintf( 'user_id IN (%s)', $this->getOption( 'ids' ) );

		// get all accounts
		$db = $this->getDB( DB_SLAVE );

		$res = $db->select(
			'`user`',
			'user_id AS id',
			$where,
			__METHOD__,
			[
				'ORDER BY' => 'user_id'
			]
		);

		$rows = $res->numRows();
		$this->output( "Query: {$db->lastQuery()}\n" );
		$this->output( "Processing {$rows} users...\n" );

		$this->output( "Will start in 5 seconds...\n" );
		sleep( 5 );

		// process users
		foreach ( $res as $n => $row ) {
			try {
				$user = User::newFromId( $row->id );
				$this->output( sprintf( "\n%d (%.2f%%) [User #%d / %s]: ", ( $n + 1 ), ( ( $n + 1 ) / $rows * 100 ), $user->getId(), $user->getName() ) );
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

		$this->output( "Done!\n" );
		$this->output( date( 'r' ) . "\n" );
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
		if ( is_null( $avatar ) || $avatar === '' ) {
			$this->output( 'no avatar set - skipping' );
			return;
		}

		// no need to store default avatars in user properties - remove the entry
		else if ( self::isDefaultAvatar( $avatar ) ) {
			$this->output( 'default avatar set - removing an attribute' );

			$this->setAvatarUrl( $user, '' );
		}
		// predefined avatar (Avatar*.jpg)
		else if ( self::isPredefinedAvatar( $avatar ) ) {
			// store the full URL in user properties
			$masthead = Masthead::newFromUser( $user );
			$avatarUrl = $masthead->getPurgeUrl(); # e.g. http://images.wikia.com/messaging/images//1/19/Avatar.jpg

			$this->output( "predefined avatar set <{$avatar}> - setting a full URL: <{$avatarUrl}>" );

			$this->setAvatarUrl( $user, $avatarUrl );
		}
		// custom, old avatar - upload via avatars service
		else if ( !self::isNewAvatar( $avatar ) ) {
			$service = new UserAvatarsService( $user->getId() );

			// fetch the user-uploaded avatar
			$masthead = Masthead::newFromUser( $user );
			$avatarUrl = $masthead->getPurgeUrl();

			$this->output( sprintf( 'uploading <%s>', $avatarUrl ) );

			if ( $this->isDryRun ) return;

			$avatarContent = Http::get( $avatarUrl, 'default', [ 'proxy' => $this->dfsProxy ] );
			if ( empty( $avatarContent ) ) {
				$this->setAvatarUrl( $user, '' );
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
			$this->output( sprintf( 'avatar set to <%s> - looks like a new URL - skipping', $avatar ) );
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
	 * Return true if a given URL is for the predefined avatar
	 *
	 * Avatar2.jpg
	 * Avatar6.jpg
	 *
	 * See AvatarsMigratorTest for examples
	 *
	 * @param string $url
	 * @returm boolean
	 */
	public static function isPredefinedAvatar( $url ) {
		return startsWith( $url, 'Avatar' );
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
	 * Save the avatar URL for a given user in user_properties and commit it to shared database
	 *
	 * @param User $user
	 * @param string $avatarUrl
	 */
	protected function setAvatarUrl( User $user, $avatarUrl ) {
		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'old_attr'  => $user->getGlobalAttribute( AVATAR_USER_OPTION_NAME ),
			'new_attr'  => $avatarUrl,
			'user_id'   => $user->getId(),
			'user_name' => $user->getName(),
		] );

		# skip when in dry-run mode
		if ( $this->isDryRun ) return;

		$user->setGlobalAttribute( AVATAR_USER_OPTION_NAME, $avatarUrl );

		$user->saveSettings();
		$this->getDB( DB_MASTER )->commit( __METHOD__ );
	}

	/**
	 * Return shared DB connector
	 *
	 * @param int $db DB_SLAVE|DB_MASTER
	 * @return DatabaseBase
	 */
	protected function getDB( $db = DB_SLAVE ) {
		global $wgExternalSharedDB;
		return wfGetDB( $db, [], $wgExternalSharedDB );
	}
}

$maintClass = AvatarsMigrator::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
