<?php
namespace Wikia\Tasks\Tasks;

use Exception;
use Title;
use User;
use Wikia;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\Loggable;

class RenameUserPagesTask extends BaseTask {
	use Loggable;
	const NAMESPACES = [
		2, // User
		3, // User talk
		500, // User blog
		1200, // Message Wall
		1201, // Message Wall replies
		1202, // Message Wall Greeting
	];

	/**
	 * Normalized user names use spaces, while article names in database
	 * are stored with underscores instead of spaces.
	 *
	 * @see SUS-3560
	 *
	 * @param string $userName
	 * @return string
	 */
	private static function normalizeUserName( string $userName ) : string {
		return str_replace( ' ', '_', $userName );
	}

	/**
	 * Get wikis where this user has an user page, user blog, Message Wall etc.
	 * @param string $oldUserName
	 * @return int[] array of wiki IDs
	 */
	public static function getTargetCommunities( string $oldUserName ) {
		global $wgExternalDatawareDB;

		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );

		return $dbr->selectFieldValues( 'pages', 'page_wikia_id', [
			'page_namespace' => static::NAMESPACES,
			'page_title' => self::normalizeUserName( $oldUserName )
		], __METHOD__ , [ 'DISTINCT' ] );
	}

	public function renameLocalPagesAndMarkAsDone( int $renameLogId, string $oldUserName, string $newUserName ) {
		global $wgSpecialsDB, $wgCityId;
		$marker = [ 'rename_log_id' => $renameLogId ];
		try {
			$this->info( __METHOD__ . 'starting local rename', $marker );
			$this->renameLocalPages( $oldUserName, $newUserName );
			$this->info( __METHOD__ . 'local rename success', $marker );
			$dbw = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
			$dbw->update(
				'rename_log_details',
				[
					'finished' => wfTimestamp( TS_DB ),
					'was_successful' => true,
				],
				[ 'rename_log_id' => $renameLogId, 'wiki_id' => $wgCityId ]
			);
			$this->info( __METHOD__ . 'marked local rename success', $marker );
			ServiceFactory::instance()->ucpTaskFactory()
				->queue()->attemptToFinishRename( $renameLogId );
			$this->info( __METHOD__ . 'scheduled attempt to finish rename', $marker );
		} catch (Exception $e) {
			$this->error( __METHOD__ . 'failed to perform local rename ' . $e->getMessage(), $marker );
			throw $e;
		}
	}

	/**
	 * Rename local user related pages and their subpages to the new user name
	 *
	 * @param string $oldUserName
	 * @param string $newUserName
	 */
	public function renameLocalPages( string $oldUserName, string $newUserName ) {
		// SUS-3835: suppress watchlist emails triggered by UserRenameTool page renames
		global $wgEnotifWatchlist, $wgEnotifUserTalk, $wgCommandLineMode;
		/**
		 * Run rename as from command line to allow moving wall namespaces.
		 * @see \WallHooksHelper::onNamespaceIsMovable()
		 */
		$wgCommandLineMode = true;
		$wgEnotifWatchlist = false;
		$wgEnotifUserTalk = false;

		$dbr = wfGetDB( DB_SLAVE );
		$normalizedOldUsername = self::normalizeUserName( $oldUserName );

		$subPagesLikeQuery = $dbr->buildLike( "$normalizedOldUsername/", $dbr->anyString() );

		$resultSet = $dbr->select( 'page', '*', [
			'page_namespace' => static::NAMESPACES,
			'page_title = '. $dbr->addQuotes( $normalizedOldUsername ) . " OR page_title $subPagesLikeQuery"
		], __METHOD__ );

		$robot = $GLOBALS['wgUser'] = User::newFromName( Wikia::BOT_USER );

		foreach ( $resultSet as $row ) {
			$title = Title::newFromRow( $row );
			if ( $title->isRedirect() ) {
				$this->warning(
					'UserRename: Page is redirect. Skipping',
					[
						'page' => $title->getText(),
						'new_username' => $newUserName,
						'old_username' => $oldUserName,
					]
				);
				continue;
			}

			$newTitleText = preg_replace( "/$normalizedOldUsername/", $newUserName, $row->page_title );
			$newTitle = Title::makeTitleSafe( $row->page_namespace, $newTitleText );

			$editSummary =
				wfMessage( 'userrenametool-move-log', $title->getText(), $newTitle->getText() )
					->inContentLanguage()
					->text();

			$this->info(
				'UserRename: Moving page',
				[
					'namespace' => $title->getNsText(),
					'old_title_db_key' => $title->getDBkey(),
					'new_title_db_key' => $newTitle->getDBkey(),
				]
			);
			$createRedirect = !($title->isCssSubpage() || $title->isJsSubpage());
			$status = $title->moveTo( $newTitle, false, $editSummary, $createRedirect, $robot );
			if ( $status !== true ) {
				$this->error(
					'UserRename: Failed to move page',
					[
						'status' => $status,
						'namespace' => $title->getNsText(),
						'old_title_db_key' => $title->getDBkey(),
						'new_title_db_key' => $newTitle->getDBkey(),
					]
				);
				throw new Exception( 'UserRename: Failed to move page' );
			}
			$title->invalidateCache();
		}

		global $wgEnableAbuseFilterExtension;
		if ( $wgEnableAbuseFilterExtension ) {
			$this->renameAbuseFilterMentions( $oldUserName, $newUserName );
		}

		$this->renameCheckUserMentions( $oldUserName, $newUserName );

		User::newFromName( $newUserName )->deleteCache();
		User::newFromName( $oldUserName )->deleteCache();
	}

	private function renameCheckUserMentions( string $oldUsername, string $newUsername ): void {
		$this->changeUsernameReference(
			'cu_log',
			'cul_target_text',
			$oldUsername,
			$newUsername
		);
		$this->changeUsernameReference(
			'cu_log',
			'cul_user_text',
			$oldUsername,
			$newUsername
		);
		$this->changeUsernameReference(
			'cu_changes',
			'cuc_user_text',
			$oldUsername,
			$newUsername
		);
	}

	private function renameAbuseFilterMentions( string $oldUsername, string $newUsername ): void {
		$this->changeUsernameReference(
			'abuse_filter',
			'af_user_text',
			$oldUsername,
			$newUsername
		);
		$this->changeUsernameReference(
			'abuse_filter_history',
			'afh_user_text',
			$oldUsername,
			$newUsername
		);
		$this->changeUsernameReference(
			'abuse_filter_log',
			'afl_user_text',
			$oldUsername,
			$newUsername
		);
	}

	private function changeUsernameReference(
		string $table,
		string $usernameColumn,
		string $oldUsername,
		string $newUsername
	): void {
		$dbw = wfGetDB( DB_MASTER );
		if ( $dbw->fieldExists( $table, $usernameColumn ) ) {
			$dbw->update(
				$table,
				[$usernameColumn => $newUsername],
				[$usernameColumn => $oldUsername]
			);
		}
	}
}
