<?php

class RevisionReview extends UnlistedSpecialPage {
	protected $form;
	protected $page;

	public function __construct() {
		parent::__construct( 'RevisionReview', 'review' );
	}

	public function execute( $par ) {
		$out = $this->getOutput();
		$user = $this->getUser();
		$request = $this->getRequest();

		$confirmed = $user->matchEditToken( $request->getVal( 'wpEditToken' ) );

		if ( !$user->isAllowed( 'review' ) ) {
			throw new PermissionsError( 'review' );
		}
		$block = $user->getBlock( !$confirmed );
		if ( $block ) {
			throw new UserBlockedError( $block );
		} elseif ( wfReadOnly() ) {
			throw new ReadOnlyError();
		}

		$this->setHeaders();

		# Our target page
		$this->page = Title::newFromURL( $request->getVal( 'target' ) );
		if ( !$this->page ) {
			$out->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}
		# Basic page permission checks...
		$permErrors = $this->page->getUserPermissionsErrors( 'review', $user, false );
		if ( !$permErrors ) {
			$permErrors = $this->page->getUserPermissionsErrors( 'edit', $user, false );
		}
		if ( $permErrors ) {
			$out->showPermissionsErrorPage( $permErrors, 'review' );
			return;
		}

		$this->form = new RevisionReviewForm( $user );
		$form = $this->form; // convenience

		$form->setPage( $this->page );
		# Param for sites with binary flagging
		$form->setApprove( $request->getCheck( 'wpApprove' ) );
		$form->setUnapprove( $request->getCheck( 'wpUnapprove' ) );
		$form->setReject( $request->getCheck( 'wpReject' ) );
		# Rev ID
		$form->setOldId( $request->getInt( 'oldid' ) );
		$form->setRefId( $request->getInt( 'refid' ) );
		# Special parameter mapping
		$form->setTemplateParams( $request->getVal( 'templateParams' ) );
		$form->setFileParams( $request->getVal( 'imageParams' ) );
		$form->setFileVersion( $request->getVal( 'fileVersion' ) );
		# Special token to discourage fiddling...
		$form->setValidatedParams( $request->getVal( 'validatedParams' ) );
		# Conflict handling
		$form->setLastChangeTime( $request->getVal( 'changetime' ) );
		# Session key
		$form->setSessionKey( $request->getSessionData( 'wsFlaggedRevsKey' ) );
		# Tag values
		foreach ( FlaggedRevs::getTags() as $tag ) {
			# This can be NULL if we uncheck a checkbox
			$val = $request->getInt( "wp$tag" );
			$form->setDim( $tag, $val );
		}
		# Log comment
		$form->setComment( $request->getText( 'wpReason' ) );
		$form->ready();

		# Review the edit if requested (POST)...
		if ( $request->wasPosted() ) {
			// Check the edit token...
			if ( !$confirmed ) {
				$out->addWikiText( wfMsg( 'sessionfailure' ) );
				$out->returnToMain( false, $this->page );
				return;
			}
			// Use confirmation screen for reject...
			if ( $form->getAction() == 'reject' && !$request->getBool( 'wpRejectConfirm' ) ) {
				$rejectForm = new RejectConfirmationFormUI( $form );
				list( $html, $status ) = $rejectForm->getHtml();
				// Success...
				if ( $status === true ) {
					$out->addHtml( $html );
				// Failure...
				} else {
					if ( $status === 'review_page_unreviewable' ) {
						$out->addWikiText( wfMsg( 'revreview-main' ) );
						return;
					} elseif ( $status === 'review_page_notexists' ) {
						$out->showErrorPage( 'internalerror', 'nopagetext' );
						return;
					} elseif ( $status === 'review_bad_oldid' ) {
						$out->showErrorPage( 'internalerror', 'revreview-revnotfound' );
					} else {
						$out->showErrorPage( 'internalerror', $status );
					}
					$out->returnToMain( false, $this->page );
				}
			// Otherwise submit...
			} else {
				$status = $form->submit();
				// Success...
				if ( $status === true ) {
					$out->setPageTitle( wfMsgHtml( 'actioncomplete' ) );
					if ( $form->getAction() === 'approve' ) {
						$out->addHTML( $this->approvalSuccessHTML( true ) );
					} elseif ( $form->getAction() === 'unapprove' ) {
						$out->addHTML( $this->deapprovalSuccessHTML( true ) );
					} elseif ( $form->getAction() === 'reject' ) {
						$out->redirect( $this->page->getFullUrl() );
					}
				// Failure...
				} else {
					if ( $status === 'review_page_unreviewable' ) {
						$out->addWikiText( wfMsg( 'revreview-main' ) );
						return;
					} elseif ( $status === 'review_page_notexists' ) {
						$out->showErrorPage( 'internalerror', 'nopagetext' );
						return;
					} elseif ( $status === 'review_denied' ) {
						$out->permissionRequired( 'badaccess-group0' ); // protected?
					} elseif ( $status === 'review_bad_key' ) {
						$out->permissionRequired( 'badaccess-group0' ); // fiddling
					} elseif ( $status === 'review_bad_oldid' ) {
						$out->showErrorPage( 'internalerror', 'revreview-revnotfound' );
					} elseif ( $status === 'review_not_flagged' ) {
						$out->redirect( $this->page->getFullUrl() ); // already unflagged
					} elseif ( $status === 'review_too_low' ) {
						$out->addWikiText( wfMsg( 'revreview-toolow' ) );
					} else {
						$out->showErrorPage( 'internalerror', $status );
					}
					$out->returnToMain( false, $this->page );
				}
			}
		// No form to view (GET)
		} else {
			$out->returnToMain( false, $this->page );
		}
	}

