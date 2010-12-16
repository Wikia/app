<?php

class SpecialCentralAuth extends SpecialPage {
	var $mUserName, $mCanUnmerge, $mCanLock, $mCanOversight, $mCanEdit;
	var $mGlobalUser, $mAttachedLocalAccounts, $mUnattachedLocalAccounts;

	function __construct() {
		wfLoadExtensionMessages('SpecialCentralAuth');
		parent::__construct( 'CentralAuth' );
	}

	function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgUser;
		global $wgExtensionAssetsPath, $wgCentralAuthStyleVersion;
		global $wgUser, $wgRequest;
		$this->setHeaders();

		$this->mCanUnmerge = $wgUser->isAllowed( 'centralauth-unmerge' );
		$this->mCanLock = $wgUser->isAllowed( 'centralauth-lock' );
		$this->mCanOversight = $wgUser->isAllowed( 'centralauth-oversight' );
		$this->mCanEdit = $this->mCanUnmerge || $this->mCanLock || $this->mCanOversight;

		$wgOut->addExtensionStyle( "{$wgExtensionAssetsPath}/CentralAuth/centralauth.css?" .
			$wgCentralAuthStyleVersion );
		$wgOut->addScriptFile( "{$wgExtensionAssetsPath}/CentralAuth/centralauth.js?" .
			$wgCentralAuthStyleVersion );
		$this->addMergeMethodDescriptions();

		$this->mUserName =
			trim(
				str_replace( '_', ' ',
					$wgRequest->getText( 'target', $subpage ) ) );

		$this->mPosted = $wgRequest->wasPosted();
		$this->mMethod = $wgRequest->getVal( 'wpMethod' );
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

		if ( !$globalUser->exists() ||
			( $globalUser->isOversighted() && !$this->mCanOversight ) ) {
			$this->showError( 'centralauth-admin-nonexistent', $this->mUserName );
			$this->showUsernameForm();
			return;
		}

		$continue = true;
		if( $this->mCanEdit && $this->mPosted ) {
			$continue = $this->doSubmit();
		}

		$this->mAttachedLocalAccounts = $this->mGlobalUser->queryAttached();
		$this->mUnattachedLocalAccounts = $this->mGlobalUser->queryUnattached();

