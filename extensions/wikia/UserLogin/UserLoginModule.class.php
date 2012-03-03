<?php

/**
 * UserLogin Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginModule extends Module {
	
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
		UserLoginHelper::getInstance()->setUserLanguage( $params['language'] );

		switch ( $params['type'] ) {
			case 'password-email':
				$this->greeting = $this->wf->MsgForContent( 'userlogin-'.$this->type.'-greeting' );
				$this->content = $this->wf->MsgForContent( 'userlogin-'.$this->type.'-content' );
				$this->signature = $this->wf->MsgForContent( 'userlogin-'.$this->type.'-signature' );
				break;
			case 'confirmation-email':
			case 'reconfirmation-email':
			case 'account-creation-email':
			case 'confirmation-reminder-email' :
				$this->greeting = $this->wf->MsgForContent( 'usersignup-'.$this->type.'-greeting' );
				$this->content = $this->wf->MsgForContent( 'usersignup-'.$this->type.'-content' );
				$this->signature = $this->wf->MsgForContent( 'usersignup-'.$this->type.'-signature' );
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
		UserLoginHelper::getInstance()->setUserLanguage( $params['language'] );
	}

}
