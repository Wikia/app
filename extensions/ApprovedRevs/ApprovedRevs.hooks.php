<?php

/**
 * Functions for the Approved Revs extension called by hooks in the MediaWiki
 * code.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Yaron Koren
 * @author Jeroen De Dauw
 */
class ApprovedRevsHooks {

	static $mNoSaveOccurring = false;

	static public function userRevsApprovedAutomatically( $title ) {
		global $egApprovedRevsAutomaticApprovals;
		return ( ApprovedRevs::userCanApprove( $title ) && $egApprovedRevsAutomaticApprovals );
	}

	/**
	 * "noindex" and "nofollow" meta-tags are added to every revision page,
	 * so that search engines won't index them - remove those if this is
	 * the approved revision.
	 * There doesn't seem to be an ideal MediaWiki hook to use for this
	 * function - it currently uses 'PersonalUrls', which works.
	 */
	static public function removeRobotsTag( &$personal_urls, &$title ) {
		if ( ! ApprovedRevs::isDefaultPageRequest() ) {
			return true;
		}

		$revisionID = ApprovedRevs::getApprovedRevID( $title );
		if ( ! empty( $revisionID ) ) {
			global $wgOut;
			$wgOut->setRobotPolicy( 'index,follow' );
		}
		return true;
	}

	/**
	 * If the page is being saved, set the text of the approved revision
	 * as the text to be parsed, for correct saving of categories,
	 * Semantic MediaWiki properties, etc.
	 */
	static public function setApprovedRevForParsing( &$parser, &$text, &$stripState ) {
		global $wgRequest;

		// Static variable to prevent recursive calls to this method.
		static $alreadyCalled = false;

		if ( $wgRequest->getCheck( 'wpSave' ) ) {
			if ( $alreadyCalled ) {
				return true;
			}
			$alreadyCalled = true;

			// @HACK ? If the ConfirmEdit extension is installed
			// and kicks in for this save (i.e., prompting the
			// user for a CAPTCHA test), it will lead to bad
			// behavior - for some reason, the hook for this
			// function will get called about seven times, and
			// each time, the contents of the page will get
			// displayed on the screen. Instead we check for a
			// specific field of the parser, because the first
			// of those seven times, that field is not set -
			// whereas, apparently, it always is when a save is
			// actually happening. Then we set a static variable,
			// to be checked the next six times.
			if ( self::$mNoSaveOccurring ) {
				return true;
			}
			if ( empty( $parser->mPreprocessor) ) {
				self::$mNoSaveOccurring = true;
				return true;
			}

			// @HACK !! If the Semantic Forms extension is being
			// used, the form will be parsed right before the page
			// is parsed, and there doesn't seem to be any way
			// to determine, from within this hook function,
			// which one is being parsed at the moment - we only
			// want to modify the parsing of the main page, not
			// of the form page. So look for a string that should
			// appear in every form page, but should really never
			// appear in non-form pages - '{{{for template'.
			if ( strpos( $text, '{{{for template' ) !== false ) {
				return true;
			}
			$title = $parser->getTitle();
			if ( ! ApprovedRevs::pageIsApprovable( $title ) ) {
				return true;
			}
			// If this user's revisions get approved automatically,
			// exit now, because this will become the approved
			// revision anyway.
			if ( self::userRevsApprovedAutomatically( $title ) ) {
				return true;
			}
			$approvedText = ApprovedRevs::getApprovedContent( $title );
			if ( !is_null( $approvedText ) ) {
				$text = $approvedText;
			}
			// If there's no approved revision, and 'blank if
			// unapproved' is set to true, set the text to blank.
			if ( is_null( $approvedText ) ) {
				global $egApprovedRevsBlankIfUnapproved;
				if ( $egApprovedRevsBlankIfUnapproved ) {
					$text = '';
				}
			}
		}
		return true;
	}

