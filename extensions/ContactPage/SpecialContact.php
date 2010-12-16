<?php
/**
 * Speclial:Contact, a contact form for visitors.
 * Based on SpecialEmailUser.php
 *
 * @file
 * @ingroup SpecialPage
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

/**
 * Provides the contact form
 * @ingroup SpecialPage
 */
class SpecialContact extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Contact' );
	}

	/**
	 * Main execution function
	 *
	 * @param $par Mixed: Parameters passed to the page
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgEnableEmail, $wgContactUser;

		wfLoadExtensionMessages( 'ContactPage' );

		if( !$wgEnableEmail || !$wgContactUser ) {
			$wgOut->showErrorPage( 'nosuchspecialpage', 'nospecialpagetext' );
			return;
		}

		$action = $wgRequest->getVal( 'action' );

		$nu = User::newFromName( $wgContactUser );
		if( is_null( $nu ) || !$nu->canReceiveEmail() ) {
			wfDebug( "Target is invalid user or can't receive.\n" );
			$wgOut->showErrorPage( 'noemailtitle', 'noemailtext' );
			return;
		}

		$f = new EmailContactForm( $nu );

		if ( 'success' == $action ) {
			wfDebug( __METHOD__ . ": success.\n" );
			$f->showSuccess();
		} elseif ( 'submit' == $action && $wgRequest->wasPosted() && $f->hasAllInfo() ) {
			$token = $wgRequest->getVal( 'wpEditToken' );

			if( $wgUser->isAnon() ) {
				# Anonymous users may not have a session
				# open. Check for suffix anyway.
				$tokenOk = ( EDIT_TOKEN_SUFFIX == $token );
			} else {
				$tokenOk = $wgUser->matchEditToken( $token );
			}

			if ( !$tokenOk ) {
				wfDebug( __METHOD__ . ": bad token (" . ( $wgUser->isAnon() ? 'anon' : 'user' ) . "): $token\n" );
				$wgOut->addWikiMsg( 'sessionfailure' );
				$f->showForm();
			} elseif ( !$f->passCaptcha() ) {
				wfDebug( __METHOD__ . ": captcha failed" );
				$wgOut->addWikiMsg( 'contactpage-captcha-failed' );
				$f->showForm();
			} else {
				wfDebug( __METHOD__ . ": submit\n" );
				$f->doSubmit();
			}
		} else {
			wfDebug( __METHOD__ . ": form\n" );
			$f->showForm();
		}
	}
}

/**
 * @todo document
 * @ingroup SpecialPage
 */
class EmailContactForm {

	var $target;
	var $text, $subject;
	var $cc_me; // Whether user requested to be sent a separate copy of their email.

	/**
	 * @param User $target
	 */
	function EmailContactForm( $target ) {
		global $wgRequest, $wgUser;
		global $wgCaptchaClass;

		$this->target = $target;
		$this->text = $wgRequest->getText( 'wpText' );
		$this->subject = $wgRequest->getText( 'wpSubject' );
		$this->cc_me = $wgRequest->getBool( 'wpCCMe' );

		$this->fromname = $wgRequest->getText( 'wpFromName' );
		$this->fromaddress = $wgRequest->getText( 'wpFromAddress' );

		if( $wgUser->isLoggedIn() ) {
			if( !$this->fromname ) {
				$this->fromname = $wgUser->getName();
			}
			if( !$this->fromaddress ) {
				$this->fromaddress = $wgUser->getEmail();
			}
		}

		// prepare captcha if applicable
		if ( $this->useCaptcha() ) {
			$captcha = ConfirmEditHooks::getInstance();
			$captcha->trigger = 'contactpage';
			$captcha->action = 'contact';
		}
	}

	function hasAllInfo() {
		global $wgContactRequireAll;

		if ( $this->text === null ) {
			return false;
		} else {
			$this->text = trim( $this->text );
		}
		if ( $this->text === '' ) {
			return false;
		}

		if ( $wgContactRequireAll ) {
			if ( $this->fromname === null ) {
				return false;
			} else {
				$this->fromname = trim( $this->fromname );
			}
			if ( $this->fromname === '' ) {
				return false;
			}

			if ( $this->fromaddress === null ) {
				return false;
			} else {
				$this->fromaddress = trim( $this->fromaddress );
			}
			if ( $this->fromaddress === '' ) {
				return false;
			}
		}

		return true;
	}

