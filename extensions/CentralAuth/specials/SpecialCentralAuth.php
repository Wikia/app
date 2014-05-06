<?php
class SpecialCentralAuth extends SpecialPage {
	var $mUserName, $mCanUnmerge, $mCanLock, $mCanOversight, $mCanEdit;

	/**
	 * @var CentralAuthUser
	 */
	var $mGlobalUser;

	var $mAttachedLocalAccounts, $mUnattachedLocalAccounts;

	var $mMethod, $mPosted, $mWikis;

	function __construct() {
		parent::__construct( 'CentralAuth' );
	}

	function execute( $subpage ) {
		global $wgContLang;
		$this->setHeaders();

		$this->mCanUnmerge = $this->getUser()->isAllowed( 'centralauth-unmerge' );
		$this->mCanLock = $this->getUser()->isAllowed( 'centralauth-lock' );
		$this->mCanOversight = $this->getUser()->isAllowed( 'centralauth-oversight' );
		$this->mCanEdit = $this->mCanUnmerge || $this->mCanLock || $this->mCanOversight;

		$this->getOutput()->addModules( 'ext.centralauth' );
		$this->getOutput()->addModuleStyles( 'ext.centralauth.noflash' );
		$this->getOutput()->addJsConfigVars( 'wgMergeMethodDescriptions', $this->getMergeMethodDescriptions() );

		$this->mUserName =
			trim(
				str_replace( '_', ' ',
					$this->getRequest()->getText( 'target', $subpage ) ) );

		$this->mUserName = $wgContLang->ucfirst( $this->mUserName );

		$this->mPosted = $this->getRequest()->wasPosted();
		$this->mMethod = $this->getRequest()->getVal( 'wpMethod' );
		$this->mWikis = (array)$this->getRequest()->getArray( 'wpWikis' );

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
			$this->getOutput()->addWikiMsg( 'centralauth-admin-intro' );
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
		if ( $this->mCanEdit && $this->mPosted ) {
			$continue = $this->doSubmit();
		}

		$this->mAttachedLocalAccounts = $this->mGlobalUser->queryAttached();
		$this->mUnattachedLocalAccounts = $this->mGlobalUser->queryUnattached();

		$this->showUsernameForm();
		if ( $continue ) {
			$this->showInfo();
			if ( $this->mCanLock ) {
				$this->showStatusForm();
			}
			if ( $this->mCanUnmerge ) {
				$this->showActionForm( 'delete' );
			}
			if ( $this->mCanEdit ) {
				$this->showLogExtract();
			}
			$this->showWikiLists();
		}
	}

