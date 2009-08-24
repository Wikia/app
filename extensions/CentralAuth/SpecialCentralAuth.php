<?php

class SpecialCentralAuth extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('SpecialCentralAuth');
		parent::__construct( 'CentralAuth', 'centralauth-admin' );
	}

	function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgUser;
		$this->setHeaders();

		if( !$wgUser->isLoggedIn() ) {
			$wgOut->addWikiText(
				wfMsg( 'centralauth-merge-notlogged' ) .
				"\n\n" .
				wfMsg( 'centralauth-readmore-text' ) );

			return;
		}

		global $wgUser, $wgRequest;
		$this->mUserName = $wgUser->getName();

		if( !$wgUser->isAllowed( 'centralauth-admin' ) ) {
			$wgOut->addWikiText(
				wfMsg( 'centralauth-admin-permission' ) .
				"\n\n" .
				wfMsg( 'centralauth-readmore-text' ) );
			return;
		}

		$this->mUserName =
			trim(
				str_replace( '_', ' ',
					$wgRequest->getText( 'target', $subpage ) ) );

		$this->mPosted = $wgRequest->wasPosted();
		$this->mMethod = $wgRequest->getVal( 'wpMethod' );
		$this->mPassword = $wgRequest->getVal( 'wpPassword' );
		$this->mWikis = (array)$wgRequest->getArray( 'wpWikis' );

		// Possible demo states

		// success, all accounts merged
		// successful login, some accounts merged, others left
		// successful login, others left
		// not account owner, others left

		// is owner / is not owner
		// did / did not merge some accounts
		// do / don't have more accounts to merge

		if ( $this->mUserName === '' ) {
			# First time through
			$wgOut->addWikiMsg( 'centralauth-admin-intro' );
			$this->showUsernameForm();
			return;
		}

		$this->mGlobalUser = $globalUser = new CentralAuthUser( $this->mUserName );

		if ( !$globalUser->exists() ) {
			$this->showError( 'centralauth-admin-nonexistent', $this->mUserName );
			$this->showUsernameForm();
			return;
		}

		$continue = true;
		if( $this->mPosted ) {
			$continue = $this->doSubmit();
		}

		$this->showUsernameForm();
		if ( $continue ) {
			$this->showInfo();
			$this->showStatusForm();
			$this->showActionForm( 'delete' );
			$this->showWikiLists();
		}
	}
	
	/** Returns true if the normal form should be displayed */
	function doSubmit() {
		$deleted = false;
		$globalUser = $this->mGlobalUser;
		global $wgUser, $wgOut, $wgRequest;
		if ( !$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
			$this->showError( 'centralauth-token-mismatch' );
		} elseif( $this->mMethod == 'unmerge' ) {
			$status = $globalUser->adminUnattach( $this->mWikis );
			if ( !$status->isGood() ) {
				$this->showStatusError( $status->getWikiText() );
			} else {
				global $wgLang;
				$this->showSuccess( 'centralauth-admin-unmerge-success',
					$wgLang->formatNum( $status->successCount ),
					/* deprecated */ $status->successCount );
			}
		} elseif ( $this->mMethod == 'delete' ) {
			$status = $globalUser->adminDelete();
			if ( !$status->isGood() ) {
				$this->showStatusError( $status->getWikiText() );
			} else {
				global $wgLang;
				$this->showSuccess( 'centralauth-admin-delete-success', $this->mUserName );
				$deleted = true;
				$this->logAction( 'delete', $this->mUserName, $wgRequest->getVal( 'reason' ) );
			}
		} elseif ( $this->mMethod == 'set-status' ) {
			$setLocked = $wgRequest->getBool( 'wpStatusLocked' );
			$setHidden = $wgRequest->getBool( 'wpStatusHidden' );
			$isLocked = $globalUser->isLocked();
			$isHidden = $globalUser->isHidden();
			$lockStatus = $hideStatus = null;
			$added = array();
			$removed = array();
			
			if ( !$isLocked && $setLocked ) {
				$lockStatus = $globalUser->adminLock();
				$added[] = wfMsg( 'centralauth-log-status-locked' );
			} elseif( $isLocked && !$setLocked ) {
				$lockStatus = $globalUser->adminUnlock();
				$removed[] = wfMsg( 'centralauth-log-status-locked' );
			}
			
			if ( !$isHidden && $setHidden ) {
				$hideStatus = $globalUser->adminHide();
				$added[] = wfMsg( 'centralauth-log-status-hidden' );
			} elseif( $isHidden && !$setHidden ) {
				$hideStatus = $globalUser->adminUnhide();
				$removed[] = wfMsg( 'centralauth-log-status-hidden' );
			}
			
			$good =
				( is_null($lockStatus) || $lockStatus->isGood() ) &&
				( is_null($hideStatus) || $hideStatus->isGood() );
			
			// Logging etc
			if ( $good && (count($added) || count($removed)) ) {
				$added = count($added) ?
					implode( ', ', $added ) : wfMsg( 'centralauth-log-status-none' );
				$removed = count($removed) ?
					implode( ', ', $removed ) : wfMsg( 'centralauth-log-status-none' );
				
				$reason = $wgRequest->getText( 'wpReason' );
				$this->logAction(
									'setstatus',
									$this->mUserName,
									$reason,
									array( $added, $removed )
								);
				$this->showSuccess( 'centralauth-admin-setstatus-success', $this->mUserName );
			} elseif (!$good) {
				if ( !is_null($lockStatus) && !$lockStatus->isGood() ) {
					$this->showStatusError( $lockStatus->getWikiText() );
				}
				if ( !is_null($hideStatus) && !$hideStatus->isGood() ) {
					$this->showStatusError( $hideStatus->getWikiText() );
				}
			}
		} else {
			$this->showError( 'centralauth-admin-bad-input' );
		}
		return !$deleted;
	}

	function showStatusError( $wikitext ) {
		global $wgOut;
		$wrap = Xml::tags( 'div', array( 'class' => 'error' ), $s );
		$wgOut->addHTML( $wgOut->parse( $wrap, /*linestart*/true, /*uilang*/true ) );
	}

	function showError( /* varargs */ ) {
		global $wgOut;
		$args = func_get_args();
		$wgOut->wrapWikiMsg( '<div class="error">$1</div>', $args );
	}


	function showSuccess( /* varargs */ ) {
		global $wgOut;
		$args = func_get_args();
		$wgOut->wrapWikiMsg( '<div class="success">$1</div>', $args );
	}

	function showUsernameForm() {
		global $wgOut, $wgScript;
		$wgOut->addHTML(
			Xml::openElement( 'form', array(
				'method' => 'get',
				'action' => $wgScript ) ) .
			'<fieldset>' .
			Xml::element( 'legend', array(), wfMsg( 'centralauth-admin-manage' ) ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			'<p>' .
			Xml::inputLabel( wfMsg( 'centralauth-admin-username' ),
				'target', 'target', 25, $this->mUserName ) .
			'</p>' .
			'<p>' .
			Xml::submitButton( wfMsg( 'centralauth-admin-lookup' ) ) .
			'</p>' .
			'</fieldset>' .
			'</form>'
		);
	}

	function prettyTimespan( $span ) {
		$units = array(
			'seconds' => 60,
			'minutes' => 60,
			'hours' => 24,
			'days' => 30.417,
			'months' => 12,
			'years' => 1 );
		foreach( $units as $unit => $chunk ) {
			if( $span < 2*$chunk ) {
				return wfMsgExt( "centralauth-$unit-ago", 'parsemag', $span );
			}
			$span = intval( $span / $chunk );
		}
		return wfMsgExt( "centralauth-$unit-ago", 'parsemag', $span );
	}
	
	function showWikiLists() {
		global $wgOut;
		$merged = $this->mGlobalUser->queryAttached();
		$remainder = $this->mGlobalUser->queryUnattached();
		
		$wgOut->addHTML(
			Xml::tags( 'h2', null, wfMsgExt( 'centralauth-admin-attached', 'parseinline' ) )
		);
		$wgOut->addHTML( $this->listMerged( $merged ) );

		$wgOut->addHTML(
			Xml::tags( 'h2', null, wfMsgExt( 'centralauth-admin-unattached', 'parseinline' ) )
		);
		
		if( $remainder ) {
			$wgOut->addHTML( $this->listRemainder( $remainder ) );
		} else {
			$wgOut->addWikiMsg( 'centralauth-admin-no-unattached' );
		}
	}

	function showInfo() {
		$globalUser = $this->mGlobalUser;

		$id = $globalUser->exists() ? $globalUser->getId() : "unified account not registered";

		global $wgOut, $wgLang;
		if( $globalUser->exists() ) {
			$reg = $globalUser->getRegistration();
			$age = $this->prettyTimespan( wfTimestamp( TS_UNIX ) - wfTimestamp( TS_UNIX, $reg ) );
			$attribs = array(
				'id' => $globalUser->getId(),
				'registered' => $wgLang->timeanddate( $reg ) . " ($age)",
				'locked' => $globalUser->isLocked() ? wfMsg( 'centralauth-admin-yes' ) : wfMsg( 'centralauth-admin-no' ),
				'hidden' => $globalUser->isHidden() ? wfMsg( 'centralauth-admin-yes' ) : wfMsg( 'centralauth-admin-no' ) );
			$out = '<ul id="mw-centralauth-info">';
			foreach( $attribs as $tag => $data ) {
				$out .= Xml::element( 'li', array(), wfMsg( "centralauth-admin-info-$tag" ) . ' ' . $data );
			}
			$out .= '</ul>';
			$wgOut->addHTML( $out );
		} else {
			$wgOut->addWikiText( wfMsg( 'centralauth-admin-no-unified' ) );
		}
	}

	function listMerged( $list ) {
		return $this->listForm( $list, 'listMergedWikiItem',
			'unmerge', wfMsg( 'centralauth-admin-unmerge' ) );
	}

	function listRemainder( $list ) {
		ksort( $list );
		$s = '<ul id="mw-centralauth-unattached">';
		foreach ( $list as $row ) {
			$s .= '<li>' . $this->foreignUserLink( $row['wiki'] ) . "</li>\n";
		}
		$s .= '</ul>';
		return $s;
	}

	function listForm( $list, $listMethod, $action, $buttonText ) {
		global $wgUser;
		ksort( $list );
		return
			Xml::openElement( 'form',
				array(
					'method' => 'post',
					'action' =>
						$this->getTitle( $this->mUserName )->getLocalUrl( 'action=submit' ),
					'id' => 'mw-centralauth-merged' ) ) .
			Xml::hidden( 'wpMethod', $action ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			'<table>' .
			'<thead>' .
			$this->tableRow( 'th',
				array(
						'',
						wfMsgHtml( 'centralauth-admin-list-localwiki' ),
						wfMsgHtml( 'centralauth-admin-list-attached-on' ),
						wfMsgHtml( 'centralauth-admin-list-method' ),
						wfMsgHtml( 'centralauth-admin-list-blocked' ),
						wfMsgHtml( 'centralauth-admin-list-editcount' ),
					)
				) .
			'</thead>' .
			'<tbody>' .
			implode( "\n",
				array_map( array( $this, $listMethod ),
				 	$list ) ) .
			'<tr>' .
			'<td></td>' .
			'<td>' .
			Xml::submitButton( $buttonText ) .
			'</td>' .
			'</tr>' .
			'</tbody>' .
			'</table>' .
			Xml::closeElement( 'form' );
	}

	function listMergedWikiItem( $row ) {
		global $wgLang;
		return $this->tableRow( 'td',
			array(
				$this->adminCheck( $row['wiki'] ),
				$this->foreignUserLink( $row['wiki'] ),
				htmlspecialchars( $wgLang->timeanddate( $row['attachedTimestamp'] ) ),
				htmlspecialchars( wfMsg( 'centralauth-merge-method-' . $row['attachedMethod'] ) ),
				$this->showBlockStatus( $row ),
				intval( $row['editCount'] )
			)
		);
	}
	
	function showBlockStatus( $row ) {
		if ($row['blocked']) {
			global $wgLang;
			$expiry = $wgLang->timeanddate( $row['block-expiry'] );
			$expiryd = $wgLang->date( $row['block-expiry'] );
			$expiryt = $wgLang->time( $row['block-expiry'] );
			$reason = $row['block-reason'];
			
			return wfMsgExt( 'centralauth-admin-blocked', 'parseinline', array( $expiry, $reason, $expiryd, $expiryt ) );
		} else {
			return wfMsgExt( 'centralauth-admin-notblocked', 'parseinline' );
		}
	}

	function tableRow( $element, $cols ) {
		return "<tr><$element>" .
			implode( "</$element><$element>", $cols ) .
			"</$element></tr>";
	}

	function foreignUserLink( $wikiID ) {
		$wiki = WikiMap::getWiki( $wikiID );
		if( !$wiki ) {
			throw new MWException( "no wiki for $wikiID" );
		}

		$hostname = $wiki->getDisplayName();
		$userPageName = 'User:' . $this->mUserName;
		$url = $wiki->getUrl( $userPageName );
		return Xml::element( 'a',
			array(
				'href' => $url,
				'title' => wfMsg( 'centralauth-foreign-link',
					$this->mUserName,
					$hostname ),
			),
			$hostname );
	}

	function adminCheck( $wikiID ) {
		return
			Xml::check( 'wpWikis[]', false, array( 'value' => $wikiID ) );
	}

	function showActionForm( $action ) {
		global $wgOut, $wgUser;
		$wgOut->addHTML(
			Xml::element( 'h2', array(), wfMsg( "centralauth-admin-{$action}-title" ) ) .
			Xml::openElement( 'form', array(
				'method' => 'POST',
				'action' => $this->getTitle()->getFullUrl( 'target=' . urlencode( $this->mUserName ) ),
				'id' => "mw-centralauth-$action" ) ) .
			Xml::hidden( 'wpMethod', $action ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			wfMsgExt( "centralauth-admin-{$action}-description", 'parse' ) .
			'<p>' .
			Xml::label( wfMsgHtml( 'centralauth-admin-reason' ), "{$action}-reason" ) . ' ' .
			Xml::input( 'reason', false, false, array( 'id' => "{$action}-reason" ) ) .
			'</p>' .
			'<p>' .
			Xml::submitButton( wfMsg( "centralauth-admin-{$action}-button" ) ) .
			'</p>' .
			'</form>' );
	}
	
	function showStatusForm() {
		// Allows locking, hiding, locking and hiding.
		global $wgUser, $wgOut;
		$form = '';
		$form .= Xml::element( 'h2', array(), wfMsg( 'centralauth-admin-status' ) );
		$form .= Xml::hidden( 'wpMethod', 'set-status' );
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$form .= wfMsgExt( 'centralauth-admin-status-intro', 'parse' );
		
		// Checkboxen
		$lockedLabel = wfMsg( 'centralauth-admin-status-locked' );
		$checkLocked = Xml::checkLabel( $lockedLabel,
										'wpStatusLocked',
										'mw-centralauth-status-locked',
										$this->mGlobalUser->isLocked() );
		$hiddenLabel = wfMsg( 'centralauth-admin-status-hidden' );
		$checkHidden = Xml::checkLabel( $hiddenLabel,
										'wpStatusHidden',
										'mw-centralauth-status-hidden',
										$this->mGlobalUser->isHidden() );
		
		$form .= Xml::tags( 'p', null, $checkLocked ) .
					Xml::tags( 'p', null, $checkHidden );
		
		// Reason
		$reasonLabel = wfMsg( 'centralauth-admin-reason' );
		$reasonField = Xml::inputLabel( $reasonLabel,
									'wpReason',
									'mw-centralauth-reason',
									45 );
		$form .= Xml::tags( 'p', null, $reasonField );
		
		$form .= Xml::tags( 'p', null,
					Xml::submitButton( wfMsg( 'centralauth-admin-status-submit' ) )
				);
		$form = Xml::tags( 'form',
							array( 'method' => 'POST',
									'action' =>
										$this->getTitle()->getFullURL(
												array( 'target' => $this->mUserName )
										),
								),
								$form
							);
		$wgOut->addHTML( $form );
	}

	function logAction( $action, $target, $reason = '', $params = array() ) {
		$log = new LogPage( 'globalauth' );	//Not centralauth because of some weird length limitiations
		$log->addEntry( $action, Title::newFromText( "User:{$target}@global" ), $reason, $params );
	}
}
