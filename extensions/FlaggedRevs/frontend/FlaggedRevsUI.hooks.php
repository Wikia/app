<?php
/**
 * Class containing hooked functions for a FlaggedRevs environment
 */
class FlaggedRevsUIHooks {
	/**
	 * Add FlaggedRevs css/js.
	 */
	protected static function injectStyleAndJS() {
		global $wgOut, $wgUser;
		static $loadedModules = false;
		if ( $loadedModules ) {
			return true; // don't double-load
		}
		$loadedModules = true;
		$fa = FlaggablePageView::globalArticleInstance();
		# Try to only add to relevant pages
		if ( !$fa || !$fa->isReviewable() ) {
			return true;
		}
		# Add main CSS & JS files
		$wgOut->addModuleStyles( 'ext.flaggedRevs.basic' );
		$wgOut->addModules( 'ext.flaggedRevs.advanced' );
		# Add review form JS for reviewers
		if ( $wgUser->isAllowed( 'review' ) ) {
			$wgOut->addModules( 'ext.flaggedRevs.review' );
		}
		return true;
	}

	public static function injectGlobalJSVars( array &$globalVars ) {
		# Get the review tags on this wiki
		$rTags = FlaggedRevs::getJSTagParams();
		$globalVars['wgFlaggedRevsParams'] = $rTags;
		# Get page-specific meta-data
		$fa = FlaggablePageView::globalArticleInstance();
		# Try to only add to relevant pages
		if ( $fa && $fa->isReviewable() ) {
			$frev = $fa->getStableRev();
			$stableId = $frev ? $frev->getRevId() : 0;
		} else {
			$stableId = null;
		}
		$globalVars['wgStableRevisionId'] = $stableId;
		return true;
	}

	/**
	 * Add FlaggedRevs css for relevant special pages.
	 * @param OutputPage $out
	 */
	protected static function injectStyleForSpecial( &$out ) {
		$title = $out->getTitle();
		$spPages = array( 'UnreviewedPages', 'PendingChanges', 'ProblemChanges',
			'Watchlist', 'Recentchanges', 'Contributions', 'Recentchangeslinked' );
		foreach ( $spPages as $key ) {
			if ( $title->isSpecial( $key ) ) {
				$out->addModuleStyles( 'ext.flaggedRevs.basic' ); // CSS only
				break;
			}
		}
		return true;
	}

	/*
	 * Add tag notice, CSS/JS, protect form link, and set robots policy
	 */
	public static function onBeforePageDisplay( &$out, &$skin ) {
		if ( $out->getTitle()->getNamespace() != NS_SPECIAL ) {
			$view = FlaggablePageView::singleton();
			$view->addStabilizationLink(); // link on protect form
			$view->displayTag(); // show notice bar/icon in subtitle
			if ( $out->isArticleRelated() ) {
				// Only use this hook if we want to prepend the form.
				// We prepend the form for diffs, so only handle that case here.
				if ( $view->diffRevsAreSet() ) {
					$view->addReviewForm( $out ); // form to be prepended
				}
			}
			$view->setRobotPolicy(); // set indexing policy
			self::injectStyleAndJS(); // full CSS/JS
		} else {
			self::maybeAddBacklogNotice( $out ); // RC/Watchlist notice
			self::injectStyleForSpecial( $out ); // try special page CSS
		}
		return true;
	}

