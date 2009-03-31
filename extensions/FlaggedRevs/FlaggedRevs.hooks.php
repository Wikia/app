<?php

class FlaggedRevsHooks {
	/**
	* Remove 'autopatrol' rights. Reviewing revisions will patrol them as well.
	*/
	public static function stripPatrolRights( $user, &$rights ) {
		# Use only our extension mechanisms
		foreach( $rights as $n => $right ) {
			if( $right == 'autopatrol' ) {
				unset($rights[$n]);
			}
		}
		return true;
	}

	/**
	* Add FlaggedRevs css/js.
	*/
	public static function injectStyleAndJS() {
		global $wgOut;
		# Don't double-load
		if( $wgOut->hasHeadItem( 'FlaggedRevs' ) || !$wgOut->isArticleRelated() ) {
			return true;
		}
		$fa = FlaggedArticle::getGlobalInstance();
		# Try to only add to relevant pages
		if( !$fa || (!$fa->isReviewable(true) && !$fa->isRateable() ) ) {
			return true;
		}
		global $wgScriptPath, $wgJsMimeType, $wgFlaggedRevsStylePath, $wgFlaggedRevStyleVersion;
		# Load required messages
		wfLoadExtensionMessages( 'FlaggedRevs' );
		
		$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFlaggedRevsStylePath );
		$rTags = FlaggedRevs::getJSTagParams();
		$fTags = FlaggedRevs::getJSFeedbackParams();
		$frev = $fa->getStableRev();
		$stableId = $frev ? $frev->getRevId() : 0;

		$encCssFile = htmlspecialchars( "$stylePath/flaggedrevs.css?$wgFlaggedRevStyleVersion" );
		$encJsFile = htmlspecialchars( "$stylePath/flaggedrevs.js?$wgFlaggedRevStyleVersion" );

		$wgOut->addExtensionStyle( $encCssFile );

		$ajaxFeedback = Xml::encodeJsVar( (object) array( 
			'sendingMsg' => wfMsgHtml('readerfeedback-submitting'), 
			'sentMsg' => wfMsgHtml('readerfeedback-finished') 
			)
		);
		$ajaxReview = Xml::encodeJsVar( (object) array( 
			'sendingMsg' => wfMsgHtml('revreview-submitting'), 
			'sentMsg' => wfMsgHtml('revreview-finished'),
			'actioncomplete' => wfMsgHtml('actioncomplete')
			)
		);

