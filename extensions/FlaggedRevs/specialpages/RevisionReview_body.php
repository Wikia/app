<?php
# (c) Aaron Schulz, Joerg Baach, 2007 GPL

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class RevisionReview extends UnlistedSpecialPage
{
	// Initialize vars in case of broken AJAX input
	var $patrolonly = false;
	var $page = null;
	var $rcid = 0;
	var $approve = false;
	var $unapprove = false;
	var $oldid = 0;
	var $templateParams = '';
	var $imageParams = '';
	var $fileVersion = '';
	var $validatedParams = '';
	var $notes = '';
	var $comment = '';
	var $dims = array();
	var $unapprovedTags = 0;
	
    public function __construct() {
		global $wgUser;
		parent::__construct( 'RevisionReview', 'review' );
		$this->skin = $wgUser->getSkin();
    }

    public function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$confirm = $wgRequest->wasPosted()
			&& $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
		if ( $wgUser->isAllowed( 'review' ) ) {
			if ( $wgUser->isBlocked( !$confirm ) ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'review' );
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		$this->setHeaders();
		# Our target page
		$this->page = Title::newFromURL( $wgRequest->getVal( 'target' ) );
		if ( is_null( $this->page ) ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}
		# Param for sites with binary flagging
		$this->approve = $wgRequest->getCheck( 'wpApprove' );
		$this->unapprove = $wgRequest->getCheck( 'wpUnapprove' );
		# Patrol the edit if requested...
		$this->markReviewed();
	}
	
	// implicit dims for binary flag case
	public function implicitDims() {
		$tag = FlaggedRevs::binaryTagName();
		if ( $tag ) {
			if ( $this->approve ) {
				return array( $tag => 1 );
			} else if ( $this->unapprove ) {
				return array( $tag => 0 );
			}
		}
		return null;
	}
	
	// non-JS submission code...
	private function markReviewed() {
		global $wgRequest, $wgOut, $wgUser;
		# Must be in reviewable namespace
		if ( !FlaggedRevs::inReviewNamespace( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt( 'revreview-main', array( 'parse' ) ) );
			return;
		}
		# Get revision ID
		$this->oldid = $wgRequest->getIntOrNull( 'oldid' );
		if ( !$this->oldid ) {
			$wgOut->showErrorPage( 'internalerror', 'revreview-revnotfound' );
			return;
		}
		# Check if page is protected
		if ( !$this->page->quickUserCan( 'edit' ) ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# Special parameter mapping
		$this->templateParams = $wgRequest->getVal( 'templateParams' );
		$this->imageParams = $wgRequest->getVal( 'imageParams' );
		$this->fileVersion = $wgRequest->getVal( 'fileVersion' );
		$this->validatedParams = $wgRequest->getVal( 'validatedParams' );
		# Special token to discourage fiddling...
		$k = self::validationKey( $this->templateParams, $this->imageParams,
			$this->fileVersion, $this->oldid );
		if ( $this->validatedParams !== $k ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# Log comment
		$this->comment = $wgRequest->getText( 'wpReason' );
		# Additional notes (displayed at bottom of page)
		$this->retrieveNotes( $wgRequest->getText( 'wpNotes' ) );
		# Get the revision's current flags, if any
		$this->oflags = FlaggedRevs::getRevisionTags( $this->page, $this->oldid );
		# Get our accuracy/quality dimensions
		$this->dims = array();
		$this->unapprovedTags = 0;
		# Fill in implicit tag data for binary flag case
		if ( $iDims = $this->implicitDims() ) {
			$this->dims = $iDims;
		} else {
			foreach ( FlaggedRevs::getDimensions() as $tag => $levels ) {
				$this->dims[$tag] = $wgRequest->getIntOrNull( "wp$tag" );
				if ( $this->dims[$tag] === 0 ) {
					$this->unapprovedTags++;
				} elseif ( is_null( $this->dims[$tag] ) ) {
					# This happens if we uncheck a checkbox
					$this->unapprovedTags++;
					$this->dims[$tag] = 0;
				}
			}
		}
		$fa = FlaggedArticle::getTitleInstance( $this->page );
		$this->config = $fa->getVisibilitySettings();
		# Check permissions and validate
		if ( !self::userCanSetFlags( $this->dims, $this->oflags, $this->config ) ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# We must at least rate each category as 1, the minimum
		# Exception: we can rate ALL as unapproved to depreciate a revision
		if ( $this->unapprovedTags && $this->unapprovedTags < count( FlaggedRevs::getDimensions() ) ) {
			$wgOut->addWikiText( wfMsg( 'revreview-toolow' ) );
			$wgOut->returnToMain( false, $this->page );
			return;
		} elseif ( !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$wgOut->addWikiText( wfMsg( 'sessionfailure' ) );
			$wgOut->returnToMain( false, $this->page );
			return;
		}
		# Submit or display info on failure
		if ( $wgRequest->wasPosted() ) {
			list( $approved, $status ) = $this->submit();
			// Success for either flagging or unflagging
			if ( $status === true ) {
				$wgOut->setPageTitle( wfMsgHtml( 'actioncomplete' ) );
				$wgOut->addHTML( $this->showSuccess( $approved, true ) );
			// Sync failure for flagging
			} elseif ( is_array( $status ) && $approved ) {
				$wgOut->setPageTitle( wfMsgHtml( 'internalerror' ) );
				$wgOut->addHTML( $this->showSyncFailure( $status, true ) );
			// Failure for unflagging
			} elseif ( $status === false && !$approved ) {
				$wgOut->redirect( $this->page->getFullUrl() );
			// Any other fail...
			} else {
				$wgOut->setPageTitle( wfMsgHtml( 'internalerror' ) );
				$wgOut->showErrorPage( 'internalerror', 'revreview-revnotfound' );
				$wgOut->returnToMain( false, $this->page );
			}
		}
	}
	
	private function retrieveNotes( $notes = '' ) {
		global $wgUser;
		$this->notes = ( FlaggedRevs::allowComments() && $wgUser->isAllowed( 'validate' ) ) ?
			$notes : '';
	}
	
	public static function AjaxReview( /*$args...*/ ) {
		global $wgUser;
		$args = func_get_args();
		if ( wfReadOnly() ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		$tags = FlaggedRevs::getDimensions();
		// Make review interface object
		$form = new RevisionReview();
		$editToken = ''; // edit token
		// Each ajax url argument is of the form param|val.
		// This means that there is no ugly order dependance.
		foreach ( $args as $x => $arg ) {
			$set = explode( '|', $arg, 2 );
			if ( count( $set ) != 2 ) {
				return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
			}
			list( $par, $val ) = $set;
			switch( $par )
			{
				case "target":
					$form->page = Title::newFromURL( $val );
					if ( is_null( $form->page ) || !FlaggedRevs::inReviewNamespace( $form->page ) ) {
						return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
					}
					break;
				case "oldid":
					$form->oldid = intval( $val );
					if ( !$form->oldid ) {
						return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
					}
					break;
				case "rcid":
					$form->rcid = intval( $val );
					break;
				case "validatedParams":
					$form->validatedParams = $val;
					break;
				case "templateParams":
					$form->templateParams = $val;
					break;
				case "imageParams":
					$form->imageParams = $val;
					break;
				case "fileVersion":
					$form->fileVersion = $val;
					break;
				case "wpApprove":
					$form->approve = $val;
					break;
				case "wpUnapprove":
					$form->unapprove = $val;
					break;
				case "wpReason":
					$form->comment = $val;
					break;
				case "wpNotes":
					$form->retrieveNotes( $val );
					break;
				case "wpEditToken":
					$editToken = $val;
					break;
				default:
					$p = preg_replace( '/^wp/', '', $par ); // kill any "wp" prefix
					if ( array_key_exists( $p, $tags ) ) {
						$form->dims[$p] = intval( $val );
						if ( $form->dims[$p] === 0 ) {
							$form->unapprovedTags++;
						}
					}
					break;
			}
		}
		// No page?
		if ( !$form->page ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		# Check session via user token
		if ( !$wgUser->matchEditToken( $editToken ) ) {
			return '<err#>' . wfMsgExt( 'sessionfailure', 'parseinline' );
		}
		// Basic permission check
		$permErrors = $form->page->getUserPermissionsErrors( 'review', $wgUser );
		if ( !$permErrors ) {
			// User must be able to edit this page
			$permErrors = $form->page->getUserPermissionsErrors( 'edit', $wgUser );
		}
		if ( $permErrors ) {
			global $wgOut;
			return '<err#>' . $wgOut->parse(
				$wgOut->formatPermissionsErrorMessage( $permErrors, 'review' )
			);
		}
		# Fill in implicit tag data for binary flag case
		if ( $iDims = $form->implicitDims() ) {
			$form->dims = $iDims;
		}
		// Missing params?
		if ( count( $form->dims ) != count( $tags ) ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		// Incomplete review?
		if ( !$form->oldid || is_null( $form->page ) ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		if ( $form->unapprovedTags && $form->unapprovedTags < count( FlaggedRevs::getDimensions() ) ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		// Doesn't match up?
		$k = self::validationKey( $form->templateParams, $form->imageParams,
			$form->fileVersion, $form->oldid );
		if ( $form->validatedParams !== $k ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		$fa = FlaggedArticle::getTitleInstance( $form->page );
		$form->config = $fa->getVisibilitySettings();
		# Get the revision's current flags, if any
		$form->oflags = FlaggedRevs::getRevisionTags( $form->page, $form->oldid );
		# Check tag permissions
		if ( !self::userCanSetFlags( $form->dims, $form->oflags, $form->config ) ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
		list( $approved, $status ) = $form->submit();
		if ( $status === true ) {
			$tier = FlaggedRevs::getLevelTier( $form->dims ) + 1; // shift to 0-3
			return "<suc#><t#$tier>" . $form->showSuccess( $approved );
		} elseif ( $approved && is_array( $status ) ) {
			return '<err#>' . $form->showSyncFailure( $status );
		} elseif ( $approved ) {
			return '<err#>' . wfMsg( 'revreview-revnotfound' );
		} else { // hmmm?
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' );
		}
	}

	public function isApproval() {
		# If all values are set to zero, this has been unapproved
		if ( FlaggedRevs::dimensionsEmpty() ) {
			if ( $this->approve && !$this->unapprove )
				return true; // no tags & approve param given
			if ( $this->unapprove && !$this->approve )
				return false;
			else
				return null; // nothing valid asserted
		}
		foreach ( $this->dims as $quality => $value ) {
			if ( $value ) return true;
		}
		return false;
	}

	public function submit() {
		global $wgUser;
		# If all values are set to zero, this has been unapproved
		$approved = $this->isApproval();
		if ( $approved === null ) {
			return array( true, false ); // user didn't say
		}
		# Double-check permissions
		if ( !$this->page->quickUserCan( 'edit' )
			|| !self::userCanSetFlags( $this->dims, $this->oflags, $this->config ) )
		{
			return array( $approved, false );
		}
		# We can only approve actual revisions...
		if ( $approved ) {
			$rev = Revision::newFromTitle( $this->page, $this->oldid );
			# Do not mess with archived/deleted revisions
			if ( is_null( $rev ) || $rev->mDeleted ) {
				return array( $approved, false );
			}
			$status = $this->approveRevision( $rev );
		# We can only unapprove approved revisions...
		} else {
			$frev = FlaggedRevision::newFromTitle( $this->page, $this->oldid );
			# If we can't find this flagged rev, return to page???
			if ( is_null( $frev ) ) {
				return array( $approved, true );
			}
			$status = $this->unapproveRevision( $frev );
		}
		# Watch page if set to do so
		if ( $status === true ) {
			if ( $wgUser->getOption( 'flaggedrevswatch' ) && !$this->page->userIsWatching() ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->begin();
				$wgUser->addWatch( $this->page );
				$dbw->commit();
			}
		}
		return array( $approved, $status );
	}
	
	private function showSuccess( $approved, $showlinks = false ) {
		global $wgUser;
		# Show success message
		$msg = $approved ? 'revreview-successful' : 'revreview-successful2';
		$form = "<div class='plainlinks'>" . wfMsgExt( $msg, array( 'parseinline' ),
			$this->page->getPrefixedText(), $this->page->getPrefixedUrl() );
		$msg = $approved ? 'revreview-stable1' : 'revreview-stable2';
		$form .= wfMsgExt( $msg, array( 'parse' ), $this->page->getPrefixedUrl(), $this->oldid );
		$form .= "</div>";
		# Handy links to special pages
		if ( $showlinks && $wgUser->isAllowed( 'unreviewedpages' ) ) {
			$form .= '<p>' . wfMsg( 'returnto',
				$this->skin->makeLinkObj( SpecialPage::getTitleFor( 'UnreviewedPages' ) ) ) . '</p>';
			$form .= '<p>' . wfMsg( 'returnto',
				$this->skin->makeLinkObj( SpecialPage::getTitleFor( 'OldReviewedPages' ) ) ) . '</p>';
		}
		return $form;
	}
	
	private function showSyncFailure( $status, $showlinks = false ) {
		$form = wfMsgExt( 'revreview-changed', array( 'parse' ), $this->page->getPrefixedText() );
		$form .= "<ul>";
		foreach ( $status as $n => $text ) {
			$form .= "<li><i>$text</i></li>\n";
		}
		$form .= "</ul>";
		if ( $showlinks ) {
			$form .= wfMsg( 'returnto', $this->skin->makeLinkObj( $this->page ) );
		}
		return $form;
	}

	/**
	 * Adds or updates the flagged revision table for this page/id set
	 * @param Revision $rev
	 * @returns true on success, array of errors on failure
	 */
	private function approveRevision( $rev ) {
		global $wgUser, $wgMemc, $wgParser, $wgEnableParserCache;
		wfProfileIn( __METHOD__ );
		
		$article = new Article( $this->page );

		$quality = 0;
		if ( FlaggedRevs::isQuality( $this->dims ) ) {
			$quality = FlaggedRevs::isPristine( $this->dims ) ? 2 : 1;
		}
		# Our flags
		$flags = $this->dims;
		# Some validation vars to make sure nothing changed during
		$lastTempId = 0;
		$lastImgTime = "0";
		# Our template version pointers
		$tmpset = $tmpParams = array();
		$templateMap = explode( '#', trim( $this->templateParams ) );
		foreach ( $templateMap as $template ) {
			if ( !$template )
				continue;

			$m = explode( '|', $template, 2 );
			if ( !isset( $m[0] ) || !isset( $m[1] ) || !$m[0] )
				continue;

			list( $prefixed_text, $rev_id ) = $m;

			$tmp_title = Title::newFromText( $prefixed_text ); // Normalize this to be sure...
			if ( is_null( $tmp_title ) )
				continue; // Page must be valid!

			if ( $rev_id > $lastTempId )
				$lastTempId = $rev_id;

			$tmpset[] = array(
				'ft_rev_id' 	=> $rev->getId(),
				'ft_namespace'  => $tmp_title->getNamespace(),
				'ft_title' 		=> $tmp_title->getDBkey(),
				'ft_tmp_rev_id' => $rev_id
			);
			if ( !isset( $tmpParams[$tmp_title->getNamespace()] ) ) {
				$tmpParams[$tmp_title->getNamespace()] = array();
			}
			$tmpParams[$tmp_title->getNamespace()][$tmp_title->getDBkey()] = $rev_id;
		}
		# Our image version pointers
		$imgset = $imgParams = array();
		$imageMap = explode( '#', trim( $this->imageParams ) );
		foreach ( $imageMap as $image ) {
			if ( !$image )
				continue;
			$m = explode( '|', $image, 3 );
			# Expand our parameters ... <name>#<timestamp>#<key>
			if ( !isset( $m[0] ) || !isset( $m[1] ) || !isset( $m[2] ) || !$m[0] )
				continue;

			list( $dbkey, $timestamp, $key ) = $m;

			$img_title = Title::makeTitle( NS_IMAGE, $dbkey ); // Normalize
			if ( is_null( $img_title ) )
				continue; // Page must be valid!

			if ( $timestamp > $lastImgTime )
				$lastImgTime = $timestamp;

			$imgset[] = array(
				'fi_rev_id' 		=> $rev->getId(),
				'fi_name' 			=> $img_title->getDBkey(),
				'fi_img_timestamp'  => $timestamp,
				'fi_img_sha1' 		=> $key
			);
			if ( !isset( $imgParams[$img_title->getDBkey()] ) ) {
				$imgParams[$img_title->getDBkey()] = array();
			}
			$imgParams[$img_title->getDBkey()][$timestamp] = $key;
		}
		# If this is an image page, store corresponding file info
		$fileData = array();
		if ( $this->page->getNamespace() == NS_IMAGE && $this->fileVersion ) {
			$data = explode( '#', $this->fileVersion, 2 );
			if ( count( $data ) == 2 ) {
				$fileData['name'] = $this->page->getDBkey();
				$fileData['timestamp'] = $data[0];
				$fileData['sha1'] = $data[1];
			}
		}
		
		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $this->page, FR_MASTER );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;
		
		# Is this rev already flagged?
		$flaggedOutput = false;
		$oldfrev = FlaggedRevision::newFromTitle( $this->page, $rev->getId(),
			FR_TEXT | FR_MASTER );
		if ( $oldfrev ) {
			$flaggedOutput = FlaggedRevs::parseStableText( $article,
				$oldfrev->getRevText(), $oldfrev->getRevId() );
		}
		
		# Be loose on templates that includes other files/templates dynamically.
		# Strict checking breaks randomized images/metatemplates...(bug 14580)
		global $wgUseCurrentTemplates, $wgUseCurrentImages;
		$mustMatch = !( $wgUseCurrentTemplates && $wgUseCurrentImages );
		
		# Set our versioning params cache
		FlaggedRevs::setIncludeVersionCache( $rev->getId(), $tmpParams, $imgParams );
		# Parse the text and check if all templates/files match up
		$text = $rev->getText();
		$stableOutput = FlaggedRevs::parseStableText( $article, $text, $rev->getId() );
		$err =& $stableOutput->fr_includeErrors;
		if ( $mustMatch ) { // if template/files must all be specified...
			if ( !empty( $err )
				|| $stableOutput->fr_newestImageTime > $lastImgTime
				|| $stableOutput->fr_newestTemplateID > $lastTempId )
			{
				wfProfileOut( __METHOD__ );
				return $err; // return templates/files with no version specified
			}
        }
		# Clear our versioning params cache
		FlaggedRevs::clearIncludeVersionCache( $rev->getId() );
		
		# Is this a duplicate review?
		if ( $oldfrev && $flaggedOutput ) {
			$synced = true;
			if ( $stableOutput->fr_newestImageTime != $flaggedOutput->fr_newestImageTime )
				$synced = false;
			elseif ( $stableOutput->fr_newestTemplateID != $flaggedOutput->fr_newestTemplateID )
				$synced = false;
			elseif ( $oldfrev->getTags() != $flags )
				$synced = false;
			elseif ( $oldfrev->getFileSha1() != @$fileData['sha1'] )
				$synced = false;
			elseif ( $oldfrev->getComment() != $this->notes )
				$synced = false;
			elseif ( $oldfrev->getQuality() != $quality )
				$synced = false;
			# Don't review if the same
			if ( $synced ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}

		$dbw = wfGetDB( DB_MASTER );
		# Our review entry
 		$flaggedRevision = new FlaggedRevision( array(
			'fr_rev_id'        => $rev->getId(),
			'fr_page_id'       => $rev->getPage(),
			'fr_user'          => $wgUser->getId(),
			'fr_timestamp'     => wfTimestampNow(),
			'fr_comment'       => $this->notes,
			'fr_quality'       => $quality,
			'fr_tags'          => FlaggedRevision::flattenRevisionTags( $flags ),
			'fr_img_name'      => $fileData ? $fileData['name'] : null,
			'fr_img_timestamp' => $fileData ? $fileData['timestamp'] : null,
			'fr_img_sha1'      => $fileData ? $fileData['sha1'] : null
		) );

		$dbw->begin();
		$flaggedRevision->insertOn( $tmpset, $imgset );
		# Avoid any lag issues
		$this->page->resetArticleId( $rev->getPage() );
		# Update recent changes
		self::updateRecentChanges( $this->page, $rev->getId(), $this->rcid, true );
		# Update the article review log
		FlaggedRevsLogs::updateLog( $this->page, $this->dims, $this->oflags,
			$this->comment, $this->oldid, $oldSvId, true );

		# Update the links tables as the stable version may now be the default page.
		# Try using the parser cache first since we didn't actually edit the current version.
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if ( !$poutput
			|| !isset( $poutput->fr_newestTemplateID )
			|| !isset( $poutput->fr_newestImageTime ) )
		{
			$options = FlaggedRevs::makeParserOptions();
			$poutput = $wgParser->parse( $article->getContent(), $article->mTitle, $options );
		}
		# Prepare for a link tracking update
		$u = new LinksUpdate( $this->page, $poutput );
		# If we know that this is now the new stable version 
		# (which it probably is), save it to the stable cache...
		$sv = FlaggedRevision::newFromStable( $this->page, FR_MASTER/*consistent*/ );
		if ( $sv && $sv->getRevId() == $rev->getId() ) {
			global $wgParserCacheExpireTime;
			$this->page->invalidateCache();
			# Update stable cache with the revision we reviewed.
			# Don't cache redirects; it would go unused and complicate things.
			if ( !Title::newFromRedirect( $text ) ) {
				FlaggedRevs::updatePageCache( $article, $wgUser, $stableOutput );
			}
			# We can set the sync cache key already
			$includesSynced = true;
			if ( $poutput->fr_newestImageTime > $stableOutput->fr_newestImageTime ) {
				$includesSynced = false;
			} elseif ( $poutput->fr_newestTemplateID > $stableOutput->fr_newestTemplateID ) {
				$includesSynced = false;
			}
			$u->fr_stableRev = $sv; // no need to re-fetch this!
			$u->fr_stableParserOut = $stableOutput; // no need to re-fetch this!
			# We can set the sync cache key already.
			$key = wfMemcKey( 'flaggedrevs', 'includesSynced', $article->getId() );
			$data = FlaggedRevs::makeMemcObj( $includesSynced ? "true" : "false" );
			$wgMemc->set( $key, $data, $wgParserCacheExpireTime );
		} else {
			# Get the old stable cache
			$stableOutput = FlaggedRevs::getPageCache( $article, $wgUser );
			# Clear the cache...(for page histories)
			$this->page->invalidateCache();
			if ( $stableOutput !== false ) {
				# Reset stable cache if it existed, since we know it is the same.
				FlaggedRevs::updatePageCache( $article, $wgUser, $stableOutput );
			}
		}
		# Update link tracking. This will trigger extraLinksUpdate()...
		$u->doUpdate();

		$dbw->commit();
		# Purge cache/squids for this page and any page that uses it
		Article::onArticleEdit( $this->page );

		wfProfileOut( __METHOD__ );
        return true;
    }

	/**
	 * @param FlaggedRevision $frev
	 * Removes flagged revision data for this page/id set
	 */
	private function unapproveRevision( $frev ) {
		global $wgUser, $wgParser, $wgMemc;
		wfProfileIn( __METHOD__ );
		
        $dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		# Delete from flaggedrevs table
		$dbw->delete( 'flaggedrevs',
			array( 'fr_page_id' => $frev->getPage(), 'fr_rev_id' => $frev->getRevId() ) );
		# Wipe versioning params
		$dbw->delete( 'flaggedtemplates', array( 'ft_rev_id' => $frev->getRevId() ) );
		$dbw->delete( 'flaggedimages', array( 'fi_rev_id' => $frev->getRevId() ) );
		# Update recent changes
		self::updateRecentChanges( $this->page, $frev->getRevId(), false, false );

		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $this->page, FR_MASTER );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;

		# Update the article review log
		FlaggedRevsLogs::updateLog( $this->page, $this->dims, $this->oflags,
			$this->comment, $this->oldid, $oldSvId, false );

		$article = new Article( $this->page );
		# Update the links tables as a new stable version
		# may now be the default page.
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if ( $poutput == false ) {
			$text = $article->getContent();
			$options = FlaggedRevs::makeParserOptions();
			$poutput = $wgParser->parse( $text, $article->mTitle, $options );
		}
		$u = new LinksUpdate( $this->page, $poutput );
		$u->doUpdate();

		# Clear the cache...
		$this->page->invalidateCache();
		# Purge cache/squids for this page and any page that uses it
		$dbw->commit();
		Article::onArticleEdit( $article->getTitle() );

		wfProfileOut( __METHOD__ );
        return true;
    }
	
	/**
	* Get a validation key from versioning metadata
	* @param string $tmpP
	* @param string $imgP
	* @param string $imgV
	* @param integer $rid rev ID
	* @return string
	*/
	public static function validationKey( $tmpP, $imgP, $imgV, $rid ) {
		global $wgReviewCodes;
		# Fall back to $wgSecretKey/$wgProxyKey
		if ( empty( $wgReviewCodes ) ) {
			global $wgSecretKey, $wgProxyKey;
			$key = $wgSecretKey ? $wgSecretKey : $wgProxyKey;
			$p = md5( $key . $imgP . $tmpP . $rid . $imgV );
		} else {
			$p = md5( $wgReviewCodes[0] . $imgP . $rid . $tmpP . $imgV . $wgReviewCodes[1] );
		}
		return $p;
	}

	/**
	 * Returns true if a user can set $tag to $value.
	 * @param string $tag
	 * @param int $value
	 * @param array $config (optional page config)
	 * @returns bool
	 */
	public static function userCan( $tag, $value, $config = null ) {
		global $wgUser;
		$restrictions = FlaggedRevs::getTagRestrictions();
		# Levels may not apply for some pages.
		# Skip this check if $config is not given.
		if ( !is_null( $config ) && !self::levelAvailable( $tag, $value, $config ) ) {
			return false;
		}
		# No restrictions -> full access
		if ( !isset( $restrictions[$tag] ) )
			return true;
		# Validators always have full access
		if ( $wgUser->isAllowed( 'validate' ) )
			return true;
		# Check if this user has any right that lets him/her set
		# up to this particular value
		foreach ( $restrictions[$tag] as $right => $level ) {
			if ( $value <= $level && $level > 0 && $wgUser->isAllowed( $right ) ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Returns true if a user can set $flags.
	 * This checks if the user has the right to review
	 * to the given levels for each tag.
	 * @param array $flags, suggested flags
	 * @param array $oldflags, pre-existing flags
	 * @param array $config, visibility settings
	 * @returns bool
	 */
	public static function userCanSetFlags( $flags, $oldflags = array(), $config = null ) {
		global $wgUser;
		if ( !$wgUser->isAllowed( 'review' ) )
			return false; // User is not able to review pages
		# Check if all of the required site flags have a valid value
		# that the user is allowed to set.
		foreach ( FlaggedRevs::getDimensions() as $qal => $levels ) {
			$level = isset( $flags[$qal] ) ? $flags[$qal] : 0;
			$highest = count( $levels ) - 1; // highest valid level
			if ( !self::userCan( $qal, $level, $config ) ) {
				return false; // user cannot set proposed flag
			} elseif ( isset( $oldflags[$qal] ) && !self::userCan( $qal, $oldflags[$qal] ) ) {
				return false; // user cannot change old flag ($config is ignored here)
			} elseif ( $level < 0 || $level > $highest ) {
				return false; // flag range is invalid
			}
		}
		return true;
	}
	
	// Check if a given level for a tag is available in $config
	public static function levelAvailable( $tag, $val, $config ) {
		global $wgFlagAvailability;
		if ( $val == 0 )
			return true; // unreviewed is always applicable
		if ( !array_key_exists( 'select', $config ) )
			return true; // missing config
		if ( isset( $wgFlagAvailability[$tag] ) && isset( $wgFlagAvailability[$tag][$val] ) ) {
			$precedence = $wgFlagAvailability[$tag][$val];
			return ( $config['select'] === $precedence );
		}
		return true;
	}
	
	public static function updateRecentChanges( $title, $revId, $rcId = false, $patrol = true ) {
		wfProfileIn( __METHOD__ );
		$revId = intval( $revId );
		$dbw = wfGetDB( DB_MASTER );
		# Olders edits be marked as patrolled now...
		$dbw->update( 'recentchanges',
			array( 'rc_patrolled' => $patrol ? 1 : 0 ),
			array( 'rc_cur_id' => $title->getArticleId(),
				$patrol ? "rc_this_oldid <= $revId" : "rc_this_oldid = $revId" ),
			__METHOD__,
			// Performance
			array( 'USE INDEX' => 'rc_cur_id', 'LIMIT' => 50 )
		);
		# New page patrol may be enabled. If so, the rc_id may be the first
		# edit and not this one. If it is different, mark it too.
		if ( $rcId && $rcId != $revId ) {
			$dbw->update( 'recentchanges',
				array( 'rc_patrolled' => 1 ),
				array( 'rc_id' => $rcId,
					'rc_type' => RC_NEW ),
				__METHOD__
			);
		}
		wfProfileOut( __METHOD__ );
	}
}