	/**
	 * Add user preferences (uses prefs-flaggedrevs, prefs-flaggedrevs-ui msgs)
	 */
	public static function onGetPreferences( $user, array &$preferences ) {
		// Box or bar UI
		$preferences['flaggedrevssimpleui'] =
			array(
				'type' => 'radio',
				'section' => 'flaggedrevs/flaggedrevs-ui',
				'label-message' => 'flaggedrevs-pref-UI',
				'options' => array(
					wfMsg( 'flaggedrevs-pref-UI-0' ) => 0,
					wfMsg( 'flaggedrevs-pref-UI-1' ) => 1,
				),
			);
		// Default versions...
		$preferences['flaggedrevsstable'] =
			array(
				'type' => 'radio',
				'section' => 'flaggedrevs/flaggedrevs-ui',
				'label-message' => 'flaggedrevs-prefs-stable',
				'options' => array(
					wfMsg( 'flaggedrevs-pref-stable-0' ) => FR_SHOW_STABLE_DEFAULT,
					wfMsg( 'flaggedrevs-pref-stable-1' ) => FR_SHOW_STABLE_ALWAYS,
					wfMsg( 'flaggedrevs-pref-stable-2' ) => FR_SHOW_STABLE_NEVER,
				),
			);
		// Review-related rights...
		if ( $user->isAllowed( 'review' ) ) {
			// Watching reviewed pages
			$preferences['flaggedrevswatch'] =
				array(
					'type' => 'toggle',
					'section' => 'watchlist/advancedwatchlist',
					'label-message' => 'flaggedrevs-prefs-watch',
				);
			// Diff-to-stable on edit
			$preferences['flaggedrevseditdiffs'] =
				array(
					'type' => 'toggle',
					'section' => 'editing/advancedediting',
					'label-message' => 'flaggedrevs-prefs-editdiffs',
				);
			// Diff-to-stable on draft view
			$preferences['flaggedrevsviewdiffs'] =
				array(
					'type' => 'toggle',
					'section' => 'flaggedrevs/flaggedrevs-ui',
					'label-message' => 'flaggedrevs-prefs-viewdiffs',
				);
		}
		return true;
	}

	public static function logLineLinks(
		$type, $action, $title, $params, &$comment, &$rv, $ts
	) {
		if ( !$title ) {
			return true; // sanity check
		}
		// Stability log
		if ( $type == 'stable' && FlaggedRevsLog::isStabilityAction( $action ) ) {
			$rv .= FlaggedRevsLogView::stabilityLogLinks( $title, $ts, $params );
		// Review log
		} elseif ( $type == 'review' && FlaggedRevsLog::isReviewAction( $action ) ) {
			$rv .= FlaggedRevsLogView::reviewLogLinks( $action, $title, $params );
		}
		return true;
	}

	public static function onImagePageFindFile( $imagePage, &$normalFile, &$displayFile ) {
		$view = FlaggablePageView::singleton();
		$view->imagePageFindFile( $normalFile, $displayFile );
		return true;
	}

	// MonoBook et al: $contentActions is all the tabs
	// Vector et al: $contentActions is all the action tabs...unused
	public static function onSkinTemplateTabs( Skin $skin, array &$contentActions ) {
		if ( $skin instanceof SkinVector ) {
			// *sigh*...skip, dealt with in setNavigation()
			return true;
		}
		if ( FlaggablePageView::globalArticleInstance() != null ) {
			$view = FlaggablePageView::singleton();
			$view->setActionTabs( $skin, $contentActions );
			$view->setViewTabs( $skin, $contentActions, 'flat' );
		}
		return true;
	}

	// Vector et al: $links is all the tabs (2 levels)
	public static function onSkinTemplateNavigation( Skin $skin, array &$links ) {
		if ( FlaggablePageView::globalArticleInstance() != null ) {
			$view = FlaggablePageView::singleton();
			$view->setActionTabs( $skin, $links['actions'] );
			$view->setViewTabs( $skin, $links['views'], 'nav' );
		}
		return true;
	}

	public static function onArticleViewHeader( &$article, &$outputDone, &$useParserCache ) {
		$view = FlaggablePageView::singleton();
		$view->addStableLink( $outputDone, $useParserCache );
		$view->setPageContent( $outputDone, $useParserCache );
		return true;
	}

