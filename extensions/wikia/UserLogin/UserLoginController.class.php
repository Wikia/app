<?php

/**
 * UserLogin Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginController extends WikiaController {
	
	// This function is only used for testing / previewing / debugging the email templates
	public function executeIndex() {
		$type = $this->wg->Request->getVal( 'type' );
		$lang = $this->wg->Request->getVal( 'lang', 'en' );
		
		$params = array(
				'type' => $type, 
				'language' => $lang, 
		);

		if ( $type == 'welcome-email' ) {
			$this->previewBody = $this->app->renderView( "UserLogin", 'WelcomeMail', $params );
			$emailParams = array (
				'$USERNAME' => 'testUser',
				'$EDITPROFILEURL' => $this->wg->Server.'/wiki/User:testUser',
				'$LEARNBASICURL' => 'http://community.wikia.com/wiki/Help:Wikia_Basics',
				'$EXPLOREWIKISURL' => 'http://www.wikia.com',
			);
		} else {
			$this->previewBody = $this->app->renderView( "UserLogin", 'GeneralMail', $params );
			$emailParams = array (
				'$USERNAME' => 'testUser',
				'$NEWPASSWORD' => 'newPassword',							// for password-email
				'$CONFIRMURL' => 'http://www.wikia.com/confirmEmail',		// for confirmation-email, reconfirmation-email
			);
		}
		$this->previewBody = strtr( $this->previewBody, $emailParams );
	}

	/**
	 * General Mail template
	 * @requestParam Array params
	 * @responseParam String type [password-email, confirmation-email, reconfirmation-email, account-creation-email, confirmation-reminder-email]
	 * @responseParam String language
	 * @responseParam String greeting
	 * @responseParam String content
	 * @responseParam String signature
	 */
	public function executeGeneralMail( $params ) {
		$this->type = $params['type'];
		$this->language = $params['language'];
		$this->msgParams = array( 'parsemag', 'language' => $this->language );

		switch ( $params['type'] ) {
			case 'password-email':
				$this->greeting = wfMsgExt( 'userlogin-'.$this->type.'-greeting', $this->msgParams );
				$this->content = wfMsgExt( 'userlogin-'.$this->type.'-content', $this->msgParams );
				$this->signature = wfMsgExt( 'userlogin-'.$this->type.'-signature', $this->msgParams );
				break;
			case 'confirmation-email':
			case 'reconfirmation-email':
			case 'account-creation-email':
			case 'confirmation-reminder-email' :
				$this->greeting = wfMsgExt( 'usersignup-'.$this->type.'-greeting', $this->msgParams );
				$this->content = wfMsgExt( 'usersignup-'.$this->type.'-content', $this->msgParams );
				$this->signature = wfMsgExt( 'usersignup-'.$this->type.'-signature', $this->msgParams );
				break;
			default:
				$this->greeting = '';
				$this->content = '';
				$this->signature = '';
				break;
		}
	}

	/**
	 * Welcome Mail template
	 * @requestParam Array params
	 */
	public function executeWelcomeMail( $params ) {
		$this->language = $params['language'];
		$this->msgParams = array( 'parsemag', 'language' => $this->language );
	}

}