	/**
	 * If the user saving this page has approval power, and automatic
	 * approvals are enabled, and the page is approvable, and either
	 * (a) this page already has an approved revision, or (b) unapproved
	 * pages are shown as blank on this wiki, automatically set this
	 * latest revision to be the approved one - don't bother logging
	 * the approval, though; the log is reserved for manual approvals.
	 */
	static public function setLatestAsApproved( &$article , &$user, $text,
		$summary, $flags, $unused1, $unused2, &$flags, $revision,
		&$status, $baseRevId ) {

		if ( is_null( $revision ) ) {
			return true;
		}

		$title = $article->getTitle();
		if ( ! self::userRevsApprovedAutomatically( $title ) ) {
			return true;
		}

		if ( !ApprovedRevs::pageIsApprovable( $title ) ) {
			return true;
		}

		global $egApprovedRevsBlankIfUnapproved;
		if ( !$egApprovedRevsBlankIfUnapproved ) {
			$approvedRevID = ApprovedRevs::getApprovedRevID( $title );
			if ( empty( $approvedRevID ) ) {
				return true;
			}
		}

		// save approval without logging
		ApprovedRevs::saveApprovedRevIDInDB( $title, $revision->getID() );
		return true;
	}

	/**
	 * Return the approved revision of the page, if there is one, and if
	 * the page is simply being viewed, and if no specific revision has
	 * been requested.
	 */
	static function showApprovedRevision( &$title, &$article ) {
		if ( ! ApprovedRevs::isDefaultPageRequest() ) {
			return true;
		}

		$revisionID = ApprovedRevs::getApprovedRevID( $title );
		if ( ! empty( $revisionID ) ) {
			$article = new Article( $title, $revisionID );
		}
		return true;
	}

	public static function showBlankIfUnapproved( &$article, &$content ) {
		global $egApprovedRevsBlankIfUnapproved;
		if ( ! $egApprovedRevsBlankIfUnapproved ) {
			return true;
		}

		$title = $article->getTitle();
		if ( ! ApprovedRevs::pageIsApprovable( $title ) ) {
			return true;
		}

		$revisionID = ApprovedRevs::getApprovedRevID( $title );
		if ( !empty( $revisionID ) ) {
			return true;
		}

		// Disable the cache for every page, if users aren't meant
		// to see pages with no approved revision, and this page
		// has no approved revision. This looks extreme - but
		// there doesn't seem to be any other way to distinguish
		// between a user looking at the main view of page, and a
		// user specifically looking at the latest revision of the
		// page (which we don't want to show as blank.)
		global $wgEnableParserCache;
		$wgEnableParserCache = false;

		if ( ! ApprovedRevs::isDefaultPageRequest() ) {
			return true;
		}

		ApprovedRevs::addCSS();

		$content = '';

		return true;
	}

	/**
	 * If user is viewing the page via its main URL, and what they're
	 * seeing is the approved revision of the page, remove the standard
	 * subtitle shown for all non-latest revisions, and replace it with
	 * either nothing or a message explaining the situation, depending
	 * on the user's rights.
	 */
	static function setSubtitle( &$article, &$revisionID ) {
		$title = $article->getTitle();
		if ( ! ApprovedRevs::hasApprovedRevision( $title ) ) {
			return true;
		}

		global $wgRequest;
		if ( $wgRequest->getCheck( 'oldid' ) ) {
			// If the user is looking at the latest revision,
			// disable caching, to avoid the wiki getting the
			// contents from the cache, and thus getting the
			// approved contents instead (seems to be an issue
			// only for MW >= 1.17).
			if ( $revisionID == $article->getLatest() ) {
				global $wgEnableParserCache;
				$wgEnableParserCache = false;
			}
			return true;
		}

		if ( ! $title->userCan( 'viewlinktolatest' ) ) {
			return false;
		}

		ApprovedRevs::addCSS();
		if ( $revisionID == $article->getLatest() ) {
			$text = Xml::element(
				'span',
				array( 'class' => 'approvedAndLatestMsg' ),
				wfMsg( 'approvedrevs-approvedandlatest' )
			);
		} else {
			$text = wfMsgHtml( 'approvedrevs-notlatest' );

			global $wgUser;
			$sk = $wgUser->getSkin();
			$text .= ' ' . $sk->link(
				$title,
				wfMsgHtml( 'approvedrevs-viewlatestrev' ),
				array(),
				array( 'oldid' => $article->getLatest() ),
				array( 'known', 'noclasses' )
			);

			$text = Xml::tags(
				'span',
				array( 'class' => 'notLatestMsg' ),
				$text
			);
		}

		global $wgOut;
		if ( $wgOut->getSubtitle() != '' ) {
			$wgOut->appendSubtitle( '<br />' . $text );
		} else {
			$wgOut->setSubtitle( $text );
		}

		return false;
	}