	public static function overrideRedirect(
		Title $title, WebRequest $request, &$ignoreRedirect, &$target, Article &$article
	) {
		global $wgMemc, $wgParserCacheExpireTime;
		$fa = FlaggableWikiPage::getTitleInstance( $title ); // on $wgTitle
		if ( !$fa->isReviewable() ) {
			return true; // nothing to do
		}
		# Viewing an old reviewed version...
		if ( $request->getVal( 'stableid' ) ) {
			$ignoreRedirect = true; // don't redirect (same as ?oldid=x)
			return true;
		}
		$srev = $fa->getStableRev();
		$view = FlaggablePageView::singleton();
		# Check if we are viewing an unsynced stable version...
		if ( $srev && $view->showingStable() && $srev->getRevId() != $article->getLatest() ) {
			# Check the stable redirect properties from the cache...
			$key = wfMemcKey( 'flaggedrevs', 'overrideRedirect', $article->getId() );
			$tuple = FlaggedRevs::getMemcValue( $wgMemc->get( $key ), $article );
			if ( is_array( $tuple ) ) { // cache hit
				list( $ignoreRedirect, $target ) = $tuple;
			} else { // cache miss; fetch the stable rev text...
				$text = $srev->getRevText();
				$redirect = $fa->getRedirectURL( Title::newFromRedirectRecurse( $text ) );
				if ( $redirect ) {
					$target = $redirect; // use stable redirect
				} else {
					$ignoreRedirect = true; // make MW skip redirection
				}
				$data = FlaggedRevs::makeMemcObj( array( $ignoreRedirect, $target ) );
				$wgMemc->set( $key, $data, $wgParserCacheExpireTime ); // cache results
			}
			$clearEnvironment = (bool)$target;
		# Check if the we are viewing a draft or synced stable version...
		} else {
			# In both cases, we can just let MW use followRedirect()
			# on the draft as normal, avoiding any page text hits.
			$clearEnvironment = $article->isRedirect();
		}
		# Environment (e.g. $wgTitle) will change in MediaWiki::initializeArticle
		if ( $clearEnvironment ) $view->clear();

		return true;
	}

	public static function addToEditView( &$editPage ) {
		$view = FlaggablePageView::singleton();
		$view->addToEditView( $editPage );
		return true;
	}

	public static function onBeforeEditButtons( &$editPage, &$buttons ) {
		$view = FlaggablePageView::singleton();
		$view->changeSaveButton( $editPage, $buttons );
		return true;
	}

	public static function onNoSuchSection( &$editPage, &$s ) {
		$view = FlaggablePageView::singleton();
		$view->addToNoSuchSection( $editPage, $s );
		return true;
	}

	public static function addToHistView( &$article ) {
		$view = FlaggablePageView::singleton();
		$view->addToHistView();
		return true;
	}

	public static function onCategoryPageView( &$category ) {
		$view = FlaggablePageView::singleton();
		$view->addToCategoryView();
		return true;
	}

	public static function onSkinAfterContent( &$data ) {
		global $wgOut;
		if ( $wgOut->isArticleRelated()
			&& FlaggablePageView::globalArticleInstance() != null )
		{
			$view = FlaggablePageView::singleton();
			// Only use this hook if we want to append the form.
			// We *prepend* the form for diffs, so skip that case here.
			if ( !$view->diffRevsAreSet() ) {
				$view->addReviewForm( $data ); // form to be appended
			}
		}
		return true;
	}

	public static function addHideReviewedFilter( $specialPage, &$filters ) {
		if ( !FlaggedRevs::useOnlyIfProtected() ) {
			$filters['hideReviewed'] = array(
				'msg' => 'flaggedrevs-hidereviewed', 'default' => false );
		}
		return true;
	}

	public static function addToHistQuery( HistoryPager $pager, array &$queryInfo ) {
		$flaggedArticle = FlaggableWikiPage::getTitleInstance( $pager->getTitle() );
		# Non-content pages cannot be validated. Stable version must exist.
		if ( $flaggedArticle->isReviewable() && $flaggedArticle->getStableRev() ) {
			# Highlight flaggedrevs
			$queryInfo['tables'][] = 'flaggedrevs';
			$queryInfo['fields'][] = 'fr_quality';
			$queryInfo['fields'][] = 'fr_user';
			$queryInfo['fields'][] = 'fr_flags';
			$queryInfo['join_conds']['flaggedrevs'] = array( 'LEFT JOIN', "fr_rev_id = rev_id" );
			# Find reviewer name. Sanity check that no extensions added a `user` query.
			if ( !in_array( 'user', $queryInfo['tables'] ) ) {
				$queryInfo['tables'][] = 'user';
				$queryInfo['fields'][] = 'user_name AS reviewer';
				$queryInfo['join_conds']['user'] = array( 'LEFT JOIN', "user_id = fr_user" );
			}
		}
		return true;
	}

