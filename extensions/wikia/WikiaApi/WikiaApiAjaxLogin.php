<?php
/*
 * Author: Inez Korczynski
 */

if (!defined('MEDIAWIKI')) {
	die();
}

class WikiaApiAjaxLogin extends ApiBase {

	public function __construct($main, $action) {
		parent :: __construct($main, $action, 'wp');
	}

	public function execute() {
		$Name = $Password = $Remember = $Loginattempt = $Mailmypassword = null;
		
		extract($this->extractRequestParams());

		if(!empty($Loginattempt)) {
			// Login attempt
			$params = new FauxRequest(array (
				'wpName' => $Name,
				'wpPassword' => $Password,
				'wpRemember' => $Remember,
				'wpLoginattempt' => $Loginattempt,
				'wpLoginToken' => $LoginToken
			));

			// Init session if necessary
			if ( session_id() == '' ) {
				wfSetupSession();
			}

			$result = array ();
			$loginForm = new LoginForm($params);
			$caseCode = $loginForm->authenticateUserData();
			switch ($caseCode) {
				case LoginForm :: RESET_PASS:
					$result['result'] = 'Reset';
					break;
				case LoginForm :: SUCCESS :
					global $wgUser;

					$injected_html = '';
					wfRunHooks('UserLoginComplete', array(&$wgUser, &$injected_html));

					$wgUser->setOption( 'rememberpassword', $Remember ? 1 : 0 );
					$wgUser->setCookies();

					$result['result'] = 'Success';
					$result['lguserid'] = $_SESSION['wsUserID'];
					$result['lgusername'] = $_SESSION['wsUserName'];
					$result['lgtoken'] = $_SESSION['wsToken'];
					break;
				case LoginForm :: NO_NAME :
					$result['result'] = 'NoName';
					$result['text'] = wfMsg('noname');
					break;
				case LoginForm :: ILLEGAL :
					$result['result'] = 'Illegal';
					$result['text'] = wfMsg('noname');
					break;
				case LoginForm :: WRONG_PLUGIN_PASS :
					$result['result'] = 'WrongPluginPass';
					$result['text'] = wfMsg('wrongpassword');
					break;
				case LoginForm :: NOT_EXISTS :
					$result['result'] = 'NotExists';
					$result['text'] = wfMsg('nosuchuser', htmlspecialchars($Name));
					break;
				case LoginForm :: WRONG_PASS :
					$result['result'] = 'WrongPass';
					$result['text'] = wfMsg('wrongpassword');
					break;
				case LoginForm :: EMPTY_PASS :
					$result['result'] = 'EmptyPass';
					$result['text'] = wfMsg('wrongpasswordempty');
					break;
				default :
					ApiBase :: dieDebug(__METHOD__, "Unhandled case value: \"$caseCode\"");
			}
			$dbw = wfGetDB( DB_MASTER );
			$dbw->commit();

			$this->getResult()->addValue(null, 'ajaxlogin', $result);
		} else if(!empty($Mailmypassword)) {
			// Remind password attemp
			$params = new FauxRequest(array (
				'wpName' => $Name
			));
			$result = array ();
			$loginForm = new LoginForm($params);
			global $wgUser, $wgOut, $wgAuth;
			if( !$wgAuth->allowPasswordChange() ) {
				$result['result'] = 'resetpass_forbidden';
				$result['text'] = wfMsg('resetpass_forbidden');
			} else if( $wgUser->isBlocked() ) {
				$result['result'] = 'blocked-mailpassword';
				$result['text'] = wfMsg('blocked-mailpassword');
			} else if ( '' == $loginForm->mName ) {
				$result['result'] = 'noname';
				$result['text'] = wfMsg('noname');
			} else {
				$u = User::newFromName( $loginForm->mName );
				if( is_null( $u ) ) {
					$result['result'] = 'noname';
					$result['text'] = wfMsg('noname');
				} else if ( 0 == $u->getID() ) {
					$result['result'] = 'nosuchuser';
					$result['text'] = wfMsg( 'nosuchuser', $u->getName() );
				} else if ( $u->isPasswordReminderThrottled() ) {
					global $wgPasswordReminderResendTime;
					$result['result'] = 'throttled-mailpassword';
					$result['text'] = wfMsg( 'throttled-mailpassword', round( $wgPasswordReminderResendTime, 3 ) );
				} else {
					$res = $loginForm->mailPasswordInternal( $u, true );
					if( WikiError::isError( $res ) ) {
						$result['result'] = 'mailerror';
						$result['text'] = wfMsg( 'mailerror', $res->getMessage() );
					} else {
						$result['result'] = 'OK';
						$result['text'] = wfMsg( 'passwordsent', $u->getName() );
					}
				}
			}
			$dbw = wfGetDB( DB_MASTER );
			$dbw->commit();

			$this->getResult()->addValue(null, 'ajaxlogin', $result);
		}
	}

	public function getAllowedParams() {
		return array (
			'Name' => null,
			'Password' => null,
			'Remember' => null,
			'Loginattempt' => null,
			'Mailmypassword' => null,
			'LoginToken' => null
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiLogin.php 17065 2006-10-17 02:11:29Z yurik $';
	}
}
?>