	/**
	 * Add a warning to the top of the 'edit' page if the approved
	 * revision is not the same as the latest one, so that users don't
	 * get confused, since they'll be seeing the latest one.
	 */
	public static function addWarningToEditPage( &$editPage ) {
		// only show the warning if it's not an old revision
		global $wgRequest;
		if ( $wgRequest->getCheck( 'oldid' ) ) {
			return true;
		}
		$title = $editPage->getArticle()->getTitle();
		$approvedRevID = ApprovedRevs::getApprovedRevID( $title );
		$latestRevID = $title->getLatestRevID();
		if ( ! empty( $approvedRevID ) && $approvedRevID != $latestRevID ) {
			ApprovedRevs::addCSS();
			global $wgOut;
			$wgOut->addHTML( '<p class="approvedRevsEditWarning">' . wfMsg( 'approvedrevs-editwarning' ) . "</p>\n" );
		}
		return true;
	}

	/**
	 * Same as addWarningToEditPage(), but for the Semantic Foms
	 * 'edit with form' tab.
	 */
	public static function addWarningToSFForm( &$pageName, &$preFormHTML ) {
		// The title could be obtained via $pageName in theory - the
		// problem is that, pre-SF 2.0.2, that variable wasn't set
		// correctly.
		global $wgTitle;
		$approvedRevID = ApprovedRevs::getApprovedRevID( $wgTitle );
		$latestRevID = $wgTitle->getLatestRevID();
		if ( ! empty( $approvedRevID ) && $approvedRevID != $latestRevID ) {
			ApprovedRevs::addCSS();
			$preFormHTML .= Xml::element ( 'p',
				array( 'style' => 'font-weight: bold' ),
				wfMsg( 'approvedrevs-editwarning' ) ) . "\n";
		}
		return true;
	}

	/**
	 * If user is looking at a revision through a main 'view' URL (no
	 * revision specified), have the 'edit' tab link to the basic
	 * 'action=edit' URL (i.e., the latest revision), no matter which
	 * revision they're actually on.
	 */
	static function changeEditLink( $skin, &$contentActions ) {
		global $wgRequest;
		if ( $wgRequest->getCheck( 'oldid' ) ) {
			return true;
		}

		$title = $skin->getTitle();
		if ( ApprovedRevs::hasApprovedRevision( $title ) ) {
			// the URL is the same regardless of whether the tab
			// is 'edit' or 'view source', but the "action" is
			// different
			if ( array_key_exists( 'edit', $contentActions ) ) {
				$contentActions['edit']['href'] = $title->getLocalUrl( array( 'action' => 'edit' ) );
			}
			if ( array_key_exists( 'viewsource', $contentActions ) ) {
				$contentActions['viewsource']['href'] = $title->getLocalUrl( array( 'action' => 'edit' ) );
			}
		}
		return true;
	}

	/**
	 * Same as changedEditLink(), but only for the Vector skin (and
	 * related skins).
	 */
	static function changeEditLinkVector( &$skin, &$links ) {
		// the old '$content_actions' array is thankfully just a
		// sub-array of this one
		self::changeEditLink( $skin, $links['views'] );
		return true;
	}

	/**
	 * Store the approved revision ID, if any, directly in the object
	 * for this article - this is called so that a query to the database
	 * can be made just once for every view of a history page, instead
	 * of for every row.
	 */
	static function storeApprovedRevisionForHistoryPage( &$article ) {
		// A bug in some versions of MW 1.19 causes $article to be null.
		if ( is_null( $article ) ) {
			return true;
		}
		// This will be null if there's no ID.
		$approvedRevID = ApprovedRevs::getApprovedRevID( $article->getTitle() );
		$article->getTitle()->approvedRevID = $approvedRevID;

		return true;
	}

