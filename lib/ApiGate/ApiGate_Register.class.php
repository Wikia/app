<?php
/**
 * @author Sean Colombo
 * @date 20111014
 *
 * Class for controlling the business-logic of registration.  For the View of the
 * registration form, see templates/register.php.
 */

 
class ApiGate_Register {

	/**
	 * Processes a POST (if there was one) of the registration form. If there was not a successful registration, then modifies
	 * the data passed in to contain the values which WERE posted (to make form re-submission easier).  Returns 'true' if there
	 * was a successful registration, false if there was no registration attempt or an error.
	 *
	 * If registration is successful, also sets 'apiKey' key in the 'data' array to the new API key that was created.
	 *
	 * @param data - array - an associative array whose keys are the names of the the variables for the template, and whose values should
	 *                       be the default values for those fields.  This will be modified (overridden) by any of those values which were posted
	 *                       to this page.
	 * @return mixed - boolean true if there was a successful registration, false if there was no registration or a failed attempt. If there was
	 *                 an error, that will be added to the 'data' array under the key 'errorString'.
	 */
	public static function processPost( &$data ){
		$didRegister = false;

		if( isset($_POST['formName']) && ($_POST['formName'] == "apiGate_register") ){
			$firstName = self::getPost('firstName');
			$lastName = self::getPost('lastName');
			$email_1 = self::getPost('email_1');
			$email_2 = self::getPost('email_2');
			
			// TODO: IMPLEMENT
			// TODO: IMPLEMENT
			
			$data['apiKey'] = "APIKEYGOESHERE";
			$didRegister = true; // TODO: MOVE THIS TO ONLY HAPPEN WHEN REGISTRATION ACTUALLY HAPPENS
			

		}
	
		return $didRegister;
	} // end processPost()

	// TODO: Move to a util class or something
	public static function getPost( $varName, $default='' ){
		return ( isset($_POST[$varName]) ? $_POST[$varName] : $default );
	} // end getPost()

} // end class ApiGate_Register
