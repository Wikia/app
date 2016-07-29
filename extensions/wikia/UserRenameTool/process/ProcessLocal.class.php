<?php

namespace UserRenameTool\Process;

class ProcessBaseLocal  extends ProcessBase {

	/**
	 * Stores the predefined tasks to do for every local wiki database.
	 * Here should be mentioned all core tables not connected to any extension.
	 *
	 * Task definition format:
	 *   'table' => (string) table name
	 *   'userid_column' => (string) column name with user ID or null if none
	 *   'username_column' => (string) column name with user name
	 *   'conds' => (array) additional conditions for the query
	 */
	static private $mLocalDefaults = [
		// Core MW tables
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'image', 'userid_column' => 'img_user', 'username_column' => 'img_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_by', 'username_column' => 'ipb_by_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[
			'table' => 'logging',
			'userid_column' => null,
			'username_column' => 'log_title',
			'conds' => [ 'log_namespace' => NS_USER ]
		],
		[ 'table' => 'oldimage', 'userid_column' => 'oi_user', 'username_column' => 'oi_user_text' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ],
		[ 'table' => 'user_newtalk', 'userid_column' => null, 'username_column' => 'user_ip' ],

		// Core 1.16 tables
		[ 'table' => 'logging', 'userid_column' => 'log_user', 'username_column' => 'log_user_text' ],
	];

	/**
	 * Stores the predefined tasks to do for every local wiki database for IP addresses.
	 * Here should be mentioned all core tables not connected to any extension.
	 */
	static private $mLocalIpDefaults = [
		[ 'table' => 'archive', 'userid_column' => 'ar_user', 'username_column' => 'ar_user_text' ],
		[ 'table' => 'filearchive', 'userid_column' => 'fa_user', 'username_column' => 'fa_user_text' ],
		[ 'table' => 'ipblocks', 'userid_column' => 'ipb_user', 'username_column' => 'ipb_address' ],
		[ 'table' => 'recentchanges', 'userid_column' => 'rc_user', 'username_column' => 'rc_user_text' ],
		[ 'table' => 'revision', 'userid_column' => 'rev_user', 'username_column' => 'rev_user_text' ]
	];

	/**
	 * Processes specific local wiki database and makes all needed changes for an IP address
	 *
	 * Important: should only be run within maintenace script (bound to specified wiki)
	 */
	public function updateLocalIP() {
		global $wgCityId, $wgUser;

		if ( !$this->isValidIP() ) {
			$this->addError( wfMessage( 'userrenametool-error-invalid-ip' )->escaped() );
			return;
		}

		$wgOldUser = $wgUser;
		$wgUser = \User::newFromName( 'Wikia' );

		$cityDb = \WikiFactory::IDtoDB( $wgCityId );
		$this->logInfo( "Processing wiki database: %s", $cityDb );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$tasks = self::$mLocalIpDefaults;

		$hookName = 'UserRename::LocalIP';
		$this->logInfo( "Broadcasting hook: %s" . $hookName );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		foreach ( $tasks as $task ) {
			$this->logInfo( 'Updating wiki "%s": %s:%s', $cityDb, $task['table'], $task['username_column'] );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

		$dbw->commit();

		$this->logInfo( "Finished updating wiki database: %s", $cityDb );

		if ( $this->mWarnings || $this->mErrors ) {
			$this->logFailWikiToStaff();
		} else {
			$this->logFinishWikiToStaff();
		}

		$wgUser = $wgOldUser;
	}

	/**
	 * Test whether this is an anonymous user and that the IP addresses used
	 * for this anonymous user's username are valid.
	 *
	 * @return bool
	 */
	protected function isValidIP() {
		return (
			$this->mUserId == 0 &&
			\IP::isIPAddress( $this->mOldUsername ) &&
			\IP::isIPAddress( $this->mNewUsername )
		);
	}

	/**
	 * Processes specific local wiki database and makes all needed changes
	 *
	 * Important: should only be run within maintenance script (bound to specified wiki)
	 *
	 * @throws \DBError
	 */
	public function updateLocal() {
		global $wgCityId, $wgUser;

		$wgOldUser = $wgUser;
		$wgUser = \User::newFromName( 'Wikia' );

		$cityDb = \WikiFactory::IDtoDB( $wgCityId );

		$this->logInfo( "Processing wiki database: %s", $cityDb );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		$tasks = self::$mLocalDefaults;

		$hookName = 'UserRename::Local';
		$this->logInfo( "Broadcasting hook: %s", $hookName );
		wfRunHooks(
			$hookName,
			[ $dbw, $this->mUserId, $this->mOldUsername, $this->mNewUsername, $this, $wgCityId, &$tasks ]
		);

		$this->moveUserPages( $dbw, $cityDb );
		$this->performTableUpdateTasks( $cityDb, $dbw );
		$this->resetEditCountWiki();

		$dbw->commit();

		// Save entry in local Special:Log
		$this->addLocalLog(
			wfMessage( 'userrenametool-success', $this->mOldUsername, $this->mNewUsername )
				->inContentLanguage()
				->text()
		);

		$this->logInfo( "Finished updating wiki database: %s", $cityDb );

		if ( $this->mWarnings || $this->mErrors ) {
			$this->logFailWikiToStaff();
		} else {
			$this->logFinishWikiToStaff();
		}

		$this->invalidateUserCache( $this->mOldUsername );
		$this->invalidateUserCache( $this->mNewUsername );

		$wgUser = $wgOldUser;
	}

	protected function moveUserPages( \DatabaseBase $dbw, $cityDb ) {
		$this->logInfo( "Moving user pages." );

		try {
			$oldTitle = \Title::makeTitle( NS_USER, $this->mOldUsername );
			$newTitle = \Title::makeTitle( NS_USER, $this->mNewUsername );

			$pages = $this->getUserPages( $oldTitle, $dbw );

			while ( $row = $dbw->fetchObject( $pages ) ) {
				$this->moveUserPage( $row, $cityDb, $oldTitle, $newTitle );
			}
			$dbw->freeResult( $pages );
		} catch ( \DBError $e ) {
			// re-throw DB related exceptions instead of silently ignoring them (@see PLATFORM-775)
			throw $e;
		} catch ( \Exception $e ) {
			$this->logInfo(
				"Exception while moving pages: %s in %s at line %d",
				$e->getMessage(), $e->getFile(), $e->getLine()
			);
		}
	}

	/**
	 * Move the user page to the new username.
	 *
	 * @param Object $row
	 * @param int $cityDb
	 * @param \Title $oldTitle
	 * @param \Title $newTitle
	 */
	protected function moveUserPage( $row, $cityDb, \Title $oldTitle, \Title $newTitle ) {
		$oldPage = \Title::makeTitleSafe( $row->page_namespace, $row->page_title );
		$updatedPageTitle = preg_replace( '!^[^/]+!', $newTitle->getDBkey(), $row->page_title );
		$newPage = \Title::makeTitleSafe( $row->page_namespace, $updatedPageTitle );

		if ( !$this->canMoveUserPage( $cityDb, $newPage, $oldPage ) ) {
			return;
		}

		$this->logInfo(
			"Moving page %s in namespace %s to %s",
			$oldPage->getText(), $row->page_namespace, $newTitle->getText()
		);
		$success = $oldPage->moveTo(
			$newPage,
			false,
			wfMessage( 'userrenametool-move-log', $oldTitle->getText(), $newTitle->getText() )
				->inContentLanguage()
				->text()
		);

		if ( $success === true ) {
			$this->logInfo(
				'Updating wiki "%s": User page %s moved to %s',
				$cityDb, $oldPage->getText(), $newPage->getText()
			);
		} else {
			$this->logInfo(
				'Updating wiki "%s": User page %s could not be moved to %s',
				$cityDb, $oldPage->getText(), $newPage->getText()
			);
			$this->addWarning(
				wfMessage( 'userrenametool-page-unmoved', [ $oldPage->getText(), $newPage->getText() ] )
					->inContentLanguage()
					->text()
			);
		}
	}

	/**
	 * Test whether we can move the user page
	 *
	 * @param int $cityDb
	 * @param \Title $newPage
	 * @param \Title $oldPage
	 *
	 * @return bool
	 */
	protected function canMoveUserPage( $cityDb, \Title $newPage, \Title $oldPage ) {
		// Do not autodelete or anything, title must not exist
		// Info: The other case is when renaming is repeated - no action should be taken
		if ( $newPage->exists() && !$oldPage->isValidMoveTarget( $newPage ) ) {
			$this->logInfo(
				'Updating wiki "%s": User page %s already exists, moving cancelled.',
				$cityDb, $newPage->getText()
			);
			$this->addWarning(
				wfMessage( 'userrenametool-page-exists', $newPage->getText() )->inContentLanguage()->text()
			);
			return false;
		}

		return true;
	}

	/**
	 * Updates a list of tables in the local wiki to have the new username
	 *
	 * @param int $cityDb
	 * @param \DatabaseBase $dbw
	 */
	protected function performTableUpdateTasks( $cityDb, $dbw ) {
		$tasks = self::$mLocalDefaults;

		foreach ( $tasks as $task ) {
			$this->logInfo( 'Updating wiki "%d": %s:%s', $cityDb, $task['table'], $task['username_column'] );
			$this->renameInTable(
				$dbw,
				$task['table'],
				$this->mUserId,
				$this->mOldUsername,
				$this->mNewUsername,
				$task
			);
		}

	}

	/**
	 * Reset local editcount for renamed user and fake user
	 */
	private function resetEditCountWiki() {
		// Renamed user
		$uss = new \UserStatsService( $this->mUserId );
		$uss->calculateEditCountWiki();

		// FakeUser
		if ( $this->mFakeUserId != 0 ) {
			$uss = new \UserStatsService( $this->mFakeUserId );
			$uss->calculateEditCountWiki();
		} else {
			// use OldUsername if FakeUser isn't set
			$oldUser = \User::newFromName( $this->mOldUsername );
			$uss = new \UserStatsService( $oldUser->getId() );
			$uss->calculateEditCountWiki();
		}
	}

	/**
	 * Builds a query using the old user page title to get the user page plus all child pages.
	 * The query looks something like:
	 *
	 *   SELECT page_namespace, page_title
	 *   FROM page
	 *   WHERE page_namespace IN ('2','3','1200','1201','1202')
	 *     AND (page_title LIKE 'SomeUserName/%' OR page_title = 'SomeUserName')
	 *
	 * The namespaces used come from self::findAllowedUserNamespaces.
	 *
	 * @param \Title $oldTitle
	 * @param \DatabaseBase $dbw
	 * @return \ResultWrapper
	 */
	protected function getUserPages( \Title $oldTitle, \DatabaseBase $dbw ) {
		// Determine all namespaces which need processing
		$allowedNamespaces = $this->findAllowedUserNamespaces();

		$oldKey = $oldTitle->getDBkey();
		$like = $dbw->buildLike( sprintf( "%s/", $oldKey ), $dbw->anyString() );
		$pages = $dbw->select(
			'page',
			[ 'page_namespace', 'page_title' ],
			[
				'page_namespace' => $allowedNamespaces,
				'(page_title ' . $like . ' OR page_title = ' . $dbw->addQuotes( $oldKey ) . ')'
			],
			__METHOD__
		);
		$this->logInfo( "SQL: %s", $dbw->lastQuery() );

		return $pages;
	}

	/**
	 * Checks which namespaces where user content is found are enabled on the current wiki
	 *
	 * @return array
	 */
	protected function findAllowedUserNamespaces() {
		// Determine all namespaces which need processing
		$allowedNamespaces = [ NS_USER, NS_USER_TALK ];

		// Blogs extension
		if ( defined( 'NS_BLOG_ARTICLE' ) ) {
			$allowedNamespaces = array_merge( $allowedNamespaces, [ NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK ] );
		}

		// NY User profile
		if ( defined( 'NS_USER_WIKI' ) ) {
			$allowedNamespaces = array_merge(
				$allowedNamespaces,
				[
					NS_USER_WIKI,
					201 // NS_USER_WIKI_TALK
				]
			);
		}

		if ( defined( 'NS_USER_WALL' ) ) {
			$allowedNamespaces = array_merge(
				$allowedNamespaces,
				[ NS_USER_WALL, NS_USER_WALL_MESSAGE, NS_USER_WALL_MESSAGE_GREETING ]
			);
		}

		return $allowedNamespaces;
	}
}