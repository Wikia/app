<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class Stabilization extends UnlistedSpecialPage
{
    function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'Stabilization', 'stablesettings' );
		wfLoadExtensionMessages( 'Stabilization' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
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
		$form .= Xml::openElement( 'form', array( 'name' => 'stabilization', 'action' => $special->getLocalUrl( ), 'method' => 'post' ) ).
			Xml::fieldset( wfMsg( 'stabilization-def' ), false ) . "\n" .
			Xml::radioLabel( wfMsg( 'stabilization-def1' ), 'mwStableconfig-override', 1, 'default-stable', 1 == $this->override, $off ) . '<br />' . "\n" .
			Xml::radioLabel( wfMsg( 'stabilization-def2' ), 'mwStableconfig-override', 0, 'default-current', 0 == $this->override, $off ) . "\n" .
			Xml::closeElement( 'fieldset' ) .

			Xml::fieldset( wfMsg( 'stabilization-select' ), false ) .
			Xml::radioLabel( wfMsg( 'stabilization-select1' ), 'mwStableconfig-select', FLAGGED_VIS_NORMAL, 'stable-select1', FLAGGED_VIS_NORMAL == $this->select, $off ) . '<br />' . "\n" .
			Xml::radioLabel( wfMsg( 'stabilization-select2' ), 'mwStableconfig-select', FLAGGED_VIS_LATEST, 'stable-select2', FLAGGED_VIS_LATEST == $this->select, $off ) . '<br />' . "\n" .
			// Xml::radioLabel( wfMsg( 'stabilization-select3' ), 'mwStableconfig-select', FLAGGED_VIS_PRISTINE, 'stable-select3', FLAGGED_VIS_PRISTINE == $this->select, $off ) .
			Xml::closeElement( 'fieldset' ) .

			Xml::fieldset( wfMsg( 'stabilization-leg' ), false ) .
			Xml::openElement( 'table', array( 'class' => 'mw-fr-stabilization-leg' ) ) .
			'<tr>
				<td class="mw-label">' .
					Xml::tags( 'label', array( 'for' => 'expires' ), wfMsgExt( 'stabilization-expiry', array( 'parseinline' ) ) ) .
				'</td>
				<td class="mw-input">' .
					Xml::input( 'mwStableconfig-expiry', 60, $this->expiry, array( 'id' => 'expires'  ) + $off ) .
				'</td>
			</tr>';		

		if( $this->isAllowed ) {
			$watchLabel = wfMsgExt('watchthis', array('parseinline'));
			$watchAttribs = array('accesskey' => wfMsg( 'accesskey-watch' ), 'id' => 'wpWatchthis');
			$watchChecked = ( $wgUser->getOption( 'watchdefault' ) || $wgTitle->userIsWatching() );

			$form .= '<tr>
					<td class="mw-label">' .
						Xml::label( wfMsg( 'stabilization-comment' ), 'wpReason' ) .
					'</td>
					<td class="mw-input">' .
						Xml::input( 'wpReason', 60, $this->comment, array( 'id' => 'wpReason' ) ) .
					'</td>
				</tr>
				<tr>
					<td></td>
					<td class="mw-input">' .
						Xml::check( 'wpWatchthis', $watchChecked, $watchAttribs ) .
						"<label for='wpWatchthis'" . $this->skin->tooltipAndAccesskey( 'watch' ) . ">{$watchLabel}</label>" .
					'</td>
				</tr>
				<tr>
					<td></td>
					<td class="mw-submit">' .
						Xml::submitButton( wfMsg( 'stabilization-submit' ) ) .
					'</td>
				</tr>' .
				Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() ) .
				Xml::hidden( 'page', $this->page->getPrefixedText() ) .
				Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		} else {
			$form .= Xml::openElement( 'table', array( 'class' => 'mw-fr-stabilization' ) );
		}

		$form .= Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' );

		$wgOut->addHTML( $form );

		$wgOut->addHTML( Xml::element( 'h2', NULL, htmlspecialchars( LogPage::logName( 'stable' ) ) ) );
		LogEventsList::showLogExtract( $wgOut, 'stable', $this->page->getPrefixedText() );
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
						$wgContLang->timeanddate($expiry, false, false) ,
						$wgContLang->date($expiry, false, false) ,
						$wgContLang->time($expiry, false, false) ) . ')';
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
			# Update page record and touch page
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

		$query = '';
		# Take the user to the diff to make sure an outdated version isn't
		# being set at the default. This is really an issue with configs
		# that only let certain pages be reviewed.
		if( $this->select == FLAGGED_VIS_NORMAL ) {
			$frev = FlaggedRevision::newFromStable( $this->page, FR_MASTER );
			if( $frev && $frev->getRevId() != $latest ) {
				$query = "oldid={$frev->getRevId()}&diff=cur&diffonly=0"; // override diff-only
			}
		}
		$wgOut->redirect( $this->page->getFullUrl( $query ) );

		return true;
	}
}