	function showForm() {
		global $wgOut, $wgUser, $wgContactRequireAll;

		#TODO: show captcha

		$wgOut->setPageTitle( wfMsg( 'contactpage-title' ) );
		$wgOut->addWikiMsg( 'contactpage-pagetext' );

		if ( $this->subject === '' ) {
			$this->subject = wfMsgForContent( 'contactpage-defsubject' );
		}

		$msgSuffix = $wgContactRequireAll ? '-required' : '';

		$titleObj = SpecialPage::getTitleFor( 'Contact' );
		$action = $titleObj->getLocalURL( 'action=submit' );
		$token = $wgUser->isAnon() ? EDIT_TOKEN_SUFFIX : $wgUser->editToken(); //this kind of sucks, really...

		$form =
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action, 'id' => 'emailuser' ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'contactpage-legend' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mailheader' ) ) .
			'<tr>
				<td class="mw-label">' .
					Xml::label( wfMsg( 'emailsubject' ), 'wpSubject' ) .
				'</td>
				<td class="mw-input" id="mw-contactpage-subject">' .
					Xml::input( 'wpSubject', 60, $this->subject, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				'</td>
			</tr>
			<tr>
				<td class="mw-label">' .
					Xml::label( wfMsg( "contactpage-fromname$msgSuffix" ), 'wpFromName' ) .
				'</td>
				<td class="mw-input" id="mw-contactpage-from">' .
					Xml::input( 'wpFromName', 60, $this->fromname, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				'</td>
			</tr>
			<tr>
				<td class="mw-label">' .
					Xml::label( wfMsg( "contactpage-fromaddress$msgSuffix" ), 'wpFromAddress' ) .
				'</td>
				<td class="mw-input" id="mw-contactpage-address">' .
					Xml::input( 'wpFromAddress', 60, $this->fromaddress, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				'</td>
			</tr>';

			// Allow other extensions to add more fields into Special:Contact
			wfRunHooks( 'ContactFormBeforeMessage', array( $this, &$form ) );

			$form .= '<tr>
				<td></td>
				<td class="mw-input" id="mw-contactpage-formfootnote">
					<small>' . wfMsg( "contactpage-formfootnotes$msgSuffix" ) . '</small>
				</td>
			</tr>
			<tr>
				<td class="mw-label">' .
					Xml::label( wfMsg( 'emailmessage' ), 'wpText' ) .
				'</td>
				<td class="mw-input">' .
					Xml::textarea( 'wpText', $this->text, 80, 20, array( 'id' => 'wpText' ) ) .
				'</td>
			</tr>
			<tr>
				<td></td>
				<td class="mw-input">' .
					Xml::checkLabel( wfMsg( 'emailccme' ), 'wpCCMe', 'wpCCMe', $wgUser->getBoolOption( 'ccmeonemails' ) ) .
					'<br />' . $this->getCaptcha() .
				'</td>
			</tr>
			<tr>
				<td></td>
				<td class="mw-submit">' .
					Xml::submitButton( wfMsg( 'emailsend' ), array( 'name' => 'wpSend', 'accesskey' => 's' ) ) .
				'</td>
			</tr>' .
			Xml::hidden( 'wpEditToken', $token ) .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' );
		$wgOut->addHTML( $form );
	}

	function useCaptcha() {
		global $wgCaptchaClass, $wgCaptchaTriggers, $wgUser;
		if ( !$wgCaptchaClass ) {
			return false; // no captcha installed
		}
		if ( !@$wgCaptchaTriggers['contactpage'] ) {
			return false; // don't trigger on contact form
		}

		if( $wgUser->isAllowed( 'skipcaptcha' ) ) {
			wfDebug( "EmailContactForm::useCaptcha: user group allows skipping captcha\n" );
			return false;
		}

		return true;
	}

	function getCaptcha() {
		global $wgCaptcha;
		if ( !$this->useCaptcha() ) {
			return '';
		}

		wfSetupSession(); #NOTE: make sure we have a session. May be required for captchas to work.

		return '<div class="captcha">' .
			$wgCaptcha->getForm() .
			wfMsgWikiHtml( 'contactpage-captcha' ) .
		"</div>\n";
	}

	function passCaptcha() {
		global $wgCaptcha;
		if ( !$this->useCaptcha() ) {
			return true;
		}

		return $wgCaptcha->passCaptcha();
	}

	function doSubmit() {
		global $wgOut;
		global $wgEnableEmail, $wgUserEmailUseReplyTo, $wgEmergencyContact;
		global $wgContactUser, $wgContactSender, $wgContactSenderName;

		$csender = $wgContactSender ? $wgContactSender : $wgEmergencyContact;
		$cname = $wgContactSenderName;

		wfDebug( __METHOD__ . ": start\n" );

		$targetAddress = new MailAddress( $this->target );
		$replyto = null;
		$contactSender = new MailAddress( $csender, $cname );

		if ( !$this->fromaddress ) {
			$submitterAddress = $contactSender;
		} else {
			$submitterAddress = new MailAddress( $this->fromaddress, $this->fromname );
			if ( $wgUserEmailUseReplyTo ) {
				$replyto = $submitterAddress;
			}
		}

		$subject = trim( $this->subject );

		if ( $subject === '' ) {
			$subject = wfMsgForContent( 'contactpage-defsubject' );
		}

		if ( $this->fromname !== '' ) {
			$subject = wfMsgForContent( 'contactpage-subject-and-sender', $subject, $this->fromname );
		} elseif ( $this->fromaddress !== '' ) {
			$subject = wfMsgForContent( 'contactpage-subject-and-sender', $subject, $this->fromaddress );
		}

		if( !wfRunHooks( 'ContactForm', array( &$targetAddress, &$replyto, &$subject, &$this->text ) ) ) {
			wfDebug( __METHOD__ . ": aborted by hook\n" );
			return;
		}

		wfDebug( __METHOD__ . ": sending mail from " . $submitterAddress->toString() .
			" to " . $targetAddress->toString().
			" replyto " . ( $replyto == null ? '-/-' : $replyto->toString() ) . "\n" );

		$mailResult = UserMailer::send( $targetAddress, $submitterAddress, $subject, $this->text, $replyto );

		if( WikiError::isError( $mailResult ) ) {
			$wgOut->addWikiMsg( 'usermailererror' ) . $mailResult->getMessage();
			wfDebug( __METHOD__ . ": got error from UserMailer: " . $mailResult->getMessage() . "\n" );
			return;
		}

		// if the user requested a copy of this mail, do this now,
		// unless they are emailing themselves, in which case one copy of the message is sufficient.
		if( $this->cc_me && $this->fromaddress ) {
			$cc_subject = wfMsg( 'emailccsubject', $this->target->getName(), $subject );
			if( wfRunHooks( 'ContactForm', array( &$submitterAddress, &$contactSender, &$cc_subject, &$this->text ) ) ) {
				wfDebug( __METHOD__ . ": sending cc mail from " . $contactSender->toString() .
					" to " . $submitterAddress->toString() . "\n" );
				$ccResult = UserMailer::send( $submitterAddress, $contactSender, $cc_subject, $this->text );
				if( WikiError::isError( $ccResult ) ) {
					// At this stage, the user's CC mail has failed, but their
					// original mail has succeeded. It's unlikely, but still, what to do?
					// We can either show them an error, or we can say everything was fine,
					// or we can say we sort of failed AND sort of succeeded. Of these options,
					// simply saying there was an error is probably best.
					$wgOut->addWikiText( wfMsg( 'usermailererror' ) . $ccResult );
					return;
				}
			}
		}

		wfDebug( __METHOD__ . ": success\n" );

		$titleObj = SpecialPage::getTitleFor( 'Contact' );
		$wgOut->redirect( $titleObj->getFullURL( 'action=success' ) );
		wfRunHooks( 'ContactFromComplete', array( $targetAddress, $replyto, $subject, $this->text ) );

		wfDebug( __METHOD__ . ": end\n" );
	}

	function showSuccess() {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'emailsent' ) );
		$wgOut->addWikiMsg( 'emailsenttext' );

		$wgOut->returnToMain( false );
	}
}
