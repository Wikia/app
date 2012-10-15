<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialGlobalBlock extends SpecialPage {
	public $mAddress, $mReason, $mExpiry, $mAnonOnly;

	function __construct() {
		parent::__construct( 'GlobalBlock', 'globalblock' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;
		$this->setHeaders();

		$this->loadParameters( $par );

		$wgOut->setPageTitle( wfMsg( 'globalblocking-block' ) );
		$wgOut->setSubtitle( GlobalBlocking::buildSubtitleLinks( 'GlobalBlock' ) );
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

		if ( GlobalBlocking::getGlobalBlockId( $this->mAddress ) ) {
			$this->mModifyForm = true;
		}

		if ( $this->mModifyForm ) {
			$dbr = GlobalBlocking::getGlobalBlockingSlave();
			$block = $dbr->selectRow( 'globalblocks',
									'*',
									array( 'gb_address' => $this->mAddress ),
									__METHOD__ );
			if ( $block ) {
				if ( $block->gb_expiry == 'infinity' ) {
					$this->mExpirySelection = 'indefinite';
				} else {
					$this->mExpiry = wfTimestamp( TS_ISO_8601, $block->gb_expiry );
				}
				$this->mAnonOnly = $block->gb_anon_only;
				$this->mReason = $block->gb_reason;
			}
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
		$this->mReasonList = $wgRequest->getText( 'wpBlockReasonList' );
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

		$reasonstr = $this->mReasonList;
		if( $reasonstr != 'other' && $this->mReason != '' ) {
			// Entry from drop down menu + additional comment
			$reasonstr .= wfMsgForContent( 'colon-separator' ) . $this->mReason;
		} elseif( $reasonstr == 'other' ) {
			$reasonstr = $this->mReason;
		}

		$errors = GlobalBlocking::block( $this->mAddress, $reasonstr, $this->mExpiry, $options );

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
		global $wgUser, $wgScript, $wgOut;

		$form = '';

		// Introduction
		if ($this->mModifyForm) {
			$wgOut->addWikiMsg( 'globalblocking-modify-intro' );
		} else {
			$wgOut->addWikiMsg( 'globalblocking-block-intro' );
		}

		// Add errors
		$wgOut->addHTML( $error );

		$form .= Xml::fieldset( wfMsg( 'globalblocking-block-legend' ) );
		$form .= Xml::openElement( 'form',
									array( 'method' => 'post',
											'action' => $wgScript,
											'name' => 'uluser',
											'id' => 'mw-globalblock-form' ) );
		$form .= Html::hidden( 'title',  SpecialPage::getTitleFor('GlobalBlock')->getPrefixedText() );

		$fields = array();

		// Who to block
		$fields['globalblocking-ipaddress'] =
			Xml::input( 'wpAddress',
				45,
				$this->mAddress,
				array('id' => 'mw-globalblock-address' )
			);

		// How long to block them for
		$dropdown = wfMsgForContentNoTrans( 'globalblocking-expiry-options' );
		if ( $dropdown === '' || $dropdown == '-' ) {
			// 'globalblocking-expiry-options' is empty, try the message from core
			$dropdown = wfMsgForContentNoTrans( 'ipboptions' );
			if ( wfEmptyMsg( 'ipboptions', $dropdown ) || $dropdown === '' || $dropdown == '-' ) {
				// 'ipboptions' is empty too. Do not show a dropdown
				// Do not assume that 'ipboptions' exists forever, therefore check with wfEmptyMsg too
				$dropdown = false;
			}
		}

		if ( $dropdown == false ) {
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
					array( 'id' => 'mw-globalblock-expiry-selector-other' )
				);
		}

		// Why to block them
		$fields['globalblocking-block-reason'] =
			Xml::listDropDown(
				'wpBlockReasonList',
				wfMsgForContent( 'globalblocking-block-reason-dropdown' ),
				wfMsgForContent( 'globalblocking-block-reasonotherlist' ),
				$this->mReasonList,
				'mw-globalblock-reasonlist'
			);

		$fields['globalblocking-block-otherreason'] =
			Xml::input(
				'wpReason',
					45,
					$this->mReason,
					array( 'id' => 'mw-globalblock-reason' )
				);

		// Block all users, or just anonymous ones
		$fields['globalblocking-block-options'] =
			Xml::checkLabel(
				wfMsg( 'globalblocking-ipbanononly' ),
				'wpAnonOnly',
				'mw-globalblock-anon-only',
				$this->mAnonOnly
			);

		// Build a form.
		$submitMsg = $this->mModifyForm
			? 'globalblocking-modify-submit' : 'globalblocking-block-submit';
		$form .= Xml::buildForm( $fields, $submitMsg );

		$form .= Html::hidden( 'wpEditToken', $wgUser->editToken() );
		if ($this->mModifyForm)
			$form .= Html::hidden( 'wpModify', 1 );

		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'fieldset' );

		#FIXME: make this actually use HTMLForm, instead of just its JavaScript
		$wgOut->addModules( 'mediawiki.htmlform' );

		$wgOut->addHTML( $form );

		// Show loglist of previous blocks
		if ( $this->mAddress ) {
			$title = Title::makeTitleSafe( NS_USER, $this->mAddress );
			LogEventsList::showLogExtract(
				$wgOut,
				'gblblock',
				$title->getPrefixedText(),
				'',
				array(
					'lim' => 10,
					'msgKey' => 'globalblocking-showlog',
					'showIfEmpty' => false
				)
			);
		}
	}

	function buildExpirySelector( $name, $id = null, $selected = null, $expiryOptions = null ) {
		$selector = '';

		if ($id == null) { $id = $name; }
		if ($selected == null) { $selected = 'other'; }

		$attribs = array(
			'id' => $id,
			'name' => $name,
			'class' => 'mw-htmlform-select-or-other' ); # FIXME: make this actually use HTMLForm

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
