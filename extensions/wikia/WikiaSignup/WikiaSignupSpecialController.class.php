<?php

/**
 * WikiaSignup Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class WikiaSignupSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('WikiaSignup');
		parent::__construct('WikiaSignup', '', false);
	}
	
	public function init() {
		
	}
	
	/**
	 * @brief serves standalone signup page on GET.  if POSTed, parameters will be required.
	 * @details
	 *   on GET, template will render
	 *   on POST, 
	 *     if signup is successful, it will redirect to returnUrl, or mainpage of wiki
	 *     if signup is not successful, the template will render error messages, highlighting the errors
	 * @requestParam string username - on POST
	 * @requestParam string email - on POST
	 * @requestParam string password - on POST
	 * @requestParam string birthmonth - on POST
	 * @requestParam string birthday - on POST
	 * @requestParam string birthyear - on POST
	 * @requestParam string captcha - on POST
	 * @requestParam string returnUrl - url to return to upon successful login
	 */
	public function index() {
		$this->response->addAsset('extensions/wikia/WikiaSignup/js/WikiaSignup.js');
	}
	
	/**
	 * @brief ajax call for signup.  returns status code
	 * @details
	 *   for use with ajax call or standalone data call only
	 * @requestParam string username
	 * @requestParam string email
	 * @requestParam string password
	 * @requestParam string birthmonth
	 * @requestParam string birthday
	 * @requestParam string birthyear
	 * @requestParam string captcha
	 * @responseParam string result [ok/error/null]
	 * @responseParam string[] errors - error messages
	 */
	public function signup() {
		
	}
	
	/**
	 * @brief returns 4 random users from the current wiki
	 * @responseParam array users - array of associative arrays that contain user information (id, avatarurl, profileurl)
	 */
	private function getTopUsers() {
	}
	
	/**
	 * @brief renders content in modal dialog
	 * @details
	 * @requestParam string username
	 */
	public function confirmEmailWidget() {
	}
	
	/**
	 * @brief sends confirmationEmail
	 * @details
	 * @requestParam string username
	 */
	public function sendConfirmationEmail() {
	}
}
