<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}
wfLoadExtensionMessages( 'Stabilization' );
wfLoadExtensionMessages( 'FlaggedRevs' );

class Stabilization extends UnlistedSpecialPage
{
    function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'Stabilization', 'stablesettings' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;

		$confirm = $wgRequest->wasPosted() &&
			$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );

		$this->isAllowed = $wgUser->isAllowed( 'stablesettings' );
		# Let anyone view, but not submit...
		if( $wgRequest->wasPosted() ) {
			if( $wgUser->isBlocked( !$confirm ) ) {
				$wgOut->blockedPage();
				return;
			} else if( !$this->isAllowed ) {
				$wgOut->permissionRequired( 'stablesettings' );
				return;
			} else if( wfReadOnly() ) {
				$wgOut->readOnlyPage();
				return;
			}
		}

		$this->setHeaders();
		$this->skin = $wgUser->getSkin();

		$isValid = true;
		# Our target page
		$this->target = $wgRequest->getText( 'page' );
		$this->page = Title::newFromUrl( $this->target );
		# We need a page...
		if( is_null($this->page) ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		} else if( !$this->page->exists() ) {
			$wgOut->addHTML( wfMsgExt( 'stabilization-notexists', array('parseinline'), $this->page->getPrefixedText() ) );
			return;
		} else if( !FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt( 'stabilization-notcontent', array('parseinline'), $this->page->getPrefixedText() ) );
			return;
		}

		# Watch checkbox
		$this->watchThis = $wgRequest->getCheck( 'wpWatchthis' );
		# Reason
		$this->comment = $wgRequest->getVal( 'wpReason' );
		# Get visiblity settings...
		$config = FlaggedRevs::getPageVisibilitySettings( $this->page, true );
		$this->select = $config['select'];
		$this->override = $config['override'];
		$this->expiry = $config['expiry'] !== 'infinity' ? wfTimestamp( TS_RFC2822, $config['expiry'] ) : 'infinite';
		if( $wgRequest->wasPosted() ) {
			$this->select = $wgRequest->getInt( 'mwStableconfig-select' );
			$this->override = intval( $wgRequest->getBool( 'mwStableconfig-override' ) );
			$this->expiry = $wgRequest->getText( 'mwStableconfig-expiry' );
			if( strlen( $this->expiry ) == 0 ) {
				$this->expiry = 'infinite';
			}
			if( $this->select && !in_array( $this->select, array(FLAGGED_VIS_NORMAL,FLAGGED_VIS_LATEST) ) ) {
				$isValid = false;
			}
		}

		if( $isValid && $confirm ) {
			$this->submit();
		} else {
			$this->showSettings();
		}
	}

	function showSettings( $err = null ) {
		global $wgOut, $wgTitle, $wgUser;

		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		# Must be a content page
		if( !FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('stableversions-none', array('parse'), $this->page->getPrefixedText() ) );
			return;
		}

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
		}

		if( !$this->isAllowed ) {
			$form = wfMsgExt( 'stabilization-perm', array('parse'), $this->page->getPrefixedText() );
			$off = array('disabled' => 'disabled');
		} else {
			$form = wfMsgExt( 'stabilization-text', array('parse'), $this->page->getPrefixedText() );
			$off = array();
		}

		$special = SpecialPage::getTitleFor( 'Stabilization' );
		$form .= Xml::openElement( 'form', array( 'name' => 'stabilization', 'action' => $special->getLocalUrl( ), 'method' => 'post' ) );

		$form .= "<fieldset><legend>".wfMsg('stabilization-def')."</legend>";
		$form .= "<table><tr>";
		$form .= "<td>".Xml::radio( 'mwStableconfig-override', 1, (1==$this->override), array('id' => 'default-stable')+$off)."</td>";
		$form .= "<td>".Xml::label( wfMsg('stabilization-def1'), 'default-stable' )."</td>";
		$form .= "</tr><tr>";
		$form .= "<td>".Xml::radio( 'mwStableconfig-override', 0, (0==$this->override), array('id' => 'default-current')+$off)."</td>";
		$form .= "<td>".Xml::label( wfMsg('stabilization-def2'), 'default-current' )."</td>";
		$form .= "</tr></table></fieldset>";

		$form .= "<fieldset><legend>".wfMsg('stabilization-select')."</legend>";
		$form .= "<table><tr>";
		/*
		$form .= "<td>".Xml::radio( 'mwStableconfig-select', FLAGGED_VIS_PRISTINE, 
			(FLAGGED_VIS_PRISTINE==$this->select), array('id' => 'stable-select3')+$off )."</td>";
		$form .= "<td>".Xml::label( wfMsg('stabilization-select3'), 'stable-select3' )."</td>";
		$form .= "</tr><tr>";
		*/
		$form .= "<td>".Xml::radio( 'mwStableconfig-select', FLAGGED_VIS_NORMAL, 
			(FLAGGED_VIS_NORMAL==$this->select), array('id' => 'stable-select1')+$off )."</td>";
		$form .= "<td>".Xml::label( wfMsg('stabilization-select1'), 'stable-select1' )."</td>";
		$form .= "</tr><tr>";
		$form .= "<td>".Xml::radio( 'mwStableconfig-select', FLAGGED_VIS_LATEST, 
			(FLAGGED_VIS_LATEST==$this->select), array('id' => 'stable-select2')+$off )."</td>";
		$form .= "<td>".Xml::label( wfMsg('stabilization-select2'), 'stable-select2' )."</td>";
		$form .= "</tr></table></fieldset>";

		if( $this->isAllowed ) {
			$form .= "<fieldset><legend>".wfMsgHtml('stabilization-leg')."</legend>";
			$form .= '<table>';
			$form .= '<tr><td>'.Xml::label( wfMsg('stabilization-comment'), 'wpReason' ).'</td>';
			$form .= '<td>'.Xml::input( 'wpReason', 60, $this->comment, array('id' => 'wpReason') )."</td></tr>";
		} else {
			$form .= '<table>';
		}
		$form .= '<tr>';
		$form .= '<td><label for="expires">' . wfMsgExt( 'stabilization-expiry', array( 'parseinline' ) ) . '</label></td>';
		$form .= '<td>' . Xml::input( 'mwStableconfig-expiry', 60, $this->expiry, array('id' => 'expires')+$off ) . '</td>';
		$form .= '</tr>';
		$form .= '</table>';

		if( $this->isAllowed ) {
			$watchLabel = wfMsgExt('watchthis', array('parseinline'));
			$watchAttribs = array('accesskey' => wfMsg( 'accesskey-watch' ), 'id' => 'wpWatchthis');
			$watchChecked = ( $wgUser->getOption( 'watchdefault' ) || $wgTitle->userIsWatching() );

			$form .= "<p>&nbsp;&nbsp;&nbsp;".Xml::check( 'wpWatchthis', $watchChecked, $watchAttribs );
			$form .= "&nbsp;<label for='wpWatchthis'".$this->skin->tooltipAndAccesskey('watch').">{$watchLabel}</label></p>";

			$form .= Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() );
			$form .= Xml::hidden( 'page', $this->page->getPrefixedText() );
			$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );

			$form .= '<p>'.Xml::submitButton( wfMsg( 'stabilization-submit' ) ).'</p>';
			$form .= "</fieldset>";
		}

		$form .= '</form>';

		$wgOut->addHTML( $form );

		$wgOut->addHtml( Xml::element( 'h2', NULL, htmlspecialchars( LogPage::logName( 'stable' ) ) ) );
		$logViewer = new LogViewer(
			new LogReader( new FauxRequest(
				array( 'page' => $this->page->getPrefixedText(), 'type' => 'stable' ) ) ) );
		$logViewer->showList( $wgOut );
	}

	function submit() {
		global $wgOut, $wgUser, $wgParser, $wgFlaggedRevsOverride, $wgFlaggedRevsPrecedence;

		$changed = $reset = false;
		# Take this opportunity to purge out expired configurations
		FlaggedRevs::purgeExpiredConfigurations();

		if( $this->expiry == 'infinite' || $this->expiry == 'indefinite' ) {
			$expiry = Block::infinity();
		} else {
			# Convert GNU-style date, on error returns -1 for PHP <5.1 and false for PHP >=5.1
			$expiry = strtotime( $this->expiry );

			if( $expiry < 0 || $expiry === false ) {
				$this->showSettings( wfMsg( 'stabilize_expiry_invalid' ) );
				return false;
			}

			$expiry = wfTimestamp( TS_MW, $expiry );

			if ( $expiry < wfTimestampNow() ) {
				$this->showSettings( wfMsg( 'stabilize_expiry_old' ) );
				return false;
			}
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		# Get current config
		$row = $dbw->selectRow( 'flaggedpage_config',
			array( 'fpc_select', 'fpc_override', 'fpc_expiry' ),
			array( 'fpc_page_id' => $this->page->getArticleID() ),
			__METHOD__ );
		# If setting to site default values, erase the row if there is one...
		if( $row && $this->select != $wgFlaggedRevsPrecedence && $this->override == $wgFlaggedRevsOverride ) {
			$reset = true;
			$dbw->delete( 'flaggedpage_config',
				array( 'fpc_page_id' => $this->page->getArticleID() ),
				__METHOD__ );
			$changed = ($dbw->affectedRows() != 0); // did this do anything?
		# Otherwise, add a row unless we are just setting it as the site default, or it is the same the current one...
		} else if( $this->select !=0 || $this->override != $wgFlaggedRevsOverride ) {
			if( !$row || $row->fpc_select != $this->select || $row->fpc_override != $this->override || $row->fpc_expiry != $expiry ) {
				$changed = true;
				$dbw->replace( 'flaggedpage_config',
					array( 'PRIMARY' ),
					array( 'fpc_page_id' => $this->page->getArticleID(),
						'fpc_select'   => $this->select,
						'fpc_override' => $this->override,
						'fpc_expiry'   => $expiry ),
					__METHOD__ );
			}
		}
		# Log if changed
		# @FIXME: do this better
		if( $changed ) {
			global $wgContLang;

			$log = new LogPage( 'stable' );
			# ID, accuracy, depth, style
			$set = array();
			$set[] = wfMsgForContent( "stabilization-sel-short" ) . ": " .
				wfMsgForContent("stabilization-sel-short-{$this->select}");
			$set[] = wfMsgForContent( "stabilization-def-short" ) . ": " .
				wfMsgForContent("stabilization-def-short-{$this->override}");
			$settings = '[' . implode(', ',$set). ']';

			$reason = '';
			# Append comment with settings (other than for resets)
			if( !$reset ) {
				$reason = $this->comment ? "{$this->comment} $settings" : "$settings";

				$encodedExpiry = Block::encodeExpiry($expiry, $dbw );
				if( $encodedExpiry != 'infinity' ) {
					$expiry_description = ' (' . wfMsgForContent( 'stabilize-expiring',
						$wgContLang->timeanddate($expiry, false, false) ) . ')';
					$reason .= "$expiry_description";
				}
			}

			if( $reset ) {
				$log->addEntry( 'reset', $this->page, $reason );
				$type = "stable-logentry2";
			} else {
				$log->addEntry( 'config', $this->page, $reason );
				$type = "stable-logentry";
			}
			$comment = $wgContLang->ucfirst( wfMsgForContent( $type, $this->page->getPrefixedText() ) );
			if( $reason ) {
				$comment .= ": $reason";
			}

			$id = $this->page->getArticleId();
			$latest = $this->page->getLatestRevID( GAID_FOR_UPDATE );
			# Insert a null revision
			$nullRevision = Revision::newNullRevision( $dbw, $id, $comment, true );
			$nullRevId = $nullRevision->insertOn( $dbw );
			# Update page record
			$article = new Article( $this->page );
			$article->updateRevisionOn( $dbw, $nullRevision, $latest );
			wfRunHooks( 'NewRevisionFromEditComplete', array($article, $nullRevision, $latest) );
		}
		# Update the links tables as the stable version may now be the default page...
		FlaggedRevs::titleLinksUpdate( $this->page );

		if( $this->watchThis ) {
			$wgUser->addWatch( $this->page );
		} else {
			$wgUser->removeWatch( $this->page );
		}
		$dbw->commit();

		$wgOut->redirect( $this->page->getFullUrl() );

		return true;
	}
}
