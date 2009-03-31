<?php
/**
 * Speclial:Contact, a contact form for visitors.
 * Based on SpecialEmailUser.php
 *
 * @addtogroup SpecialPage
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "not a valid entry point.\n" );
	die( 1 );
}

global $IP; #needed when called from the autoloader
require_once("$IP/includes/UserMailer.php");

/**
 *
 */
class SpecialContact extends SpecialPage {

	/**
	 * Constructor
	 */
	function __construct() {
		global $wgOut;
		SpecialPage::SpecialPage( 'Contact', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgEnableEmail, $wgContactUser;

		wfLoadExtensionMessages( 'ContactPage' );
		$fname = "SpecialContact::execute";

		if( !$wgEnableEmail || !$wgContactUser ) {
			$wgOut->showErrorPage( "nosuchspecialpage", "nospecialpagetext" );
			return;
		}

		$action = $wgRequest->getVal( 'action' );

		$nu = User::newFromName( $wgContactUser );
		if( is_null( $nu ) || !$nu->canReceiveEmail() ) {
			wfDebug( "Target is invalid user or can't receive.\n" );
			$wgOut->showErrorPage( "noemailtitle", "noemailtext" );
			return;
		}

		$f = new EmailContactForm( $nu );

		if ( "success" == $action ) {
			wfDebug( "$fname: success.\n" );
			$f->showSuccess( );
		} else if ( "submit" == $action && $wgRequest->wasPosted() && $f->hasAllInfo() ) {
			$token = $wgRequest->getVal( 'wpEditToken' );

			if( $wgUser->isAnon() ) {
				# Anonymous users may not have a session
				# open. Check for suffix anyway.
				$tokenOk = ( EDIT_TOKEN_SUFFIX == $token );
			} else {
				$tokenOk = $wgUser->matchEditToken( $token );
			}

			if ( !$tokenOk ) {
				wfDebug( "$fname: bad token (".($wgUser->isAnon()?'anon':'user')."): $token\n" );
				$wgOut->addWikiText( wfMsg( 'sessionfailure' ) );
				$f->showForm();
			} else if ( !$f->passCaptcha() ) {
				wfDebug( "$fname: captcha failed" );
				$wgOut->addWikiText( wfMsg( 'contactpage-captcha-failed' ) ); //TODO: provide a message for this!
				$f->showForm();
			} else if ( !User::isValidEmailAddr($wgRequest->getVal('wpFromAddress')) ) {
				wfDebug( "$fname: incorrect e-mail" );
				$wgOut->addWikiText( wfMsg( 'contactpage-email-failed' ) );
				$f->showForm();
			} else {
				wfDebug( "$fname: submit\n" );
				$f->doSubmit();
			}
		} else {
			wfDebug( "$fname: form\n" );
			$f->showForm();
		}
	}
}

/**
 * @todo document
 * @addtogroup SpecialPage
 */
class EmailContactForm {

	var $target;
	var $text, $subject;
	var $cc_me;     // Whether user requested to be sent a separate copy of their email.

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

		if ($wgUser->isLoggedIn()) {
			if (!$this->fromname) $this->fromname = $wgUser->getName();
			if (!$this->fromaddress) $this->fromaddress = $wgUser->getEmail();
		}

		//prepare captcha if applicable
		if ( $this->useCaptcha() ) {
			$captcha = ConfirmEditHooks::getInstance();
			$captcha->trigger = 'contactpage';
			$captcha->action = 'contact';
		}
	}

	function hasAllInfo() {
		global $wgContactRequireAll;

		if ( $this->text === NULL ) return false;
		else $this->text = trim( $this->text );
		if ( $this->text === '' ) return false;

		if ( $wgContactRequireAll ) {
			if ( $this->fromname === NULL ) return false;
			else $this->fromname = trim( $this->fromname );
			if ( $this->fromname === '' ) return false;

			if ( $this->fromaddress === NULL ) return false;
			else $this->fromaddress = trim( $this->fromaddress );
			if ( $this->fromaddress === '' ) return false;
		}

		return true;
	}

