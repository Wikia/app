<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class AbuseFilterHooks {
	// So far, all of the error message out-params for these hooks accept HTML.
	// Hooray!

	/**
	 * Entry points for MediaWiki hook 'EditFilterMerged'
	 *
	 * @param $editor EditPage instance (object)
	 * @param $text Content of the edit box
	 * @param &$error Error message to return
	 * @param $summary Edit summary for page
	 * @return bool
	 */
	public static function onEditFilterMerged( $editor, $text, &$error, $summary ) {
		// Load vars
		$vars = new AbuseFilterVariableHolder;

		// Check for null edits.
		$oldtext = '';

		$article = $editor->getArticle();
		if ( $article->exists() ) {
			//Wikia Change Start - Jakub Olek
			$rev = $article->getRevision();
			if ( $rev instanceof Revision ) {
				// Make sure we load the latest text saved in database (bug 31656)
				$oldtext = $rev->getRawText();
			}
			//Wikia Change End
		}

		// Cache article object so we can share a parse operation
		$title = $editor->mTitle;
		$articleCacheKey = $title->getNamespace() . ':' . $title->getText();
		AFComputedVariable::$articleCache[$articleCacheKey] = $article;

		if ( strcmp( $oldtext, $text ) == 0 ) {
			// Don't trigger for null edits.
			return true;
		}

		global $wgUser;
		$vars->addHolder( AbuseFilter::generateUserVars( $wgUser ) );
		$vars->addHolder( AbuseFilter::generateTitleVars( $title , 'ARTICLE' ) );
		$vars->setVar( 'ACTION', 'edit' );
		$vars->setVar( 'SUMMARY', $summary );
		$vars->setVar( 'minor_edit', $editor->minoredit );

		$vars->setVar( 'old_wikitext', $oldtext );
		$vars->setVar( 'new_wikitext', $text );

		$vars->addHolder( AbuseFilter::getEditVars( $title, $article ) );

		$filter_result = AbuseFilter::filterAction( $vars, $title );

		if ( $filter_result !== true ) {
			global $wgOut;
			$wgOut->addHTML( $filter_result );
			$editor->showEditForm();
			return false;
		}
		return true;
	}

	public static function onGetAutoPromoteGroups( $user, &$promote ) {
		global $wgMemc;

		$key = AbuseFilter::autoPromoteBlockKey( $user );

		if ( $wgMemc->get( $key ) ) {
			$promote = array();
		}

		return true;
	}

	public static function onAbortMove( $oldTitle, $newTitle, $user, &$error, $reason ) {
		$vars = new AbuseFilterVariableHolder;

		global $wgUser;
		$vars->addHolder(
			AbuseFilterVariableHolder::merge(
				AbuseFilter::generateUserVars( $wgUser ),
				AbuseFilter::generateTitleVars( $oldTitle, 'MOVED_FROM' ),
				AbuseFilter::generateTitleVars( $newTitle, 'MOVED_TO' )
			)
		);
		$vars->setVar( 'SUMMARY', $reason );
		$vars->setVar( 'ACTION', 'move' );

		$filter_result = AbuseFilter::filterAction( $vars, $oldTitle );

		$error = $filter_result;

		return $filter_result == '' || $filter_result === true;
	}

	public static function onArticleDelete(
		WikiPage $article, User $user, $reason, &$error
	): bool {
		$vars = new AbuseFilterVariableHolder;

		global $wgUser;
		$vars->addHolder( AbuseFilter::generateUserVars( $wgUser ) );
		$vars->addHolder( AbuseFilter::generateTitleVars( $article->mTitle, 'ARTICLE' ) );
		$vars->setVar( 'SUMMARY', $reason );
		$vars->setVar( 'ACTION', 'delete' );

		$filter_result = AbuseFilter::filterAction( $vars, $article->mTitle );

		$error = $filter_result;

		return $filter_result == '' || $filter_result === true;
	}

	public static function onAbortNewAccount( $user, &$message ) {
		if ( $user->getName() == wfMsgForContent( 'abusefilter-blocker' ) ) {
			$message = wfMsg( 'abusefilter-accountreserved' );
			return false;
		}
		$vars = new AbuseFilterVariableHolder;
		// Add variables only for a registered user, so IP addresses of
		// new users won't be exposed
		global $wgUser;
		if ( $wgUser->getId() ) {
			$vars->addHolder( AbuseFilter::generateUserVars( $wgUser ) );
		}

		$vars->setVar( 'ACTION', 'createaccount' );
		$vars->setVar( 'ACCOUNTNAME', $user->getName() );

		$filter_result = AbuseFilter::filterAction(
			$vars, SpecialPage::getTitleFor( 'Userlogin' ) );

		$message = $filter_result;

		return $filter_result == '' || $filter_result === true;
	}

	public static function onRecentChangeSave( RecentChange $recentChange ) {
		$title = Title::makeTitle(
			$recentChange->mAttribs['rc_namespace'],
			$recentChange->mAttribs['rc_title']
		);
		$action = $recentChange->mAttribs['rc_log_type'] ?
			$recentChange->mAttribs['rc_log_type'] : 'edit';
		$actionID = implode( '-', [
			$title->getPrefixedText(),
			$recentChange->mAttribs['rc_user'] ?: $recentChange->getUserIp(),
			$action,
		] );

		if ( !empty( AbuseFilter::$tagsToSet[$actionID] )
			&& count( $tags = AbuseFilter::$tagsToSet[$actionID] ) )
		{
			ChangeTags::addTags(
				$tags,
				$recentChange->mAttribs['rc_id'],
				$recentChange->mAttribs['rc_this_oldid'],
				$recentChange->mAttribs['rc_logid']
			);
		}

		return true;
	}

	public static function onListDefinedTags( &$emptyTags ) {
		# This is a pretty awful hack.
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			array( 'abuse_filter_action', 'abuse_filter' ),
			'afa_parameters',
			array( 'afa_consequence' => 'tag', 'af_enabled' => true ),
			__METHOD__,
			array(),
			array( 'abuse_filter' => array( 'INNER JOIN', 'afa_filter=af_id' ) )
		);

		foreach ( $res as $row ) {
			$emptyTags = array_filter(
				array_merge( explode( "\n", $row->afa_parameters ), $emptyTags )
			);
		}

		return true;
	}

	/**
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		$dir = dirname( __FILE__ );

		if ( $updater->getDB()->getType() == 'mysql' || $updater->getDB()->getType() == 'sqlite' ) {
			if ( $updater->getDB()->getType() == 'mysql' ) {
				$updater->addExtensionUpdate( array( 'addTable', 'abuse_filter', "$dir/abusefilter.tables.sql", true ) );
				$updater->addExtensionUpdate( array( 'addTable', 'abuse_filter_history', "$dir/db_patches/patch-abuse_filter_history.sql", true ) );
			} else {
				$updater->addExtensionUpdate( array( 'addTable', 'abuse_filter', "$dir/abusefilter.tables.sqlite.sql", true ) );
				$updater->addExtensionUpdate( array( 'addTable', 'abuse_filter_history', "$dir/db_patches/patch-abuse_filter_history.sqlite.sql", true ) );
			}
			$updater->addExtensionUpdate( array( 'addField', 'abuse_filter_history', 'afh_changed_fields', "$dir/db_patches/patch-afh_changed_fields.sql", true ) );
			$updater->addExtensionUpdate( array( 'addField', 'abuse_filter', 'af_deleted', "$dir/db_patches/patch-af_deleted.sql", true ) );
			$updater->addExtensionUpdate( array( 'addField', 'abuse_filter', 'af_actions', "$dir/db_patches/patch-af_actions.sql", true ) );
			$updater->addExtensionUpdate( array( 'addField', 'abuse_filter', 'af_global', "$dir/db_patches/patch-global_filters.sql", true ) );
			if ( $updater->getDB()->getType() == 'mysql' ) {
				$updater->addExtensionUpdate( array( 'addIndex', 'abuse_filter_log', 'filter_timestamp', "$dir/db_patches/patch-fix-indexes.sql", true ) );
				$updater->addExtensionUpdate( array( 'modifyField', 'abuse_filter_log', 'afl_namespace', "$dir/db_patches/patch-afl-namespace_int.sql", true ) );
			} else {
				$updater->addExtensionUpdate( array( 'addIndex', 'abuse_filter_log', 'afl_filter_timestamp', "$dir/db_patches/patch-fix-indexes.sqlite.sql", true ) );
			}
		} elseif ( $updater->getDB()->getType() == 'postgres' ) {
			$updater->addExtensionUpdate( array( 'addTable', 'abuse_filter', "$dir/abusefilter.tables.pg.sql", true ) );
			$updater->addExtensionUpdate( array( 'addTable', 'abuse_filter_history', "$dir/db_patches/patch-abuse_filter_history.pg.sql", true ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'abuse_filter', 'af_actions', "TEXT NOT NULL DEFAULT ''" ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'abuse_filter', 'af_deleted', 'SMALLINT NOT NULL DEFAULT 0' ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'abuse_filter', 'af_global', 'SMALLINT NOT NULL DEFAULT 0' ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'abuse_filter_log', 'afl_wiki', 'TEXT' ) );
			$updater->addExtensionUpdate( array( 'addPgField', 'abuse_filter_log', 'afl_deleted', 'SMALLINT' ) );
			$updater->addExtensionUpdate( array( 'changeField', 'abuse_filter_log', 'afl_filter', 'TEXT' ) );
			$updater->addExtensionUpdate( array( 'addPgExtIndex', 'abuse_filter_log', 'abuse_filter_log_ip', "(afl_ip)" ) );
		} else {
			throw new MWException("No known Schema updates.");
		}

		// Create the Abuse Filter user.
		$user = User::newFromName( wfMsgForContent( 'abusefilter-blocker' ) );

		if ( $user && !$updater->updateRowExists( 'create abusefilter-blocker-user' ) ) {
			if ( !$user->getId() ) {
				$user->addToDatabase();
				$user->saveSettings();
				# Increment site_stats.ss_users
				$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
				$ssu->doUpdate();
			}
			// Wikia change - no action needed if user exists

			$updater->insertUpdateRow( 'create abusefilter-blocker-user' );
			# Promote user so it doesn't look too crazy.
			$user->addGroup( 'sysop' );
		}

		return true;
	}

	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgUser;
		if ( $wgUser->isAllowed( 'abusefilter-log' ) ) {
			$sk = $wgUser->getSkin();
			$tools[] = $sk->link(
				SpecialPage::getTitleFor( 'AbuseLog' ),
				wfMsg( 'abusefilter-log-linkoncontribs' ),
				array( 'title' =>
					wfMsgExt( 'abusefilter-log-linkoncontribs-text', 'parseinline' ) ),
				array( 'wpSearchUser' => $nt->getText() )
			);
		}
		return true;
	}

	public static function onUploadVerification( $saveName, $tempName, &$error ) {
		$vars = new AbuseFilterVariableHolder;

		global $wgUser;
		$title = Title::makeTitle( NS_FILE, $saveName );
		$vars->addHolder(
			AbuseFilterVariableHolder::merge(
				AbuseFilter::generateUserVars( $wgUser ),
				AbuseFilter::generateTitleVars( $title, 'FILE' )
			)
		);

		$vars->setVar( 'ACTION', 'upload' );
		$vars->setVar( 'file_sha1', sha1_file( $tempName ) ); // TODO share with save

		$filter_result = AbuseFilter::filterAction( $vars, $title );

		if ( is_string( $filter_result ) ) {
			$error = $filter_result;
		}

		return $filter_result == '' || $filter_result === true;
	}

	/**
	 * Adds global variables to the Javascript as needed
	 *
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( array &$vars ) {
		if ( AbuseFilter::$editboxName !== null ) {
			$vars['abuseFilterBoxName'] = AbuseFilter::$editboxName;
		}

		if ( AbuseFilterViewExamine::$examineType !== null ) {
			$vars['abuseFilterExamine'] = array(
				'type' => AbuseFilterViewExamine::$examineType,
				'id' => AbuseFilterViewExamine::$examineId,
			);
		}
		return true;
	}

	/**
	 * Register tables that need to be updated when an IP address has to be removed from database
	 *
	 * @param array $tasks
	 * @return bool
	 */
	public static function onUserRenameLocalIP( array &$tasks ) {
		$tasks[] = array(
			'table' => 'abuse_filter_log',
			'userid_column' => 'afl_user',
			'username_column' => 'afl_user_text',
		);

		return true;
	}
}
