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

		$this->loadParameters();

		$wgOut->setPageTitle( wfMsg( 'globalblocking-block' ) );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );

		// We expect one error message, the "pages in the special namespace cannot be edited" one.
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

		$errorstr = '';

		if (is_array($errors) && count($errors)>0) {			
			foreach ( $errors as $error ) {
				if (is_array($error)) {
					$msg = array_shift($error);
				} else {
					$msg = $error;
					$error = array();
				}
				$errorstr .= Xml::tags( 'li', null, wfMsgExt( $msg, array( 'parseinline' ), $error ) );
			}
			
			$errorstr = wfMsgExt( 'globalblocking-block-errors', array( 'parse' ), array( count( $errors ) ) ) . Xml::tags( 'ul', null, $errorstr );
			
			$errorstr = Xml::tags( 'div', array( 'class' => 'error' ), $errorstr );
		}
		
		$this->form( $errorstr );
	}

	function loadParameters() {
		global $wgRequest;
		$this->mAddress = $wgRequest->getText( 'wpAddress' );
		$this->mReason = $wgRequest->getText( 'wpReason' );
		$this->mExpiry = $this->mExpirySelection = $wgRequest->getText( 'wpExpiry' );
		if ($this->mExpiry == 'other') {
			$this->mExpiry = $wgRequest->getText( 'wpExpiryOther' );
		}
		$this->mAnonOnly = $wgRequest->getCheck( 'wpAnonOnly' );
	}

	function trySubmit() {
		global $wgUser,$wgDBname,$wgOut;
		$errors = array();
		
		## Purge expired blocks.
		GlobalBlocking::purgeExpired();

		## Validate input
		$ip = IP::sanitizeIP( $this->mAddress );

		if (!IP::isIPAddress($ip)) {
			// Invalid IP address.
			$errors[] = array( 'globalblocking-block-ipinvalid', $ip );
		}

		$expiry = Block::parseExpiryInput( $this->mExpiry );
		
		if ( false === $expiry ) {
			$errors[] = array( 'globalblocking-block-expiryinvalid', $this->mExpiry );
		}
		
		if (GlobalBlocking::getGlobalBlockId($ip)) {
			$errors[] = array( 'globalblocking-block-alreadyblocked', $ip );
		}
	
		// Check for too-big ranges.
		list( $range_start, $range_end ) = IP::parseRange( $ip );
		
		if (substr( $range_start, 0, 4 ) != substr( $range_end, 0, 4 )) {
			// Range crosses a /16 boundary.
			$errors[] = array( 'globalblocking-block-bigrange', $ip );
		}
		
		// Normalise the range
		if ($range_start != $range_end) {
			$ip = Block::normaliseRange( $ip );
		}
		
		if (count($errors)>0)
			return $errors;

		// We're a-ok.
		$dbw = GlobalBlocking::getGlobalBlockingMaster();

		$row = array();
		$row['gb_address'] = $ip;
		$row['gb_by'] = $wgUser->getName();
		$row['gb_by_wiki'] = $wgDBname;
		$row['gb_reason'] = $this->mReason;
		$row['gb_timestamp'] = $dbw->timestamp(wfTimestampNow());
		$row['gb_anon_only'] = $this->mAnonOnly;
		$row['gb_expiry'] = Block::encodeExpiry($expiry, $dbw);
		list( $row['gb_range_start'], $row['gb_range_end'] ) = array( $range_start, $range_end );

		$dbw->insert( 'globalblocks', $row, __METHOD__ );

		// Log it.
		$logParams = array();
		$logParams[] = $this->mExpiry;
		if ($this->mAnonOnly)
			$logParams[] = wfMsgForContent( 'globalblocking-list-anononly' );

		$page = new LogPage( 'gblblock' );

		$page->addEntry( 'gblock', SpecialPage::getTitleFor( 'Contributions', $ip ), $this->mReason, $logParams );

		$wgOut->addWikitext( wfMsg('globalblocking-block-success', $ip ) );
		$wgOut->setSubtitle( wfMsg( 'globalblocking-block-successsub' ) );
		
		$link = $wgUser->getSkin()->makeKnownLinkObj( SpecialPage::getTitleFor( 'GlobalBlockList' ), wfMsg( 'globalblocking-return' ) );
		$wgOut->addHTML( $link );

		return array();
	}

	function form( $error ) {
		global $wgUser, $wgRequest,$wgScript,$wgOut;
		
		$form = '';

		// Introduction
		$wgOut->addWikiMsg( 'globalblocking-block-intro' );
		
		// Add errors
		$wgOut->addHTML( $error );

		$form .= Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'globalblocking-block-legend' ) );

		$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgScript, 'name' => 'uluser' ) );
		$form .= Xml::hidden( 'title',  SpecialPage::getTitleFor('GlobalBlock')->getPrefixedText() );

		$fields = array ();

		// Who to block
		$fields['ipaddress'] = Xml::input( 'wpAddress', 45, $this->mAddress );
		// Why to block them
		$fields['globalblocking-block-reason'] = Xml::input( 'wpReason', 45, $this->mReason );

		// How long to block them for
		if ( ( $dropdown = wfMsgNoTrans( 'globalblocking-expiry-options' ) ) != '-') {
			# Drop-down list
		} elseif ( ( $dropdown = wfMsgNoTrans( 'ipboptions' ) ) != '-' ) {
			# Also a drop-down list
		} else {
			$dropdown = false;
		}
		
		if ($dropdown == false ) {
			$fields['globalblocking-block-expiry'] = Xml::input( 'wpExpiry', 45, $this->mExpiry );
		} else {
			$fields['globalblocking-block-expiry'] = $this->buildExpirySelector( 'wpExpiry', 'wpExpiry', $this->mExpirySelection, $dropdown );
			$fields['globalblocking-block-expiry-otherfield'] = Xml::input( 'wpExpiryOther', 45, $this->mExpiry == $this->mExpirySelection ? '' : $this->mExpiry );
		}

		// Block all users, or just anonymous ones
		$fields['globalblocking-block-options'] = Xml::checkLabel( wfMsg( 'ipbanononly' ), 'wpAnonOnly', 'wpAnonOnly', $this->mAnonOnly );

		// Build a form.
		$form .= Xml::buildForm( $fields, 'globalblocking-block-submit' );

		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );

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
