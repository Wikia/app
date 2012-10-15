<?php

class PureWikiDeletionHooks {
	/**
	 * When a user visits the URL of a blanked page, redirect to the edit page
	 */
	public static function PureWikiDeletionOutputPageParserOutputHook( &$out, $parseroutput ) {
		$dbr = wfGetDB( DB_SLAVE );
		$target = $out->getTitle();
		$blank_page_id = $target->getArticleID();
		if ( $target->getNamespace() == NS_SPECIAL
			|| $target->getNamespace() == NS_MEDIA
			|| $target->getNamespace() == NS_FILE
			|| $target->isExternal() ) {
			return true;
		}
		$result = $dbr->selectRow( 'blanked_page', 'blank_page_id',
			array( "blank_page_id" => $blank_page_id ) );
		if ( !$result ) {
			return true;
		}
		$out->setRobotPolicy( 'noindex,nofollow' );
		if ( $out->getPageTitle() == $target->getPrefixedText() ) {
			$out->redirect( $target->getEditURL() );
		}

		$out->setPageTitle( $out->getPageTitle() );
		return true;
	}

	/**
	 * After a page is saved, add or remove it from the blank_page table if
	 * it has been blanked or unblanked, respectively; if blanked, redirect
	 * the user to the "Action complete" page
	 */
	public static function PureWikiDeletionSaveCompleteHook( &$article, &$user, $text, $summary,
		$minoredit, &$watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId,
		&$redirect ) {
		global $wgOut, $wgInterWikiIntegrationInEffect;
		if ( !isset( $revision ) ) {
			return true;
		}
		$mTitle = $article->getTitle();
		if ( $mTitle->getNamespace() == NS_FILE ) {
			return true;
		}
		$blankRevId = $revision->getId();
		if ( $text == "" ) {
			if ( $summary == wfMsgForContent( 'autosumm-blank' ) ) {
				$hasHistory = false;
				$summary = $article->generateReason( $hasHistory );
			}
			$dbw = wfGetDB( DB_MASTER );
			$blank_row = array(
				'blank_page_id'   => $article->getID(),
				'blank_user_id'   => $user->getId(),
				'blank_user_name' => $user->getName(),
				'blank_timestamp' => $revision->getTimeStamp(),
				'blank_summary'   => $summary,
				'blank_parent_id' => $revision->getParentId()
			);
			$dbw->insert( 'blanked_page', $blank_row );
			$log = new LogPage( 'blank' );
			$log->addEntry( 'blank', $mTitle, $summary, array(), $user );
			$dbw->commit();
			$dbw->delete( 'recentchanges',
				array( 'rc_this_oldid' => $blankRevId
			) );
			Article::onArticleDelete( $mTitle );
			$mTitle->resetArticleID( 0 );
			if ( $user->getOption( 'watchblank' ) ) {
				$watchthis = true;
			}
			wfRunHooks ( 'PureWikiDeletionArticleBlankComplete', array ( $mTitle ) );
			$redirect = false;
			$wgOut->setPagetitle( wfMsg( 'actioncomplete' ) );
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$loglink = wfMsg( 'blank-log-link' );
			$wgOut->addWikiMsg( 'purewikideletion-blankedtext', $mTitle->getPrefixedText(), $loglink );
			$wgOut->returnToMain( false );
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$blank_page_id = $article->getID();
			$result = $dbr->selectRow( 'blanked_page', 'blank_page_id',
				array( "blank_page_id" => $blank_page_id ) );
			if ( !$result ) {
				return true;
			} else {
				if ( $summary == '' ) {
					$summary = $article->getAutosummary( '', $text, EDIT_NEW );
				}
				$dbw = wfGetDB( DB_MASTER );
				$blank_page_id = $article->getID();
				$dbw->delete ( 'blanked_page',
					array( "blank_page_id" => $blank_page_id ) );
				$log = new LogPage( 'blank' );
				$log->addEntry( 'unblank', $mTitle, $summary, array(), $user );
				$dbw->commit();
				$dbw->delete( 'recentchanges',
					array( 'rc_this_oldid' => $blankRevId
				) );
				$mTitle->touchLinks();
				$mTitle->invalidateCache();
				$mTitle->purgeSquid();
				wfRunHooks ( 'PureWikiDeletionArticleUnblankComplete', array ( $mTitle ) );
			}
		}
		return true;
	}