	/**
	 * If the user is allowed to make revision approvals, add either an
	 * 'approve' or 'unapprove' link to the end of this row in the page
	 * history, depending on whether or not this is already the approved
	 * revision. If it's the approved revision also add on a "star"
	 * icon, regardless of the user.
	 */
	static function addApprovalLink( $historyPage, &$row , &$s ) {
		$title = $historyPage->getTitle();
		if ( ! ApprovedRevs::pageIsApprovable( $title ) ) {
			return true;
		}

		$article = $historyPage->getArticle();
		// use the rev ID field in the $article object, which was
		// stored earlier
		$approvedRevID = $title->approvedRevID;
		if ( $row->rev_id == $approvedRevID ) {
			$s .= '&#9733; ';
		}
		if ( ApprovedRevs::userCanApprove( $title ) ) {
			if ( $row->rev_id == $approvedRevID ) {
				$url = $title->getLocalUrl(
					array( 'action' => 'unapprove' )
				);
				$msg = wfMsg( 'approvedrevs-unapprove' );
			} else {
				$url = $title->getLocalUrl(
					array( 'action' => 'approve', 'oldid' => $row->rev_id )
				);
				$msg = wfMsg( 'approvedrevs-approve' );
			}
			$s .= '(' . Xml::element(
				'a',
				array( 'href' => $url ),
				$msg
			) . ')';
		}
		return true;
	}

	/**
	 * Handle the 'approve' action, defined for ApprovedRevs -
	 * mark the revision as approved, log it, and show a message to
	 * the user.
	 */
	static function setAsApproved( $action, $article ) {
		// Return "true" if the call failed (meaning, pass on handling
		// of the hook to others), and "false" otherwise.
		if ( $action != 'approve' ) {
			return true;
		}
		$title = $article->getTitle();
		if ( ! ApprovedRevs::pageIsApprovable( $title ) ) {
			return true;
		}
		if ( ! ApprovedRevs::userCanApprove( $title ) ) {
			return true;
		}
		global $wgRequest;
		if ( ! $wgRequest->getCheck( 'oldid' ) ) {
			return true;
		}
		$revisionID = $wgRequest->getVal( 'oldid' );
		ApprovedRevs::setApprovedRevID( $title, $revisionID );

		global $wgOut;
		$wgOut->addHTML( "\t\t" . Xml::element(
			'div',
			array( 'class' => 'successbox' ),
			wfMsg( 'approvedrevs-approvesuccess' )
		) . "\n" );
		$wgOut->addHTML( "\t\t" . Xml::element(
			'p',
			array( 'style' => 'clear: both' )
		) . "\n" );

		// show the revision, instead of the history page
		$article->doPurge();
		$article->view();

		return false;
	}

	/**
	 * Handle the 'unapprove' action, defined for ApprovedRevs -
	 * unset the previously-approved revision, log the change, and show
	 * a message to the user.
	 */
	static function unsetAsApproved( $action, $article ) {
		// return "true" if the call failed (meaning, pass on handling
		// of the hook to others), and "false" otherwise
		if ( $action != 'unapprove' ) {
			return true;
		}
		$title = $article->getTitle();
		if ( ! ApprovedRevs::userCanApprove( $title ) ) {
			return true;
		}

		ApprovedRevs::unsetApproval( $title );

		// the message depends on whether the page should display
		// a blank right now or not
		global $egApprovedRevsBlankIfUnapproved;
		if ( $egApprovedRevsBlankIfUnapproved ) {
			$successMsg = wfMsg( 'approvedrevs-unapprovesuccess2' );
		} else {
			$successMsg = wfMsg( 'approvedrevs-unapprovesuccess' );
		}

		global $wgOut;
		$wgOut->addHTML( "\t\t" . Xml::element(
			'div',
			array( 'class' => 'successbox' ),
			$successMsg
		) . "\n" );
		$wgOut->addHTML( "\t\t" . Xml::element(
			'p',
			array( 'style' => 'clear: both' )
		) . "\n" );

		// show the revision, instead of the history page
		$article->doPurge();
		$article->view();

		return false;
	}

	/**
	 * Use the approved revision, if it exists, for templates and other
	 * transcluded pages.
	 */
	static function setTranscludedPageRev( $parser, $title, &$skip, &$id ) {
		$revisionID = ApprovedRevs::getApprovedRevID( $title );
		if ( ! empty( $revisionID ) ) {
			$id = $revisionID;
		}
		return true;
	}

	/**
	 * Delete the approval record in the database if the page itself is
	 * deleted.
	 */
	static function deleteRevisionApproval( &$article, &$user, $reason, $id ) {
		ApprovedRevs::deleteRevisionApproval( $article->getTitle() );
		return true;
	}

	/**
	 * Register magic-word variable IDs
	 */
	static function addMagicWordVariableIDs( &$magicWordVariableIDs ) {
		$magicWordVariableIDs[] = 'MAG_APPROVEDREVS';
		return true;
	}