	public static function addToFileHistQuery(
		File $file, array &$tables, array &$fields, &$conds, array &$opts, array &$join_conds
	) {
		if ( !$file->isLocal() ) {
			return true; // local files only
		}
		$flaggedArticle = FlaggableWikiPage::getTitleInstance( $file->getTitle() );
		# Non-content pages cannot be validated. Stable version must exist.
		if ( $flaggedArticle->isReviewable() && $flaggedArticle->getStableRev() ) {
			$tables[] = 'flaggedrevs';
			$fields[] = 'MAX(fr_quality) AS fr_quality';
			# Avoid duplicate rows due to multiple revs with the same sha-1 key

			# This is a stupid hack to get all the field names in our GROUP BY
			# clause. Postgres yells at you for not including all of the selected
			# columns, so grab the full list, unset the two we actually want to
			# order by, then append the rest of them to our two. It would be
			# REALLY nice if we handled this automagically in makeSelectOptions()
			# or something *sigh*
			$groupBy = OldLocalFile::selectFields();
			unset( $groupBy[ array_search( 'oi_name', $groupBy ) ] );
			unset( $groupBy[ array_search( 'oi_timestamp', $groupBy ) ] );
			$opts['GROUP BY'] = 'oi_name,oi_timestamp,' . implode( ',', $groupBy );

			$join_conds['flaggedrevs'] = array( 'LEFT JOIN',
				'oi_sha1 = fr_img_sha1 AND oi_timestamp = fr_img_timestamp' );
		}
		return true;
	}

	public static function addToContribsQuery( $pager, array &$queryInfo ) {
		# Highlight flaggedrevs
		$queryInfo['tables'][] = 'flaggedrevs';
		$queryInfo['fields'][] = 'fr_quality';
		$queryInfo['join_conds']['flaggedrevs'] = array( 'LEFT JOIN', "fr_rev_id = rev_id" );
		# Highlight unchecked content
		$queryInfo['tables'][] = 'flaggedpages';
		$queryInfo['fields'][] = 'fp_stable';
		$queryInfo['fields'][] = 'fp_pending_since';
		$queryInfo['join_conds']['flaggedpages'] = array( 'LEFT JOIN', "fp_page_id = rev_page" );
		return true;
	}

	public static function modifyRecentChangesQuery(
		&$conds, &$tables, &$join_conds, $opts, &$query_opts, &$fields
	) {
		return self::modifyChangesListQuery( $conds, $tables, $join_conds, $fields );
	}

	public static function modifyNewPagesQuery(
		$specialPage, $opts, &$conds, &$tables, &$fields, &$join_conds
	) {
		return self::modifyChangesListQuery( $conds, $tables, $join_conds, $fields );
	}

	public static function modifyChangesListQuery(
		array &$conds, array &$tables, array &$join_conds, array &$fields
	) {
		global $wgRequest;
		$tables[] = 'flaggedpages';
		$fields[] = 'fp_stable';
		$fields[] = 'fp_pending_since';
		$join_conds['flaggedpages'] = array( 'LEFT JOIN', 'fp_page_id = rc_cur_id' );
		if ( $wgRequest->getBool( 'hideReviewed' ) && !FlaggedRevs::useOnlyIfProtected() ) {
			$conds[] = 'rc_timestamp >= fp_pending_since OR fp_stable IS NULL';
		}
		return true;
	}

	public static function addToHistLine( HistoryPager $history, $row, &$s, &$liClasses ) {
		$fa = FlaggableWikiPage::getTitleInstance( $history->getTitle() );
		if ( !$fa->isReviewable() ) {
			return true; // nothing to do here
		}
		# Fetch and process cache the stable revision
		if ( !isset( $history->fr_stableRevId ) ) {
			$srev = $fa->getStableRev();
			$history->fr_stableRevId = $srev ? $srev->getRevId() : null;
			$history->fr_stableRevUTS = $srev ? // bug 15515
				wfTimestamp( TS_UNIX, $srev->getRevTimestamp() ) : null;
			$history->fr_pendingRevs = false;
		}
		if ( !$history->fr_stableRevId ) {
			return true; // nothing to do here
		}
		$title = $history->getTitle();
		$revId = (int)$row->rev_id;
		// Pending revision: highlight and add diff link
		$link = $class = '';
		if ( wfTimestamp( TS_UNIX, $row->rev_timestamp ) > $history->fr_stableRevUTS ) {
			$class = 'flaggedrevs-pending';
			$link = wfMsgExt( 'revreview-hist-pending-difflink', 'parseinline',
				$title->getPrefixedText(), $history->fr_stableRevId, $revId );
			$link = '<span class="plainlinks mw-fr-hist-difflink">' . $link . '</span>';
			$history->fr_pendingRevs = true; // pending rev shown above stable
		// Reviewed revision: highlight and add link
		} elseif ( isset( $row->fr_quality ) ) {
			if ( !( $row->rev_deleted & Revision::DELETED_TEXT ) ) {
				# Add link to stable version of *this* rev, if any
				list( $link, $class ) = self::markHistoryRow( $title, $row );
				# Space out and demark the stable revision
				if ( $revId == $history->fr_stableRevId && $history->fr_pendingRevs ) {
					$liClasses[] = 'fr-hist-stable-margin';
				}
			}
		}
		# Style the row as needed
		if ( $class ) $s = "<span class='$class'>$s</span>";
		# Add stable old version link
		if ( $link ) $s .= " $link";
		return true;
	}

