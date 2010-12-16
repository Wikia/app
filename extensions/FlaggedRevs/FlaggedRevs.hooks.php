<?php

class FlaggedRevsHooks {
	/* 
	 * Register FlaggedRevs special pages as needed. 
	 * Also sets $wgSpecialPages just to be consistent.
	 */
	public static function defineSpecialPages( &$list ) {
		global $wgSpecialPages, $wgUseTagFilter;
		global $wgFlaggedRevsNamespaces, $wgFlaggedRevsOverride, $wgFlaggedRevsProtectLevels;
		// Show special pages only if FlaggedRevs is enabled on some namespaces
		if ( empty( $wgFlaggedRevsNamespaces ) ) {
			return true;
		}
		$list['RevisionReview'] = $wgSpecialPages['RevisionReview'] = 'RevisionReview';
		$list['ReviewedVersions'] = $wgSpecialPages['ReviewedVersions'] = 'ReviewedVersions';
		// Protect levels define allowed stability settings
		if ( empty( $wgFlaggedRevsProtectLevels ) ) {
			$list['Stabilization'] = $wgSpecialPages['Stabilization'] = 'Stabilization';
		}
		$list['UnreviewedPages'] = $wgSpecialPages['UnreviewedPages'] = 'UnreviewedPages';
		$list['OldReviewedPages'] = $wgSpecialPages['OldReviewedPages'] = 'OldReviewedPages';
		// Show tag filtered pending edit page if there are tags
		if ( $wgUseTagFilter && ChangeTags::listDefinedTags() ) {
			$list['ProblemChanges'] = $wgSpecialPages['ProblemChanges'] = 'ProblemChanges';
		}
		$list['ReviewedPages'] = $wgSpecialPages['ReviewedPages'] = 'ReviewedPages';
		$list['QualityOversight'] = $wgSpecialPages['QualityOversight'] = 'QualityOversight';
		$list['ValidationStatistics'] = $wgSpecialPages['ValidationStatistics'] = 'ValidationStatistics';
		if ( !$wgFlaggedRevsOverride ) {
			$list['StablePages'] = $wgSpecialPages['StablePages'] = 'StablePages';
		} else {
			$list['UnstablePages'] = $wgSpecialPages['UnstablePages'] = 'UnstablePages';
		}
		return true;
	}

	/**
	* Add FlaggedRevs css/js.
	*/
	protected static function injectStyleAndJS() {
		global $wgOut, $wgUser;
		if ( $wgOut->hasHeadItem( 'FlaggedRevs' ) ) {
			return true; # Don't double-load
		}
		$fa = FlaggedArticleView::globalArticleInstance();
		# Try to only add to relevant pages
		if ( !$fa || !$fa->isReviewable() ) {
			return true;
		}
		global $wgScriptPath, $wgJsMimeType, $wgFlaggedRevsStylePath, $wgFlaggedRevStyleVersion;
		$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFlaggedRevsStylePath );
		# Get JS/CSS file locations
		$encCssFile = htmlspecialchars( "$stylePath/flaggedrevs.css?$wgFlaggedRevStyleVersion" );
		$encJsFile = htmlspecialchars( "$stylePath/flaggedrevs.js?$wgFlaggedRevStyleVersion" );
		# Add CSS file
		$wgOut->addExtensionStyle( $encCssFile );
		# Add main JS file
		$head = "<script type=\"{$wgJsMimeType}\" src=\"{$encJsFile}\"></script>";
		# Add review form JS for reviewers
		if ( $wgUser->isAllowed( 'review' ) ) {
			$encJsFile = htmlspecialchars( "$stylePath/review.js?$wgFlaggedRevStyleVersion" );
			$head .= "\n<script type=\"{$wgJsMimeType}\" src=\"{$encJsFile}\"></script>";
		}
		# Set basic messages
		$msgs = (object) array(
			'revreviewDiffToggleShow' => wfMsgHtml( 'revreview-diff-toggle-show' ),
			'revreviewDiffToggleHide' => wfMsgHtml( 'revreview-diff-toggle-hide' )
		);
		$head .= "\n<script type=\"{$wgJsMimeType}\">" .
			"FlaggedRevs.messages = " . Xml::encodeJsVar( $msgs ) . ";</script>\n";
		$wgOut->addHeadItem( 'FlaggedRevs', $head );

