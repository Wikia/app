<?php
#(c) Aaron Schulz, Joerg Baach, 2007 GPL

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}
wfLoadExtensionMessages( 'FlaggedRevs' );

class RevisionReview extends UnlistedSpecialPage
{
	// Initialize vars in case of broken AJAX input
	var $patrolonly = false;
	var $page = null;
	var $rcid = 0;
	var $approve = false;
	var $oldid = 0;
	var $templateParams = '';
	var $imageParams = '';
	var $fileVersion = '';
	var $validatedParams = '';
	var $notes = '';
	
    function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'RevisionReview', 'review' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$confirm = $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
		if( $wgUser->isAllowed( 'review' ) ) {
			if( $wgUser->isBlocked( !$confirm ) ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'review' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		$this->setHeaders();
		# Our target page
		$this->page = Title::newFromUrl( $wgRequest->getVal( 'target' ) );
		if( is_null($this->page) ) {
			$wgOut->showErrorPage('notargettitle', 'notargettext' );
			return;
		}
		# Basic patrolling
		$this->patrolonly = $wgRequest->getBool( 'patrolonly' );
		$this->rcid = $wgRequest->getIntOrNull( 'rcid' );
		# Param for sites with no tags, otherwise discarded
		$this->approve = $wgRequest->getBool( 'wpApprove' );
		# Patrol the edit if requested...
		if( $this->patrolonly && $this->rcid ) {
			$this->markPatrolled();
		# Otherwise, do a regular review...
		} else {
			$this->markReviewed();
		}
	}
	
	private function markPatrolled() {
		global $wgRequest, $wgOut, $wgUser;
		
		$token = $wgRequest->getVal('token');
		$wgOut->setPageTitle( wfMsg( 'revreview-patrol-title' ) );
		# Prevent hijacking
		if( !$wgUser->matchEditToken( $token, $this->page->getPrefixedText(), $this->rcid ) ) {
			$wgOut->addWikiText( wfMsg('sessionfailure') );
			return;
		}
		# Make sure page is not reviewable. This can be spoofed in theory,
		# but the token is salted with the id and title and this should
		# be a trusted user...so it is not worth doing extra query work. 	 
		if( FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->showErrorPage('notargettitle', 'notargettext' ); 	 
			return;
		}
		# Mark as patrolled
		$changed = RecentChange::markPatrolled( $this->rcid );
		if( $changed ) {
			PatrolLog::record( $this->rcid );
		}
		# Inform the user
		$wgOut->addWikiText( wfMsg( 'revreview-patrolled', $this->page->getPrefixedText() ) );
		$wgOut->returnToMain( false, SpecialPage::getTitleFor( 'Recentchanges' ) );
	}
	
	private function markReviewed() {
		global $wgRequest, $wgOut, $wgUser;
		# Must be in reviewable namespace
		if( !FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('revreview-main',array('parse')) );
			return;
		}
		$this->oldid = $wgRequest->getIntOrNull( 'oldid' );
		if( !$this->oldid ) {
			$wgOut->showErrorPage( 'internalerror', 'revnotfoundtext' );
			return;
		}
		# Check if page is protected
		if( !$this->page->quickUserCan( 'edit' ) ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# Special parameter mapping
		$this->templateParams = $wgRequest->getVal( 'templateParams' );
		$this->imageParams = $wgRequest->getVal( 'imageParams' );
		$this->fileVersion = $wgRequest->getVal( 'fileVersion' );
		$this->validatedParams = $wgRequest->getVal( 'validatedParams' );	
		# Special token to discourage fiddling...
		$k = self::validationKey( $this->templateParams, $this->imageParams, $this->fileVersion, $this->oldid );
		if( $this->validatedParams !== $k ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# Log comment
		$this->comment = $wgRequest->getText( 'wpReason' );
		# Additional notes (displayed at bottom of page)
		$this->retrieveNotes( $wgRequest->getText('wpNotes') );
		# Get the revision's current flags, if any
		$this->oflags = FlaggedRevs::getRevisionTags( $this->page, $this->oldid );
		# Get our accuracy/quality dimensions
		$this->dims = array();
		$this->unapprovedTags = 0;
		foreach( FlaggedRevs::getDimensions() as $tag => $levels ) {
			$this->dims[$tag] = $wgRequest->getIntOrNull( "wp$tag" );
			if( $this->dims[$tag] === 0 ) {
				$this->unapprovedTags++;
			} else if( is_null($this->dims[$tag]) ) {
				# This happens if we uncheck a checkbox
				$this->unapprovedTags++;
				$this->dims[$tag] = 0;
			}
		}
		# Check permissions and validate
		if( !$this->userCanSetFlags( $this->dims, $this->oflags ) ) {
			$wgOut->permissionRequired( 'badaccess-group0' );
			return;
		}
		# We must at least rate each category as 1, the minimum
		# Exception: we can rate ALL as unapproved to depreciate a revision
		$valid = true;
		if( $this->unapprovedTags && $this->unapprovedTags < count( FlaggedRevs::getDimensions() ) ) {
			$valid = false;
		} else if( !$wgUser->matchEditToken( $wgRequest->getVal('wpEditToken') ) ) {
			$valid = false;
		}
		# Submit or display info on failure
		if( $valid && $wgRequest->wasPosted() ) {
			list($approved,$status) = $this->submit();
			// Success for either flagging or unflagging
			if( $status === true ) {
				$wgOut->setPageTitle( wfMsgHtml('actioncomplete') );
				$wgOut->addHTML( $this->showSuccess( $approved, true ) );
			// Sync failure for flagging
			} else if( is_array($status) && $approved ) {
				$wgOut->setPageTitle( wfMsgHtml('internalerror') );
				$wgOut->addHTML( $this->showSyncFailure( $status, true ) );
			// Failure for unflagging
			} else if( $status === false && !$approved ) {
				$wgOut->redirect( $this->page->getFullUrl() );
			// Any other fail...
			} else {
				$wgOut->setPageTitle( wfMsgHtml('internalerror') );
				$wgOut->showErrorPage( 'internalerror', 'revnotfoundtext' );
				$wgOut->returnToMain( false, $this->page );
			}
		# Show revision and form
		} else {
			$this->showRevision();
		}
	}
	
	private function retrieveNotes( $notes = '' ) {
		global $wgUser;
		$this->notes = ( FlaggedRevs::allowComments() && $wgUser->isAllowed('validate') ) ? $notes : '';
	}
	
	public static function AjaxReview( /*$args...*/ ) {
		global $wgUser;
		$args = func_get_args();
		// Basic permission check
		if( $wgUser->isAllowed( 'review' ) ) {
			if( $wgUser->isBlocked() ) {
				return '<err#>';
			}
		} else {
			return '<err#>';
		}
		if( wfReadOnly() ) {
			return '<err#>';
		}
		$tags = FlaggedRevs::getDimensions();
		// Make review interface object
		$form = new RevisionReview();
		$form->dims = array();
		$form->unapprovedTags = 0;
		// Each ajax url argument is of the form param|val.
		// This means that there is no ugly order dependance.
		foreach( $args as $x => $arg ) {
			$set = explode('|',$arg,2);
			if( count($set) != 2 ) {
				return '<err#>';
			}
			list($par,$val) = $set;
			switch( $par )
			{
				case "target":
					$form->page = Title::newFromUrl( $val );
					if( is_null($form->page) || !FlaggedRevs::isPageReviewable( $form->page ) ) {
						return '<err#>';
					}
					break;
				case "oldid":
					$form->oldid = intval( $val );
					if( !$form->oldid ) {
						return '<err#>';
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
				case "wpReason":
					$form->comment = $val;
					break;
				case "wpNotes":
					$form->retrieveNotes( $val );
					break;
				case "wpEditToken":
					if( !$wgUser->matchEditToken( $val ) ) {
						return '<err#>';
					}
					break;
				default:
					$p = preg_replace( '/^wp/', '', $par ); // kill any "wp" prefix
					if( array_key_exists( $p, $tags ) ) {
						$form->dims[$p] = intval($val);
						if( $form->dims[$p] === 0 ) {
							$form->unapprovedTags++;
						}
					}
					break;
			}
		}
		// Missing params?
		if( count($form->dims) != count($tags) ) {
			return '<err#>';
		}
		// Incomplete review?
		if( !$form->oldid ) {
			return '<err#>';
		}
		if( $form->unapprovedTags && $form->unapprovedTags < count( FlaggedRevs::getDimensions() ) ) {
			return '<err#>';
		} 
		// Doesn't match up?
		$k = self::validationKey( $form->templateParams, $form->imageParams, $form->fileVersion, $form->oldid );
		if( $form->validatedParams !== $k ) {
			return '<err#>';
		}
		# Get the revision's current flags, if any
		$form->oflags = FlaggedRevs::getRevisionTags( $form->page, $form->oldid );
		# Check permissions
		if( !$form->page->quickUserCan('edit') || !$form->userCanSetFlags($form->dims,$form->oflags) ) {
			return '<err#>';
		}
		list($approved,$status) = $form->submit();
		if( $status === true ) {
			return '<suc#>'.$form->showSuccess( $approved );
		} else if( $approved && is_array($status) ) {
			return '<err#>'.$form->showSyncFailure( $status );
		} else { // hmmm?
			return '<err#>';
		}
	}

	/**
	 * Show revision review form
	 */
	private function showRevision() {
		global $wgOut, $wgUser, $wgTitle, $wgFlaggedRevComments, $wgFlaggedRevTags, $wgFlaggedRevValues;

		if( $this->unapprovedTags )
			$wgOut->addWikiText( '<strong>' . wfMsg( 'revreview-toolow' ) . '</strong>' );

		$wgOut->addWikiText( wfMsg( 'revreview-selected', $this->page->getPrefixedText() ) );

		$this->skin = $wgUser->getSkin();
		$rev = Revision::newFromTitle( $this->page, $this->oldid );
		# Check if rev exists
		# Do not mess with deleted revisions
		if( !isset( $rev ) || $rev->mDeleted ) {
			$wgOut->showErrorPage( 'internalerror', 'notargettitle', 'notargettext' );
			return;
		}

		$wgOut->addHtml( "<ul>" );
		$wgOut->addHtml( $this->historyLine( $rev ) );
		$wgOut->addHtml( "</ul>" );

		if( FlaggedRevs::showStableByDefault() )
			$wgOut->addWikiText( wfMsg('revreview-text') );
			
		$action = $wgTitle->escapeLocalUrl( 'action=submit' );
		$form = "<form name='RevisionReview' action='$action' method='post'>";
		$form .= '<fieldset><legend>' . wfMsgHtml( 'revreview-legend' ) . '</legend><table><tr>';

		$formradios = array();
		# Dynamically contruct our radio options
		foreach( $wgFlaggedRevTags as $tag => $minQL ) {
			$formradios[$tag] = array();
			for ($i=0; $i <= $wgFlaggedRevValues; $i++) {
				$formradios[$tag][] = array( "revreview-$tag-$i", "wp$tag", $i );
			}
			$form .= '<td><strong>' . wfMsgHtml( "revreview-$tag" ) . '</strong></td><td width=\'20\'></td>';
		}
		$hidden = array(
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ),
			Xml::hidden( 'target', $this->page->getPrefixedText() ),
			Xml::hidden( 'oldid', $this->oldid ) 
		);

		$form .= '</tr><tr>';
		foreach( $formradios as $set => $ratioset ) {
			$form .= '<td>';
			foreach( $ratioset as $item ) {
				list( $message, $name, $field ) = $item;
				# Don't give options the user can't set unless its the status quo
				$attribs = array('id' => $name.$field);
				if( !$this->userCan($set,$field) )
					$attribs['disabled'] = 'true';
				$form .= "<div>";
				$form .= Xml::radio( $name, $field, ($field==$this->dims[$set]), $attribs );
				$form .= Xml::label( wfMsg($message), $name.$field );
				$form .= "</div>\n";
			}
			$form .= '</td><td width=\'20\'></td>';
		}
		$form .= '</tr></table></fieldset>';
		# Add box to add live notes to a flagged revision
		if( $wgFlaggedRevComments && $wgUser->isAllowed( 'validate' ) ) {
			$form .= "<fieldset><legend>" . wfMsgHtml( 'revreview-notes' ) . "</legend>" .
			"<textarea tabindex='1' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%'>" .
			htmlspecialchars( $this->notes ) .
			"</textarea></fieldset>";
		}

		$form .= '<fieldset><legend>' . wfMsgHtml('revisionreview') . '</legend>';
		$form .= '<p>'.Xml::inputLabel( wfMsg( 'revreview-log' ), 'wpReason', 'wpReason', 60 ).'</p>';
		$form .= '<p>'.Xml::submitButton( wfMsg( 'revreview-submit' ) ).'</p>';
		foreach( $hidden as $item ) {
			$form .= $item;
		}
		# Hack, versioning params
		$form .= Xml::hidden( 'templateParams', $this->templateParams ) . "\n";
		$form .= Xml::hidden( 'imageParams', $this->imageParams ) . "\n";
		$form .= Xml::hidden( 'fileVersion', $this->fileVersion ) . "\n";
		$form .= Xml::hidden( 'wpApprove', $this->approve ) . "\n";
		$form .= Xml::hidden( 'rcid', $this->rcid ) . "\n";
		# Special token to discourage fiddling...
		$checkCode = self::validationKey( $this->templateParams, $this->imageParams, $this->fileVersion, $rev->getId() );
		$form .= Xml::hidden( 'validatedParams', $checkCode );
		$form .= '</fieldset>';

		$form .= '</form>';
		$wgOut->addHtml( $form );
	}

	/**
	 * @param Revision $rev
	 * @return string
	 */
	private function historyLine( $rev ) {
		global $wgContLang;
		$date = $wgContLang->timeanddate( $rev->getTimestamp() );
		$difflink = '(' . $this->skin->makeKnownLinkObj( $this->page, wfMsgHtml('diff'),
			'&diff=' . $rev->getId() . '&oldid=prev' ) . ')';
		$revlink = $this->skin->makeLinkObj( $this->page, $date, 'oldid=' . $rev->getId() );
		return "<li> $difflink $revlink " . $this->skin->revUserLink($rev) . " " . $this->skin->revComment($rev) . "</li>";
	}

	private function submit() {
		global $wgUser;
		# If all values are set to zero, this has been unapproved
		$approved = !count( FlaggedRevs::getDimensions() ) && $this->approve;
		foreach( $this->dims as $quality => $value ) {
			if( $value ) {
				$approved = true;
				break;
			}
		}
		# Double-check permissions
		if( !$this->page->quickUserCan('edit') || !$this->userCanSetFlags($this->dims,$this->oflags) ) {
			return array($approved,false);
		}
		# We can only approve actual revisions...
		if( $approved ) {
			$rev = Revision::newFromTitle( $this->page, $this->oldid );
			# Do not mess with archived/deleted revisions
			if( is_null($rev) || $rev->mDeleted ) {
				return array($approved,false);
			}
			$status = $this->approveRevision( $rev );
		# We can only unapprove approved revisions...
		} else {
			$frev = FlaggedRevision::newFromTitle( $this->page, $this->oldid );
			# If we can't find this flagged rev, return to page???
			if( is_null($frev) ) {
				return array($approved,false);
			}
			$status = $this->unapproveRevision( $frev );
		}
		# Watch page if set to do so
		if( $status === true ) {
			if( $wgUser->getOption('flaggedrevswatch') && !$this->page->userIsWatching() ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->begin();
				$wgUser->addWatch( $this->page );
				$dbw->commit();
			}
		}
		return array($approved,$status);
	}
	
	private function showSuccess( $approved, $showlinks=false ) {
		global $wgUser;
		# Show success message
		$msg = $approved ? 'revreview-successful' : 'revreview-successful2';
		$form = "<div class='plainlinks'>" .wfMsgExt( $msg, array('parseinline'), 
			$this->page->getPrefixedText(), $this->page->getPrefixedUrl() );
		$msg = $approved ? 'revreview-stable1' : 'revreview-stable2';
		$form .= wfMsgExt( $msg, array('parse'), $this->page->getPrefixedUrl(), $this->oldid );
		$form .= "</div>";
		# Handy links to special pages
		$sk = $wgUser->getSkin();
		if( $showlinks && $wgUser->isAllowed( 'unreviewedpages' ) ) {
			$form .= '<p>'.wfMsg( 'returnto', $sk->makeLinkObj( SpecialPage::getTitleFor( 'UnreviewedPages' ) ) ).'</p>';
			$form .= '<p>'.wfMsg( 'returnto', $sk->makeLinkObj( SpecialPage::getTitleFor( 'OldReviewedPages' ) ) ).'</p>';
		}
		return $form;
	}
	
	private function showSyncFailure( $status, $showlinks=false ) {
		global $wgOut;
		$form = wfMsgExt( 'revreview-changed', array('parse'), $this->page->getPrefixedText() );
		$form .= "<ul>";
		foreach( $status as $n => $text ) {
			$form .= "<li><i>$text</i></li>\n";
		}
		$form .= "</ul>";
		if( $showlinks ) {
			$form .= wfMsg( 'returnto', $sk->makeLinkObj( $this->page ) );
		}
		return $form;
	}

	/**
	 * Adds or updates the flagged revision table for this page/id set
	 * @param Revision $rev
	 * @returns true on success, array of errors on failure
	 */
	private function approveRevision( $rev ) {
		global $wgUser, $wgParser, $wgRevisionCacheExpiry, $wgEnableParserCache, $wgMemc;

		wfProfileIn( __METHOD__ );
		
		$article = new Article( $this->page );

		$quality = 0;
		if( FlaggedRevs::isQuality($this->dims) ) {
			$quality = FlaggedRevs::isPristine($this->dims) ? 2 : 1;
		}
		# Our flags
		$flags = $this->dims;

		# Some validation vars to make sure nothing changed during
		$lastTempID = 0;
		$lastImgTime = "0";

		# Our template version pointers
		$tmpset = $tmpParams = array();
		$templateMap = explode('#',trim($this->templateParams) );
		foreach( $templateMap as $template ) {
			if( !$template )
				continue;

			$m = explode('|',$template,2);
			if( !isset($m[0]) || !isset($m[1]) || !$m[0] )
				continue;

			list($prefixed_text,$rev_id) = $m;

			$tmp_title = Title::newFromText( $prefixed_text ); // Normalize this to be sure...
			if( is_null($tmp_title) )
				continue; // Page must be valid!

			if( $rev_id > $lastTempID )
				$lastTempID = $rev_id;

			$tmpset[] = array(
				'ft_rev_id' => $rev->getId(),
				'ft_namespace' => $tmp_title->getNamespace(),
				'ft_title' => $tmp_title->getDBkey(),
				'ft_tmp_rev_id' => $rev_id
			);
			if( !isset($tmpParams[$tmp_title->getNamespace()]) ) {
				$tmpParams[$tmp_title->getNamespace()] = array();
			}
			$tmpParams[$tmp_title->getNamespace()][$tmp_title->getDBkey()] = $rev_id;
		}
		# Our image version pointers
		$imgset = $imgParams = array();
		$imageMap = explode('#',trim($this->imageParams) );
		foreach( $imageMap as $image ) {
			if( !$image )
				continue;
			$m = explode('|',$image,3);
			# Expand our parameters ... <name>#<timestamp>#<key>
			if( !isset($m[0]) || !isset($m[1]) || !isset($m[2]) || !$m[0] )
				continue;

			list($dbkey,$timestamp,$key) = $m;

			$img_title = Title::makeTitle( NS_IMAGE, $dbkey ); // Normalize
			if( is_null($img_title) )
				continue; // Page must be valid!

			if( $timestamp > $lastImgTime )
				$lastImgTime = $timestamp;

			$imgset[] = array(
				'fi_rev_id' => $rev->getId(),
				'fi_name' => $img_title->getDBkey(),
				'fi_img_timestamp' => $timestamp,
				'fi_img_sha1' => $key
			);
			if( !isset($imgParams[$img_title->getDBkey()]) ) {
				$imgParams[$img_title->getDBkey()] = array();
			}
			$imgParams[$img_title->getDBkey()][$timestamp] = $key;
		}
		
		# If this is an image page, store corresponding file info
		$fileData = array();
		if( $this->page->getNamespace() == NS_IMAGE && $this->fileVersion ) {
			$data = explode('#',$this->fileVersion,2);
			if( count($data) == 2 ) {
				$fileData['name'] = $this->page->getDBkey();
				$fileData['timestamp'] = $data[0];
				$fileData['sha1'] = $data[1];
			}
		}
		
		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $this->page, FR_FOR_UPDATE );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;
		
		# Is this rev already flagged?
		$flaggedOutput = false;
		if( $oldfrev = FlaggedRevision::newFromTitle( $this->page, $rev->getId(), FR_TEXT | FR_FOR_UPDATE ) ) {
			$flaggedOutput = FlaggedRevs::parseStableText( $article, $oldfrev->getTextForParse(), $oldfrev->getRevId() );
		}
		
		# Be looser on includes for templates, since they don't matter much
		# and strict checking breaks randomized images/metatemplates...(bug 14580)
		global $wgUseCurrentTemplates, $wgUseCurrentImages;
		$noMatch = ($rev->getTitle()->getNamespace() == NS_TEMPLATE && $wgUseCurrentTemplates && $wgUseCurrentImages);
		
		# Set our versioning params cache
		FlaggedRevs::setIncludeVersionCache( $rev->getId(), $tmpParams, $imgParams );
        # Get the expanded text and resolve all templates.
		# Store $templateIDs and add it to final parser output later...
        list($fulltext,$tmps,$tmpIDs,$err,$maxID) = FlaggedRevs::expandText( $rev->getText(), $rev->getTitle(), $rev->getId() );
        if( !$noMatch && (!empty($err) || $maxID > $lastTempID) ) {
			wfProfileOut( __METHOD__ );
        	return $err;
        }
		# Parse the rest and check if it matches up
		$stableOutput = FlaggedRevs::parseStableText( $article, $fulltext, $rev->getId(), false );
		$err =& $stableOutput->fr_includeErrors;
		if( !$noMatch && (!empty($err) || $stableOutput->fr_newestImageTime > $lastImgTime) ) {
			wfProfileOut( __METHOD__ );
        	return $err;
        }
		# Merge in template params from first phase of parsing...
		$this->mergeTemplateParams( $stableOutput, $tmps, $tmpIDs, $maxID );
		# Clear our versioning params cache
		FlaggedRevs::clearIncludeVersionCache( $rev->getId() );
		
		# Is this a duplicate review?
		if( $oldfrev && $flaggedOutput ) {
			$synced = true;
			if( $stableOutput->fr_newestImageTime != $flaggedOutput->fr_newestImageTime )
				$synced = false;
			if( $stableOutput->fr_newestTemplateID != $flaggedOutput->fr_newestTemplateID )
				$synced = false;
			if( $oldfrev->getTags() != $flags )
				$synced = false;
			if( $oldfrev->getFileSha1() != @$fileData['sha1'] )
				$synced = false;
			if( $oldfrev->getComment() != $this->notes )
				$synced = false;
			# Don't review if the same
			if( $synced ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		} 
		
        # Compress $fulltext, passed by reference
        $textFlags = FlaggedRevision::compressText( $fulltext );

		# Write to external storage if required
		$storage = FlaggedRevs::getExternalStorage();
		if( $storage ) {
			if( is_array($storage) ) {
				# Distribute storage across multiple clusters
				$store = $storage[mt_rand(0, count( $storage ) - 1)];
			} else {
				$store = $storage;
			}
			# Store and get the URL
			$fulltext = ExternalStore::insert( $store, $fulltext );
			if( !$fulltext ) {
				# This should only happen in the case of a configuration error, where the external store is not valid
				wfProfileOut( __METHOD__ );
				throw new MWException( "Unable to store text to external storage $store" );
			}
			if( $textFlags ) {
				$textFlags .= ',';
			}
			$textFlags .= 'external';
		}

		$dbw = wfGetDB( DB_MASTER );
		# Our review entry
 		$revset = array(
 			'fr_rev_id'        => $rev->getId(),
 			'fr_page_id'       => $this->page->getArticleID(),
			'fr_user'          => $wgUser->getId(),
			'fr_timestamp'     => $dbw->timestamp( wfTimestampNow() ),
			'fr_comment'       => $this->notes,
			'fr_quality'       => $quality,
			'fr_tags'          => FlaggedRevision::flattenRevisionTags( $flags ),
			'fr_text'          => $fulltext, # Store expanded text for speed
			'fr_flags'         => $textFlags,
			'fr_img_name'      => $fileData ? $fileData['name'] : null,
			'fr_img_timestamp' => $fileData ? $fileData['timestamp'] : null,
			'fr_img_sha1'      => $fileData ? $fileData['sha1'] : null
		);
		
		# Start!
		$dbw->begin();
		# Update flagged revisions table
		$dbw->replace( 'flaggedrevs', array( array('fr_page_id','fr_rev_id') ), $revset, __METHOD__ );
		# Clear out any previous garbage.
		# We want to be able to use this for tracking...
		$dbw->delete( 'flaggedtemplates',
			array('ft_rev_id' => $rev->getId() ),
			__METHOD__ );
		$dbw->delete( 'flaggedimages',
			array('fi_rev_id' => $rev->getId() ),
			__METHOD__ );
		# Update our versioning params
		if( !empty($tmpset) ) {
			$dbw->insert( 'flaggedtemplates', $tmpset, __METHOD__, 'IGNORE' );
		}
		if( !empty($imgset) ) {
			$dbw->insert( 'flaggedimages', $imgset, __METHOD__, 'IGNORE' );
		}
		
		# Kill any text cache
		if( $wgRevisionCacheExpiry ) {
			$key = wfMemcKey( 'flaggedrevisiontext', 'revid', $rev->getId() );
			$wgMemc->delete( $key );
		}
		
		# Update recent changes
		self::updateRecentChanges( $this->page, $rev->getId(), $this->rcid );

		# Update the article review log
		self::updateLog( $this->page, $this->dims, $this->oflags, $this->comment, $this->oldid, $oldSvId, true );

		# Update the links tables as the stable version may now be the default page.
		# Try using the parser cache first since we didn't actually edit the current version.
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if( $poutput == false ) {
			$text = $article->getContent();
			$options = FlaggedRevs::makeParserOptions();
			$poutput = $wgParser->parse( $text, $article->mTitle, $options );
		}
		# If we know that this is now the new stable version 
		# (which it probably is), save it to the stable cache...
		$sv = FlaggedRevision::newFromStable( $this->page, FR_FOR_UPDATE );
		if( $sv && $sv->getRevId() == $rev->getId() ) {
			# Clear the cache...
			$this->page->invalidateCache();
			# Update stable cache with the revision we reviewed
			FlaggedRevs::updatePageCache( $article, $stableOutput );
		} else {
			# Get the old stable cache
			$stableOutput = FlaggedRevs::getPageCache( $article );
			# Clear the cache...(for page histories)
			$this->page->invalidateCache();
			if( $stableOutput !== false ) {
				# Reset stable cache if it existed, since we know it is the same.
				FlaggedRevs::updatePageCache( $article, $stableOutput );
			}
		}
		$u = new LinksUpdate( $this->page, $poutput );
		$u->doUpdate(); // Will trigger our hook to add stable links too...
		# Might as well save the cache, since it should be the same
		if( $wgEnableParserCache )
			$parserCache->save( $poutput, $article, $wgUser );
		# Purge cache/squids for this page and any page that uses it
		Article::onArticleEdit( $article->getTitle() );

		$dbw->commit();

		wfProfileOut( __METHOD__ );
        return true;
    }

	/**
	 * @param FlaggedRevision $frev
	 * Removes flagged revision data for this page/id set
	 */
	private function unapproveRevision( $frev ) {
		global $wgUser, $wgParser, $wgRevisionCacheExpiry, $wgMemc;
		wfProfileIn( __METHOD__ );
		
        $dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		# Delete from flaggedrevs table
		$dbw->delete( 'flaggedrevs', 
			array( 'fr_page_id' => $frev->getPage(), 'fr_rev_id' => $frev->getRevId() ) );
		# Wipe versioning params
		$dbw->delete( 'flaggedtemplates', array( 'ft_rev_id' => $frev->getRevId() ) );
		$dbw->delete( 'flaggedimages', array( 'fi_rev_id' => $frev->getRevId() ) );

		# Get current stable version ID (for logging)
		$oldSv = FlaggedRevision::newFromStable( $this->page, FR_FOR_UPDATE );
		$oldSvId = $oldSv ? $oldSv->getRevId() : 0;

		# Update the article review log
		self::updateLog( $this->page, $this->dims, $this->oflags, $this->comment, $this->oldid, $oldSvId, false );

		# Kill any text cache
		if( $wgRevisionCacheExpiry ) {
			$key = wfMemcKey( 'flaggedrevisiontext', 'revid', $frev->getRevId() );
			$wgMemc->delete( $key );
		}

		$article = new Article( $this->page );
		# Update the links tables as a new stable version
		# may now be the default page.
		$parserCache = ParserCache::singleton();
		$poutput = $parserCache->get( $article, $wgUser );
		if( $poutput == false ) {
			$text = $article->getContent();
			$options = FlaggedRevs::makeParserOptions();
			$poutput = $wgParser->parse( $text, $article->mTitle, $options );
		}
		$u = new LinksUpdate( $this->page, $poutput );
		$u->doUpdate();

		# Clear the cache...
		$this->page->invalidateCache();
		# Might as well save the cache
		global $wgEnableParserCache;
		if( $wgEnableParserCache )
			$parserCache->save( $poutput, $article, $wgUser );
		# Purge cache/squids for this page and any page that uses it
		Article::onArticleEdit( $article->getTitle() );

		$dbw->commit();

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
		if( empty($wgReviewCodes) ) {
			global $wgSecretKey, $wgProxyKey;
			$key = $wgSecretKey ? $wgSecretKey : $wgProxyKey;
			$p = md5($key.$imgP.$tmpP.$rid.$imgV);
		} else {
			$p = md5($wgReviewCodes[0].$imgP.$rid.$tmpP.$imgV.$wgReviewCodes[1]);
		}
		return $p;
	}

	/**
	 * Returns true if a user can do something
	 * @param string $tag
	 * @param int $value
	 * @returns bool
	 */
	public static function userCan( $tag, $value ) {
		global $wgFlagRestrictions, $wgUser;

		if( !isset($wgFlagRestrictions[$tag]) )
			return true;
		# Validators always have full access
		if( $wgUser->isAllowed('validate') )
			return true;
		# Check if this user has any right that lets him/her set
		# up to this particular value
		foreach( $wgFlagRestrictions[$tag] as $right => $level ) {
			if( $value <= $level && $level > 0 && $wgUser->isAllowed($right) ) {
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
	 * @returns bool
	 */
	public static function userCanSetFlags( $flags, $oldflags = array() ) {
		global $wgUser, $wgFlaggedRevTags, $wgFlaggedRevValues;
		
		if( !$wgUser->isAllowed('review') ) {
			return false;
		}
		# Check if all of the required site flags have a valid value
		# that the user is allowed to set.
		foreach( $wgFlaggedRevTags as $qal => $minQL ) {
			$level = isset($flags[$qal]) ? $flags[$qal] : 0;
			if( !self::userCan($qal,$level) ) {
				return false;
			} else if( isset($oldflags[$qal]) && !self::userCan($qal,$oldflags[$qal]) ) {
				return false;
			} else if( $level < 0 || $level > $wgFlaggedRevValues ) {
				return false;
			}
		}
		return true;
	}
	
	public static function updateRecentChanges( $title, $revId, $rcId = false ) {
		wfProfileIn( __METHOD__ );
		$dbw = wfGetDB( DB_MASTER );
		# Olders edits be marked as patrolled now...
		$dbw->update( 'recentchanges',
			array( 'rc_patrolled' => 1 ),
			array( 'rc_namespace' => $title->getNamespace(),
				'rc_title' => $title->getDBKey(),
				'rc_this_oldid <= ' . intval($revId) ),
			__METHOD__,
			array( 'USE INDEX' => 'rc_namespace_title', 'LIMIT' => 50 )
		);
		# New page patrol may be enabled. If so, the rc_id may be the first
		# edit and not this one. If it is different, mark it too.
		if( $rcId && $rcId != $revId ) {
			$dbw->update( 'recentchanges',
				array( 'rc_patrolled' => 1 ),
				array( 'rc_id' => $rcid,
					'rc_type' => RC_NEW ),
				__METHOD__
			);
		}
		wfProfileOut( __METHOD__ );
	}
	
	private function mergeTemplateParams( $pout, $tmps, $tmpIds, $maxID ) {
		foreach( $tmps as $ns => $dbkey_id ) {
			foreach( $dbkey_id as $dbkey => $pageid ) {
				if( !isset($pout->mTemplates[$ns]) )
					$pout->mTemplates[$ns] = array();
				# Add in this template; overrides
				$pout->mTemplates[$ns][$dbkey] = $pageid;
			}
		}
		# Merge in template params from first phase of parsing...
		foreach( $tmpIds as $ns => $dbkey_id ) {
			foreach( $dbkey_id as $dbkey => $revid ) {
				if( !isset($pout->mTemplateIds[$ns]) )
					$pout->mTemplateIds[$ns] = array();
				# Add in this template; overrides
				$pout->mTemplateIds[$ns][$dbkey] = $revid;
			}
		}
		if( $maxID > $pout->fr_newestTemplateID ) {
			$pout->fr_newestTemplateID = $maxID;
		}
	}

	/**
	 * Record a log entry on the action
	 * @param Title $title
	 * @param array $dims
	 * @param array $oldDims
	 * @param string $comment
	 * @param int $revId, revision ID
	 * @param int $stableId, prior stable revision ID
	 * @param bool $approve, approved? (otherwise unapproved)
	 * @param bool $auto
	 */
	public static function updateLog( $title, $dims, $oldDims, $comment, $revId, $stableId, $approve, $auto=false ) {
		global $wgFlaggedRevsLogInRC;
		$log = new LogPage( 'review', ($auto ? false : $wgFlaggedRevsLogInRC) );
		# ID, accuracy, depth, style
		$ratings = array();
		foreach( $dims as $quality => $level ) {
			$ratings[] = wfMsgForContent( "revreview-$quality" ) . ": " . 
				wfMsgForContent("revreview-$quality-$level");
		}
		$isAuto = ($auto && !FlaggedRevs::isQuality($dims)); // Paranoid check
		if( $approve ) {
			# Append comment with ratings
			$comment = $isAuto ? wfMsgForContent('revreview-auto') : $comment; // override this
			$rating = !empty($ratings) ? '[' . implode(', ',$ratings). ']' : '';
			$comment .= $comment ? " $rating" : $rating;
			# Sort into the proper action (useful for filtering)
			$action = (FlaggedRevs::isQuality($dims) || FlaggedRevs::isQuality($oldDims)) ? 'approve2' : 'approve';
			if( !$stableId ) { // first time
				$action .= $isAuto ? "-ia" : "-i";
			} else if( $isAuto ) { // automatic
				$action .= "-a";
			}
		} else { // depreciated
			$action = FlaggedRevs::isQuality($oldDims) ? 'unapprove2' : 'unapprove';
		}
		$log->addEntry( $action, $title, $comment, array($revId,$stableId) );
	}
}