	/**
	 * Make stable version link and return the css
	 * @param Title $title
	 * @param Row $row, from history page
	 * @return array (string,string)
	 */
	protected static function markHistoryRow( Title $title, $row ) {
		if ( !isset( $row->fr_quality ) ) {
			return array( "", "" ); // not reviewed
		}
		$liCss = FlaggedRevsXML::getQualityColor( $row->fr_quality );
		$flags = explode( ',', $row->fr_flags );
		if ( in_array( 'auto', $flags ) ) {
			$msg = ( $row->fr_quality >= 1 )
				? 'revreview-hist-quality-auto'
				: 'revreview-hist-basic-auto';
			$css = ( $row->fr_quality >= 1 )
				? 'fr-hist-quality-auto'
				: 'fr-hist-basic-auto';
		} else {
			$msg = ( $row->fr_quality >= 1 )
				? 'revreview-hist-quality-user'
				: 'revreview-hist-basic-user';
			$css = ( $row->fr_quality >= 1 )
				? 'fr-hist-quality-user'
				: 'fr-hist-basic-user';
		}
		$name = isset( $row->reviewer ) ?
			$row->reviewer : User::whoIs( $row->fr_user );
		$link = wfMsgExt( $msg, 'parseinline', $title->getPrefixedDBkey(), $row->rev_id, $name );
		$link = "<span class='$css plainlinks'>[$link]</span>";
		return array( $link, $liCss );
	}

	public static function addToFileHistLine( $hist, File $file, &$s, &$rowClass ) {
		if ( !$file->isVisible() ) {
			return true; // Don't bother showing notice for deleted revs
		}
		# Quality level for old versions selected all at once.
		# Commons queries cannot be done all at once...
		if ( !$file->isOld() || !$file->isLocal() ) {
			$dbr = wfGetDB( DB_SLAVE );
			$quality = $dbr->selectField( 'flaggedrevs', 'fr_quality',
				array( 'fr_img_sha1' => $file->getSha1(),
					'fr_img_timestamp' => $dbr->timestamp( $file->getTimestamp() ) ),
				__METHOD__
			);
		} else {
			$quality = is_null( $file->quality ) ? false : $file->quality;
		}
		# If reviewed, class the line
		if ( $quality !== false ) {
			$rowClass = FlaggedRevsXML::getQualityColor( $quality );
		}
		return true;
	}

	public static function addToContribsLine( $contribs, &$ret, $row ) {
		$namespaces = FlaggedRevs::getReviewNamespaces();
		if ( !in_array( $row->page_namespace, $namespaces ) ) {
			// do nothing
		} elseif ( isset( $row->fr_quality ) ) {
			$ret = '<span class="' . FlaggedRevsXML::getQualityColor( $row->fr_quality ) .
				'">' . $ret . '</span>';
		} elseif ( isset( $row->fp_pending_since )
			&& $row->rev_timestamp >= $row->fp_pending_since ) // bug 15515
		{
			$ret = '<span class="flaggedrevs-pending">' . $ret . '</span>';
		} elseif ( !isset( $row->fp_stable ) ) {
			$ret = '<span class="flaggedrevs-unreviewed">' . $ret . '</span>';
		}
		return true;
	}