	/**
	 * @return bool Returns true if the normal form should be displayed
	 */
	function doSubmit() {
		$deleted = false;
		$globalUser = $this->mGlobalUser;

		if ( !$this->getUser()->matchEditToken( $this->getRequest()->getVal( 'wpEditToken' ) ) ) {
			$this->showError( 'centralauth-token-mismatch' );
		} elseif ( $this->mMethod == 'unmerge' && $this->mCanUnmerge ) {
			$status = $globalUser->adminUnattach( $this->mWikis );
			if ( !$status->isGood() ) {
				$this->showStatusError( $status->getWikiText() );
			} else {
				$this->showSuccess( 'centralauth-admin-unmerge-success',
					$this->getLanguage()->formatNum( $status->successCount ),
					/* deprecated */ $status->successCount );
			}
		} elseif ( $this->mMethod == 'delete' && $this->mCanUnmerge ) {
			$status = $globalUser->adminDelete();
			if ( !$status->isGood() ) {
				$this->showStatusError( $status->getWikiText() );
			} else {
				$this->showSuccess( 'centralauth-admin-delete-success', $this->mUserName );
				$deleted = true;
				$this->logAction( 'delete', $this->mUserName, $this->getRequest()->getVal( 'reason' ) );
			}
		} elseif ( $this->mMethod == 'set-status' && $this->mCanLock ) {
			$setLocked = $this->getRequest()->getBool( 'wpStatusLocked' );
			$setHidden = $this->getRequest()->getVal( 'wpStatusHidden' );
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
			if ( !in_array( $setHidden, $hiddenLevels ) )
				$setHidden = '';

			if ( !$isLocked && $setLocked ) {
				$lockStatus = $globalUser->adminLock();
				$added[] = wfMsgForContent( 'centralauth-log-status-locked' );
			} elseif ( $isLocked && !$setLocked ) {
				$lockStatus = $globalUser->adminUnlock();
				$removed[] = wfMsgForContent( 'centralauth-log-status-locked' );
			}

			$reason = $this->getRequest()->getText( 'wpReasonList' );
			$reasonDetail = $this->getRequest()->getText( 'wpReason' );
			if ( $reason == 'other' ) {
				$reason = $reasonDetail;
			} elseif ( $reasonDetail ) {
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
						if ( $oldHiddenLevel == CentralAuthUser::HIDDEN_OVERSIGHT )
							$removed[] = wfMsgForContent( 'centralauth-log-status-oversighted' );
						break;
					case CentralAuthUser::HIDDEN_OVERSIGHT:
						$added[] = wfMsgForContent( 'centralauth-log-status-oversighted' );
						if ( $oldHiddenLevel == CentralAuthUser::HIDDEN_LISTS )
							$removed[] = wfMsgForContent( 'centralauth-log-status-hidden' );
						break;
				}

				if ( $setHidden == CentralAuthUser::HIDDEN_OVERSIGHT )
					$globalUser->suppress( $reason );
				elseif ( $oldHiddenLevel == CentralAuthUser::HIDDEN_OVERSIGHT )
					$globalUser->unsuppress( $reason );
			}

			$good =
				( is_null( $lockStatus ) || $lockStatus->isGood() ) &&
				( is_null( $hideStatus ) || $hideStatus->isGood() );

			// Logging etc
			if ( $good && ( count( $added ) || count( $removed ) ) ) {
				$added = count( $added ) ?
					implode( ', ', $added ) : wfMsgForContent( 'centralauth-log-status-none' );
				$removed = count( $removed ) ?
					implode( ', ', $removed ) : wfMsgForContent( 'centralauth-log-status-none' );

				$this->logAction(
									'setstatus',
									$this->mUserName,
									$reason,
									array( $added, $removed ),
									$setHidden == CentralAuthUser::HIDDEN_OVERSIGHT
								);
				$this->showSuccess( 'centralauth-admin-setstatus-success', $this->mUserName );
			} elseif ( !$good ) {
				if ( !is_null( $lockStatus ) && !$lockStatus->isGood() ) {
					$this->showStatusError( $lockStatus->getWikiText() );
				}
				if ( !is_null( $hideStatus ) && !$hideStatus->isGood() ) {
					$this->showStatusError( $hideStatus->getWikiText() );
				}
			}
		} else {
			$this->showError( 'centralauth-admin-bad-input' );
		}
		return !$deleted;
	}

	/**
	 * @param $wikitext string
	 */
	function showStatusError( $wikitext ) {
		$wrap = Xml::tags( 'div', array( 'class' => 'error' ), $wikitext );
		$this->getOutput()->addHTML( $this->getOutput()->parse( $wrap, /*linestart*/true, /*uilang*/true ) );
	}

	function showError( /* varargs */ ) {
		$args = func_get_args();
		$this->getOutput()->wrapWikiMsg( '<div class="error">$1</div>', $args );
	}

	function showSuccess( /* varargs */ ) {
		$args = func_get_args();
		$this->getOutput()->wrapWikiMsg( '<div class="success">$1</div>', $args );
	}

	function showUsernameForm() {
		global $wgScript;
		$lookup = $this->mCanEdit ?
			wfMsg( 'centralauth-admin-lookup-rw' ) :
			wfMsg( 'centralauth-admin-lookup-ro' );
		$this->getOutput()->addHTML(
			Xml::openElement( 'form', array(
				'method' => 'get',
				'action' => $wgScript ) ) .
			'<fieldset>' .
			Xml::element( 'legend', array(), wfMsg( 'centralauth-admin-manage' ) ) .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
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

	/**
	 * @param $span
	 * @return String
	 */
	function prettyTimespan( $span ) {
		$units = array(
			'seconds' => 60,
			'minutes' => 60,
			'hours' => 24,
			'days' => 30.417,
			'months' => 12,
			'years' => 1 );
		foreach ( $units as $unit => $chunk ) {
			// Used messaged (to make sure that grep finds them):
			// 'centralauth-seconds-ago', 'centralauth-minutes-ago', 'centralauth-hours-ago'
			// 'centralauth-days-ago', 'centralauth-months-ago', 'centralauth-years-ago'
			if ( $span < 2 * $chunk ) {
				return wfMsgExt( "centralauth-$unit-ago", 'parsemag', $this->getLanguage()->formatNum( $span ) );
			}
			$span = intval( $span / $chunk );
		}
		return wfMsgExt( "centralauth-$unit-ago", 'parsemag', $this->getLanguage()->formatNum( $span ) );
	}

	function showInfo() {
		$globalUser = $this->mGlobalUser;

		$reg = $globalUser->getRegistration();
		$age = $this->prettyTimespan( wfTimestamp( TS_UNIX ) - wfTimestamp( TS_UNIX, $reg ) );
		$attribs = array(
			'id' => $globalUser->getId(),
			'registered' => htmlspecialchars( $this->getLanguage()->timeanddate( $reg, true ) . " ($age)" ),
			'home' => $this->determineHomeWiki(),
			'editcount' => htmlspecialchars( $this->getLanguage()->formatNum( $this->evaluateTotalEditcount() ) ),
			'locked' => wfMsgHtml( $globalUser->isLocked() ? 'centralauth-admin-yes' : 'centralauth-admin-no' ),
			'hidden' => $this->formatHiddenLevel( $globalUser->getHiddenLevel() )
		);
		$out = '<fieldset id="mw-centralauth-info">';
		$out .= '<legend>' . wfMsgHtml( 'centralauth-admin-info-header' ) . '</legend><ul>';
		foreach ( $attribs as $tag => $data ) {
			$out .= '<li><strong>' . wfMsgHtml( "centralauth-admin-info-$tag" ) . '</strong> ' .
				$data . '</li>';
		}
		$out .= '</ul></fieldset>';
		$this->getOutput()->addHTML( $out );
	}

	function showWikiLists() {
		$merged = $this->mAttachedLocalAccounts;
		$remainder = $this->mUnattachedLocalAccounts;

		$legend = $this->mCanUnmerge ?
			wfMsgHtml( 'centralauth-admin-list-legend-rw' ) :
			wfMsgHtml( 'centralauth-admin-list-legend-ro' );

		$this->getOutput()->addHTML( "<fieldset><legend>{$legend}</legend>" );
		$this->getOutput()->addHTML( $this->listHeader() );
		$this->getOutput()->addHTML( $this->listMerged( $merged ) );
		if ( $remainder ) {
			$this->getOutput()->addHTML( $this->listRemainder( $remainder ) );
		}
		$this->getOutput()->addHTML( $this->listFooter() );
		$this->getOutput()->addHTML( '</fieldset>' );
	}

	/**
	 * @return string
	 */
	function listHeader() {
		return
			Xml::openElement( 'form',
				array(
					'method' => 'post',
					'action' =>
						$this->getTitle( $this->mUserName )->getLocalUrl( 'action=submit' ),
					'id' => 'mw-centralauth-merged' ) ) .
			Html::hidden( 'wpMethod', 'unmerge' ) .
			Html::hidden( 'wpEditToken', $this->getUser()->getEditToken() ) .
			Xml::openElement( 'table', array( 'class' => 'wikitable sortable mw-centralauth-wikislist' ) ) . "\n" .
			'<thead><tr>' .
				( $this->mCanUnmerge ? '<th></th>' : '' ) .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-localwiki' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-attached-on' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-method' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-blocked' ) . '</th>' .
				'<th>' . wfMsgHtml( 'centralauth-admin-list-editcount' ) . '</th>' .
			'</tr></thead>' .
			'<tbody>';
	}

	/**
	 * @return string
	 */
	function listFooter() {
		$footer = '';
		if ( $this->mCanUnmerge )
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

	/**
	 * @param $list
	 * @return string
	 */
	function listMerged( $list ) {
		ksort( $list );
		return implode( "\n", array_map( array( $this, 'listMergedWikiItem' ), $list ) );
	}

	/**
	 * @param $list
	 * @return string
	 */
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
		return implode( '\n', $rows );
	}

	/**
	 * @param $row
	 * @return string
	 */
	function listMergedWikiItem( $row ) {
		if ( $row === null ) {
			// https://bugzilla.wikimedia.org/show_bug.cgi?id=28767
			// It seems sometimes local accounts aren't correctly created
			// Revisiting the wiki solves the issue
			return '';
		}
		return '<tr>' .
			( $this->mCanUnmerge ? '<td>' . $this->adminCheck( $row['wiki'] ) . '</td>' : '' ) .
			'<td>' . $this->foreignUserLink( $row['wiki'] ) . '</td>' .
			'<td>' .
				// invisible, to make this column sortable
				Html::element( 'span', array( 'style' => 'display: none' ), htmlspecialchars( $row['attachedTimestamp'] ) ) .
				// visible date and time in users preference
				htmlspecialchars( $this->getLanguage()->timeanddate( $row['attachedTimestamp'], true ) ) .
			'</td>' .
			'<td style="text-align: center">' . $this->formatMergeMethod( $row['attachedMethod'] ) . '</td>' .
			'<td>' . $this->formatBlockStatus( $row ) . '</td>' .
			'<td style="text-align: right">' . $this->formatEditcount( $row ) . '</td>' .
			'</tr>';
	}

	/**
	 * @param $method
	 * @return string
	 */
	function formatMergeMethod( $method ) {
		global $wgExtensionAssetsPath;
		
		$brief = wfMessage( 'centralauth-merge-method-{$method}' )->text();
		$html = 
			Html::element(
				'img', array(
					'src' => "{$wgExtensionAssetsPath}/CentralAuth/icons/merged-{$method}.png",
					'alt' => $brief,
					'title' => $brief,
				)
			)
			. Html::element(
				'span', array(
					'class' => 'merge-method-help',
					'title' => $brief,
					'data-centralauth-mergemethod' => $method
				),
				'(?)'
			);

		return $html;
	}

	/**
	 * @param $row
	 * @return String
	 */
	function formatBlockStatus( $row ) {
		if ( $row['blocked'] ) {
			if ( $row['block-expiry'] == 'infinity' ) {
			$reason = $row['block-reason'];
				return wfMsgExt( 'centralauth-admin-blocked-indef', 'parseinline', array( $reason ) );
			} else {
				$expiry = $this->getLanguage()->timeanddate( $row['block-expiry'], true );
				$expiryd = $this->getLanguage()->date( $row['block-expiry'], true );
				$expiryt = $this->getLanguage()->time( $row['block-expiry'], true );
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

	/**
	 * @param $row
	 * @return string
	 * @throws MWException
	 */
	function formatEditcount( $row ) {
		$wiki = WikiMap::getWiki( $row['wiki'] );
		if ( !$wiki ) {
			throw new MWException( "Invalid wiki: {$row['wiki']}" );
		}
		$wikiname = $wiki->getDisplayName();
		$editCount = $this->getLanguage()->formatNum( intval( $row['editCount'] ) );
		return $this->foreignLink(
			$row['wiki'],
			'Special:Contributions/' . $this->mUserName,
			$editCount,
			wfMsgExt( 'centralauth-foreign-contributions', 'parseinline', $editCount, $wikiname )
		);
	}

	/**
	 * @param $level
	 * @return String
	 */
	function formatHiddenLevel( $level ) {
		switch( $level ) {
			case CentralAuthUser::HIDDEN_NONE:
				return wfMsgHtml( 'centralauth-admin-no' );
			case CentralAuthUser::HIDDEN_LISTS:
				return wfMsgHtml( 'centralauth-admin-hidden-list' );
			case CentralAuthUser::HIDDEN_OVERSIGHT:
				return wfMsgHtml( 'centralauth-admin-hidden-oversight' );
		}
		return '';
	}

	/**
	 * @param $element
	 * @param $cols
	 * @return string
	 */
	function tableRow( $element, $cols ) {
		return "<tr><$element>" .
			implode( "</$element><$element>", $cols ) .
			"</$element></tr>";
	}

	/**
	 * @param $wikiID
	 * @param $title
	 * @param $text
	 * @param string $hint
	 * @param string $params
	 * @return string
	 * @throws MWException
	 */
	function foreignLink( $wikiID, $title, $text, $hint = '', $params = '' ) {
		if ( $wikiID instanceof WikiReference ) {
			$wiki = $wikiID;
		} else {
			$wiki = WikiMap::getWiki( $wikiID );
			if ( !$wiki ) {
				throw new MWException( "Invalid wiki: $wikiID" );
			}
		}

		$url = $wiki->getFullUrl( $title );
		if ( $params ) {
			$url .= '?' . $params;
		}
		return Xml::element( 'a',
			array(
				'href' => $url,
				'title' => $hint,
			),
			$text );
	}

	/**
	 * @param $wikiID
	 * @return string
	 * @throws MWException
	 */
	function foreignUserLink( $wikiID ) {
		$wiki = WikiMap::getWiki( $wikiID );
		if ( !$wiki ) {
			throw new MWException( "Invalid wiki: $wikiID" );
		}

		$wikiname = $wiki->getDisplayName();
		return $this->foreignLink(
			$wiki,
			'User:' . $this->mUserName,
			$wikiname,
			wfMsg( 'centralauth-foreign-link', $this->mUserName, $wikiname ) );
	}

	/**
	 * @param $wikiID
	 * @return string
	 */
	function adminCheck( $wikiID ) {
		return Xml::check( 'wpWikis[]', false, array( 'value' => $wikiID ) );
	}

	/**
	 * @param $action String: Only 'delete' supported
	 */
	function showActionForm( $action ) {
		$this->getOutput()->addHTML(
			# to be able to find messages: centralauth-admin-delete-title,
			# centralauth-admin-delete-description, centralauth-admin-delete-button
			Xml::fieldset( wfMsg( "centralauth-admin-{$action}-title" ) ) .
			Xml::openElement( 'form', array(
				'method' => 'POST',
				'action' => $this->getTitle()->getFullUrl( 'target=' . urlencode( $this->mUserName ) ),
				'id' => "mw-centralauth-$action" ) ) .
			Html::hidden( 'wpMethod', $action ) .
			Html::hidden( 'wpEditToken', $this->getUser()->getEditToken() ) .
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
		$form = '';
		$form .= Xml::fieldset( wfMsg( 'centralauth-admin-status' ) );
		$form .= Html::hidden( 'wpMethod', 'set-status' );
		$form .= Html::hidden( 'wpEditToken', $this->getUser()->getEditToken() );
		$form .= wfMsgExt( 'centralauth-admin-status-intro', 'parse' );

		// Radio buttons
		$radioLocked =
			Xml::radioLabel(
				wfMsgExt( 'centralauth-admin-status-locked-no', array( 'parseinline' ) ),
				'wpStatusLocked',
				'0',
				'mw-centralauth-status-locked-no',
				!$this->mGlobalUser->isLocked() ) .
			'<br />' .
			Xml::radioLabel(
				wfMsgExt( 'centralauth-admin-status-locked-yes', array( 'parseinline' ) ),
				'wpStatusLocked',
				'1',
				'mw-centralauth-status-locked-yes',
				$this->mGlobalUser->isLocked() );
		$radioHidden =
			Xml::radioLabel(
				wfMsgExt( 'centralauth-admin-status-hidden-no', array( 'parseinline' ) ),
				'wpStatusHidden',
				CentralAuthUser::HIDDEN_NONE,
				'mw-centralauth-status-hidden-no',
				$this->mGlobalUser->getHiddenLevel() == CentralAuthUser::HIDDEN_NONE ) .
			'<br />' .
			Xml::radioLabel(
				wfMsgExt( 'centralauth-admin-status-hidden-list', array( 'parseinline' ) ),
				'wpStatusHidden',
				CentralAuthUser::HIDDEN_LISTS,
				'mw-centralauth-status-hidden-list',
				$this->mGlobalUser->getHiddenLevel() == CentralAuthUser::HIDDEN_LISTS ) .
			'<br />';
		if ( $this->mCanOversight ) {
			$radioHidden .= Xml::radioLabel(
				wfMsgExt( 'centralauth-admin-status-hidden-oversight', array( 'parseinline' ) ),
				'wpStatusHidden',
				CentralAuthUser::HIDDEN_OVERSIGHT,
				'mw-centralauth-status-hidden-oversight',
				$this->mGlobalUser->getHiddenLevel() == CentralAuthUser::HIDDEN_OVERSIGHT
			);
		}

		// Reason
		$reasonList = Xml::listDropDown(
			'wpReasonList',
			wfMsgForContent( 'centralauth-admin-status-reasons' ),
			wfMsgForContent( 'ipbreasonotherlist' )
		);
		$reasonField = Xml::input( 'wpReason', 45, false );

		$form .= Xml::buildForm(
			array(
				'centralauth-admin-status-locked' => $radioLocked,
				'centralauth-admin-status-hidden' => $radioHidden,
				'centralauth-admin-reason' => $reasonList,
				'centralauth-admin-reason-other' => $reasonField ),
				'centralauth-admin-status-submit'
		);

		$form .= '</fieldset>';
		$form = Xml::tags(
			'form',
			array(
				'method' => 'POST',
				'action' => $this->getTitle()->getFullURL(
					array( 'target' => $this->mUserName )
				),
			),
			$form
		);
		$this->getOutput()->addHTML( $form );
	}

	/**
	 *
	 */
	function showLogExtract() {
		$user = $this->mGlobalUser->getName();
		$text = '';
		$numRows = LogEventsList::showLogExtract(
			$text,
			array( 'globalauth', 'suppress' ),
			Title::newFromText( "User:{$user}@global" )->getPrefixedText(),
			'',
			array( 'showIfEmpty' => true ) );
		if ( $numRows ) {
			$this->getOutput()->addHTML( Xml::fieldset( wfMsg( 'centralauth-admin-logsnippet' ), $text ) );
		}
	}

	/**
	 * @return int|string
	 */
	function determineHomeWiki() {
		foreach ( $this->mAttachedLocalAccounts as $wiki => $acc ) {
			if ( $acc['attachedMethod'] == 'primary' || $acc['attachedMethod'] == 'new' ) {
				return $this->foreignUserLink( $wiki );
			}
		}

		// Home account can be renamed or unmerged
		return wfMsgHtml( 'centralauth-admin-nohome' );
	}

	/**
	 * @return int
	 */
	function evaluateTotalEditcount() {
		$total = 0;
		foreach ( $this->mAttachedLocalAccounts as $acc ) {
			$total += $acc['editCount'];
		}
		return $total;
	}

	function getMergeMethodDescriptions() {
		$mergeMethodDescriptions = array();
		foreach ( array( 'primary', 'new', 'empty', 'password', 'mail', 'admin', 'login' ) as $method ) {
			$mergeMethodDescriptions[$method] = array(
				'short' => $this->getLanguage()->ucfirst( wfMsgHtml( "centralauth-merge-method-{$method}" ) ),
				'desc' => wfMsgWikiHtml( "centralauth-merge-method-{$method}-desc" )
			);
		}
		return $mergeMethodDescriptions;
	}

	/**
	 * @param $action
	 * @param $target
	 * @param $reason string
	 * @param $params array
	 * @param $suppressLog bool
	 */
	function logAction( $action, $target, $reason = '', $params = array(), $suppressLog = false ) {
		$logType = $suppressLog ? 'suppress' : 'globalauth';	// Not centralauth because of some weird length limitiations
		$log = new LogPage( $logType );
		$log->addEntry( $action, Title::newFromText( "User:{$target}@global" ), $reason, $params );
	}
}