	/**
	 * Change the link style if the target page is in the blank_table
	 */
	public static function PureWikiDeletionLink( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
		global $wgPureWikiDeletionBlankLinkStyle;
		// If it's on the local wiki, then see if it's blanked
		if ( in_array( 'known', $options ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$blank_page_id = $target->getArticleID();
			if ( $target->getNamespace() == NS_SPECIAL
				|| $target->getNamespace() == NS_MEDIA
				|| $target->getNamespace() == NS_FILE
				|| $target->isExternal() ) {
				return true;
			}
			$result = $dbr->selectRow( 'blanked_page', 'blank_page_id',
				array( "blank_page_id" => $blank_page_id ) );
			if ( !$result ) {
				return true;
			} elseif ( !isset( $query['action'] )
				&& !isset( $query['curid'] )
				&& !isset( $query['oldid'] ) ) {
				$query['action'] = "edit";
				$customAttribs['style'] = $wgPureWikiDeletionBlankLinkStyle;
				// $options='broken';
			}
		}
		return true;
	}

	/**
	 * Provide historical information about a blank page that the user is editing
	 */
	public static function PureWikiDeletionEditHook( &$editPage ) {
		global $wgLang, $wgUser;
		$dbr = wfGetDB( DB_SLAVE );
		$blank_page_id = $editPage->getArticle()->getID();
		$blank_row = array(
			'blank_user_id',
			'blank_user_name',
			'blank_timestamp',
			'blank_summary',
			'blank_parent_id'
		);

		$result = $dbr->selectRow( 'blanked_page', $blank_row,
			array( 'blank_page_id' => $blank_page_id ) );
		if ( !$result ) {
			return true;
		}

		$blank_user_id = $result->blank_user_id;
		if ( $blank_user_id == 0 ) {
			$blank_user_name = $result->blank_user_name;
		} else {
			$blanking_user = User::newFromId( $blank_user_id );
			$blank_user_name = $blanking_user->getName();
		}
		$html = wfMsgExt( 'purewikideletion-blanked', 'parse', array(
			$blank_user_name,
			$wgLang->timeanddate( wfTimestamp( TS_MW, $result->blank_timestamp ), true ),
			$result->blank_summary,
			$result->blank_parent_id,
			$wgLang->date( wfTimestamp( TS_MW, $result->blank_timestamp ), true ),
			$wgLang->time( wfTimestamp( TS_MW, $result->blank_timestamp ), true )
		) );
		$editPage->editFormPageTop .= $html;

		if ($wgUser->getOption( 'watchunblank' )){
			$editPage->watchthis = true;
		}

		return true;
	}

	/**
	 * Remove blanked pages from the blank_page table when they are deleted
	 */
	public static function PureWikiDeletionDeleteHook( &$article, &$user, $reason, $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->selectRow( 'blanked_page', 'blank_page_id',
			array( "blank_page_id" => $id ) );
		if ( !$result ) {
			return true;
		} else {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->delete ( 'blanked_page', array( "blank_page_id" => $id ) );
		}
		return true;
	}

	/**
	 * Add blanked pages back to the blank_page table when they are undeleted
	 */
	public static function PureWikiDeletionUndeleteHook( $title, $create ) {
		$dbr = wfGetDB( DB_SLAVE );
		$myRevision = Revision::loadFromTitle( $dbr, $title );
		if ( $myRevision->getRawText () == "" ) {
			$dbw = wfGetDB( DB_MASTER );
			$blank_row = array(
				'blank_page_id'   => $title->getArticleID(),
				'blank_user_id'   => $myRevision->getRawUser(),
				'blank_user_name' => $myRevision->getRawUserText(),
				'blank_timestamp' => $myRevision->getTimeStamp(),
				'blank_summary'   => $myRevision->getRawComment (),
				'blank_parent_id' => $myRevision->getParentId()
			);
			$dbw->insert( 'blanked_page', $blank_row );
		}
		return true;
	}

	public static function efPureWikiDeletionParserFunction_Setup( $parser ) {
		# Set a function hook associating the "example" magic word with our function
		$parser->setFunctionHook( 'ifnotblank', 'PureWikiDeletionHooks::efPureWikiDeletionParserFunction_RenderNotBlank' );
		$parser->setFunctionHook( 'ifblank', 'PureWikiDeletionHooks::efPureWikiDeletionParserFunction_RenderBlank' );
		return true;
	}

	public static function efPureWikiDeletionParserFunction_RenderBlank( $parser, $param1 = '', $param2 = '', $param3 = '' ) {
		return PureWikiDeletionHooks::evaluateBlankness ( $parser, $param1, $param2, $param3 );
	}

	public static function efPureWikiDeletionParserFunction_RenderNotBlank( $parser, $param1 = '', $param2 = '', $param3 = '' ) {
		return PureWikiDeletionHooks::evaluateBlankness ( $parser, $param1, $param3, $param2 );
	}

	public static function evaluateBlankness ( $parser, $param1 = '', $param2 = '', $param3 = '' ) {
		global $wgNamespaceAliases, $wgExpensiveParserFunctionLimit;
		if ( $parser->incrementExpensiveFunctionCount() ) {
			$title = Title::newFromText( $param1 );
			if ( $title == null ) {
				return;
			}
			if ( $title->getNamespace() == NS_SPECIAL || $title->getNamespace() == NS_MEDIA
				|| $title->isExternal() ) {
				return $param3; // These not-editable namespaces are never considered blank
			}
			$param1 = $title->getDBkey ();
			$searchNameSpace = $title->getNamespace();
			$dbr = wfGetDB( DB_SLAVE );
			if ( !$title->exists() ) {
				return $param3; // This page does not exist; therefore it can't be blank
			}
			$blank_page_id = $title->getArticleID();
			$row = $dbr->selectRow( 'blanked_page', 'blank_page_id',
				array( "blank_page_id" => $blank_page_id ) );
			if ( !$row ) {
				return $param3; // This page exists but is not blanked
			}
			return $param2; // This page exists and is blanked
		}
		return false; // If too many expensive functions have been run
	}

	public static function PureWikiDeletionCreateTable( $updater = null ) {
		if ( $updater === null ) {
			global $wgExtNewTables;
			$wgExtNewTables[] = array( 'blanked_page', dirname( __FILE__ ) . '/purewikideletiontable.sql' );
		} else {
			$updater->addExtensionTable( 'blanked_page', dirname( __FILE__ ) . '/purewikideletiontable.sql' );
		}
		return true;
	}
}