	function showForm() {
		global $wgOut, $wgUser, $wgContactRequireAll;

		#TODO: show captcha

		$wgOut->setPagetitle( wfMsg( "contactpage-title" ) );
		$wgOut->addWikiText( wfMsg( "contactpage-pagetext" ) );

		if ( $this->subject === "" ) {
			$this->subject = wfMsgForContent( "contactpage-defsubject" );
		}

		$msgSuffix = $wgContactRequireAll ? '-required' : '';

		$titleObj = SpecialPage::getTitleFor( 'Contact' );
		$action = $titleObj->getLocalURL( 'action=submit' );
		$token = $wgUser->isAnon() ? EDIT_TOKEN_SUFFIX : $wgUser->editToken(); //this kind of sucks, really...

		$wgOut->addHTML( "
<script type=\"text/javascript\">
function checkForm() {
	var email = document.getElementById('wpFromAddress').value;
	result = email.match(/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/i);
	YAHOO.util.Dom.setStyle('wpFromAddress', 'background-color', result ? '' : '#FFBBBB');
	return result ? true : false;
}
</script>
");
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $action, 'id' => 'emailuser' ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'contactpage-legend' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mailheader' ) ) .
			"<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'emailsubject' ), 'wpSubject' ) .
				"</td>
				<td class='mw-input' id='mw-contactpage-subject'>" .
					Xml::input( 'wpSubject', 60, $this->subject, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( "contactpage-fromname$msgSuffix" ), 'wpFromName' ) .
				"</td>
				<td class='mw-input' id='mw-contactpage-from'>" .
					Xml::input( 'wpFromName', 60, $this->fromname, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( "contactpage-fromaddress$msgSuffix" ), 'wpFromAddress' ) .
				"</td>
				<td class='mw-input' id='mw-contactpage-address'>" .
					Xml::input( 'wpFromAddress', 60, $this->fromaddress, array( 'type' => 'text', 'maxlength' => 200 ) ) .
				"</td>
			</tr>
			<tr>
				<td></td>
				<td class='mw-input' id='mw-contactpage-formfootnote'>
					<small>" . wfMsg( "contactpage-formfootnotes$msgSuffix" ) . "</small>
				</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'emailmessage' ), 'wpText' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::textarea( 'wpText', $this->text, 80, 20, array( 'id' => 'wpText' ) ) .
				"</td>
			</tr>
			<tr>
				<td></td>
				<td class='mw-input'>" .
					Xml::checkLabel( wfMsg( 'emailccme' ), 'wpCCMe', 'wpCCMe', $wgUser->getBoolOption( 'ccmeonemails' ) ) .
					"<br />" . $this->getCaptcha() .
				"</td>
			</tr>
			<tr>
				<td></td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'emailsend' ), array( 'name' => 'wpSend', 'accesskey' => 's' ) ) .
				"</td>
			</tr>" .
			Xml::hidden( 'wpEditToken', $token ) .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' )
		);
	}

	function useCaptcha() {
		global $wgCaptchaClass, $wgCaptchaTriggers, $wgUser;
		if ( !$wgCaptchaClass ) return false; //no captcha installed
		if ( !@$wgCaptchaTriggers['contactpage'] ) return false; //don't trigger on contact form

		if( $wgUser->isAllowed( 'skipcaptcha' ) ) {
			wfDebug( "EmailContactForm::useCaptcha: user group allows skipping captcha\n" );
			return false;
		}

		return true;
	}

	function getCaptcha() {
		global $wgCaptcha;
		if ( !$this->useCaptcha() ) return ""; 

		wfSetupSession(); #NOTE: make sure we have a session. May be required for captchas to work.

		return "<div class='captcha'>" .
		$wgCaptcha->getForm() .
		wfMsgWikiHtml( 'contactpage-captcha' ) .
		"</div>\n";
	}

	function passCaptcha() {
		global $wgCaptcha;
		if ( !$this->useCaptcha() ) return true;

		return $wgCaptcha->passCaptcha();
	}

	function doSubmit( ) {
		global $wgOut;
		global $wgEnableEmail, $wgUserEmailUseReplyTo, $wgEmergencyContact;
		global $wgContactUser, $wgContactSender, $wgContactSenderName;

		$csender = $wgContactSender ? $wgContactSender : $wgEmergencyContact;
		$cname = $wgContactSenderName;

		$fname = 'EmailContactForm::doSubmit';

		wfDebug( "$fname: start\n" );

		$to = new MailAddress( $this->target );
		$replyto = NULL;

		if ( !$this->fromaddress ) {
			$from = new MailAddress( $csender, $cname );
		}
		else if ( $wgUserEmailUseReplyTo ) {
			$from = new MailAddress( $csender, $cname );
			$replyto = new MailAddress( $this->fromaddress, $this->fromname );
		}
		else {
			$from = new MailAddress( $this->fromaddress, $this->fromname );
		}

		$subject = trim( $this->subject );

		if ( $subject === "" ) {
			$subject = wfMsgForContent( "contactpage-defsubject" );
		}

		if ( $this->fromname !== "" ) {
			$subject = wfMsgForContent( "contactpage-subject-and-sender", $subject, $this->fromname );
		}
		else if ( $this->fromaddress !== "" ) {
			$subject = wfMsgForContent( "contactpage-subject-and-sender", $subject, $this->fromaddress );
		}

		if( wfRunHooks( 'ContactForm', array( &$to, &$replyto, &$subject, &$this->text ) ) ) {

			wfDebug( "$fname: sending mail from ".$from->toString()." to ".$to->toString()." replyto ".($replyto==null?'-/-':$replyto->toString())."\n" );

			#HACK: in MW 1.9, replyto must be a string, in MW 1.10 it must be an object!
			$ver = preg_replace( '![^\d._+]!', '', $GLOBALS['wgVersion'] );
			$replyaddr = $replyto == null
					? NULL : version_compare( $ver, '1.10', '<' )
						? $replyto->toString() : $replyto;

			$mailResult = userMailer( $to, $from, $subject, $this->text, $replyaddr );

			if( WikiError::isError( $mailResult ) ) {
				$wgOut->addWikiText( wfMsg( "usermailererror" ) . $mailResult->getMessage());
			} else {

				// if the user requested a copy of this mail, do this now,
				// unless they are emailing themselves, in which case one copy of the message is sufficient.
				if ($this->cc_me && $replyto) {
					$cc_subject = wfMsg('emailccsubject', $this->target->getName(), $subject);
					if( wfRunHooks( 'ContactForm', array( &$from, &$replyto, &$cc_subject, &$this->text ) ) ) {
						wfDebug( "$fname: sending cc mail from ".$from->toString()." to ".$replyto->toString()."\n" );
						$ccResult = userMailer( $replyto, $from, $cc_subject, $this->text );
						if( WikiError::isError( $ccResult ) ) {
							// At this stage, the user's CC mail has failed, but their
							// original mail has succeeded. It's unlikely, but still, what to do?
							// We can either show them an error, or we can say everything was fine,
							// or we can say we sort of failed AND sort of succeeded. Of these options,
							// simply saying there was an error is probably best.
							$wgOut->addWikiText( wfMsg( "usermailererror" ) . $ccResult);
							return;
						}
					}
				}

				wfDebug( "$fname: success\n" );

				$titleObj = SpecialPage::getTitleFor( "Contact" );
				$wgOut->redirect( $titleObj->getFullURL( "action=success" ) );
				wfRunHooks( 'ContactFromComplete', array( $to, $replyto, $subject, $this->text ) );
			}
		}

		wfDebug( "$fname: end\n" );
	}

	function showSuccess( ) {
		global $wgOut;

		$wgOut->setPagetitle( wfMsg( "emailsent" ) );
		$wgOut->addWikiText( wfMsg( "emailsenttext" ) );

		$wgOut->returnToMain( false );
	}
}