	public static function addToChangeListLine( &$list, &$articlelink, &$s, RecentChange &$rc ) {
		global $wgUser;
		$title = $rc->getTitle(); // convenience
		if ( !FlaggedRevs::inReviewNamespace( $title )
			|| empty( $rc->mAttribs['rc_this_oldid'] ) // rev, not log
			|| !array_key_exists( 'fp_stable', $rc->mAttribs ) )
		{
			return true; // confirm that page is in reviewable namespace
		}
		$rlink = $css = '';
		// page is not reviewed
		if ( $rc->mAttribs['fp_stable'] == null ) {
			// Is this a config were pages start off reviewable?
			// Hide notice from non-reviewers due to vandalism concerns (bug 24002).
			if ( !FlaggedRevs::useOnlyIfProtected() && $wgUser->isAllowed( 'review' ) ) {
				$rlink = wfMsgHtml( 'revreview-unreviewedpage' );
				$css = 'flaggedrevs-unreviewed';
			}
		// page is reviewed and has pending edits (use timestamps; bug 15515)
		} elseif ( isset( $rc->mAttribs['fp_pending_since'] ) &&
			$rc->mAttribs['rc_timestamp'] >= $rc->mAttribs['fp_pending_since'] )
		{
			$rlink = $list->skin->link(
				$title,
				wfMsgHtml( 'revreview-reviewlink' ),
				array( 'title' => wfMsg( 'revreview-reviewlink-title' ) ),
				array( 'oldid' => $rc->mAttribs['fp_stable'], 'diff' => 'cur' ) +
					FlaggedRevs::diffOnlyCGI()
			);
			$css = 'flaggedrevs-pending';
		}
		if ( $rlink != '' ) {
			$articlelink .= " <span class=\"mw-fr-reviewlink $css\">[$rlink]</span>";
		}
		return true;
	}

	public static function injectPostEditURLParams( $article, &$sectionAnchor, &$extraQuery ) {
		if ( FlaggablePageView::globalArticleInstance() != null ) {
			$view = FlaggablePageView::singleton();
			$view->injectPostEditURLParams( $sectionAnchor, $extraQuery );
		}
		return true;
	}

	// diff=review param (bug 16923)
	public static function checkDiffUrl( $titleObj, &$mOldid, &$mNewid, $old, $new ) {
		if ( $new === 'review' && isset( $titleObj ) ) {
			$sRevId = FlaggedRevision::getStableRevId( $titleObj );
			if ( $sRevId ) {
				$mOldid = $sRevId; // stable
				$mNewid = 0; // cur
			}
		}
		return true;
	}

	public static function onDiffViewHeader( $diff, $oldRev, $newRev ) {
		self::injectStyleAndJS();
		$view = FlaggablePageView::singleton();
		$view->setViewFlags( $diff, $oldRev, $newRev );
		$view->addToDiffView( $diff, $oldRev, $newRev );
		return true;
	}

	public static function addRevisionIDField( $editPage, $out ) {
		$view = FlaggablePageView::singleton();
		$view->addRevisionIDField( $editPage, $out );
		return true;
	}

	public static function addReviewCheck( $editPage, &$checkboxes, &$tabindex ) {
		$view = FlaggablePageView::singleton();
		$view->addReviewCheck( $editPage, $checkboxes, $tabindex );
		return true;
	}

	protected static function maybeAddBacklogNotice( OutputPage &$out ) {
		global $wgUser;
		if ( !$wgUser->isAllowed( 'review' ) ) {
			return true; // not relevant to user
		}
		$namespaces = FlaggedRevs::getReviewNamespaces();
		$watchlist = SpecialPage::getTitleFor( 'Watchlist' );
		# Add notice to watchlist about pending changes...
		if ( $out->getTitle()->equals( $watchlist ) && $namespaces ) {
			$dbr = wfGetDB( DB_SLAVE, 'watchlist' ); // consistency with watchlist
			$watchedOutdated = (bool)$dbr->selectField(
				array( 'watchlist', 'page', 'flaggedpages' ),
				'1', // existence
				array( 'wl_user' => $wgUser->getId(), // this user
					'wl_namespace' => $namespaces, // reviewable
					'wl_namespace = page_namespace',
					'wl_title = page_title',
					'fp_page_id = page_id',
					'fp_pending_since IS NOT NULL', // edits pending
				), __METHOD__
			);
			# Give a notice if pages on the users's wachlist have pending edits
			if ( $watchedOutdated ) {
				$css = 'plainlinks fr-watchlist-pending-notice';
				$out->prependHTML( "<div id='mw-fr-watchlist-pending-notice' class='$css'>" .
					wfMsgExt( 'flaggedrevs-watched-pending', 'parseinline' ) . "</div>" );
			}
		}
		return true;
	}

