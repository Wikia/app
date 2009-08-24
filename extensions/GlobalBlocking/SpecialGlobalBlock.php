<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialGlobalBlock extends SpecialPage {
	public $mAddress, $mReason, $mExpiry, $mAnonOnly;

	function __construct() {
		wfLoadExtensionMessages('GlobalBlocking');
		SpecialPage::SpecialPage( 'GlobalBlock', 'globalblock' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;
		$this->setHeaders();

		$this->loadParameters( $par );

		$wgOut->setPageTitle( wfMsg( 'globalblocking-block' ) );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );

		if (!$this->userCanExecute( $wgUser )) {
			$this->displayRestrictionError();
			return;
		}

		$errors = '';

		if ($wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ))) {
			// They want to submit. Let's have a look.
			$errors = $this->trySubmit();
			if( !$errors ) {
				// Success!
				return;
			}
		}
		
		if ($this->mModifyForm) {
			$dbr = GlobalBlocking::getGlobalBlockingSlave();
			$block = $dbr->selectRow( 'globalblocks',
									'*',
									array( 'gb_address' => $this->mAddress ),
									__METHOD__ );
			if ($block->gb_expiry == 'infinity') {
				$this->mExpirySelection = 'indefinite';
			} else {
				$this->mExpiry = wfTimestamp( TS_ISO_8601, $block->gb_expiry );
			}
			$this->mAnonOnly = $block->gb_anon_only;
			$this->mReason = $block->gb_reason;
		}
		
		$errorstr = null;

		if (is_array($errors) && count($errors)>0) {
			$errorstr = $this->formatErrors( $errors );
		}
		
		$this->form( $errorstr );
	}
	
	function formatErrors( $errors ) {
		$errorstr = '';
		foreach ( $errors as $error ) {
			if (is_array($error)) {
				$msg = array_shift($error);
			} else {
				$msg = $error;
				$error = array();
			}
			$errorstr .= Xml::tags( 'li', null, wfMsgExt( $msg, array( 'parseinline' ), $error ) );
			
			// Special case
			if ($msg == 'globalblocking-block-alreadyblocked') {
				$this->mModifyForm = true;
			}
		}
		
		$errorstr = Xml::tags( 'ul', null, $errorstr );
		$header = wfMsgExt( 'globalblocking-block-errors',
								'parse',
								array(count( $errors ))
							);
		$errorstr = "$header\n$errorstr";
		
		$errorstr = Xml::tags( 'div', array( 'class' => 'error' ), $errorstr );
		
		return $errorstr;
	}

	function loadParameters( $par ) {
		global $wgRequest;
		$this->mAddress = trim( $wgRequest->getText( 'wpAddress' ) );
		if (!$this->mAddress)
			$this->mAddress = $par;
			
		$this->mReason = $wgRequest->getText( 'wpReason' );
		$this->mExpiry = $this->mExpirySelection = $wgRequest->getText( 'wpExpiry' );
		if ($this->mExpiry == 'other') {
			$this->mExpiry = $wgRequest->getText( 'wpExpiryOther' );
		}
		$this->mAnonOnly = $wgRequest->getBool( 'wpAnonOnly' );
		$this->mModify = $wgRequest->getBool( 'wpModify' );
		$this->mModifyForm = $wgRequest->getCheck( 'modify' );
	}

	function trySubmit() {
		global $wgOut, $wgUser;
		$options = array();
		$skin = $wgUser->getSkin();
		
		if ($this->mAnonOnly)
			$options[] = 'anon-only';
		if ($this->mModify)
			$options[] = 'modify';
		
		$errors = GlobalBlocking::block( $this->mAddress, $this->mReason, $this->mExpiry, $options );
		
		if ( count($errors) ) {
			return $errors;
		}
		
		if ($this->mModify) {
			$textMessage = 'globalblocking-modify-success';
			$subMessage = 'globalblocking-modify-successsub';
		} else {
			$textMessage = 'globalblocking-block-success';
			$subMessage = 'globalblocking-block-successsub';
		}
		
		$wgOut->addWikitext( wfMsg($textMessage, $this->mAddress ) );
		$wgOut->setSubtitle( wfMsg( $subMessage ) );
		
		$link = $skin->link( SpecialPage::getTitleFor( 'GlobalBlockList' ),
							wfMsg( 'globalblocking-return' ) );
		$wgOut->addHTML( $link );
		
		return array();
	}

	function form( $error ) {
		global $wgUser, $wgRequest,$wgScript,$wgOut;
		
		$form = '';

		// Introduction
		if ($this->mModifyForm) {
			$wgOut->addWikiMsg( 'globalblocking-modify-intro' );
		} else {
			$wgOut->addWikiMsg( 'globalblocking-block-intro' );
		}
		
		// Add errors
		$wgOut->addHTML( $error );

		$form .= Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'globalblocking-block-legend' ) );
		$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgScript, 'name' => 'uluser' ) );
		$form .= Xml::hidden( 'title',  SpecialPage::getTitleFor('GlobalBlock')->getPrefixedText() );

		$fields = array ();

		// Who to block
		$fields['ipaddress'] =
			Xml::input( 'wpAddress',
				45,
				$this->mAddress,
				array('id' => 'mw-globalblock-address' )
			);
		
		// Why to block them
		$fields['globalblocking-block-reason'] =
			Xml::input(
				'wpReason',
					45,
					$this->mReason,
					array( 'id' => 'mw-globalblock-reason' )
				);

		// How long to block them for
		if ( ( $dropdown = wfMsgNoTrans( 'globalblocking-expiry-options' ) ) != '-') {
			# Drop-down list
		} elseif ( ( $dropdown = wfMsgNoTrans( 'ipboptions' ) ) != '-' ) {
			# Also a drop-down list
		} else {
			$dropdown = false;
		}
		
		if ($dropdown == false ) {
			$fields['globalblocking-block-expiry'] =
				Xml::input(
					'wpExpiry',
					45,
					$this->mExpiry,
					array( 'id' => 'mw-globalblock-expiry' )
				);
		} else {
			$fields['globalblocking-block-expiry'] =
				$this->buildExpirySelector(
					'wpExpiry',
					'mw-globalblock-expiry-selector',
					$this->mExpirySelection,
					$dropdown
				);
			$fields['globalblocking-block-expiry-otherfield'] =
				Xml::input(
					'wpExpiryOther',
					45,
					$this->mExpiry == $this->mExpirySelection ? '' : $this->mExpiry,
					array( 'id' => 'mw-globalblock-expiry-other' )
				);
		}

		// Block all users, or just anonymous ones
		$fields['globalblocking-block-options'] =
			Xml::checkLabel(
				wfMsg( 'ipbanononly' ),
				'wpAnonOnly',
				'mw-globalblock-anon-only',
				$this->mAnonOnly
			);

		// Build a form.
		$submitMsg = $this->mModifyForm
			? 'globalblocking-modify-submit' : 'globalblocking-block-submit';
		$form .= Xml::buildForm( $fields, $submitMsg );

		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );
		if ($this->mModifyForm)
			$form .= Xml::hidden( 'wpModify', 1 );

		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'fieldset' );

		$wgOut->addHTML( $form );
	}

	function buildExpirySelector( $name, $id = null, $selected = null, $expiryOptions = null ) {
		$selector = '';

		if ($id == null) { $id = $name; }
		if ($selected == null) { $selected = 'other'; }

		$attribs = array( 'id' => $id, 'name' => $name, 'onchange' => 'considerChangingExpiryFocus()' );

		$selector .= Xml::openElement( 'select', $attribs );

		foreach (explode(',', $expiryOptions) as $option) {
			if ( strpos($option, ":") === false ) $option = "$option:$option";
			list($show, $value) = explode(":", $option);
			$show = htmlspecialchars($show);
			$value = htmlspecialchars($value);
			$selector .= Xml::option( $show, $value, $value == $selected );
		}

		$selector .= Xml::option( wfMsg( 'globalblocking-block-expiry-other' ), 'other', 'other' == $selected );

		$selector .= Xml::closeElement( 'select' );

		return $selector;
	}
}