		$head = <<<EOT
<script type="$wgJsMimeType">
var wgFlaggedRevsParams = $rTags;
var wgFlaggedRevsParams2 = $fTags;
var wgStableRevisionId = $stableId;
var wgAjaxFeedback = $ajaxFeedback
var wgAjaxReview = $ajaxReview
</script>
<script type="$wgJsMimeType" src="$encJsFile"></script>

EOT;
		$wgOut->addHeadItem( 'FlaggedRevs', $head );
		return true;
	}
	
	/**
	* Add FlaggedRevs css for relevant special pages.
	*/
	public static function InjectStyleForSpecial() {
		global $wgTitle, $wgOut, $wgUser;
		if( empty($wgTitle) || $wgTitle->getNamespace() !== NS_SPECIAL ) {
			return true;
		}
		$spPages = array( 'UnreviewedPages', 'OldReviewedPages', 'Watchlist', 'Recentchanges', 
			'Contributions', 'RatingHistory' );
		foreach( $spPages as $n => $key ) {
			if( $wgTitle->isSpecial( $key ) ) {
				global $wgScriptPath, $wgFlaggedRevsStylePath, $wgFlaggedRevStyleVersion;
				$stylePath = str_replace( '$wgScriptPath', $wgScriptPath, $wgFlaggedRevsStylePath );
				$encCssFile = htmlspecialchars( "$stylePath/flaggedrevs.css?$wgFlaggedRevStyleVersion" );
				$wgOut->addExtensionStyle( $encCssFile );
				break;
			}
		}
		return true;
	}

	/**
	* Update flaggedrevs table on revision restore
	*/
	public static function updateFromRestore( $title, $revision, &$oldPageID ) {
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
		wfProfileIn( __METHOD__ );
	
		$oldPageID = $sourceTitle->getArticleID();
		$newPageID = $destTitle->getArticleID();
		# Get flagged revisions from old page id that point to destination page
		$dbw = wfGetDB( DB_MASTER );
		$result = $dbw->select( array('flaggedrevs','revision'),
			array( 'fr_rev_id' ),
			array( 'fr_page_id' => $oldPageID,
				'fr_rev_id = rev_id',
				'rev_page' => $newPageID ),
			__METHOD__ );
		# Update these rows
		$revIDs = array();
		while( $row = $dbw->fetchObject($result) ) {
			$revIDs[] = $row->fr_rev_id;
		}
		if( !empty($revIDs) ) {
			$dbw->update( 'flaggedrevs',
				array( 'fr_page_id' => $newPageID ),
				array( 'fr_page_id' => $oldPageID,
					'fr_rev_id' => $revIDs ),
				__METHOD__ );
		}
		# Update pages
		FlaggedRevs::titleLinksUpdate( $sourceTitle );
		FlaggedRevs::titleLinksUpdate( $destTitle );

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	public static function onArticleDelete( &$article, &$user, $reason, $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'flaggedpage_config',
			array( 'fpc_page_id' => $article->getID() ),
			__METHOD__
		);
		return true;
	}

	/**
	* Inject stable links on LinksUpdate
	*/
	public static function extraLinksUpdate( $linksUpdate ) {
		if( !FlaggedRevs::isPageReviewable( $linksUpdate->mTitle ) ) {
			return true;
		}
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		$pageId = $linksUpdate->mTitle->getArticleId();
		# Check if this page has a stable version...
		$sv = isset($u->fr_stableRev) ? // Try the process cache...
			$u->fr_stableRev : FlaggedRevision::newFromStable( $linksUpdate->mTitle, FR_MASTER );
		# Empty flagged revs data for this page if there is no stable version
		if( !$sv ) {
			$dbw->delete( 'flaggedpages', array( 'fp_page_id' => $pageId ), __METHOD__ );
			$dbw->delete( 'flaggedrevs_tracking', array( 'ftr_from' => $pageId ), __METHOD__ );
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Try the process cache...
		$article = new Article( $linksUpdate->mTitle );
		if( isset($linksUpdate->fr_stableParserOut) ) {
			$parserOut = $linksUpdate->fr_stableParserOut;
		} else {
			# Try stable version cache. This should be updated before this is called.
			$parserOut = FlaggedRevs::getPageCache( $article );
			if( $parserOut === false ) {
				$text = $sv->getRevText();
				# Parse the text
				$parserOut = FlaggedRevs::parseStableText( $article, $text, $sv->getRevId() );
			}
		}
		# Update page fields
		FlaggedRevs::updateArticleOn( $article, $sv->getRevId() );
		# We only care about links that are only in the stable version
		$links = array();
		foreach( $parserOut->getLinks() as $ns => $titles ) {
			foreach( $titles as $title => $id ) {
				if( !isset($linksUpdate->mLinks[$ns]) || !isset($linksUpdate->mLinks[$ns][$title]) ) {
					self::addLink( $links, $ns, $title );
				}
			}
		}
		foreach( $parserOut->getImages() as $image => $n ) {
			if( !isset($linksUpdate->mImages[$image]) ) {
				self::addLink( $links, NS_FILE, $image );
			}
		}
		foreach( $parserOut->getTemplates() as $ns => $titles ) {
			foreach( $titles as $title => $id ) {
				if( !isset($linksUpdate->mTemplates[$ns]) || !isset($linksUpdate->mTemplates[$ns][$title]) ) {
					self::addLink( $links, $ns, $title );
				}
			}
		}
		foreach( $parserOut->getCategories() as $category => $sort ) {
            if( !isset($linksUpdate->mCategories[$category]) ) {
                self::addLink( $links, NS_CATEGORY, $category );
			}
        }
		# Get any link tracking changes
		$existing = self::getExistingLinks( $pageId );
		$insertions = self::getLinkInsertions( $existing, $links, $pageId );
		$deletions = self::getLinkDeletions( $existing, $links );
		# Delete removed links
		if( $clause = self::makeWhereFrom2d( $deletions ) ) {
			$where = array( 'ftr_from' => $pageId );
			$where[] = $clause;
			$dbw->delete( 'flaggedrevs_tracking', $where, __METHOD__ );
		}
		# Add any new links
		if( count($insertions) ) {
			$dbw->insert( 'flaggedrevs_tracking', $insertions, __METHOD__, 'IGNORE' );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
	
	protected static function addLink( &$links, $ns, $dbKey ) {
		if( !isset($links[$ns]) ) {
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
		while( $row = $dbr->fetchObject( $res ) ) {
			if( !isset( $arr[$row->ftr_namespace] ) ) {
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
		foreach( $new as $ns => $dbkeys ) {
			$diffs = isset( $existing[$ns] ) ? array_diff_key( $dbkeys, $existing[$ns] ) : $dbkeys;
			foreach( $diffs as $dbk => $id ) {
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
		foreach( $existing as $ns => $dbkeys ) {
			if( isset( $new[$ns] ) ) {
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
		$update = new FRCacheUpdate( $title, 'flaggedrevs_tracking' );
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
		if( !$parser || empty($parser->fr_isStable) )
			return true;
		# Special namespace ... ?
		if( $title->getNamespace() < 0 ) {
			return true;
		}
		$dbr = wfGetDB( DB_SLAVE );
		# Check for stable version of template if this feature is enabled.
		# Should be in reviewable namespace, this saves unneeded DB checks as
		# well as enforce site settings if they are later changed.
		if( FlaggedRevs::isPageReviewable($title) && $title->getArticleId() ) {
			$id = $dbr->selectField( 'flaggedpages', 'fp_stable',
				array( 'fp_page_id' => $title->getArticleId() ),
				__METHOD__ );
		}
		# Check cache before doing another DB hit...
		$idP = FlaggedRevs::getTemplateIdFromCache( $parser->getRevisionId(), $title->getNamespace(), $title->getDBKey() );
		if( !is_null($idP) && (!$id || $idP > $id) ) {
			$id = $idP;
		}
		# If there is no stable version (or that feature is not enabled), use
		# the template revision during review time. If both, use the newest one.
		if( !FlaggedRevs::useProcessCache( $parser->getRevisionId() ) ) {
			$idP = $dbr->selectField( 'flaggedtemplates', 'ft_tmp_rev_id',
				array( 'ft_rev_id' => $parser->getRevisionId(),
					'ft_namespace' => $title->getNamespace(),
					'ft_title' => $title->getDBkey() ),
				__METHOD__ );
			$id = ($id === false || $idP > $id) ? $idP : $id;
		}
		# If none specified, see if we are allowed to use the current revision
		if( !$id ) {
			global $wgUseCurrentTemplates;
			if( $id === false ) {
				$parser->mOutput->fr_includeErrors[] = $title->getPrefixedDBKey(); // May want to give an error
				if( !$wgUseCurrentTemplates ) {
					$skip = true;
				}
			} else {
				$skip = true; // If ID is zero, don't load it
			}
		}
		if( $id > $parser->mOutput->fr_newestTemplateID ) {
			$parser->mOutput->fr_newestTemplateID = $id;
		}
		return true;
	}

	/**
	* Select the desired images based on the selected stable revision times/SHA-1s
	*/
	public static function parserMakeStableImageLink( $parser, $nt, &$skip, &$time, &$query=false ) {
		# Trigger for stable version parsing only
		if( empty($parser->fr_isStable) ) {
			return true;
		}
		$file = null;
		$dbr = wfGetDB( DB_SLAVE );
		# Normalize NS_MEDIA to NS_FILE
		$title = $nt->getNamespace() == NS_FILE ? $nt : Title::makeTitle( NS_FILE, $nt->getDBKey() );
		# Check for stable version of image if this feature is enabled.
		# Should be in reviewable namespace, this saves unneeded DB checks as
		# well as enforce site settings if they are later changed.
		$sha1 = "";
		global $wgUseStableImages;
		if( $wgUseStableImages && FlaggedRevs::isPageReviewable( $title ) ) {
			if( $srev = FlaggedRevision::newFromStable( $title ) ) {
				$time = $srev->getFileTimestamp();
				$sha1 = $srev->getFileSha1();
			}
		}
		# Check cache before doing another DB hit...
		$params = FlaggedRevs::getFileVersionFromCache( $parser->getRevisionId(), $title->getDBKey() );
		if( is_array($params) ) {
			list($timeP,$sha1) = $params;
			// Take the newest one...
			if( !$time || $timeP > $time ) {
				$time = $timeP;
			}
		}
		# If there is no stable version (or that feature is not enabled), use
		# the image revision during review time. If both, use the newest one.
		if( !FlaggedRevs::useProcessCache( $parser->getRevisionId() ) ) {
			$row = $dbr->selectRow( 'flaggedimages', 
				array( 'fi_img_timestamp', 'fi_img_sha1' ),
				array( 'fi_rev_id' => $parser->getRevisionId(),
					'fi_name' => $title->getDBkey() ),
				__METHOD__ );
			if( $row && ($time === false || $row->fi_img_timestamp > $time) ) {
				$time = $row->fi_img_timestamp;
				$sha1 = $row->fi_img_sha1;
			}
		}
		$query = $time ? "filetimestamp=" . urlencode( wfTimestamp(TS_MW,$time) ) : "";
		# If none specified, see if we are allowed to use the current revision
		if( !$time ) {
			global $wgUseCurrentImages;
			# If the DB found nothing...
			if( $time === false ) {
				$parser->mOutput->fr_includeErrors[] = $title->getPrefixedDBKey(); // May want to give an error
				if( !$wgUseCurrentImages ) {
					$time = "0";
				} else {
					$file = wfFindFile( $title );
					$time = $file ? $file->getTimestamp() : "0"; // Use current
				}
			} else {
				$time = "0";
			}
		}
		# Add image metadata to parser output
		$parser->mOutput->fr_ImageSHA1Keys[$title->getDBkey()] = array();
		$parser->mOutput->fr_ImageSHA1Keys[$title->getDBkey()][$time] = $sha1;
		# Bug 15748, be lax about commons image sync status
		$file = $file ? $file : self::getLocalFile( $title, $time ); # FIXME: would be nice not to double fetch!
		if( $file && $file->exists() && $file->isLocal() && $time > $parser->mOutput->fr_newestImageTime ) {
			$parser->mOutput->fr_newestImageTime = $time;
		}
		return true;
	}

	/**
	* Select the desired images based on the selected stable revision times/SHA-1s
	*/
	public static function galleryFindStableFileTime( $ig, $nt, &$time, &$query=false ) {
		# Trigger for stable version parsing only
		if( empty($ig->mParser->fr_isStable) || $nt->getNamespace() != NS_FILE ) {
			return true;
		}
		$file = null;
		$dbr = wfGetDB( DB_SLAVE );
		# Check for stable version of image if this feature is enabled.
		# Should be in reviewable namespace, this saves unneeded DB checks as
		# well as enforce site settings if they are later changed.
		$sha1 = "";
		global $wgUseStableImages;
		if( $wgUseStableImages && FlaggedRevs::isPageReviewable( $nt ) ) {
			if( $srev = FlaggedRevision::newFromStable( $nt ) ) {
				$time = $srev->getFileTimestamp();
				$sha1 = $srev->getFileSha1();
			}
		}
		# Check cache before doing another DB hit...
		$params = FlaggedRevs::getFileVersionFromCache( $ig->mRevisionId, $nt->getDBKey() );
		if( is_array($params) ) {
			list($timeP,$sha1) = $params;
			// Take the newest one...
			if( !$time || $timeP > $time ) {
				$time = $timeP;
			}
		}
		# If there is no stable version (or that feature is not enabled), use
		# the image revision during review time. If both, use the newest one.
		if( !FlaggedRevs::useProcessCache( $ig->mRevisionId ) ) {
			$row = $dbr->selectRow( 'flaggedimages', 
				array( 'fi_img_timestamp', 'fi_img_sha1' ),
				array('fi_rev_id' => $ig->mRevisionId,
					'fi_name' => $nt->getDBkey() ),
				__METHOD__ );
			if( $row && ($time === false || $row->fi_img_timestamp > $time) ) {
				$time = $row->fi_img_timestamp;
				$sha1 = $row->fi_img_sha1;
			}
		}
		$query = $time ? "filetimestamp=" . urlencode( wfTimestamp(TS_MW,$time) ) : "";
		# If none specified, see if we are allowed to use the current revision
		if( !$time ) {
			global $wgUseCurrentImages;
			# If the DB found nothing...
			if( $time === false ) {
				$ig->mParser->mOutput->fr_includeErrors[] = $nt->getPrefixedDBKey(); // May want to give an error
				if( !$wgUseCurrentImages ) {
					$time = "0";
				} else {
					$file = wfFindFile( $nt );
					$time = $file ? $file->getTimestamp() : "0";
				}
			} else {
				$time = "0";
			}
		}
		# Add image metadata to parser output
		$ig->mParser->mOutput->fr_ImageSHA1Keys[$nt->getDBkey()] = array();
		$ig->mParser->mOutput->fr_ImageSHA1Keys[$nt->getDBkey()][$time] = $sha1;
		# Bug 15748, be lax about commons image sync status
		$file = $file ? $file : self::getLocalFile( $nt, $time ); # FIXME: would be nice not to double fetch!
		if( $file && $file->exists() && $file->isLocal() && $time > $ig->mParser->mOutput->fr_newestImageTime ) {
			$ig->mParser->mOutput->fr_newestImageTime = $time;
		}
		return true;
	}
	
	/**
	* Insert image timestamps/SHA-1 keys into parser output
	*/
	public static function parserInjectTimestamps( $parser, &$text ) {
		# Don't trigger this for stable version parsing...it will do it separately.
		if( !empty($parser->fr_isStable) )
			return true;

		wfProfileIn( __METHOD__ );
		$maxRevision = 0;
		# Record the max template revision ID
		if( !empty($parser->mOutput->mTemplateIds) ) {
			foreach( $parser->mOutput->mTemplateIds as $namespace => $DBKeyRev ) {
				foreach( $DBKeyRev as $DBkey => $revID ) {
					if( $revID > $maxRevision ) {
						$maxRevision = $revID;
					}
				}
			}
		}
		$parser->mOutput->fr_newestTemplateID = $maxRevision;

		$maxTimestamp = "0";
		# Fetch the current timestamps of the images.
		if( !empty($parser->mOutput->mImages) ) {
			foreach( $parser->mOutput->mImages as $filename => $x ) {
				# FIXME: it would be nice not to double fetch these!
				$file = wfFindFile( Title::makeTitleSafe( NS_FILE, $filename ) );
				$parser->mOutput->fr_ImageSHA1Keys[$filename] = array();
				if( $file ) {
					# Bug 15748, be lax about commons image sync status
					if( $file->isLocal() && $file->getTimestamp() > $maxTimestamp ) {
						$maxTimestamp = $file->getTimestamp();
					}
					$parser->mOutput->fr_ImageSHA1Keys[$filename][$file->getTimestamp()] = $file->getSha1();
				} else {
					$parser->mOutput->fr_ImageSHA1Keys[$filename]["0"] = '';
				}
			}
		}
		# Record the max timestamp
		$parser->mOutput->fr_newestImageTime = $maxTimestamp;

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	* Insert image timestamps/SHA-1s into page output
	*/
	public static function outputInjectTimestamps( $out, $parserOut ) {
		# Set first time
		$out->fr_ImageSHA1Keys = isset($out->fr_ImageSHA1Keys) ? $out->fr_ImageSHA1Keys : array();
		# Leave as defaults if missing. Relevant things will be updated only when needed.
		# We don't want to go around resetting caches all over the place if avoidable...
		$imageSHA1Keys = isset($parserOut->fr_ImageSHA1Keys) ? $parserOut->fr_ImageSHA1Keys : array();
		# Add on any new items
		$out->fr_ImageSHA1Keys = wfArrayMerge( $out->fr_ImageSHA1Keys, $imageSHA1Keys );
		return true;
	}

	protected static function getLocalFile( $title, $time ) {
		return RepoGroup::singleton()->getLocalRepo()->findFile( $title, $time );
	}

	/**
	* Don't let users vandalize pages by moving them
	*/
	public static function userCanMove( $title, $user, $action, &$result ) {
		if( $action != 'move' || $result===false || !FlaggedRevs::isPageReviewable($title) ) {
			return true;
		}
		$flaggedArticle = FlaggedArticle::getTitleInstance( $title );
		if( !$flaggedArticle->showStableByDefault() ) {
			return true;
		}
		if( $frev = $flaggedArticle->getStableRev() ) {
			# Allow for only editors/reviewers to move this
			if( !$user->isAllowed('review') && !$user->isAllowed('movestable') ) {
				$result = false;
				return false;
			}
		}
		return true;
	}
	
	/**
	* Don't let users pages pages not in $wgFlaggedRevsPatrolNamespaces
	*/
	public static function userCanPatrol( $title, $user, $action, &$result ) {
		if( $action != 'patrol' || $result===false ) {
			return true;
		}
		# Pages in reviewable namespace can be patrolled IF reviewing
		# is disabled for pages that don't show the stable by default.
		# In such cases, we let people with 'review' rights patrol them.
		if( FlaggedRevs::isPageReviewable($title) && !$user->isAllowed( 'review' ) ) {
			$result = false;
			return false;
		}
		$flaggedArticle = FlaggedArticle::getTitleInstance( $title );
		# The page must be in a patrollable namespace...
		if( !$flaggedArticle->isPatrollable() ) {
			global $wgUseNPPatrol;
			# ...unless the page is not in a reviewable namespace and
			# new page patrol is enabled. In this scenario, any edits
			# to pages outside of patrollable namespaces would already
			# be auto-patrolled, except for the new page edits.
			if( $wgUseNPPatrol && !$flaggedArticle->isReviewable() ) {
				return true;
			} else {
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
        if( $action !== 'read' || $result===false || empty($wgFlaggedRevsVisible) )
            return true;
        # Admin may set this to false, rather than array()...
        $groups = $user->getGroups();
        $groups[] = '*';
        if( !array_intersect($groups,$wgFlaggedRevsVisible) )
            return true;
        # Is this a talk page?
        if( $wgFlaggedRevsTalkVisible && $title->isTalkPage() ) {
            $result = true;
            return true;
        }
        # See if there is a stable version. Also, see if, given the page 
        # config and URL params, the page can be overriden.
		$flaggedArticle = FlaggedArticle::getTitleInstance( $title );
        if( !empty($wgTitle) && $wgTitle->equals( $title ) ) {
            // Cache stable version while we are at it.
            if( $flaggedArticle->pageOverride() && $flaggedArticle->getStableRev() ) {
                $result = true;
            }
        } else {
            if( FlaggedRevision::newFromStable( $title ) ) {
                $result = true;
            }
        }
        return true;
    }
	
	/**
	* When an edit is made by a reviewer, if the current revision is the stable
	* version, try to automatically review it.
	*/
	public static function maybeMakeEditReviewed( $article, $rev, $baseRevId = false, $user = null ) {
		global $wgFlaggedRevsAutoReview, $wgFlaggedRevsAutoReviewNew, $wgRequest;
		# Get the user
		$user = is_null($user) ? User::newFromId( $rev->getUser() ) : $user;
		$checked = $wgRequest->getCheck('wpReviewEdit') && $user->isAllowed('review');
		if( $checked ) {
			# Review this revision of the page. Let articlesavecomplete hook do rc_patrolled bit...
			FlaggedRevs::autoReviewEdit( $article, $user, $rev->getText(), $rev, null, false );
			return true;
		}
		# Auto-reviewing must be enabled
		if( !$wgFlaggedRevsAutoReview ) return true;
		# User must have the required permissions
		if( !$user->isAllowed('autoreview') && !$user->isAllowed('bot') )
			return true;
		# If $baseRevId passed in, this is a null edit
		$isNullEdit = $baseRevId ? true : false;
		# Must be in reviewable namespace
		$title = $article->getTitle();
		if( !FlaggedRevs::isPageReviewable( $title ) ) {
			return true;
		}
		$frev = null;
		$reviewableNewPage = false;
		# Avoid extra DB hit and lag issues
		$title->resetArticleID( $rev->getPage() );
		# Get what was just the current revision ID
		$prevRevId = $rev->getParentId();
		# Get the revision ID the incoming one was based off...
		if( !$baseRevId && $prevRevId ) {
			$prevTimestamp = Revision::getTimestampFromId( $title, $prevRevId ); // use PK			
			# Get edit timestamp. Existance already valided by EditPage.php. If 
			# not present, then it shouldn't be, like null edits.
			$editTimestamp = $wgRequest->getVal('wpEdittime');
			# The user just made an edit. The one before that should have
			# been the current version. If not reflected in wpEdittime, an
			# edit may have been auto-merged in between, in that case, discard
			# the baseRevId given from the client...
			if( !$editTimestamp || $prevTimestamp == $editTimestamp ) {
				$baseRevId = intval( trim( $wgRequest->getVal('baseRevId') ) );
			}
			# If baseRevId not given, assume the previous revision ID.
			# For auto-merges, this also occurs since the given ID is ignored.
			# Also for bots that don't submit everything...
			if( !$baseRevId ) {
				$baseRevId = $prevRevId;
			}
		}
		// New pages
		if( !$prevRevId ) {
			$reviewableNewPage = (bool)$wgFlaggedRevsAutoReviewNew;
		// Edits to existing pages
		} else if( $baseRevId ) {
			$frev = FlaggedRevision::newFromTitle( $title, $baseRevId, FR_MASTER );
			# If the base revision was not reviewed, check if the previous one was.
			# This should catch null edits as well as normal ones.
			if( !$frev ) {
				$frev = FlaggedRevision::newFromTitle( $title, $prevRevId, FR_MASTER );
			}
		}
		# Is this an edit directly to the stable version?
		if( $reviewableNewPage || !is_null($frev) ) {
			# Assume basic flagging level unless this is a null edit
			if( $isNullEdit ) {
				$flags = $frev->getTags();
			} else {
				$flags = null;
			}
			# Review this revision of the page. Let articlesavecomplete hook do rc_patrolled bit...
			FlaggedRevs::autoReviewEdit( $article, $user, $rev->getText(), $rev, $flags, false );
		}
		return true;
	}

	/**
	* When an edit is made to a page that can't be reviewed, autopatrol if allowed.
	*/
	public static function autoMarkPatrolled( $rc ) {
		global $wgUser;
		if( empty($rc->mAttribs['rc_this_oldid']) ) {
			return true;
		}
		$patrol = $record = false;
		// Is the page reviewable?
		if( FlaggedRevs::isPageReviewable( $rc->getTitle() ) ) {
			# Note: pages in reviewable namespace with FR disabled
			# won't autopatrol. May or may not be useful...
			$patrol = FlaggedRevs::revIsFlagged( $rc->getTitle(), $rc->mAttribs['rc_this_oldid'], 
				GAID_FOR_UPDATE );
		// Can this be patrolled?
		} else if( FlaggedRevs::isPagePatrollable( $rc->getTitle() ) ) {
			$patrol = $wgUser->isAllowed('autopatrolother') || $wgUser->isAllowed('bot');
			$record = true;
		} else {
			global $wgUseNPPatrol;
			# Mark patrolled by default unless this is a new page and new page patrol 
			# is enabled (except when the user has 'autopatrol', then patrol it).
			if( $wgUser->isAllowed('autopatrol') ) {
				$patrol = true;
				# Record patrolled new pages if $wgUseNPPatrol is on
				$record = ( $wgUseNPPatrol && !empty($rc->mAttribs['rc_new']) );
			} else {
				$patrol = !( $wgUseNPPatrol && !empty($rc->mAttribs['rc_new']) );
			}
		}
		if( $patrol ) {
			RevisionReview::updateRecentChanges( $rc->getTitle(), $rc->mAttribs['rc_this_oldid'] );
			if( $record ) {
				PatrolLog::record( $rc->mAttribs['rc_id'], true );
			}
		}
		return true;
	}
	
	public static function incrementRollbacks( $this, $user, $target, $current ) {
		if( $current->getRawUser() ) {
			global $wgFlaggedRevsAutopromote;
			$p = FlaggedRevs::getUserParams( $current->getRawUser() );
			$p['revertedEdits'] = isset($p['revertedEdits']) ? $p['revertedEdits'] : 0;
			$p['revertedEdits']++;
			if( $wgFlaggedRevsAutopromote['maxRevertedEdits'] >= $p['revertedEdits'] )
				FlaggedRevs::saveUserParams( $current->getRawUser(), $p );
		}
		return true;
	}

	/**
	* Callback that autopromotes user according to the setting in
	* $wgFlaggedRevsAutopromote. This is not as efficient as it should be
	*/
	public static function autoPromoteUser( $article, $user, &$text, &$summary, &$m, &$a, &$b, &$f, $rev ) {
		global $wgFlaggedRevsAutopromote, $wgMemc;
		if( empty($wgFlaggedRevsAutopromote) || !$rev )
			return true;

		wfProfileIn( __METHOD__ );
		# Grab current groups
		$groups = $user->getGroups();
		# Do not give this to current holders or bots
		if( $user->isAllowed('bot') || in_array('editor',$groups) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Do not re-add status if it was previously removed!
		$p = FlaggedRevs::getUserParams( $user->getId() );
		if( isset($p['demoted']) && $p['demoted'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Update any special counters for non-null revisions
		$changed = false;
		$pages = array();
		$p['uniqueContentPages'] = isset($p['uniqueContentPages']) ? $p['uniqueContentPages'] : '';
		$p['totalContentEdits'] = isset($p['totalContentEdits']) ? $p['totalContentEdits'] : 0;
		$p['editComments'] = isset($p['editComments']) ? $p['editComments'] : 0;
		$p['reviewedEdits'] = isset($p['reviewedEdits']) ? $p['reviewedEdits'] : 0;
		$p['revertedEdits'] = isset($p['revertedEdits']) ? $p['revertedEdits'] : 0;
		if( $article->getTitle()->isContentPage() ) {
			$pages = explode( ',', trim($p['uniqueContentPages']) ); // page IDs
			# Don't let this get bloated for no reason
			if( count($pages) < $wgFlaggedRevsAutopromote['uniqueContentPages'] && !in_array($article->getId(),$pages) ) {
				$pages[] = $article->getId();
				$p['uniqueContentPages'] = preg_replace('/^,/','',implode(',',$pages)); // clear any garbage
			}
			$p['totalContentEdits'] += 1;
			$changed = true;
		}
		if( $summary ) {
			$p['editComments'] += 1;
			$changed = true;
		}
		# Save any updates to user params
		if( $changed ) {
			FlaggedRevs::saveUserParams( $user->getId(), $p );
		}
		# Check if user edited enough content pages
		if( $wgFlaggedRevsAutopromote['totalContentEdits'] > $p['totalContentEdits'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check if the user has enough sighted edits
		if( $wgFlaggedRevsAutopromote['totalReviewedEdits'] > $p['reviewedEdits'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check if user edited enough unique pages
		if( $wgFlaggedRevsAutopromote['uniqueContentPages'] > count($pages) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check edit comment use
		if( $wgFlaggedRevsAutopromote['editComments'] > $p['editComments'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check reverted edits
		if( $wgFlaggedRevsAutopromote['maxRevertedEdits'] < $p['revertedEdits'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check user email
		if( $wgFlaggedRevsAutopromote['email'] && !$user->isEmailConfirmed() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check account age
		$now = time();
		$usercreation = wfTimestampOrNull( TS_UNIX, $user->getRegistration() );
		$userage = $usercreation ? floor(($now - $usercreation) / 86400) : NULL;
		if( !is_null($userage) && $userage < $wgFlaggedRevsAutopromote['days'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check user edit count. Should be stored.
		if( $user->getEditCount() < $wgFlaggedRevsAutopromote['edits'] ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check if results are cached to avoid DB queries.
		# Checked basic, already available, promotion heuristics first...
		$key = wfMemcKey( 'flaggedrevs', 'autopromote-skip', $user->getID() );
		$value = $wgMemc->get( $key );
		if( $value == 'true' ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Don't grant to currently blocked users...
		if( $user->isBlocked() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		# Check if user was ever blocked before
		if( $wgFlaggedRevsAutopromote['neverBlocked'] ) {
			$dbr = wfGetDB( DB_SLAVE );
			$blocked = $dbr->selectField( 'logging', '1',
				array( 'log_namespace' => NS_USER, 
					'log_title' => $user->getUserPage()->getDBKey(),
					'log_type' => 'block',
					'log_action' => 'block' ),
				__METHOD__,
				array( 'USE INDEX' => 'page_time' ) );
			if( $blocked ) {
				# Make a key to store the results
				$wgMemc->set( $key, 'true', 3600*24*7 );
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		# See if the page actually has sufficient content...
		if( $wgFlaggedRevsAutopromote['userpage'] ) {
			if( !$user->getUserPage()->exists() ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
			$dbr = isset($dbr) ? $dbr : wfGetDB( DB_SLAVE );
			$size = $dbr->selectField( 'page', 'page_len',
				array( 'page_namespace' => $user->getUserPage()->getNamespace(),
					'page_title' => $user->getUserPage()->getDBKey() ),
				__METHOD__ );
			if( $size < $wgFlaggedRevsAutopromote['userpageBytes'] ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		# Check for edit spacing. This lets us know that the account has
		# been used over N different days, rather than all in one lump.
		if( $wgFlaggedRevsAutopromote['spacing'] > 0 && $wgFlaggedRevsAutopromote['benchmarks'] > 1 ) {
			# Convert days to seconds...
			$spacing = $wgFlaggedRevsAutopromote['spacing'] * 24 * 3600;
			# Check the oldest edit
			$dbr = isset($dbr) ? $dbr : wfGetDB( DB_SLAVE );
			$lower = $dbr->selectField( 'revision', 'rev_timestamp',
				array( 'rev_user' => $user->getID() ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp ASC',
					'USE INDEX' => 'user_timestamp' ) );
			# Recursively check for an edit $spacing seconds later, until we are done.
			# The first edit counts, so we have one less scans to do...
			$benchmarks = 0;
			$needed = $wgFlaggedRevsAutopromote['benchmarks'] - 1;
			while( $lower && $benchmarks < $needed ) {
				$next = wfTimestamp( TS_UNIX, $lower ) + $spacing;
				$lower = $dbr->selectField( 'revision', 'rev_timestamp',
					array( 'rev_user' => $user->getID(),
						'rev_timestamp > ' . $dbr->addQuotes( $dbr->timestamp($next) ) ),
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp ASC',
						'USE INDEX' => 'user_timestamp' ) );
				if( $lower !== false )
					$benchmarks++;
			}
			if( $benchmarks < $needed ) {
				# Make a key to store the results
				$wgMemc->set( $key, 'true', 3600*24*$spacing*($benchmarks - $needed - 1) );
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		# Check if this user is sharing IPs with another users
		if( $wgFlaggedRevsAutopromote['uniqueIPAddress'] ) {
			$uid = $user->getId();

			$dbr = isset($dbr) ? $dbr : wfGetDB( DB_SLAVE );
			$shared = $dbr->selectField( 'recentchanges', '1',
				array( 'rc_ip' => wfGetIP(),
					"rc_user != '$uid'" ),
				__METHOD__,
				array( 'USE INDEX' => 'rc_ip' ) );
			if( $shared ) {
				# Make a key to store the results
				$wgMemc->set( $key, 'true', 3600*24*7 );
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		# Check if the user has any recent content edits
		if( $wgFlaggedRevsAutopromote['recentContentEdits'] > 0 ) {
			global $wgContentNamespaces;
		
			$dbr = isset($dbr) ? $dbr : wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'recentchanges', '1', 
				array( 'rc_user_text' => $user->getName(),
					'rc_namespace' => $wgContentNamespaces ), 
				__METHOD__, 
				array( 'USE INDEX' => 'rc_ns_usertext',
					'LIMIT' => $wgFlaggedRevsAutopromote['recentContent'] ) );
			if( $dbr->numRows($res) < $wgFlaggedRevsAutopromote['recentContent'] ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		# Check to see if the user has so many deleted edits that
		# they don't actually enough live edits. This is because
		# $user->getEditCount() is the count of edits made, not live.
		if( $wgFlaggedRevsAutopromote['excludeDeleted'] ) {
			$dbr = isset($dbr) ? $dbr : wfGetDB( DB_SLAVE );
			$minDiff = $user->getEditCount() - $wgFlaggedRevsAutopromote['days'] + 1;
			# Use an estimate if the number starts to get large
			if( $minDiff <= 100 ) {
				$res = $dbr->select( 'archive', '1', 
					array( 'ar_user_text' => $user->getName() ), 
					__METHOD__, 
					array( 'USE INDEX' => 'usertext_timestamp', 'LIMIT' => $minDiff ) );
				$deletedEdits = $dbr->numRows($res);
			} else {
				$deletedEdits = $dbr->estimateRowCount( 'archive', '1',
					array( 'ar_user_text' => $user->getName() ),
					__METHOD__,
					array( 'USE INDEX' => 'usertext_timestamp' ) );
			}
			if( $deletedEdits >= $minDiff ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		# Add editor rights
		$newGroups = $groups ;
		array_push( $newGroups, 'editor' );

		wfLoadExtensionMessages( 'FlaggedRevs' );
		# Lets NOT spam RC, set $RC to false
		$log = new LogPage( 'rights', false );
		$log->addEntry( 'rights', $user->getUserPage(), wfMsg('rights-editor-autosum'),
			array( implode(', ',$groups), implode(', ',$newGroups) ) );
		$user->addGroup('editor');

		wfProfileOut( __METHOD__ );
		return true;
	}
	
   	/**
	* Record demotion so that auto-promote will be disabled
	*/
	public static function recordDemote( $u, $addgroup, $removegroup ) {
		if( $removegroup && in_array('editor',$removegroup) ) {
			$params = FlaggedRevs::getUserParams( $u->getId() );
			$params['demoted'] = 1;
			FlaggedRevs::saveUserParams( $u->getId(), $params );
		}
		return true;
	}
	
	/**
	* Add user preference to form HTML
	*/
	public static function injectPreferences( $form, $out ) {
		$prefsHtml = FlaggedRevsXML::stabilityPreferences( $form );
		$out->addHTML( $prefsHtml );
		return true;
	}
	
	/**
	* Add user preference to form object based on submission
	*/
	public static function injectFormPreferences( $form, $request ) {
		global $wgUser;
		$form->mFlaggedRevsStable = $request->getInt( 'wpFlaggedRevsStable' );
		$form->mFlaggedRevsSUI = $request->getInt( 'wpFlaggedRevsSUI' );
		$form->mFlaggedRevsWatch = $wgUser->isAllowed( 'review' ) ? $request->getInt( 'wpFlaggedRevsWatch' ) : 0;
		return true;
	}
	
	/**
	* Set preferences on form based on user settings
	*/
	public static function resetPreferences( $form, $user ) {
		global $wgSimpleFlaggedRevsUI;
		$form->mFlaggedRevsStable = $user->getOption( 'flaggedrevsstable' );
		$form->mFlaggedRevsSUI = $user->getOption( 'flaggedrevssimpleui', intval($wgSimpleFlaggedRevsUI) );
		$form->mFlaggedRevsWatch = $user->getOption( 'flaggedrevswatch' );
		return true;
	}
	
	/**
	* Set user preferences into user object before it is applied to DB
	*/
	public static function savePreferences( $form, $user, &$msg ) {
		$user->setOption( 'flaggedrevsstable', $form->validateInt( $form->mFlaggedRevsStable, 0, 1 ) );
		$user->setOption( 'flaggedrevssimpleui', $form->validateInt( $form->mFlaggedRevsSUI, 0, 1 ) );
		$user->setOption( 'flaggedrevswatch', $form->validateInt( $form->mFlaggedRevsWatch, 0, 1 ) );
		return true;
	}
	
	/**
	* Create revision link for log line entry
	* @param string $type
	* @param string $action
	* @param object $title
	* @param array $paramArray
	* @param string $c
	* @param string $r user tool links
	* @param string $t timestamp of the log entry
	* @return bool true
	*/
	public static function reviewLogLine( $type='', $action='', $title=null, $paramArray=array(), &$c='', &$r='' ) {
		$actionsValid = array('approve','approve2','approve-a','approve2-a','unapprove','unapprove2');
		# Show link to page with oldid=x
		if( $type == 'review' && in_array($action,$actionsValid) && is_object($title) && isset($paramArray[0]) ) {
			global $wgUser;
			# Load required messages
			wfLoadExtensionMessages( 'FlaggedRevs' );
			# Don't show diff if param missing or rev IDs are the same
			if( !empty($paramArray[1]) && $paramArray[0] != $paramArray[1] ) {
				$r = '(' . $wgUser->getSkin()->makeKnownLinkObj( $title, wfMsgHtml('review-logentry-diff'), 
					"oldid={$paramArray[1]}&diff={$paramArray[0]}") . ') ';
			} else {
				$r = '(' . wfMsgHtml('review-logentry-diff') . ')';
			}
			$r .= ' (' . $wgUser->getSkin()->makeKnownLinkObj( $title, 
				wfMsgHtml('review-logentry-id',$paramArray[0]), "oldid={$paramArray[0]}&diff=prev") . ')';
		}
		return true;
	}

	public static function imagePageFindFile( &$imagePage, &$normalFile, &$displayFile ) {
		$fa = FlaggedArticle::getInstance( $imagePage );
		$fa->imagePageFindFile( $normalFile, $displayFile );
		return true;
	}

	public static function setActionTabs( $skin, &$contentActions ) {
		$fa = FlaggedArticle::getGlobalInstance();
		if( $fa ) {
			$fa->setActionTabs( $skin, $contentActions );
		}
		return true;
	}

	public static function onArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		$flaggedArticle = FlaggedArticle::getInstance( $article );
		$flaggedArticle->maybeUpdateMainCache( $outputDone, $pcache );
		$flaggedArticle->addStableLink( $outputDone, $pcache );
		$flaggedArticle->setPageContent( $outputDone, $pcache );
		return true;
	}
	
	public static function addRatingLink( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
		$fa = FlaggedArticle::getTitleInstance( $skintemplate->mTitle );
		# Add rating tab
		if( $fa->isRateable() ) {
			wfLoadExtensionMessages( 'RatingHistory' );
			$nav_urls['ratinghist'] = array( 
				'text' => wfMsg( 'ratinghistory-link' ),
				'href' => $skintemplate->makeSpecialUrl( 'RatingHistory', 
					"target=" . wfUrlencode( "{$skintemplate->thispage}" ) )
			);
		}
		return true;
	}
	
	public static function ratingToolboxLink( &$skin ) {
		if( isset( $skin->data['nav_urls']['ratinghist'] ) ) {
			?><li id="t-rating"><?php
				?><a href="<?php echo htmlspecialchars( $skin->data['nav_urls']['ratinghist']['href'] ) ?>"><?php
					echo $skin->msg( 'ratinghistory-link' );
				?></a><?php
			?></li><?php
		}
		return true;
	}
	
	public static function overrideRedirect( &$title, $request, &$ignoreRedirect, &$target, &$article ) {
		# Get an instance on the title ($wgTitle)
		if( !FlaggedRevs::isPageReviewable($title) ) {
			return true;
		}
		if( $request->getVal( 'stableid' ) ) {
			$ignoreRedirect = true;
		} else {
			global $wgMemc, $wgParserCacheExpireTime;
			# Try the cache...
			$key = wfMemcKey( 'flaggedrevs', 'overrideRedirect', $title->getArticleId() );
			$data = $wgMemc->get($key);
			if( is_object($data) && $data->time > $article->getTouched() ) {
				list($ignoreRedirect,$target) = $data->value;
				return true;
			}
			$fa = FlaggedArticle::getTitleInstance( $title );
			if( $srev = $fa->getStableRev() ) {
				# If synced, nothing special here...
				if( $srev->getRevId() != $article->getLatest() && $fa->pageOverride() ) {
					$text = $srev->getRevText();
					$redirect = $fa->followRedirectText( $text );
					if( $redirect ) {
						$target = $redirect;
					} else {
						$ignoreRedirect = true;
					}
				}
				$data = FlaggedRevs::makeMemcObj( array($ignoreRedirect,$target) );
				$wgMemc->set( $key, $data, $wgParserCacheExpireTime );
			}
		}
		return true;
	}
	
	public static function addToEditView( &$editPage ) {
		return FlaggedArticle::getInstance( $editPage->mArticle )->addToEditView( $editPage );
	}
	
	public static function onCategoryPageView( &$category ) {
		return FlaggedArticle::getInstance( $category )->addToCategoryView();
	}
	
	public static function onSkinAfterContent( &$data ) {
		global $wgOut;
		if( $wgOut->isArticleRelated() && $fa = FlaggedArticle::getGlobalInstance() ) {
			$fa->addReviewNotes( $data );
			$fa->addReviewForm( $data );
			$fa->addFeedbackForm( $data );
			$fa->addVisibilityLink( $data );
		}
		return true;
	}
	
	public static function addToHistQuery( $pager, &$queryInfo ) {
		$flaggedArticle = FlaggedArticle::getTitleInstance( $pager->mPageHistory->getTitle() );
		if( $flaggedArticle->isReviewable() ) {
			$queryInfo['tables'][] = 'flaggedrevs';
			$queryInfo['fields'][] = 'fr_quality';
			$queryInfo['fields'][] = 'fr_user';
			$queryInfo['join_conds']['flaggedrevs'] = array( 'LEFT JOIN', "fr_page_id = rev_page AND fr_rev_id = rev_id" );
		}
		return true;
	}
	
	public static function addToFileHistQuery( $file, &$tables, &$fields, &$conds, &$opts, &$join_conds ) {
		if( $file->isLocal() ) {
			$tables[] = 'flaggedrevs';
			$fields[] = 'MAX(fr_quality) AS fr_quality';
			# Avoid duplicate rows due to multiple revs with the same sha-1 key
			$opts['GROUP BY'] = 'oi_name,oi_timestamp';
			$join_conds['flaggedrevs'] = array( 'LEFT JOIN', 'oi_sha1 = fr_img_sha1 AND oi_timestamp = fr_img_timestamp' );
		}
		return true;
	}
	
	public static function addToContribsQuery( $pager, &$queryInfo ) {
		$queryInfo['tables'][] = 'flaggedpages';
		$queryInfo['fields'][] = 'fp_stable';
		$queryInfo['join_conds']['flaggedpages'] = array( 'LEFT JOIN', "fp_page_id = rev_page" );
		return true;
	}
	
	public static function addToRCQuery( &$conds, &$tables, &$join_conds, $opts ) {
		$tables[] = 'flaggedpages';
		$join_conds['flaggedpages'] = array( 'LEFT JOIN', 'fp_page_id = rc_cur_id' );
		return true;
	}
	
	public static function addToWatchlistQuery( &$conds, &$tables, &$join_conds, &$fields ) {
		$tables[] = 'flaggedpages';
		$fields[] = 'fp_stable';
		$join_conds['flaggedpages'] = array( 'LEFT JOIN', 'fp_page_id = rc_cur_id' );
		return true;
	}
	
	public static function addToHistLine( &$history, $row, &$s ) {
		return FlaggedArticle::getInstance( $history->getArticle() )->addToHistLine( $history, $row, $s );
	}
	
	public static function addToFileHistLine( $hist, $file, &$s, &$rowClass ) {
		return FlaggedArticle::getInstance( $hist->getImagePage() )->addToFileHistLine( $hist, $file, $s, $rowClass );
	}
	
	public static function addToContribsLine( $contribs, &$ret, $row ) {
		global $wgFlaggedRevsNamespaces;
		if( !in_array($row->page_namespace,$wgFlaggedRevsNamespaces) ) {
			// do nothing
		} else if( isset($row->fp_stable) && $row->rev_id > $row->fp_stable ) {
			$ret = '<span class="flaggedrevs-unreviewed">'.$ret.'</span>';
		} else if( !isset($row->fp_stable) ) {
			$ret = '<span class="flaggedrevs-unreviewed2">'.$ret.'</span>';
		}
		return true;
	}
	
	public static function addTochangeListLine( &$list, &$articlelink, &$s, &$rc, $unpatrolled, $watched ) {
		global $wgUser;
		if( $rc->getTitle()->getNamespace() < 0 || !isset($rc->mAttribs['fp_stable']) )
			return true; // reviewed pages only
		if( $unpatrolled && $wgUser->isAllowed('review') ) {
			wfLoadExtensionMessages( 'FlaggedRevs' );
			$rlink = $list->skin->makeKnownLinkObj( $rc->getTitle(), wfMsg('revreview-reviewlink'),
				'oldid='.intval($rc->mAttribs['fp_stable']).'&diff=cur' );
			$articlelink .= " <span class='mw-fr-reviewlink'>($rlink)</span>";
		}
		return true;
	}
	
	public static function injectReviewDiffURLParams( &$article, &$sectionAnchor, &$extraQuery ) {
		return FlaggedArticle::getInstance( $article )->injectReviewDiffURLParams( $sectionAnchor, $extraQuery );
	}

	public static function onDiffViewHeader( $diff, $oldRev, $newRev ) {
		self::injectStyleAndJS();
		$flaggedArticle = FlaggedArticle::getTitleInstance( $diff->getTitle() );
		$flaggedArticle->addDiffLink( $diff, $oldRev, $newRev );
		$flaggedArticle->addDiffNoticeAndIncludes( $diff, $oldRev, $newRev );
		return true;
	}

	public static function addRevisionIDField( $editPage, $out ) {
		return FlaggedArticle::getInstance( $editPage->mArticle )->addRevisionIDField( $editPage, $out );
	}
	
	public static function addReviewCheck( $editPage, &$checkboxes, &$tabindex ) {
		global $wgUser, $wgRequest;
		if( !$wgUser->isAllowed('review') ) {
			return true;
		}
		$fa = FlaggedArticle::getTitleInstance( $editPage->getArticle() );
		if( $fa->isReviewable() ) {
			$srev = $fa->getStableRev();
			# For pages with either no stable version, or an outdated one, let
			# the user decide if he/she wants it reviewed on the spot. One might
			# do this if he/she just saw the diff-to-stable and *then* decided to edit.
			if( !$srev || $srev->getRevId() != $editPage->getArticle()->getLatest() ) {
				wfLoadExtensionMessages( 'FlaggedRevs' );
				$checkboxes['reviewed'] = '';
				$reviewLabel = wfMsgExt('revreview-flag', array('parseinline'));
				$attribs = array( 'tabindex' => ++$tabindex, 'id' => 'wpReviewEdit' );
				$checkboxes['reviewed'] = Xml::check( 'wpReviewEdit', 
					$wgRequest->getCheck('wpReviewEdit'), $attribs ) . 
					'&nbsp;' . Xml::label( $reviewLabel, 'wpReviewEdit' );
			}
		}
		return true;
	}
	
	public static function addBacklogNotice( &$notice ) {
		global $wgUser, $wgTitle, $wgFlaggedRevsBacklog;
		if( empty($wgTitle) ) {
			return true; // nothing to do here
		}
		$watchlist = SpecialPage::getTitleFor( 'Watchlist' );
		$recentchanges = SpecialPage::getTitleFor( 'Recentchanges' );
		if( $wgUser->isAllowed('review') && ($wgTitle->equals($watchlist) || $wgTitle->equals($recentchanges)) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$unreviewed = $dbr->estimateRowCount( 'flaggedpages', '*', array('fp_reviewed' => 0), __METHOD__ );
			if( $unreviewed >= $wgFlaggedRevsBacklog ) {
				wfLoadExtensionMessages( 'FlaggedRevs' );
				$notice .= "<div id='mw-oldreviewed-notice' class='plainlinks fr-backlognotice'>" . 
					wfMsgExt('flaggedrevs-backlog',array('parseinline')) . "</div>";
			}
		}
		return true;
	}

	public static function onParserTestTables( &$tables ) {
		$tables[] = 'flaggedpages';
		$tables[] = 'flaggedrevs';
		$tables[] = 'flaggedpage_config';
		$tables[] = 'flaggedtemplates';
		$tables[] = 'flaggedimages';
		$tables[] = 'flaggedrevs_promote';
		$tables[] = 'reader_feedback';
		$tables[] = 'reader_feedback_history';
		$tables[] = 'reader_feedback_pages';
		$tables[] = 'flaggedrevs_tracking';
		return true;
	}
}
