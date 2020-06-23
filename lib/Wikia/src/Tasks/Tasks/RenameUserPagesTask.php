<?php
namespace Wikia\Tasks\Tasks;

use Title;
use User;
use Wikia;
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

			$newTitleText = preg_replace( "/$normalizedOldUsername/", $newUserName, $row->page_title );
			$newTitle = Title::makeTitleSafe( $row->page_namespace, $newTitleText );

			$editSummary =
				wfMessage( 'userrenametool-move-log', $title->getText(), $newTitle->getText() )
					->inContentLanguage()
					->text();

			$status = $title->moveTo( $newTitle, false, $editSummary, true, $robot );
			if ( $status !== true ) {
				$this->error(
					'UserRename: Failed to move page',
					[
						'status' => $status,
						'old_title_db_key' => $title->getDBkey(),
						'new_title_db_key' => $newTitle->getDBkey(),
					]
				);
				throw new \Exception( 'UserRename: Failed to move page' );
			}
			$title->invalidateCache();
		}

		global $wgEnableAbuseFilterExtension;
		if ( $wgEnableAbuseFilterExtension ) {
			$this->renameAbuseFilterMentions( $oldUserName, $newUserName );
		}

		$this->renameCheckUserMentions( $oldUserName, $newUserName );

		$user = User::newFromName( $newUserName );
		$user->deleteCache();
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
