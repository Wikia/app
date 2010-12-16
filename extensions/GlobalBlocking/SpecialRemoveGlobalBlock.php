<?php

class SpecialRemoveGlobalBlock extends SpecialPage {
	public $mAddress, $mReason;

	function __construct() {
		wfLoadExtensionMessages('GlobalBlocking');
		SpecialPage::SpecialPage( 'RemoveGlobalBlock', 'globalunblock' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;
		$this->setHeaders();

		$this->loadParameters();

		$wgOut->setPageTitle( wfMsg( 'globalblocking-unblock' ) );
		$wgOut->setSubtitle( GlobalBlocking::buildSubtitleLinks( 'RemoveGlobalBlock' ) );
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
		
		$wgOut->addWikiMsg( 'globalblocking-unblock-intro' );

		if (is_array($errors) && count($errors)>0) {
			$errorstr = '';
			
			foreach ( $errors as $error ) {
				if (is_array($error)) {
					$msg = array_shift($error);
				} else {
					$msg = $error;
					$error = array();
				}
				$errorstr .= Xml::tags( 'li', null, wfMsgExt( $msg, array( 'parseinline' ), $error ) );
			}
			
			$errorstr = Xml::tags( 'ul', array( 'class' => 'error' ), $errorstr );
			$errorstr = wfMsgExt( 'globalblocking-unblock-errors', array('parse'), array( count( $errors ) ) ) . $errorstr;
			$errorstr = Xml::tags( 'div', array( 'class' => 'error' ), $errorstr );
			$wgOut->addHTML( $errorstr );
		}
		
		$this->form( );

	}

	function loadParameters() {
		global $wgRequest;
		$this->mUnblockIP = trim($wgRequest->getText( 'address' ));
		$this->mReason = $wgRequest->getText( 'wpReason' );
		$this->mEditToken = $wgRequest->getText( 'wpEditToken' );
	}

	function trySubmit() {
		global $wgOut,$wgUser;
		$errors = array();
		$ip = $this->mUnblockIP;
		if (!IP::isIPAddress($ip) && strlen($ip)) {
			$errors[] = array('globalblocking-unblock-ipinvalid',$ip);
			$ip = '';
		}

		if (0==($id = GlobalBlocking::getGlobalBlockId( $ip ))) {
			$errors[] = array( 'globalblocking-notblocked', $ip );
		}

		if (count($errors)>0) {
			return $errors;
		}

		$dbw = GlobalBlocking::getGlobalBlockingMaster();
		$dbw->delete( 'globalblocks', array( 'gb_id' => $id ), __METHOD__ );

		$page = new LogPage( 'gblblock' );
		$page->addEntry( 'gunblock', Title::makeTitleSafe( NS_USER, $ip ), $this->mReason );

		$successmsg = wfMsgExt( 'globalblocking-unblock-unblocked', array( 'parse' ), $ip, $id );
		$wgOut->addHTML( $successmsg );

		$link = $wgUser->getSkin()->makeKnownLinkObj( SpecialPage::getTitleFor( 'GlobalBlockList' ), wfMsg( 'globalblocking-return' ) );
		$wgOut->addHTML( $link );

		$wgOut->setSubtitle(wfMsg('globalblocking-unblock-successsub'));

		return array();
	}

	function form( ) {
		global $wgScript,$wgRequest,$wgUser,$wgOut;

		$form = '';

		$form .= Xml::openElement( 'fieldset' ) . Xml::element( 'legend', null, wfMsg( 'globalblocking-unblock-legend' ) );
		$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgScript, 'name' => 'globalblock-unblock' ) );

		$form .= Xml::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$form .= Xml::hidden( 'action', 'unblock' );

		$fields = array();

		$fields['ipaddress'] = Xml::input( 'address', 45, $this->mUnblockIP );
		$fields['globalblocking-unblock-reason'] = Xml::input( 'wpReason', 45, $this->mReason );

		$form .= Xml::buildForm( $fields, 'globalblocking-unblock-submit' );

		$form .= Xml::hidden( 'wpEditToken', $wgUser->editToken() );

		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'fieldset' );

		$wgOut->addHTML( $form );
	}
}