	protected function approvalSuccessHTML( $showlinks = false ) {
		$title = $this->form->getPage();
		# Show success message
		$s = "<div class='plainlinks'>";
		$s .= wfMsgExt( 'revreview-successful', 'parse',
			$title->getPrefixedText(), $title->getPrefixedUrl() );
		$s .= wfMsgExt( 'revreview-stable1', 'parse',
			$title->getPrefixedUrl(), $this->form->getOldId() );
		$s .= "</div>";
		# Handy links to special pages
		if ( $showlinks && $this->getUser()->isAllowed( 'unreviewedpages' ) ) {
			$s .= $this->getSpecialLinks();
		}
		return $s;
	}

	protected function deapprovalSuccessHTML( $showlinks = false ) {
		$title = $this->form->getPage();
		# Show success message
		$s = "<div class='plainlinks'>";
		$s .= wfMsgExt( 'revreview-successful2', 'parse',
			$title->getPrefixedText(), $title->getPrefixedUrl() );
		$s .= wfMsgExt( 'revreview-stable2', 'parse',
			$title->getPrefixedUrl(), $this->form->getOldId() );
		$s .= "</div>";
		# Handy links to special pages
		if ( $showlinks && $this->getUser()->isAllowed( 'unreviewedpages' ) ) {
			$s .= $this->getSpecialLinks();
		}
		return $s;
	}

	protected function getSpecialLinks() {
		$s = '<p>' . wfMsgHtml( 'returnto',
			Linker::linkKnown( SpecialPage::getTitleFor( 'UnreviewedPages' ) )
		) . '</p>';
		$s .= '<p>' . wfMsgHtml( 'returnto',
			Linker::linkKnown( SpecialPage::getTitleFor( 'PendingChanges' ) )
		) . '</p>';
		return $s;
	}

	public static function AjaxReview( /*$args...*/ ) {
		global $wgUser, $wgOut, $wgRequest;

		$args = func_get_args();
		if ( wfReadOnly() ) {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' ) .
				wfMsgExt( 'revreview-submission-invalid', 'parseinline' );
		}
		$tags = FlaggedRevs::getTags();
		// Make review interface object
		$form = new RevisionReviewForm( $wgUser );
		$title = null; // target page
		$editToken = ''; // edit token
		// Each ajax url argument is of the form param|val.
		// This means that there is no ugly order dependance.
		foreach ( $args as $arg ) {
			$set = explode( '|', $arg, 2 );
			if ( count( $set ) != 2 ) {
				return '<err#>' . wfMsgExt( 'revreview-failed', 'parseinline' ) .
					wfMsgExt( 'revreview-submission-invalid', 'parseinline' );
			}
			list( $par, $val ) = $set;
			switch( $par )
			{
				case "target":
					$title = Title::newFromURL( $val );
					break;
				case "oldid":
					$form->setOldId( $val );
					break;
				case "refid":
					$form->setRefId( $val );
					break;
				case "validatedParams":
					$form->setValidatedParams( $val );
					break;
				case "templateParams":
					$form->setTemplateParams( $val);
					break;
				case "imageParams":
					$form->setFileParams( $val );
					break;
				case "fileVersion":
					$form->setFileVersion( $val );
					break;
				case "wpApprove":
					$form->setApprove( $val );
					break;
				case "wpUnapprove":
					$form->setUnapprove( $val );
					break;
				case "wpReject":
					$form->setReject( $val );
					break;
				case "wpReason":
					$form->setComment( $val );
					break;
				case "changetime":
					$form->setLastChangeTime( $val );
					break;
				case "wpEditToken":
					$editToken = $val;
					break;
				default:
					$p = preg_replace( '/^wp/', '', $par ); // kill any "wp" prefix
					if ( in_array( $p, $tags ) ) {
						$form->setDim( $p, $val );
					}
					break;
			}
		}
		# Valid target title?
		if ( !$title ) {
			return '<err#>' . wfMsgExt( 'notargettext', 'parseinline' );
		}
		$form->setPage( $title );
		$form->setSessionKey( $wgRequest->getSessionData( 'wsFlaggedRevsKey' ) );

		$status = $form->ready(); // all params loaded
		# Check session via user token
		if ( !$wgUser->matchEditToken( $editToken ) ) {
			return '<err#>' . wfMsgExt( 'sessionfailure', 'parseinline' );
		}
		# Basic permission checks...
		$permErrors = $title->getUserPermissionsErrors( 'review', $wgUser, false );
		if ( !$permErrors ) {
			$permErrors = $title->getUserPermissionsErrors( 'edit', $wgUser, false );
		}
		if ( $permErrors ) {
			return '<err#>' . $wgOut->parse(
				$wgOut->formatPermissionsErrorMessage( $permErrors, 'review' )
			);
		}
		# Try submission...
		$status = $form->submit();
		# Success...
		if ( $status === true ) {
			# Sent new lastChangeTime TS to client for later submissions...
			$changeTime = $form->getNewLastChangeTime();
			if ( $form->getAction() === 'approve' ) { // approve
				return "<suc#><lct#$changeTime>";
			} elseif ( $form->getAction() === 'unapprove' ) { // de-approve
				return "<suc#><lct#$changeTime>";
			} elseif ( $form->getAction() === 'reject' ) { // revert
				return "<suc#><lct#$changeTime>";
			}
		# Failure...
		} else {
			return '<err#>' . wfMsgExt( 'revreview-failed', 'parse' ) .
				'<p>' . wfMsgHtml( $status ) . '</p>';
		}
	}
}
