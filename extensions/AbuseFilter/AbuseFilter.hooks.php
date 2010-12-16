<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

class AbuseFilterHooks {
// So far, all of the error message out-params for these hooks accept HTML.
// Hooray!
	public static function onEditFilterMerged( $editor, $text, &$error, $summary ) {
		// Load vars
		$vars = new AbuseFilterVariableHolder;

		// Cache article object so we can share a parse operation
		$title = $editor->mTitle;
		$articleCacheKey = $title->getNamespace() . ':' . $title->getText();
		AFComputedVariable::$articleCache[$articleCacheKey] = $editor->mArticle;

		// Check for null edits.
		$oldtext = '';

		if ( $editor->mArticle->exists() ) {
			$oldtext = $editor->mArticle->getContent();
		}

		if ( strcmp( $oldtext, $text ) == 0 ) {
			// Don't trigger for null edits.
			return true;
		}

		global $wgUser;
		$vars->addHolder( AbuseFilter::generateUserVars( $wgUser ) );
		$vars->addHolder( AbuseFilter::generateTitleVars( $editor->mTitle , 'ARTICLE' ) );
		$vars->setVar( 'ACTION', 'edit' );
		$vars->setVar( 'SUMMARY', $summary );
		$vars->setVar( 'minor_edit', $editor->minoredit );

		$vars->setVar( 'old_wikitext', $oldtext );
		$vars->setVar( 'new_wikitext', $text );

		$vars->addHolder( AbuseFilter::getEditVars( $editor->mTitle ) );

		$filter_result = AbuseFilter::filterAction( $vars, $editor->mTitle );

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

	public static function onArticleDelete( &$article, &$user, &$reason, &$error ) {
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
		wfLoadExtensionMessages( 'AbuseFilter' );
		if ( $user->getName() == wfMsgForContent( 'abusefilter-blocker' ) ) {
			$message = wfMsg( 'abusefilter-accountreserved' );
			return false;
		}
		$vars = new AbuseFilterVariableHolder;

		$vars->setVar( 'ACTION', 'createaccount' );
		$vars->setVar( 'ACCOUNTNAME', $user->getName() );

		$filter_result = AbuseFilter::filterAction(
			$vars, SpecialPage::getTitleFor( 'Userlogin' ) );

		$message = $filter_result;

		return $filter_result == '' || $filter_result === true;
	}

	public static function onRecentChangeSave( $recentChange ) {
		$title = Title::makeTitle(
			$recentChange->mAttribs['rc_namespace'],
			$recentChange->mAttribs['rc_title']
		);
		$action = $recentChange->mAttribs['rc_log_type'] ?
			$recentChange->mAttribs['rc_log_type'] : 'edit';
		$actionID = implode( '-', array(
				$title->getPrefixedText(), $recentChange->mAttribs['rc_user_text'], $action
			) );

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

		while ( $row = $res->fetchObject() ) {
			$emptyTags = array_filter(
				array_merge( explode( "\n", $row->afa_parameters ), $emptyTags )
			);
		}

		return true;
	}

	public static function onLoadExtensionSchemaUpdates() {
		global $wgExtNewTables, $wgExtNewFields, $wgExtPGNewFields, $wgExtPGAlteredFields, $wgExtNewIndexes, $wgDBtype;

		$dir = dirname( __FILE__ );

		// DB updates
		if ( $wgDBtype == 'mysql' ) {
			$wgExtNewTables[] = array( 'abuse_filter', "$dir/abusefilter.tables.sql" );
			$wgExtNewTables[] = array( 'abuse_filter_history', "$dir/db_patches/patch-abuse_filter_history.sql" );
			$wgExtNewFields[] = array( 'abuse_filter_history', 'afh_changed_fields', "$dir/db_patches/patch-afh_changed_fields.sql" );
			$wgExtNewFields[] = array( 'abuse_filter', 'af_deleted', "$dir/db_patches/patch-af_deleted.sql" );
			$wgExtNewFields[] = array( 'abuse_filter', 'af_actions', "$dir/db_patches/patch-af_actions.sql" );
			$wgExtNewFields[] = array( 'abuse_filter', 'af_global', "$dir/db_patches/patch-global_filters.sql" );
		} elseif ( $wgDBtype == 'postgres' ) {
			$wgExtNewTables = array_merge( $wgExtNewTables,
					array(
						array( 'abuse_filter', "$dir/abusefilter.tables.pg.sql" ),
						array( 'abuse_filter_history', "$dir/db_patches/patch-abuse_filter_history.pg.sql" ),
					) );
			$wgExtPGNewFields[] = array( 'abuse_filter', 'af_actions', "TEXT NOT NULL DEFAULT ''" );
			$wgExtPGNewFields[] = array( 'abuse_filter', 'af_deleted', 'SMALLINT NOT NULL DEFAULT 0' );
			$wgExtPGNewFields[] = array( 'abuse_filter', 'af_global',  'SMALLINT NOT NULL DEFAULT 0' );

			$wgExtPGNewFields[] = array( 'abuse_filter_log', 'afl_wiki', 'TEXT' );
			$wgExtPGNewFields[] = array( 'abuse_filter_log', 'afl_deleted', 'SMALLINT' );
			$wgExtPGAlteredFields[] = array( 'abuse_filter_log', 'afl_filter', 'TEXT' );

			$wgExtNewIndexes[] = array( 'abuse_filter_log', 'abuse_filter_log_ip', "(afl_ip)" );
		}
		return true;
	}

	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgUser;
		wfLoadExtensionMessages( 'AbuseFilter' );
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
}