	// Add selector of review "protection" options
	// Code stolen from Stabilization (which was stolen from ProtectionForm)
	public static function onProtectionForm( Page $article, &$output ) {
		global $wgUser, $wgOut, $wgRequest, $wgLang;
		if ( !$article->exists() ) {
			return true; // nothing to do
		} elseif ( !FlaggedRevs::inReviewNamespace( $article->getTitle() ) ) {
			return true; // not a reviewable page
		}
		$form = new PageStabilityProtectForm( $wgUser );
		$form->setPage( $article->getTitle() );
		# Can the user actually do anything?
		$isAllowed = $form->isAllowed();
		$disabledAttrib = $isAllowed ?
			array() : array( 'disabled' => 'disabled' );

		# Get the current config/expiry
		$config = FRPageConfig::getStabilitySettings( $article->getTitle(), FR_MASTER );
		$oldExpirySelect = ( $config['expiry'] == 'infinity' ) ? 'infinite' : 'existing';

		# Load requested restriction level, default to current level...
		$restriction = $wgRequest->getVal( 'mwStabilityLevel',
			FRPageConfig::getProtectionLevel( $config ) );
		# Load the requested expiry time (dropdown)
		$expirySelect = $wgRequest->getVal( 'mwStabilizeExpirySelection', $oldExpirySelect );
		# Load the requested expiry time (field)
		$expiryOther = $wgRequest->getVal( 'mwStabilizeExpiryOther', '' );
		if ( $expiryOther != '' ) $expirySelect = 'othertime'; // mutual exclusion

		# Add an extra row to the protection fieldset tables.
		# Includes restriction dropdown and expiry dropdown & field.
		$output .= "<tr><td>";
		$output .= Xml::openElement( 'fieldset' );
		$legendMsg = wfMsgExt( 'flaggedrevs-protect-legend', 'parseinline' );
		$output .= "<legend>{$legendMsg}</legend>";
		# Add a "no restrictions" level
		$effectiveLevels = FlaggedRevs::getRestrictionLevels();
		array_unshift( $effectiveLevels, "none" );
		# Show all restriction levels in a <select>...
		$attribs = array(
			'id'    => 'mwStabilityLevel',
			'name'  => 'mwStabilityLevel',
			'size'  => count( $effectiveLevels ),
		) + $disabledAttrib;
		$output .= Xml::openElement( 'select', $attribs );
		foreach ( $effectiveLevels as $limit ) {
			if ( $limit == 'none' ) {
				$label = wfMsg( 'flaggedrevs-protect-none' );
			} else {
				$label = wfMsg( 'flaggedrevs-protect-' . $limit );
			}
			// Default to the key itself if no UI message
			if ( wfEmptyMsg( 'flaggedrevs-protect-' . $limit, $label ) ) {
				$label = 'flaggedrevs-protect-' . $limit;
			}
			$output .= Xml::option( $label, $limit, $limit == $restriction );
		}
		$output .= Xml::closeElement( 'select' );

		# Get expiry dropdown <select>...
		$scExpiryOptions = wfMsgForContent( 'protect-expiry-options' );
		$showProtectOptions = ( $scExpiryOptions !== '-' && $isAllowed );
		# Add the current expiry as an option
		$expiryFormOptions = '';
		if ( $config['expiry'] != 'infinity' ) {
			$timestamp = $wgLang->timeanddate( $config['expiry'] );
			$d = $wgLang->date( $config['expiry'] );
			$t = $wgLang->time( $config['expiry'] );
			$expiryFormOptions .=
				Xml::option(
					wfMsg( 'protect-existing-expiry', $timestamp, $d, $t ),
					'existing',
					$expirySelect == 'existing'
				) . "\n";
		}
		$expiryFormOptions .= Xml::option( wfMsg( 'protect-othertime-op' ), 'othertime' ) . "\n";
		# Add custom dropdown levels (from MediaWiki message)
		foreach ( explode( ',', $scExpiryOptions ) as $option ) {
			if ( strpos( $option, ":" ) === false ) {
				$show = $value = $option;
			} else {
				list( $show, $value ) = explode( ":", $option );
			}
			$show = htmlspecialchars( $show );
			$value = htmlspecialchars( $value );
			$expiryFormOptions .= Xml::option( $show, $value, $expirySelect == $value ) . "\n";
		}
		# Actually add expiry dropdown to form
		$output .= "<table>"; // expiry table start
		if ( $showProtectOptions && $isAllowed ) {
			$output .= "
				<tr>
					<td class='mw-label'>" .
						Xml::label( wfMsg( 'stabilization-expiry' ),
							'mwStabilizeExpirySelection' ) .
					"</td>
					<td class='mw-input'>" .
						Xml::tags( 'select',
							array(
								'id'        => 'mwStabilizeExpirySelection',
								'name'      => 'mwStabilizeExpirySelection',
								'onchange'  => 'onFRChangeExpiryDropdown()',
							) + $disabledAttrib,
							$expiryFormOptions ) .
					"</td>
				</tr>";
		}
		# Add custom expiry field to form
		$attribs = array( 'id' => 'mwStabilizeExpiryOther',
			'onkeyup' => 'onFRChangeExpiryField()' ) + $disabledAttrib;
		$output .= "
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'stabilization-othertime' ), 'mwStabilizeExpiryOther' ) .
				'</td>
				<td class="mw-input">' .
					Xml::input( 'mwStabilizeExpiryOther', 50, $expiryOther, $attribs ) .
				'</td>
			</tr>';
		$output .= "</table>"; // expiry table end
		# Close field set and table row
		$output .= Xml::closeElement( 'fieldset' );
		$output .= "</td></tr>";

		# Add some javascript for expiry dropdowns
		$wgOut->addScript(
			"<script type=\"text/javascript\">
				function onFRChangeExpiryDropdown() {
					document.getElementById('mwStabilizeExpiryOther').value = '';
				}
				function onFRChangeExpiryField() {
					document.getElementById('mwStabilizeExpirySelection').value = 'othertime';
				}
			</script>"
		);
		return true;
	}

	// Add stability log extract to protection form
	public static function insertStabilityLog( Page $article, OutputPage $out ) {
		if ( !$article->exists() ) {
			return true; // nothing to do
		} elseif ( !FlaggedRevs::inReviewNamespace( $article->getTitle() ) ) {
			return true; // not a reviewable page
		}
		# Show relevant lines from the stability log:
		$out->addHTML( Xml::element( 'h2', null, LogPage::logName( 'stable' ) ) );
		LogEventsList::showLogExtract( $out, 'stable', $article->getTitle()->getPrefixedText() );
		return true;
	}

	// Update stability config from request
	public static function onProtectionSave( Page $article, &$errorMsg ) {
		global $wgUser, $wgRequest;
		if ( !$article->exists() ) {
			return true; // simple custom levels set for action=protect
		} elseif ( !FlaggedRevs::inReviewNamespace( $article->getTitle() ) ) {
			return true; // not a reviewable page
		} elseif ( wfReadOnly() || !$wgUser->isAllowed( 'stablesettings' ) ) {
			return true; // user cannot change anything
		}
		$form = new PageStabilityProtectForm( $wgUser );
		$form->setPage( $article->getTitle() ); // target page
		$permission = $wgRequest->getVal( 'mwStabilityLevel' );
		if ( $permission == "none" ) {
			$permission = ''; // 'none' => ''
		}
		$form->setAutoreview( $permission ); // protection level (autoreview restriction)
		$form->setWatchThis( null ); // protection form already has a watch check
		$form->setReasonExtra( $wgRequest->getText( 'mwProtect-reason' ) ); // manual
		$form->setReasonSelection( $wgRequest->getVal( 'wpProtectReasonSelection' ) ); // dropdown
		$form->setExpiryCustom( $wgRequest->getVal( 'mwStabilizeExpiryOther' ) ); // manual
		$form->setExpirySelection( $wgRequest->getVal( 'mwStabilizeExpirySelection' ) ); // dropdown
		$form->ready(); // params all set
		if ( $wgRequest->wasPosted() && $form->isAllowed() ) {
			$status = $form->submit();
			if ( $status !== true ) {
				$errorMsg = wfMsg( $status ); // some error message
			}
		}
		return true;
	}
}