		$this->showUsernameForm();
		if ( $continue ) {
			$this->showInfo();
			if( $this->mCanLock )
				$this->showStatusForm();
			if( $this->mCanUnmerge )
				$this->showActionForm( 'delete' );
			if( $this->mCanEdit )
				$this->showLogExtract();
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
		} elseif( $this->mMethod == 'unmerge' && $this->mCanUnmerge ) {
			$status = $globalUser->adminUnattach( $this->mWikis );
			if ( !$status->isGood() ) {
				$this->showStatusError( $status->getWikiText() );
			} else {
				global $wgLang;
				$this->showSuccess( 'centralauth-admin-unmerge-success',
					$wgLang->formatNum( $status->successCount ),
					/* deprecated */ $status->successCount );
			}
		} elseif ( $this->mMethod == 'delete' && $this->mCanUnmerge ) {
			$status = $globalUser->adminDelete();
			if ( !$status->isGood() ) {
				$this->showStatusError( $status->getWikiText() );
			} else {
				global $wgLang;
				$this->showSuccess( 'centralauth-admin-delete-success', $this->mUserName );
				$deleted = true;
				$this->logAction( 'delete', $this->mUserName, $wgRequest->getVal( 'reason' ) );
			}
		} elseif ( $this->mMethod == 'set-status' && $this->mCanLock ) {
			$setLocked = $wgRequest->getBool( 'wpStatusLocked' );
			$setHidden = $wgRequest->getVal( 'wpStatusHidden' );
			$isLocked = $globalUser->isLocked();
			$oldHiddenLevel = $globalUser->getHiddenLevel();
			$lockStatus = $hideStatus = null;
			$added = array();
			$removed = array();

			// Sanitizing input value...
			$hiddenLevels = array(
				CentralAuthUser::HIDDEN_NONE,
				CentralAuthUser::HIDDEN_LISTS,
				CentralAuthUser::HIDDEN_OVERSIGHT );
			if( !in_array( $setHidden, $hiddenLevels ) )
				$setHidden = '';

			if ( !$isLocked && $setLocked ) {
				$lockStatus = $globalUser->adminLock();
				$added[] = wfMsgForContent( 'centralauth-log-status-locked' );
			} elseif( $isLocked && !$setLocked ) {
				$lockStatus = $globalUser->adminUnlock();
				$removed[] = wfMsgForContent( 'centralauth-log-status-locked' );
			}

			$reason = $wgRequest->getText( 'wpReasonList' );
			$reasonDetail = $wgRequest->getText( 'wpReason' );
			if( $reason == 'other' ) {
				$reason = $reasonDetail;
			} elseif( $reasonDetail ) {
				$reason .= wfMsgForContent( 'colon-separator' ) . $reasonDetail;
			}
			
			if ( $oldHiddenLevel != $setHidden ) {
				$hideStatus = $globalUser->adminSetHidden( $setHidden );
				switch( $setHidden ) {
					case CentralAuthUser::HIDDEN_NONE:
						$removed[] = $oldHiddenLevel == CentralAuthUser::HIDDEN_OVERSIGHT ?
							wfMsgForContent( 'centralauth-log-status-oversighted' ) :
							wfMsgForContent( 'centralauth-log-status-hidden' );
						break;
					case CentralAuthUser::HIDDEN_LISTS:
						$added[] = wfMsgForContent( 'centralauth-log-status-hidden' );
						if( $oldHiddenLevel == CentralAuthUser::HIDDEN_OVERSIGHT )
							$removed[] = wfMsgForContent( 'centralauth-log-status-oversighted' );
						break;
					case CentralAuthUser::HIDDEN_OVERSIGHT:
						$added[] = wfMsgForContent( 'centralauth-log-status-oversighted' );
						if( $oldHiddenLevel == CentralAuthUser::HIDDEN_LISTS )
							$removed[] = wfMsgForContent( 'centralauth-log-status-hidden' );
						break;
				}

				if( $setHidden == CentralAuthUser::HIDDEN_OVERSIGHT )
					$globalUser->suppress( $reason );
				elseif( $oldHiddenLevel == CentralAuthUser::HIDDEN_OVERSIGHT )
					$globalUser->unsuppress( $reason );
			}
			
			$good =
				( is_null($lockStatus) || $lockStatus->isGood() ) &&
				( is_null($hideStatus) || $hideStatus->isGood() );
			
			// Logging etc
			if ( $good && (count($added) || count($removed)) ) {
				$added = count($added) ?
					implode( ', ', $added ) : wfMsgForContent( 'centralauth-log-status-none' );
				$removed = count($removed) ?
					implode( ', ', $removed ) : wfMsgForContent( 'centralauth-log-status-none' );

				$this->logAction(
									'setstatus',
									$this->mUserName,
									$reason,
									array( $added, $removed ),
									$setHidden == CentralAuthUser::HIDDEN_OVERSIGHT
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
		$wrap = Xml::tags( 'div', array( 'class' => 'error' ), $wikitext );
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
		$lookup = $this->mCanEdit ?
			wfMsg( 'centralauth-admin-lookup-rw' ) :
			wfMsg( 'centralauth-admin-lookup-ro' );
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
			Xml::submitButton( $lookup ) .
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

	function showInfo() {
		$globalUser = $this->mGlobalUser;

		global $wgOut, $wgLang;
		$reg = $globalUser->getRegistration();
		$age = $this->prettyTimespan( wfTimestamp( TS_UNIX ) - wfTimestamp( TS_UNIX, $reg ) );
		$attribs = array(
			'id' => $globalUser->getId(),
			'registered' => $wgLang->timeanddate( $reg ) . " ($age)",
			'home' => $this->determineHomeWiki(),
			'editcount' => $this->evaluateTotalEditcount(),
			'locked' => $globalUser->isLocked() ? wfMsg( 'centralauth-admin-yes' ) : wfMsg( 'centralauth-admin-no' ),
			'hidden' => $this->formatHiddenLevel( $globalUser->getHiddenLevel() ) );
		$out = '<fieldset id="mw-centralauth-info">';
		$out .= '<legend>' . wfMsgHtml( 'centralauth-admin-info-header' ) . '</legend>';
		foreach( $attribs as $tag => $data ) {
			$out .= '<p><strong>' . wfMsgHtml( "centralauth-admin-info-$tag" ) . '</strong> ' .
				htmlspecialchars( $data ) . '</p>';
		}
		$out .= '</fieldset>';
		$wgOut->addHTML( $out );
	}

	function showWikiLists() {
		global $wgOut;
		$merged = $this->mAttachedLocalAccounts;
		$remainder = $this->mUnattachedLocalAccounts;

		$legend = $this->mCanUnmerge ?
			wfMsgHtml( 'centralauth-admin-list-legend-rw' ) :
			wfMsgHtml( 'centralauth-admin-list-legend-ro' );

		$wgOut->addHTML( "<fieldset><legend>{$legend}</legend>" );
		$wgOut->addHTML( $this->listHeader() );
		$wgOut->addHTML( $this->listMerged( $merged ) );
		if( $remainder )
			$wgOut->addHTML( $this->listRemainder( $remainder ) );
		$wgOut->addHTML( $this->listFooter() );
		$wgOut->addHTML( '</fieldset>' );
	}

	function listHeader() {
		global $wgUser;
		return
			Xml::openElement( 'form',
				array(
					'method' => 'post',
					'action' =>
						$this->getTitle( $this->mUserName )->getLocalUrl( 'action=submit' ),
					'id' => 'mw-centralauth-merged' ) ) .
			Xml::hidden( 'wpMethod', 'unmerge' ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			'<table id="mw-wikis-list">' .
			'<thead><tr>' .
				( $this->mCanUnmerge ? '<th></th>' : '' ) .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-localwiki' ) . '</th>'.
				'<th>' . wfMsgHtml( 'centralauth-admin-list-attached-on' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-method' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-blocked' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-editcount' ) . '</th>'.
			'</tr></thead>' .
			'<tbody>';
	}

	function listFooter() {
		$footer = '';
		if( $this->mCanUnmerge )
			$footer .=
				'<tr>' .
				'<td style="border-right: none"></td>' .
				'<td style="border-left: none" colspan="5">' .
				Xml::submitButton( wfMsg( 'centralauth-admin-unmerge' ) ) .
				'</td>' .
				'</tr>';
		$footer .= '</tbody></table></form>';
		return $footer;
	}

	function listMerged( $list ) {
		ksort( $list );
		return implode( "\n", array_map( array( $this, 'listMergedWikiItem' ), $list ) );
	}

	function listRemainder( $list ) {
		ksort( $list );
		$notMerged = wfMsgExt( 'centralauth-admin-unattached', array( 'parseinline' ) );
		$rows = array();
		foreach ( $list as $row ) {
			$rows[] = '<tr class="unattached-row"><td>' .
				( $this->mCanUnmerge ? '</td><td>' : '' ) .
				$this->foreignUserLink( $row['wiki'] ) .
				"</td><td colspan='4'>{$notMerged}</td></tr>\n";
		}
		return implode( $rows );
	}

	function listMergedWikiItem( $row ) {
		global $wgLang;
		return '<tr>' .
			( $this->mCanUnmerge ? '<td>' . $this->adminCheck( $row['wiki'] ) . '</td>' : '' ).
			'<td>' . $this->foreignUserLink( $row['wiki'] ) . '</td>' .
			'<td>' . htmlspecialchars( $wgLang->timeanddate( $row['attachedTimestamp'] ) ) . '</td>' .
			'<td style="text-align: center">' . $this->formatMergeMethod( $row['attachedMethod'] ) . '</td>' .
			'<td>' . $this->formatBlockStatus( $row ) . '</td>' .
			'<td>' . $this->formatEditcount( $row ) . '</td>' .
			'</tr>';
	}

	function formatMergeMethod( $method ) {
		global $wgExtensionAssetsPath;

		$img = htmlspecialchars( "{$wgExtensionAssetsPath}/CentralAuth/icons/merged-{$method}.png" );
		$brief = wfMsgHtml( "centralauth-merge-method-{$method}" );
		return "<img src=\"{$img}\" alt=\"{$brief}\" title=\"{$brief}\"/>" .
			"<span class=\"merge-method-help\" title=\"{$brief}\" onclick=\"showMethodHint('{$method}')\">(?)</span>";
	}

	function formatBlockStatus( $row ) {
		if( $row['blocked'] ) {
			if( $row['block-expiry'] == 'infinity' ) {
			$reason = $row['block-reason'];
				return wfMsgExt( 'centralauth-admin-blocked-indef', 'parseinline', array( $reason ) );
			} else {
				global $wgLang;
				$expiry = $wgLang->timeanddate( $row['block-expiry'] );
				$expiryd = $wgLang->date( $row['block-expiry'] );
				$expiryt = $wgLang->time( $row['block-expiry'] );
				$reason = $row['block-reason'];
				
				$text = wfMsgExt( 'centralauth-admin-blocked', 'parseinline', array( $expiry, $reason, $expiryd, $expiryt ) );
			}
		} else {
			$text = wfMsgExt( 'centralauth-admin-notblocked', 'parseinline' );
		}

		return $this->foreignLink(
			$row['wiki'],
			'Special:Log/block',
			$text,
			wfMsg( 'centralauth-admin-blocklog' ),
			'page=User:' . urlencode( $this->mUserName ) );
	}

	function formatEditcount( $row ) {
		return $this->foreignLink(
			$row['wiki'],
			'Special:Contributions/' . $this->mUserName,
			intval( $row['editCount'] ),
			'contributions' );
	}

	function formatHiddenLevel( $level ) {
		switch( $level ) {
			case CentralAuthUser::HIDDEN_NONE:
				return wfMsg( 'centralauth-admin-no' );
			case CentralAuthUser::HIDDEN_LISTS:
				return wfMsg( 'centralauth-admin-hidden-list' );
			case CentralAuthUser::HIDDEN_OVERSIGHT:
				return wfMsg( 'centralauth-admin-hidden-oversight' );
		}
	}

	function tableRow( $element, $cols ) {
		return "<tr><$element>" .
			implode( "</$element><$element>", $cols ) .
			"</$element></tr>";
	}

	function foreignLink( $wikiID, $title, $text, $hint = '', $params = '' ) {
		if ( $wikiID instanceof WikiReference ) {
			$wiki = $wikiID;
		} else {
			$wiki = WikiMap::getWiki( $wikiID );
			if( !$wiki ) {
				throw new MWException( "Invalid wiki: $wikiID" );
			}
		}

		$url = $wiki->getUrl( $title );
		if( $params )
			$url .= '?' . $params;
		return Xml::element( 'a',
			array(
				'href' => $url,
				'title' => $hint,
			),
			$text );
	}

	function foreignUserLink( $wikiID ) {
		$wiki = WikiMap::getWiki( $wikiID );
		if( !$wiki ) {
			throw new MWException( "Invalid wiki: $wikiID" );
		}

		$wikiname = $wiki->getDisplayName();
		return $this->foreignLink(
			$wiki,
			'User:' . $this->mUserName,
			$wikiname,
			wfMsg( 'centralauth-foreign-link', $this->mUserName, $wikiname ) );
		
	}

	function adminCheck( $wikiID ) {
		return
			Xml::check( 'wpWikis[]', false, array( 'value' => $wikiID ) );
	}

	function showActionForm( $action ) {
		global $wgOut, $wgUser;
		$wgOut->addHTML(
			Xml::fieldset( wfMsg( "centralauth-admin-{$action}-title" ) ) .
			Xml::openElement( 'form', array(
				'method' => 'POST',
				'action' => $this->getTitle()->getFullUrl( 'target=' . urlencode( $this->mUserName ) ),
				'id' => "mw-centralauth-$action" ) ) .
			Xml::hidden( 'wpMethod', $action ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			wfMsgExt( "centralauth-admin-{$action}-description", 'parse' ) .
			Xml::buildForm(
				array( 'centralauth-admin-reason' => Xml::input( 'reason',
					false, false, array( 'id' => "{$action}-reason" ) ) ),
				"centralauth-admin-{$action}-button"
			) .
			'</form></fieldset>' );
	}
	
	function showStatusForm() {
		// Allows locking, hiding, locking and hiding.
		global $wgUser, $wgOut;
		$form = '';
		$form .= Xml::fieldset( wfMsg( 'centralauth-admin-status' ) );
		$form .= Xml::hidden( 'wpMethod', 'set-status' );
		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		$form .= wfMsgExt( 'centralauth-admin-status-intro', 'parse' );
		
		// Radio buttons
		$radioLocked =
			Xml::radioLabel(
				wfMsg( 'centralauth-admin-status-locked-no' ),
				'wpStatusLocked',
				'0',
				'mw-centralauth-status-locked-no',
				!$this->mGlobalUser->isLocked() ) .
			'<br/>' .
			Xml::radioLabel(
				wfMsg( 'centralauth-admin-status-locked-yes' ),
				'wpStatusLocked',
				'1',
				'mw-centralauth-status-locked-yes',
				$this->mGlobalUser->isLocked() );
		$radioHidden =
			Xml::radioLabel(
				wfMsg( 'centralauth-admin-status-hidden-no' ),
				'wpStatusHidden',
				CentralAuthUser::HIDDEN_NONE,
				'mw-centralauth-status-hidden-no',
				$this->mGlobalUser->getHiddenLevel() == CentralAuthUser::HIDDEN_NONE ) .
			'<br/>' .
			Xml::radioLabel(
				wfMsg( 'centralauth-admin-status-hidden-list' ),
				'wpStatusHidden',
				CentralAuthUser::HIDDEN_LISTS,
				'mw-centralauth-status-hidden-list',
				$this->mGlobalUser->getHiddenLevel() == CentralAuthUser::HIDDEN_LISTS ) .
			'<br/>';
		if( $this->mCanOversight )
			$radioHidden .= Xml::radioLabel(
				wfMsg( 'centralauth-admin-status-hidden-oversight' ),
				'wpStatusHidden',
				CentralAuthUser::HIDDEN_OVERSIGHT,
				'mw-centralauth-status-hidden-oversight',
				$this->mGlobalUser->getHiddenLevel() == CentralAuthUser::HIDDEN_OVERSIGHT );

		// Reason
		$reasonList = Xml::listDropDown( 'wpReasonList',
			wfMsgForContent( 'centralauth-admin-status-reasons' ),
			wfMsgForContent( 'ipbreasonotherlist' ) );
		$reasonField = Xml::input( 'wpReason', 45, false );

		$form .= Xml::buildForm(
			array(
				'centralauth-admin-status-locked' => $radioLocked,
				'centralauth-admin-status-hidden' => $radioHidden,
				'centralauth-admin-reason' => $reasonList,
				'centralauth-admin-reason-other' => $reasonField ),
			'centralauth-admin-status-submit' );

		$form .= '</fieldset>';
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

	function showLogExtract() {
		global $wgOut;
		$user = $this->mGlobalUser->getName();
		$text = '';
		$numRows = LogEventsList::showLogExtract(
			$text,
			array( 'globalauth', 'suppress' ),
			Title::newFromText( "User:{$user}@global" )->getPrefixedText(),
			'',
			array( 'showIfEmpty' => true ) );
		if( $numRows ) {
			$wgOut->addHTML( Xml::fieldset( wfMsg( 'centralauth-admin-logsnippet' ), $text ) );
		}
	}

	function determineHomeWiki() {
		foreach( $this->mAttachedLocalAccounts as $wiki => $acc ) {
			if( $acc['attachedMethod'] == 'primary' || $acc['attachedMethod'] == 'new' ) {
				return $wiki;
			}
		}

		// Should not happen.
		throw new MWException( 'Failed to determine home wiki' );
	}

	function evaluateTotalEditcount() {
		$total = 0;
		foreach( $this->mAttachedLocalAccounts as $acc ) {
			$total += $acc['editCount'];
		}
		return $total;
	}

	function addMergeMethodDescriptions() {
		global $wgOut, $wgLang;
		$js = "wgMergeMethodDescriptions = {\n";
		foreach( array( 'primary', 'new', 'empty', 'password', 'mail', 'admin', 'login' ) as $method ) {
			$short = Xml::encodeJsVar( $wgLang->ucfirst( wfMsgHtml( "centralauth-merge-method-{$method}" ) ) );
			$desc = Xml::encodeJsVar( wfMsgWikiHtml( "centralauth-merge-method-{$method}-desc" ) );
			$js .= "\t'{$method}' : { 'short' : {$short}, 'desc' : {$desc} },\n";
		}
		$js .= "}";
		$wgOut->addInlineScript( $js );
	}

	function logAction( $action, $target, $reason = '', $params = array(), $suppressLog = false ) {
		$logType = $suppressLog ? 'suppress' : 'globalauth';	// Not centralauth because of some weird length limitiations
		$log = new LogPage( $logType );	
		$log->addEntry( $action, Title::newFromText( "User:{$target}@global" ), $reason, $params );
	}
}