	/**
	 * Set values in the page_props table based on the presence of the
	 * 'APPROVEDREVS' magic word in a page
	 */
	static function handleMagicWords( &$parser, &$text ) {
		$mw_hide = MagicWord::get( 'MAG_APPROVEDREVS' );
		if ( $mw_hide->matchAndRemove( $text ) ) {
			$parser->mOutput->setProperty( 'approvedrevs', 'y' );
		}
		return true;
	}

	/**
	 * Add a link to 'Special:ApprovedPages' to the the page
	 * 'Special:AdminLinks', defined by the Admin Links extension.
	 */
	static function addToAdminLinks( &$admin_links_tree ) {
		$general_section = $admin_links_tree->getSection( wfMsg( 'adminlinks_general' ) );
		$extensions_row = $general_section->getRow( 'extensions' );
		if ( is_null( $extensions_row ) ) {
			$extensions_row = new ALRow( 'extensions' );
			$general_section->addRow( $extensions_row );
		}
		$extensions_row->addItem( ALItem::newFromSpecialPage( 'ApprovedRevs' ) );
		return true;
	}

	public static function describeDBSchema( $updater = null ) {
		$dir = dirname( __FILE__ );

		// DB updates
		// For now, there's just a single SQL file for all DB types.
		if ( $updater === null ) {
			global $wgExtNewTables, $wgDBtype;
			//if ( $wgDBtype == 'mysql' ) {
				$wgExtNewTables[] = array( 'approved_revs', "$dir/ApprovedRevs.sql" );
			//}
		} else {
			//if ( $updater->getDB()->getType() == 'mysql' ) {
				$updater->addExtensionUpdate( array( 'addTable', 'approved_revs', "$dir/ApprovedRevs.sql", true ) );
			//}
		}
		return true;
	}

	/**
	 * Display a message
	 *
	 * @since 0.5.6
	 *
	 * @param Article &$article
	 * @param boolean $outputDone
	 * @param boolean $useParserCache
	 *
	 * @return true
	 */
	public static function setArticleHeader( Article &$article, &$outputDone, &$useParserCache ) {
		global $wgOut, $wgRequest, $egApprovedRevsBlankIfUnapproved;

		// For now, we only set the header if "blank if unapproved"
		// is set.
		if ( ! $egApprovedRevsBlankIfUnapproved ) {
			return true;
		}

		$title = $article->getTitle();
		if ( ! ApprovedRevs::pageIsApprovable( $title ) ) {
			return true;
		}
		if ( ! ApprovedRevs::userCanApprove( $title ) ) {
			return true;
		}

		$approvedRevID = ApprovedRevs::getApprovedRevID( $title );
		if ( ! empty( $approvedRevID ) &&
			! ( $wgRequest->getCheck( 'oldid' ) &&
			$wgRequest->getInt( 'oldid' ) == $approvedRevID ) ) {
			return true;
		}

		// Disable caching, so that if it's a specific ID being shown
		// that happens to be the latest, it doesn't show a blank page.
		$useParserCache = false;
		$wgOut->addHTML( '<span style="margin-left: 10.75px">' );

		if ( $wgRequest->getCheck( 'oldid' ) ) {
			$wgOut->addHTML( Xml::tags( 'span', array( 'id' => 'contentSub2' ),
				Xml::element( 'a',
				array( 'href' => $title->getLocalUrl(
					array(
						'action' => 'approve',
						'oldid' => $wgRequest->getInt( 'oldid' )
					)
				) ),
				wfMsg( 'approvedrevs-approvethisrev' )
			) ) );

		} else {
			$wgOut->appendSubtitle(
				htmlspecialchars( wfMsg( 'approvedrevs-blankpageshown' ) ) . '&#160;' .
				Xml::element( 'a',
					array( 'href' => $title->getLocalUrl(
						array(
							'oldid' => $article->getRevIdFetched()
						)
					) ),
					wfMsg( 'approvedrevs-viewlatestrev' )
				)
			);
		}

		$wgOut->addHTML( '</span>' );

		return true;
	}

	/**
	 * @TODO - this should ideally set the text that MediaWiki's search
	 * uses when searching the wiki, but I haven't been able to get it
	 * working. At the moment, it's not being called.
	 */
	public static function setSearchText( $id, $namespace, $title, $text ) {
		return true;
	}

}