		return true;
	}
	
	public static function injectGlobalJSVars( &$globalVars ) {
		global $wgUser;
		$fa = FlaggedArticleView::globalArticleInstance();
		# Try to only add to relevant pages
		if ( !$fa || !FlaggedRevs::inReviewNamespace( $fa->getTitle() ) ) {
			return true;
		}
		# Get the review tags on this wiki
		$rTags = FlaggedRevs::getJSTagParams();
		# Get page-specific meta-data
		$frev = $fa->getStableRev();
		$stableId = $frev ? $frev->getRevId() : 0;
		$globalVars['wgFlaggedRevsParams'] = $rTags;
		$globalVars['wgStableRevisionId'] = $stableId;
		if ( $wgUser->isAllowed( 'review' ) ) {
			$ajaxReview = (object) array(
				'sendMsg'		 => wfMsgHtml( 'revreview-submit' ),
				'flagMsg'		 => wfMsgHtml( 'revreview-submit-review' ),
				'unflagMsg'		 => wfMsgHtml( 'revreview-submit-unreview' ),
				'flagLegMsg'	 => wfMsgHtml( 'revreview-flag' ),
				'sendingMsg'     => wfMsgHtml( 'revreview-submitting' ),
				'actioncomplete' => wfMsgHtml( 'actioncomplete' ),
				'actionfailed'	 => wfMsgHtml( 'actionfailed' ),
				'draftRev'  	 => wfMsgHtml( 'revreview-hist-draft' ),
				'sightedRev' 	 => wfMsgHtml( 'revreview-hist-basic' ),
				'qualityRev' 	 => wfMsgHtml( 'revreview-hist-quality' ),
			);
			$globalVars['wgAjaxReview'] = $ajaxReview; // language for AJAX form
		}
		return true;
	}
	
	/**
	* Add FlaggedRevs css for relevant special pages.
	*/
	protected static function injectStyleForSpecial() {
		global $wgTitle, $wgOut;
		if ( empty( $wgTitle ) || $wgTitle->getNamespace() !== NS_SPECIAL ) {
			return true;
		}
		$spPages = array( 'UnreviewedPages', 'OldReviewedPages', 'Watchlist',
			'Recentchanges', 'Contributions' );
		foreach ( $spPages as $n => $key ) {
			if ( $wgTitle->isSpecial( $key ) ) {
				global $wgScriptPath, $wgFlaggedRevsStylePath, $wgFlaggedRevStyleVersion;
				$stylePath = str_replace( '$wgScriptPath',
					$wgScriptPath, $wgFlaggedRevsStylePath );
				$encCssFile = htmlspecialchars( "$stylePath/flaggedrevs.css?" .
					$wgFlaggedRevStyleVersion );
				$wgOut->addExtensionStyle( $encCssFile );
				break;
			}
		}
		return true;
	}
	
	/*
	* Add tag notice, CSS/JS, and set robots policy
	*/
	public static function onBeforePageDisplay() {
		global $wgOut;
		if ( $wgOut->isArticleRelated() ) {
			$view = FlaggedArticleView::singleton();
			$view->displayTag(); // show notice bar/icon in subtitle
			$view->setRobotPolicy(); // set indexing policy
			self::injectStyleAndJS(); // full CSS/JS
		} else {
			self::injectStyleForSpecial(); // try special page CSS
		}
		return true;
	}
	
	public static function markUnderReview( $output, $article, $title, $user, $request ) {
		if( !$user->isAllowed( 'review' ) ) {
			return true; // user cannot review
		}
		# Set a key to note when someone is reviewing this.
		# NOTE: diff-to-stable views already handled elsewhere.
		if ( $request->getInt( 'reviewing' ) || $request->getInt( 'rcid' ) ) {
			global $wgMemc;
			$key = wfMemcKey( 'unreviewedPages', 'underReview', $title->getArticleId() );
			$wgMemc->set( $key, '1', 20 * 60 ); // 20 min
		}
		return true;
	}

	/**
	* Update flaggedrevs table on revision restore
	*/
	public static function onRevisionRestore( $title, $revision, $oldPageID ) {
		$dbw = wfGetDB( DB_MASTER );
		# Some revisions may have had null rev_id values stored when deleted.
		# This hook is called after insertOn() however, in which case it is set
		# as a new one.
		$dbw->update( 'flaggedrevs',
			array( 'fr_page_id' => $revision->getPage() ),
			array( 'fr_page_id' => $oldPageID,
				'fr_rev_id' => $revision->getID() ),
			__METHOD__
		);
		return true;
	}

	/**
	* Update flaggedrevs table on article history merge
	*/
	public static function updateFromMerge( $sourceTitle, $destTitle ) {
		$oldPageID = $sourceTitle->getArticleID();
		$newPageID = $destTitle->getArticleID();
		# Get flagged revisions from old page id that point to destination page
		$dbw = wfGetDB( DB_MASTER );
		$result = $dbw->select( array( 'flaggedrevs', 'revision' ),
			array( 'fr_rev_id' ),
			array( 'fr_page_id' => $oldPageID,
				'fr_rev_id = rev_id',
				'rev_page' => $newPageID ),
			__METHOD__ );
		# Update these rows
		$revIDs = array();
		while ( $row = $dbw->fetchObject( $result ) ) {
			$revIDs[] = $row->fr_rev_id;
		}
		if ( !empty( $revIDs ) ) {
			$dbw->update( 'flaggedrevs',
				array( 'fr_page_id' => $newPageID ),
				array( 'fr_page_id' => $oldPageID,
					'fr_rev_id' => $revIDs ),
				__METHOD__ );
		}
		# Update pages..stable version possibly lost to another page
		FlaggedRevs::titleLinksUpdate( $sourceTitle );
		FlaggedRevs::titleLinksUpdate( $destTitle );

		return true;
	}
	
	/**
	* Update flaggedrevs tracking tables
	*/
	public static function onArticleDelete( &$article, &$user, $reason, $id ) {
		FlaggedRevs::clearTrackingRows( $id );
		return true;
	}
	
	/**
	* Update stable version selection
	*/
	public static function onRevisionDelete( &$title ) {
		FlaggedRevs::titleLinksUpdate( $title );
		return true;
	}
	
	/**
	* Update pending revision table
	* Autoreview pages moved into content NS
	*/
	public static function onTitleMoveComplete( &$otitle, &$ntitle, $user, $pageId ) {
		$fa = FlaggedArticle::getTitleInstance( $ntitle );
		// Re-validate NS/config (new title may not be reviewable)
		if ( $fa->isReviewable( FR_MASTER ) ) {
			// Moved from non-reviewable to reviewable NS?
			if ( FlaggedRevs::autoReviewNewPages() && $user->isAllowed( 'autoreview' )
				&& !FlaggedRevs::inReviewNamespace( $otitle ) )
			{
				$rev = Revision::newFromTitle( $ntitle );
				// Treat this kind of like a new page...
				FlaggedRevs::autoReviewEdit( $fa, $user, $rev->getText(), $rev );
				return true; // pending list handled
			} else if ( $fa->getStableRev( FR_MASTER ) ) {
				return true; // nothing to do
			}
		}
		FlaggedRevs::clearTrackingRows( $pageId );
		return true;
	}

	/**
	* Inject stable links on LinksUpdate
	*/
	public static function extraLinksUpdate( $linksUpdate ) {
		$dbw = wfGetDB( DB_MASTER );
		$pageId = $linksUpdate->mTitle->getArticleId();
		# Check if this page has a stable version...
		if ( isset( $u->fr_stableRev ) ) {
			$sv = $u->fr_stableRev; // Try the process cache...
		} else {
			$fa = FlaggedArticle::getTitleInstance( $linksUpdate->mTitle );
			if ( FlaggedRevs::inReviewNamespace( $linksUpdate->mTitle ) ) {
				$sv = $fa->getStableRev( FR_MASTER ); // re-validate NS/config
			} else {
				$sv = null;
			}
		}
		# Empty flagged revs data for this page if there is no stable version
		if ( !$sv ) {
			FlaggedRevs::clearTrackingRows( $pageId );
			return true;
		}
		# Try the process cache...
		$article = new Article( $linksUpdate->mTitle );
		if ( isset( $linksUpdate->fr_stableParserOut ) ) {
			$parserOut = $linksUpdate->fr_stableParserOut;
		} else {
			global $wgUser;
			# Try stable version cache. This should be updated before this is called.
			$anon = new User; // anon cache most likely to exist
			$parserOut = FlaggedRevs::getPageCache( $article, $anon );
			if ( $parserOut == false && $wgUser->getId() )
				$parserOut = FlaggedRevs::getPageCache( $article, $wgUser );
			if ( $parserOut == false ) {
				$text = $sv->getRevText();
				# Parse the text
				$parserOut = FlaggedRevs::parseStableText( $article, $text, $sv->getRevId() );
			}
		}
		# Update page fields
		FlaggedRevs::updateStableVersion( $article, $sv->getRevision() );
		# Get the list of categories that must be reviewed
		$reviewedCats = array();
		$msg = wfMsgForContent( 'flaggedrevs-stable-categories' );
		if ( !wfEmptyMsg( 'flaggedrevs-stable-categories', $msg ) ) {
			$list = explode( "\n*", "\n$msg" );
			foreach ( $list as $category ) {
				$category = trim( $category );
				if ( $category != '' )
					$reviewedCats[$category] = 1;
			}
		}
		$links = array();
		# Get any links that are only in the stable version...
		foreach ( $parserOut->getLinks() as $ns => $titles ) {
			foreach ( $titles as $title => $id ) {
				if ( !isset( $linksUpdate->mLinks[$ns] )
					|| !isset( $linksUpdate->mLinks[$ns][$title] ) )
				{
					self::addLink( $links, $ns, $title );
				}
			}
		}
		# Get any images that are only in the stable version...
		foreach ( $parserOut->getImages() as $image => $n ) {
			if ( !isset( $linksUpdate->mImages[$image] ) ) {
				self::addLink( $links, NS_FILE, $image );
			}
		}
		# Get any templates that are only in the stable version...
		foreach ( $parserOut->getTemplates() as $ns => $titles ) {
			foreach ( $titles as $title => $id ) {
				if ( !isset( $linksUpdate->mTemplates[$ns] )
					|| !isset( $linksUpdate->mTemplates[$ns][$title] ) )
				{
					self::addLink( $links, $ns, $title );
				}
			}
		}
		# Get any categories that are only in the stable version...
		foreach ( $parserOut->getCategories() as $category => $sort ) {
            if ( !isset( $linksUpdate->mCategories[$category] ) ) {
				// Stable categories must remain until removed from the stable version
				if ( isset( $reviewedCats[$category] ) ) {
					$linksUpdate->mCategories[$category] = $sort;
				} else {
					self::addLink( $links, NS_CATEGORY, $category );
				}
			}
        }
		$stableCats = $parserOut->getCategories(); // from stable version
		foreach ( $reviewedCats as $category ) {
			// Stable categories cannot be added until added to the stable version
			if ( isset( $linksUpdate->mCategories[$category] )
				&& !isset( $stableCats[$category] ) )
			{
				unset( $linksUpdate->mCategories[$category] );
			}
		}
		# Get any link tracking changes
		$existing = self::getExistingLinks( $pageId );
		$insertions = self::getLinkInsertions( $existing, $links, $pageId );
		$deletions = self::getLinkDeletions( $existing, $links );
		# Delete removed links
		if ( $clause = self::makeWhereFrom2d( $deletions ) ) {
			$where = array( 'ftr_from' => $pageId );
			$where[] = $clause;
			$dbw->delete( 'flaggedrevs_tracking', $where, __METHOD__ );
		}
		# Add any new links
		if ( count( $insertions ) ) {
			$dbw->insert( 'flaggedrevs_tracking', $insertions, __METHOD__, 'IGNORE' );
		}
		return true;
	}
	
	protected static function addLink( &$links, $ns, $dbKey ) {
		if ( !isset( $links[$ns] ) ) {
			$links[$ns] = array();
		}
		$links[$ns][$dbKey] = 1;
	}
	
	protected static function getExistingLinks( $pageId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'flaggedrevs_tracking',
			array( 'ftr_namespace', 'ftr_title' ),
			array( 'ftr_from' => $pageId ),
			__METHOD__ );
		$arr = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( !isset( $arr[$row->ftr_namespace] ) ) {
				$arr[$row->ftr_namespace] = array();
			}
			$arr[$row->ftr_namespace][$row->ftr_title] = 1;
		}
		return $arr;
	}
	
	protected static function makeWhereFrom2d( &$arr ) {
		$lb = new LinkBatch();
		$lb->setArray( $arr );
		return $lb->constructSet( 'ftr', wfGetDB( DB_SLAVE ) );
	}
	
	protected static function getLinkInsertions( $existing, $new, $pageId ) {
		$arr = array();
		foreach ( $new as $ns => $dbkeys ) {
			$diffs = isset( $existing[$ns] ) ?
				array_diff_key( $dbkeys, $existing[$ns] ) : $dbkeys;
			foreach ( $diffs as $dbk => $id ) {
				$arr[] = array(
					'ftr_from'      => $pageId,
					'ftr_namespace' => $ns,
					'ftr_title'     => $dbk
				);
			}
		}
		return $arr;
	}
	
	protected static function getLinkDeletions( $existing, $new ) {
		$del = array();
		foreach ( $existing as $ns => $dbkeys ) {
			if ( isset( $new[$ns] ) ) {
				$del[$ns] = array_diff_key( $existing[$ns], $new[$ns] );
			} else {
				$del[$ns] = $existing[$ns];
			}
		}
		return $del;
	}
	
	/*
	* Update pages where only the stable version links to a page
	* that was just changed in some way.
	*/
	public static function doCacheUpdate( $title ) {
		$update = new FRCacheUpdate( $title );
		$update->doUpdate();
		return true;
	}
	
	/**
	* Add special fields to parser.
	*/
	public static function parserAddFields( $parser ) {
		$parser->mOutput->fr_ImageSHA1Keys = array();
		$parser->mOutput->fr_newestImageTime = "0";
		$parser->mOutput->fr_newestTemplateID = 0;
		$parser->mOutput->fr_includeErrors = array();
		return true;
	}

	/**
	* Select the desired templates based on the selected stable revision IDs
	*/
	public static function parserFetchStableTemplate( $parser, $title, &$skip, &$id ) {
		# Trigger for stable version parsing only
		if ( !$parser || empty( $parser->fr_isStable ) || $title->getNamespace() < 0 ) {
			return true;
		}
		if( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return true; // use the current version as normal
		}
		$dbr = wfGetDB( DB_SLAVE );
		# Check for stable version of template if this feature is enabled.
		# Should be in reviewable namespace, this saves unneeded DB checks as
		# well as enforce site settings if they are later changed.
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE
			&& FlaggedRevs::inReviewNamespace( $title ) && $title->getArticleId() )
		{
			$id = $dbr->selectField( 'flaggedpages', 'fp_stable',
				array( 'fp_page_id' => $title->getArticleId() ),
				__METHOD__ );
		}
		# Check cache before doing another DB hit...
		$idP = FlaggedRevs::getTemplateIdFromCache( $parser->getRevisionId(),
			$title->getNamespace(), $title->getDBkey() );
		# Use the process cache key if it's newer or we have none yet
		if ( !is_null( $idP ) && ( !$id || $idP > $id ) ) {
			$id = $idP;
		}
		# If there is no stable version (or that feature is not enabled), use
		# the template revision during review time. If both, use the newest one.
		$revId = $parser->getRevisionId();
		if ( $revId && !FlaggedRevs::useProcessCache( $revId ) ) {
			$idP = $dbr->selectField( 'flaggedtemplates',
				'ft_tmp_rev_id',
				array( 'ft_rev_id'  => $revId,
					'ft_namespace'  => $title->getNamespace(),
					'ft_title' 		=> $title->getDBkey() ),
				__METHOD__
			);
			# Take the newest (or only available) of the two
			$id = ( $id === false || $idP > $id ) ? $idP : $id;
		}
		# If none specified, see if we are allowed to use the current revision
		if ( !$id ) {
			global $wgUseCurrentTemplates;
			if ( $id === false ) {
				// May want to give an error
				$parser->mOutput->fr_includeErrors[] = $title->getPrefixedDBKey();
				if ( !$wgUseCurrentTemplates ) {
					$skip = true;
				}
			} else {
				$skip = true; // If ID is zero, don't load it
			}
		}
		if ( $id > $parser->mOutput->fr_newestTemplateID ) {
			$parser->mOutput->fr_newestTemplateID = $id;
		}
		return true;
	}

	/**
	* Select the desired images based on the selected stable revision times/SHA-1s
	*/
	public static function parserMakeStableFileLink(
		$parser, $nt, &$skip, &$time, &$query = false
	) {
		# Trigger for stable version parsing only
		if ( empty( $parser->fr_isStable ) ) {
			return true;
		}
		if( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return true; // use the current version as normal
		}
		$file = null;
		$isKnownLocal = $isLocalFile = false; // local file on this wiki?
		# Normalize NS_MEDIA to NS_FILE
		if ( $nt->getNamespace() == NS_MEDIA ) {
			$title = Title::makeTitle( NS_FILE, $nt->getDBkey() );
			$title->resetArticleId( $nt->getArticleId() ); // avoid extra queries
		} else {
			$title =& $nt;
		}
		# Check for stable version of image if this feature is enabled.
		# Should be in reviewable namespace, this saves unneeded DB checks as
		# well as enforce site settings if they are later changed.
		$sha1 = '';
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE
			&& FlaggedRevs::inReviewNamespace( $title ) )
		{
			$srev = FlaggedRevision::newFromStable( $title );
			if ( $srev && $srev->getFileTimestamp() ) {
				$time = $srev->getFileTimestamp(); // TS or null
				$sha1 = $srev->getFileSha1();
				$isKnownLocal = true; // must be local
			}
		}
		# Check cache before doing another DB hit...
		$params = FlaggedRevs::getFileVersionFromCache(
			$parser->getRevisionId(), $title->getDBkey() );
		if ( is_array( $params ) ) {
			list( $timeP, $sha1P ) = $params;
			// Take the newest one...
			if ( !$time || $timeP > $time ) {
				$time = $timeP;
				$sha1 = $sha1P;
				$isKnownLocal = false; // up in the air...possibly a commons image
			}
		}
		# If there is no stable version (or that feature is not enabled), use
		# the image revision during review time. If both, use the newest one.
		$revId = $parser->getRevisionId();
		if ( $revId && !FlaggedRevs::useProcessCache( $revId ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow( 'flaggedimages',
				array( 'fi_img_timestamp', 'fi_img_sha1' ),
				array( 'fi_rev_id' => $parser->getRevisionId(), 'fi_name' => $title->getDBkey() ),
				__METHOD__
			);
			# Only the one picked at review time exists OR it is the newest...use it!
			if ( $row && ( $time === false || $row->fi_img_timestamp > $time ) ) {
				$time = $row->fi_img_timestamp;
				$sha1 = $row->fi_img_sha1;
				$isKnownLocal = false; // up in the air...possibly a commons image
			}
		}
		$query = $time ? "filetimestamp=" . urlencode( wfTimestamp( TS_MW, $time ) ) : "";
		# If none specified, see if we are allowed to use the current revision
		if ( !$time ) {
			global $wgUseCurrentImages;
			# If the DB found nothing...
			if ( $time === false ) {
				# May want to give an error, so track these...
				$parser->mOutput->fr_includeErrors[] = $title->getPrefixedDBKey();
				if ( !$wgUseCurrentImages ) {
					$time = "0"; // no image
				} else {
					$file = wfFindFile( $title );
					$time = $file ? $file->getTimestamp() : "0"; // Use current
				}
			} else {
				$time = "0"; // no image (may trigger on review)
			}
		}
		# Add image metadata to parser output
		$parser->mOutput->fr_ImageSHA1Keys[$title->getDBkey()] = array();
		$parser->mOutput->fr_ImageSHA1Keys[$title->getDBkey()][$time] = $sha1;
		# Check if this file is local or on a foreign repo...
		if ( $isKnownLocal ) {
			$isLocalFile = true; // no need to check
		# Load the image if needed (note that time === '0' means we have no image)
		} elseif ( $time !== "0" ) {
			# FIXME: would be nice not to double fetch!
			$file = $file ? $file : self::getLocalFile( $title, $time );
			$isLocalFile = $file && $file->exists() && $file->isLocal();
		}
		# Bug 15748, be lax about commons image sync status...
		# When getting the max timestamp, just ignore the commons image timestamps.
		if ( $isLocalFile && $time > $parser->mOutput->fr_newestImageTime ) {
			$parser->mOutput->fr_newestImageTime = $time;
		}
		return true;
	}

	/**
	* Select the desired images based on the selected stable revision times/SHA-1s
	*/
	public static function galleryFindStableFileTime( $ig, $nt, &$time, &$query = false ) {
		# Trigger for stable version parsing only
		if ( empty( $ig->mParser->fr_isStable ) || $nt->getNamespace() != NS_FILE ) {
			return true;
		}
		if( FlaggedRevs::inclusionSetting() == FR_INCLUDES_CURRENT ) {
			return true; // use the current version as normal
		}
		$file = null;
		$isKnownLocal = $isLocalFile = false; // local file on this wiki?
		# Check for stable version of image if this feature is enabled.
		# Should be in reviewable namespace, this saves unneeded DB checks as
		# well as enforce site settings if they are later changed.
		$sha1 = "";
		if ( FlaggedRevs::inclusionSetting() == FR_INCLUDES_STABLE
			&& FlaggedRevs::inReviewNamespace( $nt ) )
		{
			$srev = FlaggedRevision::newFromStable( $nt );
			if ( $srev && $srev->getFileTimestamp() ) {
				$time = $srev->getFileTimestamp(); // TS or null
				$sha1 = $srev->getFileSha1();
				$isKnownLocal = true; // must be local
			}
		}
		# Check cache before doing another DB hit...
		$params = FlaggedRevs::getFileVersionFromCache( $ig->mRevisionId, $nt->getDBkey() );
		if ( is_array( $params ) ) {
			list( $timeP, $sha1P ) = $params;
			// Take the newest one...
			if ( !$time || $timeP > $time ) {
				$time = $timeP;
				$sha1 = $sha1P;
				$isKnownLocal = false; // up in the air...possibly a commons image
			}
		}
		# If there is no stable version (or that feature is not enabled), use
		# the image revision during review time. If both, use the newest one.
		if ( $ig->mRevisionId && !FlaggedRevs::useProcessCache( $ig->mRevisionId ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow( 'flaggedimages',
				array( 'fi_img_timestamp', 'fi_img_sha1' ),
				array( 'fi_rev_id' => $ig->mRevisionId, 'fi_name' => $nt->getDBkey() ),
				__METHOD__
			);
			# Only the one picked at review time exists OR it is the newest...use it!
			if ( $row && ( $time === false || $row->fi_img_timestamp > $time ) ) {
				$time = $row->fi_img_timestamp;
				$sha1 = $row->fi_img_sha1;
				$isKnownLocal = false; // up in the air...possibly a commons image
			}
		}
		$query = $time ? "filetimestamp=" . urlencode( wfTimestamp( TS_MW, $time ) ) : "";
		# If none specified, see if we are allowed to use the current revision
		if ( !$time ) {
			global $wgUseCurrentImages;
			# If the DB found nothing...
			if ( $time === false ) {
				# May want to give an error, so track these...
				$ig->mParser->mOutput->fr_includeErrors[] = $nt->getPrefixedDBKey();
				if ( !$wgUseCurrentImages ) {
					$time = "0"; // no image
				} else {
					$file = wfFindFile( $nt );
					$time = $file ? $file->getTimestamp() : "0";
				}
			} else {
				$time = "0"; // no image (may trigger on review)
			}
		}
		# Add image metadata to parser output
		$ig->mParser->mOutput->fr_ImageSHA1Keys[$nt->getDBkey()] = array();
		$ig->mParser->mOutput->fr_ImageSHA1Keys[$nt->getDBkey()][$time] = $sha1;
		# Check if this file is local or on a foreign repo...
		if ( $isKnownLocal ) {
			$isLocalFile = true; // no need to check
		# Load the image if needed (note that time === '0' means we have no image)
		} elseif ( $time !== "0" ) {
			# FIXME: would be nice not to double fetch!
			$file = $file ? $file : self::getLocalFile( $nt, $time );
			$isLocalFile = $file && $file->exists() && $file->isLocal();
		}
		# Bug 15748, be lax about commons image sync status
		if ( $isLocalFile && $time > $ig->mParser->mOutput->fr_newestImageTime ) {
			$ig->mParser->mOutput->fr_newestImageTime = $time;
		}
		return true;
	}
	
	/**
	* Insert image timestamps/SHA-1 keys into parser output
	*/
	public static function parserInjectTimestamps( $parser, &$text ) {
		# Don't trigger this for stable version parsing...it will do it separately.
		if ( !empty( $parser->fr_isStable ) ) {
			return true;
		}
		$maxRevision = 0;
		# Record the max template revision ID
		if ( !empty( $parser->mOutput->mTemplateIds ) ) {
			foreach ( $parser->mOutput->mTemplateIds as $namespace => $DBKeyRev ) {
				foreach ( $DBKeyRev as $DBkey => $revID ) {
					if ( $revID > $maxRevision ) {
						$maxRevision = $revID;
					}
				}
			}
		}
		$parser->mOutput->fr_newestTemplateID = $maxRevision;
		# Fetch the current timestamps of the images.
		$maxTimestamp = "0";
		if ( !empty( $parser->mOutput->mImages ) ) {
			foreach ( $parser->mOutput->mImages as $filename => $x ) {
				# FIXME: it would be nice not to double fetch these!
				$file = wfFindFile( Title::makeTitleSafe( NS_FILE, $filename ) );
				$parser->mOutput->fr_ImageSHA1Keys[$filename] = array();
				if ( $file ) {
					$ts = $file->getTimestamp();
					# Bug 15748, be lax about commons image sync status
					if ( $file->isLocal() && $ts > $maxTimestamp ) {
						$maxTimestamp = $ts;
					}
					$parser->mOutput->fr_ImageSHA1Keys[$filename][$ts] = $file->getSha1();
				} else {
					$parser->mOutput->fr_ImageSHA1Keys[$filename]["0"] = '';
				}
			}
		}
		# Record the max timestamp
		$parser->mOutput->fr_newestImageTime = $maxTimestamp;
		return true;
	}

	/**
	* Insert image timestamps/SHA-1s into page output
	*/
	public static function outputInjectTimestamps( $out, $parserOut ) {
		# Set first time
		$out->fr_ImageSHA1Keys = isset( $out->fr_ImageSHA1Keys ) ?
			$out->fr_ImageSHA1Keys : array();
		# Leave as defaults if missing. Relevant things will be updated only when needed.
		# We don't want to go around resetting caches all over the place if avoidable...
		$imageSHA1Keys = isset( $parserOut->fr_ImageSHA1Keys ) ?
			$parserOut->fr_ImageSHA1Keys : array();
		# Add on any new items
		$out->fr_ImageSHA1Keys = wfArrayMerge( $out->fr_ImageSHA1Keys, $imageSHA1Keys );
		return true;
	}

	protected static function getLocalFile( $title, $time ) {
		return RepoGroup::singleton()->getLocalRepo()->findFile( $title, $time );
	}

	/**
	* Check page move and patrol permissions for FlaggedRevs
	*/
	public static function onUserCan( $title, $user, $action, &$result ) {
		if ( $result === false ) {
			return true; // nothing to do
		}
		# Don't let users vandalize pages by moving them...
		if ( $action === 'move' ) {
			if ( !FlaggedRevs::inReviewNamespace( $title ) || !$title->exists() ) {
				return true;
			}
			$flaggedArticle = FlaggedArticle::getTitleInstance( $title );
			# If the current shows be default anyway, nothing to do...
			if ( !$flaggedArticle->isStableShownByDefault() ) {
				return true;
			}
			$frev = $flaggedArticle->getStableRev();
			if ( $frev && !$user->isAllowed( 'review' ) && !$user->isAllowed( 'movestable' ) ) {
				# Allow for only editors/reviewers to move this page
				$result = false;
				return false;
			}
		# Don't let users patrol pages not in $wgFlaggedRevsPatrolNamespaces
		} else if ( $action === 'patrol' || $action === 'autopatrol' ) {
			$flaggedArticle = FlaggedArticle::getTitleInstance( $title );
			# For a page to be patrollable it must not be reviewable.
			# Note: normally, edits to non-reviewable, non-patrollable, pages are
			# silently marked patrolled automatically. With $wgUseNPPatrol on, the
			# first edit to those pages is left as being unpatrolled.
			if ( $flaggedArticle->isReviewable() ) {
				$result = false;
				return false;
			}
		# Enforce autoreview restrictions
		} else if( $action === 'autoreview' ) {
			# Get autoreview restriction settings...
			$config = FlaggedRevs::getPageVisibilitySettings( $title, true );
			# Convert Sysop -> protect
			$right = ( $config['autoreview'] === 'sysop' ) ?
				'protect' : $config['autoreview'];
			# Check if the user has the required right, if any
			if( $right != '' && !$user->isAllowed( $right ) ) {
				$result = false;
				return false;
			}
		}
		return true;
	}
	
    /**
    * Allow users to view reviewed pages
    */
    public static function userCanView( $title, $user, $action, &$result ) {
        global $wgFlaggedRevsVisible, $wgFlaggedRevsTalkVisible, $wgTitle;
        # Assume $action may still not be set, in which case, treat it as 'view'...
		# Return out if $result set to false by some other hooked call.
        if ( $action !== 'read' || $result === false || empty( $wgFlaggedRevsVisible ) )
            return true;
        # Admin may set this to false, rather than array()...
        $groups = $user->getGroups();
        $groups[] = '*';
        if ( !array_intersect( $groups, $wgFlaggedRevsVisible ) )
            return true;
        # Is this a talk page?
        if ( $wgFlaggedRevsTalkVisible && $title->isTalkPage() ) {
            $result = true;
            return true;
        }
        # See if there is a stable version. Also, see if, given the page 
        # config and URL params, the page can be overriden. The later
		# only applies on page views of $title.
		$flaggedArticle = FlaggedArticle::getTitleInstance( $title );
        if ( !empty( $wgTitle ) && $wgTitle->equals( $title ) ) {
			$view = FlaggedArticleView::singleton();
            // Cache stable version while we are at it.
            if ( $view->pageOverride() && $flaggedArticle->getStableRev() ) {
                $result = true;
            }
        } else {
            if ( FlaggedRevision::newFromStable( $title ) ) {
                $result = true;
            }
        }
        return true;
    }
	
	/**
	* When an edit is made by a reviewer, if the base revision the
	* edit was made from is the stable version, or the edit is a reversion
	* to the stable version, then try to automatically review it.
	* Also automatically review if the "review this revision" box is checked.
	*/
	public static function maybeMakeEditReviewed(
		$article, $rev, $baseRevId = false, $user = null
	) {
		global $wgRequest;
		# Edit must be non-null, and to a reviewable page
		$fa = FlaggedArticle::getArticleInstance( $article );
		if ( !$rev || !$fa->isReviewable( FR_MASTER ) ) {
			return true;
		}
		if ( !$user ) {
			$user = User::newFromId( $rev->getUser() );
		}
		$title = $article->getTitle();
		$title->resetArticleID( $rev->getPage() ); // Avoid extra DB hit and lag issues
		# Get what was just the current revision ID
		$prevRevId = $rev->getParentId();
		$prevTimestamp = $frev = $flags = null;
		# Get edit timestamp. Existance already validated by EditPage.php.
		$editTimestamp = $wgRequest->getVal( 'wpEdittime' );
		# Is the page manually checked off to be reviewed?
		if ( $wgRequest->getCheck( 'wpReviewEdit' ) && $user->isAllowed( 'review' ) ) {
			# Check wpEdittime against the previous edit for verification
			if ( $prevRevId ) {
				$prevTimestamp = Revision::getTimestampFromId( $title, $prevRevId );
			}
			# Review this revision of the page unless edit was auto-merged in between...
			if ( !$editTimestamp || !$prevTimestamp || $prevTimestamp == $editTimestamp ) {
				# Note: articlesavecomplete hook does rc_patrolled bit
				$ok = FlaggedRevs::autoReviewEdit(
					$article, $user, $rev->getText(), $rev, $flags, false );
				if ( $ok ) return true; // done!
			}
		}
		# All cases below require auto-review of edits to be enabled
		if( !FlaggedRevs::autoReviewEdits() ) {
			return true;
		}
		# If a $baseRevId is passed in this is a null edit
		$isNullEdit = (bool)$baseRevId;
		# Get the revision ID the incoming one was based off...
		if ( !$baseRevId && $prevRevId ) {
			if ( is_null( $prevTimestamp ) ) { // may already be set
				$prevTimestamp = Revision::getTimestampFromId( $title, $prevRevId );
			}
			# The user just made an edit. The one before that should have
			# been the current version. If not reflected in wpEdittime, an
			# edit may have been auto-merged in between, in that case, discard
			# the baseRevId given from the client.
			if ( !$editTimestamp || $prevTimestamp == $editTimestamp ) {
				$baseRevId = intval( trim( $wgRequest->getVal( 'baseRevId' ) ) );
			}
			# If baseRevId not given, assume the previous revision ID (for bots).
			# For auto-merges, this also occurs since the given ID is ignored.
			if ( !$baseRevId ) {
				$baseRevId = $prevRevId;
			}
		}
		# Self-reversions to the stable version by anyone can be auto-reviewed...
		$srev = FlaggedRevision::newFromStable( $title, FR_MASTER );
		if ( $srev && self::isSelfRevertToStable( $rev, $srev, $baseRevId, $user ) ) {
			$flags = $srev->getTags(); // use old tags
			FlaggedRevs::autoReviewEdit( $article, $user, $rev->getText(), $rev, $flags );
			return true; // done!
		}
		# Can this user auto-review this page?
		$isAllowed = $title->getUserPermissionsErrors( 'autoreview', $user ) === array();
		if ( !$isAllowed ) {
			return true; // user does not have auto-review rights
		}
		$reviewableNewPage = false;
		// New pages
		if ( !$prevRevId ) {
			$reviewableNewPage = FlaggedRevs::autoReviewNewPages();
		// Edits to existing pages
		} elseif ( $baseRevId ) {
			# Check if the base revision was reviewed...
			$frev = ( $srev && $srev->getRevId() == $baseRevId )
				? $srev // save ourselves a query
				: FlaggedRevision::newFromTitle( $title, $baseRevId, FR_MASTER );
		}
		// Is this an edit directly to the stable version? Is it a new page?
		if ( $isAllowed && ( $reviewableNewPage || !is_null( $frev ) ) ) {
			if ( $isNullEdit && $frev ) {
				$flags = $frev->getTags(); // Null edits always keep previous tags
			}
			# Review this revision of the page. Let articlesavecomplete hook do rc_patrolled bit...
			FlaggedRevs::autoReviewEdit( $article, $user, $rev->getText(), $rev, $flags );
		}
		return true;
	}
	
	/**
	* Check if a user reverted himself to the stable version
	*/
	protected static function isSelfRevertToStable( $rev, $srev, $baseRevId, $user ) {
		if( !$srev || $baseRevId != $srev->getRevId() ) {
			return false; // user reports they are not the same
		}
		$dbw = wfGetDB( DB_MASTER );
		# Such a revert requires 1+ revs between it and the stable
		$revertedRevs = $dbw->selectField( 'revision', '1',
			array(
				'rev_page' => $rev->getPage(),
				'rev_id > ' . intval( $baseRevId ), // stable rev
				'rev_id < ' . intval( $rev->getId() ), // this rev
				'rev_user_text' => $user->getName()
			), __METHOD__
		);
		if( !$revertedRevs ) {
			return false; // can't be a revert
		}
		# Check that this user is ONLY reverting his/herself.
		$otherUsers = $dbw->selectField( 'revision', '1',
			array(
				'rev_page' => $rev->getPage(),
				'rev_id > ' . intval( $baseRevId ),
				'rev_user_text != ' . $dbw->addQuotes( $user->getName() )
			), __METHOD__
		);
		if( $otherUsers ) {
			return false; // only looking for self-reverts
		}
		# Confirm the text because we can't trust this user.
		return ( $rev->getText() == $srev->getRevText() );
	}
	
	/**
	* When an user makes a null-edit we sometimes want to review it...
	*/
	public static function maybeNullEditReview(
		$article, $user, $text, $summary, $m, $a, $b, $flags, $rev, &$status, $baseId
	) {
		global $wgRequest;
		# Must be in reviewable namespace
		$title = $article->getTitle();
		# Revision must *be* null (null edit). We also need the user who made the edit.
		if ( !$user || $rev !== null || !FlaggedRevs::inReviewNamespace( $title ) ) {
			return true;
		}
		# Get the current revision ID
		$rev = Revision::newFromTitle( $title );
		$flags = null;
		# Is this a rollback/undo that didn't change anything?
		if ( $rev && $baseId ) {
			$frev = FlaggedRevision::newFromTitle( $title, $baseId );
			# Was the edit that we tried to revert to reviewed?
			if ( $frev ) {
				FlaggedRevs::autoReviewEdit( $article, $user, $rev->getText(), $rev, $flags );
				FlaggedRevs::markRevisionPatrolled( $rev ); // Make sure it is now marked patrolled...
			}
		}
		# Get edit timestamp, it must exist.
		$editTimestamp = $wgRequest->getVal( 'wpEdittime' );
		# Is the page checked off to be reviewed?
		if ( $rev && $editTimestamp && $wgRequest->getCheck( 'wpReviewEdit' )
			&& $user->isAllowed( 'review' ) )
		{
			# Review this revision of the page. Let articlesavecomplete hook do rc_patrolled bit.
			# Don't do so if an edit was auto-merged in between though...
			if ( $rev->getTimestamp() == $editTimestamp ) {
				FlaggedRevs::autoReviewEdit( $article, $user, $rev->getText(),
					$rev, $flags, false );
				FlaggedRevs::markRevisionPatrolled( $rev ); // Make sure it is now marked patrolled...
				return true; // done!
			}
		}
		return true;
	}

	/**
	* When an edit is made to a page that can't be reviewed, autopatrol if allowed.
	*/
	public static function autoMarkPatrolled( &$rc ) {
		global $wgUser;
		if ( empty( $rc->mAttribs['rc_this_oldid'] ) ) {
			return true;
		}
		$fa = FlaggedArticle::getTitleInstance( $rc->getTitle() );
		// Is the page reviewable?
		if ( $fa->isReviewable( FR_MASTER ) ) {
			$revId = $rc->mAttribs['rc_this_oldid'];
			$quality = FlaggedRevs::getRevQuality( $rc->mAttribs['rc_cur_id'], $revId, FR_MASTER );
			if ( $quality !== false && $quality >= FlaggedRevs::getPatrolLevel() ) {
				RevisionReview::updateRecentChanges( $rc->getTitle(), $revId );
				$rc->mAttribs['rc_patrolled'] = 1; // make sure irc/email notifs know status
			}
			return true;
		}
		// Is this page in patrollable namespace?
		$patrol = $record = false;
		if ( FlaggedRevs::inPatrolNamespace( $rc->getTitle() ) ) {
			# Bots and users with 'autopatrol' have edits to patrollable
			# pages marked automatically on edit.
			$patrol = $wgUser->isAllowed( 'autopatrol' ) || $wgUser->isAllowed( 'bot' );
			$record = true; // record if patrolled
		} else {
			global $wgUseNPPatrol;
			// Is this is a new page edit and $wgUseNPPatrol is enabled?
			if( $wgUseNPPatrol && !empty( $rc->mAttribs['rc_new'] ) ) {
				# Automatically mark it patrolled if the user can do so
				$patrol = $wgUser->isAllowed( 'autopatrol' );
				$record = true;
			// Otherwise, this edit is not patrollable
			} else {
				# Silently mark it "patrolled" so that it doesn't show up as being unpatrolled
				$patrol = true;
				$record = false;
			}
		}
		// Set rc_patrolled flag and add log entry as needed
		if ( $patrol ) {
			$rc->reallyMarkPatrolled();
			$rc->mAttribs['rc_patrolled'] = 1; // make sure irc/email notifs now status
			if ( $record ) {
				PatrolLog::record( $rc->mAttribs['rc_id'], true );
			}
		}
		return true;
	}
	
	public static function incrementRollbacks( $this, $user, $target, $current ) {
		# Mark when a user reverts another user, but not self-reverts
		if ( $current->getRawUser() && $user->getId() != $current->getRawUser() ) {
			$p = FlaggedRevs::getUserParams( $current->getRawUser() );
			$p['revertedEdits'] = isset( $p['revertedEdits'] ) ? $p['revertedEdits'] : 0;
			$p['revertedEdits']++;
			FlaggedRevs::saveUserParams( $current->getRawUser(), $p );
		}
		return true;
	}
	
	public static function incrementReverts( $article, $rev, $baseRevId = false, $user = null ) {
		global $wgRequest;
		# Was this an edit by an auto-sighter that undid another edit?
		$undid = $wgRequest->getInt( 'undidRev' );
		if ( $rev && $undid && $user->isAllowed( 'autoreview' ) ) {
			$badRev = Revision::newFromTitle( $article->getTitle(), $undid );
			# Don't count self-reverts
			if ( $badRev && $badRev->getRawUser() && $badRev->getRawUser() != $rev->getRawUser() ) {
				$p = FlaggedRevs::getUserParams( $badRev->getRawUser() );
				$p['revertedEdits'] = isset( $p['revertedEdits'] ) ? $p['revertedEdits'] : 0;
				$p['revertedEdits']++;
				FlaggedRevs::saveUserParams( $badRev->getRawUser(), $p );
			}
		}
		return true;
	}
	
	protected static function editSpacingCheck( $spacing, $points, $user ) {
		# Convert days to seconds...
		$spacing = $spacing * 24 * 3600;
		# Check the oldest edit
		$dbr = isset( $dbr ) ? $dbr : wfGetDB( DB_SLAVE );
		$lower = $dbr->selectField( 'revision', 'rev_timestamp',
			array( 'rev_user' => $user->getId() ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp ASC', 'USE INDEX' => 'user_timestamp' )
		);
		# Recursively check for an edit $spacing seconds later, until we are done.
		# The first edit counts, so we have one less scans to do...
		$benchmarks = 0; // actual
		$needed = $points - 1; // required
		while ( $lower && $benchmarks < $needed ) {
			$next = wfTimestamp( TS_UNIX, $lower ) + $spacing;
			$lower = $dbr->selectField( 'revision', 'rev_timestamp',
				array( 'rev_user' => $user->getId(),
					'rev_timestamp > ' . $dbr->addQuotes( $dbr->timestamp( $next ) ) ),
					__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp ASC', 'USE INDEX' => 'user_timestamp' )
			);
			if ( $lower !== false ) $benchmarks++;
		}
		return ( $benchmarks >= $needed );
	}
	
	/**
	* Checks if $user was previously blocked
	*/
	protected function previousBlockCheck( $user ) {
		$dbr = wfGetDB( DB_SLAVE );
		return (bool)$dbr->selectField( 'logging', '1',
			array(
				'log_namespace' => NS_USER,
				'log_title'     => $user->getUserPage()->getDBkey(),
				'log_type'      => 'block',
				'log_action'    => 'block' ),
			__METHOD__,
			array( 'USE INDEX' => 'page_time' )
		);
	}
	
	/**
	* Check for 'autoreview' permission. This lets people who opt-out as
	* Editors still have their own edits automatically reviewed. Bot
	* accounts are also handled here to make sure that can autoreview.
	*/
	public static function checkAutoPromote( $user, &$promote ) {
		global $wgFlaggedRevsAutoconfirm, $wgMemc;
		# Make sure bots always have autoreview
		if ( $user->isAllowed( 'bot' ) ) {
			$promote[] = 'autoreview'; // add the group
			return true;
		}
		# Check if $wgFlaggedRevsAutoconfirm is actually enabled
		# and that this is a logged-in user that doesn't already
		# have the 'autoreview' permission
		if ( !$user->getId() || $user->isAllowed( 'autoreview' )
			|| empty( $wgFlaggedRevsAutoconfirm ) )
		{
			return true;
		}
		# Check if results are cached to avoid DB queries.
		# Checked basic, already available, promotion heuristics first...
		$APSkipKey = wfMemcKey( 'flaggedrevs', 'autoreview-skip', $user->getId() );
		$value = $wgMemc->get( $APSkipKey );
		if ( $value === 'true' ) return true;
		# Check $wgFlaggedRevsAutoconfirm settings...
		$now = time();
		$userCreation = wfTimestampOrNull( TS_UNIX, $user->getRegistration() );
		# User registration was not always tracked in DB...use null for such cases
		$userage = $userCreation ? floor( ( $now - $userCreation ) / 86400 ) : null;
		$p = FlaggedRevs::getUserParams( $user->getId() );
		# Check if user edited enough content pages
		$totalCheckedEditsNeeded = false;
		if ( $wgFlaggedRevsAutoconfirm['totalContentEdits'] > $p['totalContentEdits'] ) {
			if ( !$wgFlaggedRevsAutoconfirm['totalCheckedEdits'] ) {
				return true;
			}
			$totalCheckedEditsNeeded = true;
		}
		# Check if user edited enough unique pages
		$pages = explode( ',', trim( $p['uniqueContentPages'] ) ); // page IDs
		if ( $wgFlaggedRevsAutoconfirm['uniqueContentPages'] > count( $pages ) ) {
			return true;
		}
		# Check edit comment use
		if ( $wgFlaggedRevsAutoconfirm['editComments'] > $p['editComments'] ) {
			return true;
		}
		# Check account age
		if ( !is_null( $userage ) && $userage < $wgFlaggedRevsAutoconfirm['days'] ) {
			return true;
		}
		# Check user edit count. Should be stored.
		if ( $user->getEditCount() < $wgFlaggedRevsAutoconfirm['edits'] ) {
			return true;
		}
		# Check user email
		if ( $wgFlaggedRevsAutoconfirm['email'] && !$user->isEmailConfirmed() ) {
			return true;
		}
		# Don't grant to currently blocked users...
		if ( $user->isBlocked() ) {
			return true;
		}
		# Check if user was ever blocked before
		if ( $wgFlaggedRevsAutoconfirm['neverBlocked'] ) {
			$blocked = self::previousBlockCheck( $user );
			if ( $blocked ) {
				# Make a key to store the results
				$wgMemc->set( $APSkipKey, 'true', 3600 * 24 * 7 );
				return true;
			}
		}
		# Check for edit spacing. This lets us know that the account has
		# been used over N different days, rather than all in one lump.
		if ( $wgFlaggedRevsAutoconfirm['spacing'] > 0
			&& $wgFlaggedRevsAutoconfirm['benchmarks'] > 1 )
		{
			$sTestKey = wfMemcKey( 'flaggedrevs', 'autoreview-spacing-ok', $user->getId() );
			$value = $wgMemc->get( $sTestKey );
			# Check if the user already passed this test via cache.
			# If no cache key is available, then check the DB...
			if ( $value !== 'true' ) {
				$pass = self::editSpacingCheck(
					$wgFlaggedRevsAutoconfirm['spacing'],
					$wgFlaggedRevsAutoconfirm['benchmarks'],
					$user
				);
				# Make a key to store the results
				if ( !$pass ) {
					$wgMemc->set( $APSkipKey, 'true',
						3600 * 24 * $spacing * ( $benchmarks - $needed - 1 ) );
					return true;
				} else {
					$wgMemc->set( $sTestKey, 'true', 7 * 24 * 3600 );
				}
			}
		}
		# Check implicitly sighted edits
		if ( $totalCheckedEditsNeeded && $wgFlaggedRevsAutoconfirm['totalCheckedEdits'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( array( 'revision', 'flaggedpages' ), '1',
				array( 'rev_user' => $user->getId(),
					'fp_page_id = rev_page', 'fp_stable >= rev_id' ),
				__METHOD__,
				array( 'USE INDEX' => array( 'revision' => 'user_timestamp' ),
					'LIMIT' => $wgFlaggedRevsAutoconfirm['totalCheckedEdits'] )
			);
			if ( $dbr->numRows( $res ) < $wgFlaggedRevsAutoconfirm['totalCheckedEdits'] ) {
				return true;
			}
		}
		$promote[] = 'autoreview';  // add the group
		return true;
	}

	/**
	* Callback that autopromotes user according to the setting in
	* $wgFlaggedRevsAutopromote. This also handles user stats tallies.
	*/
	public static function maybeMakeEditor(
		$article, $user, $text, $summary, $m, $a, $b, &$f, $rev
	) {
		global $wgFlaggedRevsAutopromote, $wgFlaggedRevsAutoconfirm, $wgMemc;
		# Ignore NULL edits or edits by anon users
		if ( !$rev || !$user->getId() )
			return true;
		# No sense in running counters if nothing uses them
		if ( empty( $wgFlaggedRevsAutopromote ) && empty( $wgFlaggedRevsAutoconfirm ) ) {
			return true;
		}
		$p = FlaggedRevs::getUserParams( $user->getId() );
		# Update any special counters for non-null revisions
		$changed = false;
		$pages = array();
		if ( $article->getTitle()->isContentPage() ) {
			$pages = explode( ',', trim( $p['uniqueContentPages'] ) ); // page IDs
			# Don't let this get bloated for no reason
			# (assumes $wgFlaggedRevsAutopromote is stricter than $wgFlaggedRevsAutoconfirm)
			if ( count( $pages ) < $wgFlaggedRevsAutopromote['uniqueContentPages']
				&& !in_array( $article->getId(), $pages ) )
			{
				$pages[] = $article->getId();
				// Clear out any formatting garbage
				$p['uniqueContentPages'] = preg_replace( '/^,/', '', implode( ',', $pages ) );
			}
			$p['totalContentEdits'] += 1;
			$changed = true;
		}
		if ( $summary ) {
			$p['editComments'] += 1;
			$changed = true;
		}
		# Save any updates to user params
		if ( $changed ) {
			FlaggedRevs::saveUserParams( $user->getId(), $p );
		}
		# Grab current groups
		$groups = $user->getGroups();
		# Do not give this to current holders or bots
		if ( $user->isAllowed( 'bot' ) || in_array( 'editor', $groups ) ) {
			return true;
		}
		# Do not re-add status if it was previously removed!
		if ( isset( $p['demoted'] ) && $p['demoted'] ) {
			return true;
		}
		# Check if results are cached to avoid DB queries
		$APSkipKey = wfMemcKey( 'flaggedrevs', 'autopromote-skip', $user->getId() );
		$value = $wgMemc->get( $APSkipKey );
		if ( $value == 'true' ) return true;
		# Check if user edited enough content pages
		$totalCheckedEditsNeeded = false;
		if ( $wgFlaggedRevsAutopromote['totalContentEdits'] > $p['totalContentEdits'] ) {
			if ( !$wgFlaggedRevsAutopromote['totalCheckedEdits'] ) {
				return true;
			}
			$totalCheckedEditsNeeded = true;
		}
		# Check if user edited enough unique pages
		if ( $wgFlaggedRevsAutopromote['uniqueContentPages'] > count( $pages ) ) {
			return true;
		}
		# Check edit comment use
		if ( $wgFlaggedRevsAutopromote['editComments'] > $p['editComments'] ) {
			return true;
		}
		# Check reverted edits
		if ( $wgFlaggedRevsAutopromote['maxRevertedEdits'] < $p['revertedEdits'] ) {
			return true;
		}
		# Check account age
		$now = time();
		$usercreation = wfTimestampOrNull( TS_UNIX, $user->getRegistration() );
		$userage = $usercreation ? floor( ( $now - $usercreation ) / 86400 ) : null;
		if ( !is_null( $userage ) && $userage < $wgFlaggedRevsAutopromote['days'] ) {
			return true;
		}
		# Check user edit count. Should be stored.
		if ( $user->getEditCount() < $wgFlaggedRevsAutopromote['edits'] ) {
			return true;
		}
		# Don't grant to currently blocked users...
		if ( $user->isBlocked() ) {
			return true;
		}
		# Check if user was ever blocked before
		if ( $wgFlaggedRevsAutopromote['neverBlocked'] ) {
			$blocked = self::previousBlockCheck( $user );
			if ( $blocked ) {
				# Make a key to store the results
				$wgMemc->set( $APSkipKey, 'true', 3600 * 24 * 7 );
				return true;
			}
		}
		# See if the page actually has sufficient content...
		if ( $wgFlaggedRevsAutopromote['userpageBytes'] > 0 ) {
			if ( !$user->getUserPage()->exists() ) {
				return true;
			}
			$dbr = isset( $dbr ) ? $dbr : wfGetDB( DB_SLAVE );
			$size = $dbr->selectField( 'page', 'page_len',
				array( 'page_namespace' => $user->getUserPage()->getNamespace(),
					'page_title' => $user->getUserPage()->getDBkey() ),
				__METHOD__ );
			if ( $size < $wgFlaggedRevsAutopromote['userpageBytes'] ) {
				return true;
			}
		}
		# Check for edit spacing. This lets us know that the account has
		# been used over N different days, rather than all in one lump.
		if ( $wgFlaggedRevsAutopromote['spacing'] > 0
			&& $wgFlaggedRevsAutopromote['benchmarks'] > 1 )
		{
			$sTestKey = wfMemcKey( 'flaggedrevs', 'autopromote-spacing-ok', $user->getId() );
			$value = $wgMemc->get( $sTestKey );
			# Check if the user already passed this test via cache.
			# If no cache key is available, then check the DB...
			if ( $value !== 'true' ) {
				$pass = self::editSpacingCheck(
					$wgFlaggedRevsAutopromote['spacing'],
					$wgFlaggedRevsAutopromote['benchmarks'],
					$user
				);
				# Make a key to store the results
				if ( !$pass ) {
					$wgMemc->set( $APSkipKey, 'true',
						3600 * 24 * $spacing * ( $benchmarks - $needed - 1 ) );
					return true;
				} else {
					$wgMemc->set( $sTestKey, 'true', 7 * 24 * 3600 );
				}
			}
		}
		# Check if this user is sharing IPs with another users
		if ( $wgFlaggedRevsAutopromote['uniqueIPAddress'] ) {
			$uid = $user->getId();

			$dbr = isset( $dbr ) ? $dbr : wfGetDB( DB_SLAVE );
			$shared = $dbr->selectField( 'recentchanges', '1',
				array( 'rc_ip' => wfGetIP(),
					"rc_user != '$uid'" ),
				__METHOD__,
				array( 'USE INDEX' => 'rc_ip' ) );
			if ( $shared ) {
				# Make a key to store the results
				$wgMemc->set( $key, 'true', 3600 * 24 * 7 );
				return true;
			}
		}
		# Check if the user has any recent content edits
		if ( $wgFlaggedRevsAutopromote['recentContentEdits'] > 0 ) {
			global $wgContentNamespaces;
		
			$dbr = isset( $dbr ) ? $dbr : wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'recentchanges', '1',
				array( 'rc_user_text' => $user->getName(),
					'rc_namespace' => $wgContentNamespaces ),
				__METHOD__,
				array( 'USE INDEX' => 'rc_ns_usertext',
					'LIMIT' => $wgFlaggedRevsAutopromote['recentContentEdits'] )
			);
			if ( $dbr->numRows( $res ) < $wgFlaggedRevsAutopromote['recentContentEdits'] ) {
				return true;
			}
		}
		# Check to see if the user has so many deleted edits that
		# they don't actually enough live edits. This is because
		# $user->getEditCount() is the count of edits made, not live.
		if ( $wgFlaggedRevsAutopromote['excludeDeleted'] ) {
			$dbr = isset( $dbr ) ? $dbr : wfGetDB( DB_SLAVE );
			$minDiff = $user->getEditCount() - $wgFlaggedRevsAutopromote['days'] + 1;
			# Use an estimate if the number starts to get large
			if ( $minDiff <= 100 ) {
				$res = $dbr->select( 'archive', '1',
					array( 'ar_user_text' => $user->getName() ),
					__METHOD__,
					array( 'USE INDEX' => 'usertext_timestamp', 'LIMIT' => $minDiff ) );
				$deletedEdits = $dbr->numRows( $res );
			} else {
				$deletedEdits = $dbr->estimateRowCount( 'archive', '1',
					array( 'ar_user_text' => $user->getName() ),
					__METHOD__,
					array( 'USE INDEX' => 'usertext_timestamp' ) );
			}
			if ( $deletedEdits >= $minDiff ) {
				return true;
			}
		}
		# Check implicitly sighted edits
		if ( $totalCheckedEditsNeeded && $wgFlaggedRevsAutopromote['totalCheckedEdits'] ) {
			$dbr = isset( $dbr ) ? $dbr : wfGetDB( DB_SLAVE );
			$res = $dbr->select( array( 'revision', 'flaggedpages' ), '1',
				array( 'rev_user' => $user->getId(),
					'fp_page_id = rev_page', 'fp_stable >= rev_id' ),
				__METHOD__,
				array( 'USE INDEX' => array( 'revision' => 'user_timestamp' ),
					'LIMIT' => $wgFlaggedRevsAutopromote['totalCheckedEdits'] )
			);
			if ( $dbr->numRows( $res ) < $wgFlaggedRevsAutopromote['totalCheckedEdits'] ) {
				return true;
			}
		}
		# Add editor rights
		$newGroups = $groups ;
		array_push( $newGroups, 'editor' );

		global $wgFlaggedRevsAutopromoteInRC;
		$log = new LogPage( 'rights', $wgFlaggedRevsAutopromoteInRC );
		$log->addEntry( 'rights', $user->getUserPage(), wfMsg( 'rights-editor-autosum' ),
			array( implode( ', ', $groups ), implode( ', ', $newGroups ) ) );
		$user->addGroup( 'editor' );

		return true;
	}
	
   	/**
	* Record demotion so that auto-promote will be disabled
	*/
	public static function recordDemote( $u, $addgroup, $removegroup ) {
		if ( $removegroup && in_array( 'editor', $removegroup ) ) {
			// Cross-wiki rights change
			if ( $u instanceof UserRightsProxy ) {
				$params = FlaggedRevs::getUserParams( $u->getId(), $u->getDBName() );
				$params['demoted'] = 1;
				FlaggedRevs::saveUserParams( $u->getId(), $params, $u->getDBName() );
			// On-wiki rights change
			} else {
				$params = FlaggedRevs::getUserParams( $u->getId() );
				$params['demoted'] = 1;
				FlaggedRevs::saveUserParams( $u->getId(), $params );
			}
		}
		return true;
	}
	
	/** Add user preferences */
	public static function onGetPreferences( $user, &$preferences ) {
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
				'type' => 'toggle',
				'section' => 'flaggedrevs/flaggedrevs-ui',
				'label-message' => 'flaggedrevs-prefs-stable',
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
					'section' => 'misc/diffs',
					'label-message' => 'flaggedrevs-prefs-viewdiffs',
				);
		}
		return true;
	}
	
	public static function logLineLinks(
		$type, $action, $title = null, $params, &$comment, &$rv, $ts
	) {
		if ( !$title ) {
			return true; // nothing to do
		// Stability log
		} else if ( $type == 'stable' ) {
			$rv .= FlaggedRevsLogs::stabilityLogLinks( $title, $ts );
		// Review log
		} else if ( $type == 'review' && FlaggedRevsLogs::isReviewAction( $action ) ) {
			$rv .= FlaggedRevsLogs::reviewLogLinks( $action, $title, $params );
		}
		return true;
	}

	public static function imagePageFindFile( $imagePage, &$normalFile, &$displayFile ) {
		$view = FlaggedArticleView::singleton();
		$view->imagePageFindFile( $normalFile, $displayFile );
		return true;
	}

	public static function setActionTabs( $skin, &$contentActions ) {
		// Note: $wgArticle sometimes not set here
		if ( FlaggedArticleView::globalArticleInstance() != null ) {
			$view = FlaggedArticleView::singleton();
			$view->setActionTabs( $skin, $contentActions );
			$view->setViewTabs( $skin, $contentActions );
		}
		return true;
	}

	public static function setNavigation( $skin, &$links ) {
		// Note: $wgArticle sometimes not set here
		if ( FlaggedArticleView::globalArticleInstance() != null ) {
			$view = FlaggedArticleView::singleton();
			$view->setActionTabs( $skin, $links['actions'] );
			$view->setViewTabs( $skin, $links['views'] );
		}
		return true;
	}

	public static function onArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		$view = FlaggedArticleView::singleton();
		$view->maybeUpdateMainCache( $outputDone, $pcache );
		$view->addStableLink( $outputDone, $pcache );
		$view->setPageContent( $outputDone, $pcache );
		return true;
	}
	
	public static function overrideRedirect(
		&$title, $request, &$ignoreRedirect, &$target, &$article
	) {
		# Get an instance on the title ($wgTitle)
		if ( !FlaggedRevs::inReviewNamespace( $title ) ) {
			return true;
		}
		if ( $request->getVal( 'stableid' ) ) {
			$ignoreRedirect = true;
		} else {
			global $wgMemc, $wgParserCacheExpireTime;
			# Try the cache...
			$key = wfMemcKey( 'flaggedrevs', 'overrideRedirect', $title->getArticleId() );
			$data = $wgMemc->get( $key );
			if ( is_object( $data ) && $data->time >= $article->getTouched() ) {
				list( $ignoreRedirect, $target ) = $data->value;
				return true;
			}
			$fa = FlaggedArticle::getTitleInstance( $title );
			if ( $srev = $fa->getStableRev() ) {
				$view = FlaggedArticleView::singleton();
				# If synced, nothing special here...
				if ( $srev->getRevId() != $article->getLatest() && $view->pageOverride() ) {
					$text = $srev->getRevText();
					$redirect = $fa->followRedirectText( $text );
					if ( $redirect ) {
						$target = $redirect;
					} else {
						$ignoreRedirect = true;
					}
				}
				$data = FlaggedRevs::makeMemcObj( array( $ignoreRedirect, $target ) );
				$wgMemc->set( $key, $data, $wgParserCacheExpireTime );
			}
		}
		return true;
	}
	
	public static function addToEditView( &$editPage ) {
		$view = FlaggedArticleView::singleton();
		$view->addToEditView( $editPage );
		return true;
	}
	
	public static function onNoSuchSection( &$editPage, &$s ) {
		$view = FlaggedArticleView::singleton();
		$view->addToNoSuchSection( $editPage, $s );
		return true;
	}
	
	public static function addToHistView( &$article ) {
		$view = FlaggedArticleView::singleton();
		$view->addToHistView();
		return true;
	}
	
	public static function onCategoryPageView( &$category ) {
		$view = FlaggedArticleView::singleton();
		$view->addToCategoryView();
		return true;
	}
	
	public static function onSkinAfterContent( &$data ) {
		global $wgOut;
		if ( $wgOut->isArticleRelated() && FlaggedArticleView::globalArticleInstance() != null ) {
			$view = FlaggedArticleView::singleton();
			$view->addReviewNotes( $data );
			$view->addReviewForm( $data );
			$view->addVisibilityLink( $data );
		}
		return true;
	}
	
	public static function addToHistQuery( $pager, &$queryInfo ) {
		$flaggedArticle = FlaggedArticle::getArticleInstance( $pager->getArticle() );
		# Non-content pages cannot be validated. Stable version must exist.
		if ( $flaggedArticle->isReviewable() && $flaggedArticle->getStableRev() ) {
			# Highlight flaggedrevs
			$queryInfo['tables'][] = 'flaggedrevs';
			$queryInfo['fields'][] = 'fr_quality';
			$queryInfo['fields'][] = 'fr_user';
			$queryInfo['fields'][] = 'fr_flags';
			$queryInfo['join_conds']['flaggedrevs'] = array( 'LEFT JOIN',
				"fr_page_id = rev_page AND fr_rev_id = rev_id" );
			# Find reviewer name. Sanity check that no extensions added a `user` query.
			if( !in_array( 'user', $queryInfo['tables'] ) ) {
				$queryInfo['tables'][] = 'user';
				$queryInfo['fields'][] = 'user_name AS reviewer';
				$queryInfo['join_conds']['user'] = array( 'LEFT JOIN', "user_id = fr_user" );
			}
		}
		return true;
	}
	
	public static function addToFileHistQuery(
		$file, &$tables, &$fields, &$conds, &$opts, &$join_conds
	) {
		if ( !$file->isLocal() ) {
			return true; // local files only
		}
		$flaggedArticle = FlaggedArticle::getTitleInstance( $file->getTitle() );
		# Non-content pages cannot be validated. Stable version must exist.
		if ( $flaggedArticle->isReviewable() && $flaggedArticle->getStableRev() ) {
			$tables[] = 'flaggedrevs';
			$fields[] = 'MAX(fr_quality) AS fr_quality';
			# Avoid duplicate rows due to multiple revs with the same sha-1 key
			$opts['GROUP BY'] = 'oi_name,oi_timestamp';
			$join_conds['flaggedrevs'] = array( 'LEFT JOIN',
				'oi_sha1 = fr_img_sha1 AND oi_timestamp = fr_img_timestamp' );
		}
		return true;
	}
	
	public static function addToContribsQuery( $pager, &$queryInfo ) {
		# Highlight flaggedrevs
		$queryInfo['tables'][] = 'flaggedrevs';
		$queryInfo['fields'][] = 'fr_quality';
		$queryInfo['join_conds']['flaggedrevs'] = array( 'LEFT JOIN',
			"fr_page_id = rev_page AND fr_rev_id = rev_id" );
		# Highlight unchecked content
		$queryInfo['tables'][] = 'flaggedpages';
		$queryInfo['fields'][] = 'fp_stable';
		$queryInfo['join_conds']['flaggedpages'] = array( 'LEFT JOIN', "fp_page_id = rev_page" );
		return true;
	}
	
	public static function addToRCQuery( &$conds, &$tables, &$join_conds, $opts ) {
		global $wgUser;
		if ( $wgUser->isAllowed( 'review' ) ) {
			$tables[] = 'flaggedpage_pending';
			$join_conds['flaggedpage_pending'] = array( 'LEFT JOIN',
				'fpp_page_id = rc_cur_id AND fpp_quality = ' . FlaggedRevs::getPatrolLevel() );
		}
		return true;
	}
	
	public static function addToWatchlistQuery( &$conds, &$tables, &$join_conds, &$fields ) {
		global $wgUser;
		if ( $wgUser->isAllowed( 'review' ) ) {
			$fields[] = 'fpp_rev_id';
			$tables[] = 'flaggedpage_pending';
			$join_conds['flaggedpage_pending'] = array( 'LEFT JOIN',
				'fpp_page_id = rc_cur_id AND fpp_quality = ' . FlaggedRevs::getPatrolLevel() );
		}
		return true;
	}
	
	public static function addToHistLine( $history, $row, &$s, &$liClasses ) {
		$fa = FlaggedArticle::getArticleInstance( $history->getArticle() );
		if ( !$fa->isReviewable() ) {
			return true; // nothing to do here
		}
		$title = $history->getArticle()->getTitle();
		# Fetch and process cache the stable revision
		if ( !isset( $history->fr_stableRevId ) ) {
			$frev = $fa->getStableRev();
			$history->fr_stableRevId = $frev ? $frev->getRevId() : 0;
			$history->fr_pendingRevs = false;
		}
		if ( !$history->fr_stableRevId ) {
			return true; // nothing to do here
		}
		$revId = (int)$row->rev_id;
		// Unreviewed revision: highlight if pending
		$link = $class = '';
		if ( !isset( $row->fr_quality ) ) {
			if ( $revId > $history->fr_stableRevId ) {
				$class = 'flaggedrevs-unreviewed';
				$link = '<strong>' . wfMsgHtml( 'revreview-hist-pending' ) . '</strong>';
				$history->fr_pendingRevs = true; // pending rev shown above stable
			}
		// Reviewed revision: highlight and add link
		} else if ( !( $row->rev_deleted & Revision::DELETED_TEXT ) ) {
			# Add link to stable version of *this* rev, if any
			list( $link, $class ) = self::markHistoryRow( $title, $row );
			# Space out and demark the stable revision
			if ( $revId == $history->fr_stableRevId && $history->fr_pendingRevs ) {
				$liClasses[] = 'fr-hist-stable-margin';
			}
		}
		# Style the row as needed
		if ( $class ) $s = "<span class='$class'>$s</span>";
		# Add stable old version link
		if ( $link ) $s .= " <small>$link</small>";
		return true;
	}
	
	
	/**
	 * Make stable version link and return the css
	 * @param Title $title
	 * @param Row $row, from history page
	 * @returns array (string,string)
	 */
	protected static function markHistoryRow( $title, $row ) {
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
		$name = isset($row->reviewer) ?
			$row->reviewer : User::whoIs( $row->fr_user );
		$link = wfMsgExt( $msg, 'parseinline', $title->getPrefixedDBkey(), $row->rev_id, $name );
		$link = "<span class='$css plainlinks'>[$link]</span>";
		return array( $link, $liCss );
	}
	
	public static function addToFileHistLine( $hist, $file, &$s, &$rowClass ) {
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
		} elseif ( isset( $row->fp_stable ) && $row->rev_id > $row->fp_stable ) {
			$ret = '<span class="flaggedrevs-unreviewed">' . $ret . '</span>';
		} elseif ( !isset( $row->fp_stable ) ) {
			$ret = '<span class="flaggedrevs-unreviewed2">' . $ret . '</span>';
		}
		return true;
	}
	
	public static function addToChangeListLine(
		&$list, &$articlelink, &$s, &$rc, $unpatrolled, $watched
	) {
		if ( empty( $rc->mAttribs['fpp_rev_id'] ) )
			return true; // page is not listed in pending edit table
		if ( !FlaggedRevs::inReviewNamespace( $rc->getTitle() ) )
			return true; // confirm that page is in reviewable namespace
		$rlink = $list->skin->makeKnownLinkObj( $rc->getTitle(), wfMsg( 'revreview-reviewlink' ),
			'oldid=' . intval( $rc->mAttribs['fpp_rev_id'] ) . '&diff=cur' );
		$articlelink .= " <span class='mw-fr-reviewlink'>($rlink)</span>";
		return true;
	}
	
	public static function injectPostEditURLParams( $article, &$sectionAnchor, &$extraQuery ) {
		$view = FlaggedArticleView::singleton();
		$view->injectPostEditURLParams( $sectionAnchor, $extraQuery );
		return true;
	}
	
	// diff=review param (bug 16923)
	public static function checkDiffUrl( $titleObj, &$mOldid, &$mNewid, $old, $new ) {
		if ( $new === 'review' && isset( $titleObj ) ) {
			$frev = FlaggedRevision::newFromStable( $titleObj );
			if ( $frev ) {
				$mOldid = $frev->getRevId(); // stable
				$mNewid = 0; // cur
			}
		}
		return true;
	}

	public static function onDiffViewHeader( $diff, $oldRev, $newRev ) {
		self::injectStyleAndJS();
		$view = FlaggedArticleView::singleton();
		$view->setViewFlags( $diff, $oldRev, $newRev );
		$view->addDiffLink( $diff, $oldRev, $newRev );
		$view->addDiffNoticeAndIncludes( $diff, $oldRev, $newRev );
		return true;
	}

	public static function addRevisionIDField( $editPage, $out ) {
		$view = FlaggedArticleView::singleton();
		$view->addRevisionIDField( $editPage, $out );
		return true;
	}
	
	public static function addReviewCheck( $editPage, &$checkboxes, &$tabindex ) {
		global $wgUser, $wgRequest;
		if ( !$wgUser->isAllowed( 'review' ) ) {
			return true;
		}
		if ( FlaggedRevs::autoReviewNewPages() && !$editPage->getArticle()->getId() ) {
			return true; // not needed
		}
		$fa = FlaggedArticleView::globalArticleInstance();
		if ( $fa->isReviewable() ) {
			$srev = $fa->getStableRev();
			# For pages with either no stable version, or an outdated one, let
			# the user decide if he/she wants it reviewed on the spot. One might
			# do this if he/she just saw the diff-to-stable and *then* decided to edit.
			if ( !$srev || $srev->getRevId() != $editPage->getArticle()->getLatest() ) {
				$reviewLabel = wfMsgExt( 'revreview-check-flag', array( 'parseinline' ) );
				$attribs = array( 'tabindex' => ++$tabindex, 'id' => 'wpReviewEdit' );
				$checkboxes['reviewed'] = Xml::check( 'wpReviewEdit',
					$wgRequest->getCheck( 'wpReviewEdit' ), $attribs ) .
					'&nbsp;' . Xml::label( $reviewLabel, 'wpReviewEdit' );
			}
		}
		return true;
	}
	
	public static function addBacklogNotice( &$notice ) {
		global $wgUser, $wgTitle;
		$namespaces = FlaggedRevs::getReviewNamespaces();
		if ( !count( $namespaces ) ) {
			return true; // nothing to have a backlog on
		}
		if ( empty( $wgTitle ) || $wgTitle->getNamespace() !== NS_SPECIAL ) {
			return true; // nothing to do here
		}
		if ( !$wgUser->isAllowed( 'review' ) )
			return true; // not relevant to user

		$watchlist = SpecialPage::getTitleFor( 'Watchlist' );
		$recentchanges = SpecialPage::getTitleFor( 'Recentchanges' );
		if ( $wgTitle->equals( $watchlist ) || $wgTitle->equals( $recentchanges ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$watchedOutdated = $dbr->selectField(
				array( 'watchlist', 'page', 'flaggedpages' ), '1',
				array( 'wl_user' => $wgUser->getId(), // this user
					'wl_namespace' => $namespaces, // reviewable
					'wl_namespace = page_namespace',
					'wl_title = page_title',
					'fp_page_id = page_id',
					'fp_reviewed' => 0,  // edits pending
				), __METHOD__
			);
			# Give a notice if pages on the wachlist are outdated
			if ( $watchedOutdated ) {
				$notice .= "<div id='mw-fr-oldreviewed-notice' class='plainlinks fr-watchlist-old-notice'>" .
					wfMsgExt( 'flaggedrevs-watched-pending', array( 'parseinline' ) ) . "</div>";
			# Otherwise, give a notice if there is a large backlog in general
			} else {
				$pages = $dbr->estimateRowCount( 'page', '*',
					array( 'page_namespace' => $namespaces ), __METHOD__ );
				# For small wikis, just get the real numbers to avoid some bogus messages
				if ( $pages < 50 ) {
					$pages = $dbr->selectField( 'page', 'COUNT(*)',
						array( 'page_namespace' => $namespaces ), __METHOD__ );
					$unreviewed = $dbr->selectField( 'flaggedpages', 'COUNT(*)',
						'fp_pending_since IS NOT NULL', __METHOD__ );
				} else {
					$unreviewed = $dbr->estimateRowCount( 'flaggedpages', '*',
						'fp_pending_since IS NOT NULL', __METHOD__ );
				}
				if ( $unreviewed > .02 * $pages ) {
					$notice .= "<div id='mw-fr-oldreviewed-notice' class='plainlinks fr-backlognotice'>" .
						wfMsgExt( 'flaggedrevs-backlog', array( 'parseinline' ) ) . "</div>";
				}
			}
		}
		return true;
	}
	
	public static function stableDumpQuery( &$tables, &$opts, &$join ) {
		$namespaces = FlaggedRevs::getReviewNamespaces();
		$tables = array( 'flaggedpages', 'page', 'revision' );
		$opts['ORDER BY'] = 'fp_page_id ASC';
		$opts['USE INDEX'] = array( 'flaggedpages' => 'PRIMARY' );
		$join['page'] = array( 'INNER JOIN',
			array( 'page_id = fp_page_id', 'page_namespace' => $namespaces )
		);
		$join['revision'] = array( 'INNER JOIN', 'rev_page = fp_page_id AND rev_id = fp_stable' );
		return false; // final
	}
	
	// Add selector of review "protection" options
	// Code stolen from Stabilization (which was stolen from ProtectionForm)
	public static function onProtectionForm( $article, &$output ) {
		global $wgUser, $wgRequest, $wgOut, $wgLang;
		if ( !FlaggedRevs::useProtectionLevels() || !$article->exists() ) {
			return true; // nothing to do
		} else if ( !FlaggedRevs::inReviewNamespace( $article->getTitle() ) ) {
			return true; // not a reviewable page
		}
		# Can the user actually do anything?
		$isAllowed = $wgUser->isAllowed( 'stablesettings' );
		$disabledAttrib = !$isAllowed ? array( 'disabled' => 'disabled' ) : array();
		# Get the current config/expiry
		$config = FlaggedRevs::getPageVisibilitySettings( $article->getTitle(), true );
		$oldExpiry = $config['expiry'] !== 'infinity' ?
			wfTimestamp( TS_RFC2822, $config['expiry'] ) : 'infinite';
		# Load request params...
		$selected = $wgRequest->getVal( 'wpStabilityConfig',
			FlaggedRevs::getProtectionLevel( $config ) );
		if ( $selected == 'invalid' ) {
			throw new MWException( 'This page has an undefined stability configuration!' );
		}
		$expiry = $wgRequest->getText( 'mwStabilize-expiry' );
		# Add some script for expiry dropdowns
		$wgOut->addScript(
			"<script type=\"text/javascript\">
				function updateStabilizationDropdowns() {
					val = document.getElementById('mwExpirySelection').value;
					if( val == 'existing' )
						document.getElementById('mwStabilize-expiry').value = " .
						Xml::encodeJsVar( $oldExpiry ) . ";
					else if( val != 'othertime' )
						document.getElementById('mwStabilize-expiry').value = val;
				}
			</script>"
		);
		# Add an extra row to the protection fieldset tables
		$output .= "<tr><td>";
		$output .= Xml::openElement( 'fieldset' );
		$output .= Xml::element( 'legend', null, wfMsg( 'flaggedrevs-protect-legend' ) );
		# Add a "no restrictions" level
		$effectiveLevels = array( "none" => null );
		$effectiveLevels += FlaggedRevs::getProtectionLevels();
		
		$attribs = array(
			'id' => 'mwStabilityConfig',
			'name' => 'mwStabilityConfig',
			'size' => count( $effectiveLevels ),
		) + $disabledAttrib;
		$output .= Xml::openElement( 'select', $attribs );
		# Show all restriction levels in a select...
		foreach ( $effectiveLevels as $level => $x ) {
			if ( $level == 'none' ) {
				$label = FlaggedRevs::stableOnlyIfConfigured()
					? wfMsg( 'flaggedrevs-protect-none' )
					: wfMsg( 'flaggedrevs-protect-basic' );
			} else {
				$label = wfMsg( 'flaggedrevs-protect-' . $level );
			}
			// Default to the key itself if no UI message
			if ( wfEmptyMsg( 'flaggedrevs-protect-' . $level, $label ) ) {
				$label = 'flaggedrevs-protect-' . $level;
			}
			$output .= Xml::option( $label, $level, $level == $selected );
		}
		$output .= Xml::closeElement( 'select' );
		# Get expiry dropdown
		$scExpiryOptions = wfMsgForContent( 'protect-expiry-options' );
		$showProtectOptions = ( $scExpiryOptions !== '-' && $isAllowed );
		# Add the current expiry as an option
		$expiryFormOptions = '';
		if ( $config['expiry'] && $config['expiry'] != 'infinity' ) {
			$timestamp = $wgLang->timeanddate( $config['expiry'] );
			$d = $wgLang->date( $config['expiry'] );
			$t = $wgLang->time( $config['expiry'] );
			$expiryFormOptions .=
				Xml::option(
					wfMsg( 'protect-existing-expiry', $timestamp, $d, $t ),
					'existing',
					$config['expiry'] == 'existing'
				) . "\n";
		}
		$expiryFormOptions .= Xml::option( wfMsg( 'protect-othertime-op' ), "othertime" ) . "\n";
		# Add custom levels (from MediaWiki message)
		foreach ( explode( ',', $scExpiryOptions ) as $option ) {
			if ( strpos( $option, ":" ) === false ) {
				$show = $value = $option;
			} else {
				list( $show, $value ) = explode( ":", $option );
			}
			$show = htmlspecialchars( $show );
			$value = htmlspecialchars( $value );
			$expiryFormOptions .= Xml::option( $show, $value, $config['expiry'] === $value )."\n";
		}
		# Add expiry dropdown to form
		$scExpiryOptions = wfMsgForContent( 'protect-expiry-options' );
		$showProtectOptions = ( $scExpiryOptions !== '-' && $isAllowed );
		$output .= "<table>"; // expiry table start
		if ( $showProtectOptions && $isAllowed ) {
			$output .= "
				<tr>
					<td class='mw-label'>" .
						Xml::label( wfMsg( 'stabilization-expiry' ), 'mwExpirySelection' ) .
					"</td>
					<td class='mw-input'>" .
						Xml::tags( 'select',
							array(
								'id' => 'mwExpirySelection',
								'name' => 'wpExpirySelection',
								'onchange' => 'updateStabilizationDropdowns()',
							) + $disabledAttrib,
							$expiryFormOptions ) .
					"</td>
				</tr>";
		}
		# Add custom expiry field to form
		$attribs = array( 'id' => "mwStabilize-expiry",
			'onkeyup' => 'updateStabilizationDropdowns()' ) + $disabledAttrib;
		$output .= "
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'stabilization-othertime' ), 'mwStabilize-expiry' ) .
				'</td>
				<td class="mw-input">' .
					Xml::input( "mwStabilize-expiry", 50,
						$expiry ? $expiry : $oldExpiry, $attribs ) .
				'</td>
			</tr>';
		$output .= "</table>"; // expiry table end
		# Close field set and table row
		$output .= Xml::closeElement( 'fieldset' );
		$output .= "</td></tr>";
		return true;
	}
	
	// Add stability log extract to protection form
	public static function insertStabilityLog( $article, $out ) {
		if ( !FlaggedRevs::useProtectionLevels() || !$article->exists() ) {
			return true; // nothing to do
		} else if ( !FlaggedRevs::inReviewNamespace( $article->getTitle() ) ) {
			return true; // not a reviewable page
		}
		# Show relevant lines from the stability log:
		$out->addHTML( Xml::element( 'h2', null, LogPage::logName( 'stable' ) ) );
		LogEventsList::showLogExtract( $out, 'stable', $article->getTitle()->getPrefixedText() );
		return true;
	}
	
	// Update stability config from request
	public static function onProtectionSave( $article, &$errorMsg ) {
		global $wgUser, $wgRequest;
		$levels = FlaggedRevs::getProtectionLevels();
		if ( empty( $levels ) || !$article->exists() )
			return true; // simple custom levels set for action=protect
		if ( wfReadOnly() || !$wgUser->isAllowed( 'stablesettings' ) ) {
			return true; // user cannot change anything
		}
		if ( !FlaggedRevs::inReviewNamespace( $article->getTitle() ) ) {
			return true; // not a reviewable page
		}
		$form = new Stabilization();
		$form->target = $article->getTitle(); # Our target page
		$form->watchThis = null; # protection form already has a watch check
		$form->reason = $wgRequest->getText( 'mwProtect-reason' ); # Reason
		$form->reasonSelection = $wgRequest->getVal( 'wpProtectReasonSelection' ); # Reason dropdown
		$form->expiry = $wgRequest->getText( 'mwStabilize-expiry' ); # Expiry
		$form->expirySelection = $wgRequest->getVal( 'wpExpirySelection' ); # Expiry dropdown
		# Fill in config from the protection level...
		$selected = $wgRequest->getVal( 'mwStabilityConfig' );
		if ( $selected == "none" ) {
			$form->select = FlaggedRevs::getPrecedence(); // default
			$form->override = (int)FlaggedRevs::isStableShownByDefault(); // default
			$form->autoreview = ''; // default
			$form->reviewThis = false;
		} else if ( isset( $levels[$selected] ) ) {
			$form->select = $levels[$selected]['select'];
			$form->override = $levels[$selected]['override'];
			$form->autoreview = $levels[$selected]['autoreview'];
			$form->reviewThis = true; // auto-review; protection-like
		} else {
			return false; // bad level
		}
		$form->wasPosted = $wgRequest->wasPosted();
		if ( $form->handleParams() ) {
			$status = $form->submit();
			if ( $status !== true ) {
				$errorMsg = wfMsg( $status ); // some error message
			}
		}
		return true;
	}

	public static function onParserTestTables( &$tables ) {
		$tables[] = 'flaggedpages';
		$tables[] = 'flaggedrevs';
		$tables[] = 'flaggedpage_pending';
		$tables[] = 'flaggedpage_config';
		$tables[] = 'flaggedtemplates';
		$tables[] = 'flaggedimages';
		$tables[] = 'flaggedrevs_promote';
		$tables[] = 'flaggedrevs_tracking';
		return true;
	}
	
	public static function addSchemaUpdates() {
		global $wgDBtype, $wgExtNewFields, $wgExtPGNewFields, $wgExtNewIndexes, $wgExtNewTables;
		$base = dirname( __FILE__ );
		if ( $wgDBtype == 'mysql' ) {
			// Initial install tables (current schema)
			$wgExtNewTables[] = array( 'flaggedrevs', "$base/FlaggedRevs.sql" );
			// Updates (in order)...
			$wgExtNewFields[] = array( 'flaggedpage_config',
				'fpc_expiry', "$base/archives/patch-fpc_expiry.sql" );
			$wgExtNewIndexes[] = array( 'flaggedpage_config',
				'fpc_expiry', "$base/archives/patch-expiry-index.sql" );
			$wgExtNewTables[] = array( 'flaggedrevs_promote',
				"$base/archives/patch-flaggedrevs_promote.sql" );
			$wgExtNewTables[] = array( 'flaggedpages', "$base/archives/patch-flaggedpages.sql" );
			$wgExtNewFields[] = array( 'flaggedrevs',
				'fr_img_name', "$base/archives/patch-fr_img_name.sql" );
			$wgExtNewTables[] = array( 'flaggedrevs_tracking',
				"$base/archives/patch-flaggedrevs_tracking.sql" );
			$wgExtNewFields[] = array( 'flaggedpages', 'fp_pending_since',
				"$base/archives/patch-fp_pending_since.sql" );
			$wgExtNewFields[] = array( 'flaggedpage_config', 'fpc_level',
				"$base/archives/patch-fpc_level.sql" );
			$wgExtNewTables[] = array( 'flaggedpage_pending',
				"$base/archives/patch-flaggedpage_pending.sql" );
		} elseif ( $wgDBtype == 'postgres' ) {
			// Initial install tables (current schema)
			$wgExtNewTables[] = array( 'flaggedrevs', "$base/FlaggedRevs.pg.sql" );
			// Updates (in order)...
			$wgExtPGNewFields[] = array( 'flaggedpage_config', 'fpc_expiry', "TIMESTAMPTZ NULL" );
			$wgExtNewIndexes[] = array( 'flaggedpage_config',
				'fpc_expiry', "$base/postgres/patch-expiry-index.sql" );
			$wgExtNewTables[] = array( 'flaggedrevs_promote',
				"$base/postgres/patch-flaggedrevs_promote.sql" );
			$wgExtNewTables[] = array( 'flaggedpages', "$base/postgres/patch-flaggedpages.sql" );
			$wgExtNewIndexes[] = array( 'flaggedrevs', 'fr_img_sha1',
				"$base/postgres/patch-fr_img_name.sql" );
			$wgExtNewTables[] = array( 'flaggedrevs_tracking',
				"$base/postgres/patch-flaggedrevs_tracking.sql" );
			$wgExtNewIndexes[] = array( 'flaggedpages', 'fp_pending_since',
				"$base/postgres/patch-fp_pending_since.sql" );
			$wgExtPGNewFields[] = array( 'flaggedpage_config', 'fpc_level', "TEXT NULL" );
			$wgExtNewTables[] = array( 'flaggedpage_pending',
				"$base/postgres/patch-flaggedpage_pending.sql" );
		}
		return true;
	}
}
