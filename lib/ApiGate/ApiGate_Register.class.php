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
			
			// Validate the input.
			$errorString = "";
			if("$firstName$lastName" == ""){
				$errorString .= "\n" . i18n( 'apigate-register-error-noname' );
			}
			if( preg_match('/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/i', $email_1) === 0 ){
				$errorString .= "\n". i18n( 'apigate-register-error-invalid-email' );
			}
			if($email_1 != $email_2){
				$errorString .= "\n". i18n( 'apigate-register-error-email-doesnt-match' );
			}

			// If input was valid, attempt to create a key.
			if($errorString == ""){
				// Create a new API key and store it to the database with the values provided.
				$apiKey = self::generateKey();

				// This is in library-code (not MediaWiki) so build the query by hand.
				$queryString = "INSERT INTO ". ApiGate::TABLE_KEYS ." (user_id, apiKey, email, firstName, lastName) VALUES (";
				$queryString .= "'".mysql_real_escape_string( $userId, $dbw )."', ";
				$queryString .= "'".mysql_real_escape_string( $apiKey, $dbw )."', ";
				$queryString .= "'".mysql_real_escape_string( $email_1, $dbw )."', ";
				$queryString .= "'".mysql_real_escape_string( $firstName, $dbw )."', ";
				$queryString .= "'".mysql_real_escape_string( $lastName, $dbw )."', ";
				$queryString .= ")";
				if( ApiGate::sendQuery($queryString, $dbw) ){
					$data['apiKey'] = $apiKey;
					$didRegister = true;
				} else {
					$errorString .= "\n". i18n( 'apigate-register-error-mysql_error' );
					$errorString .= "\n<br/><br/>". mysql_error( $dbw );
				}
			}

			if( $errorString != "" ) {
				$errorString = trim($errorString);
				$errorString = str_replace("\n", "<br/>", $errorString);
				$data['errorString'] = $errorString;
			}
		}

		return $didRegister;
	} // end processPost()

	// TODO: Move to a util class or something
	public static function getPost( $varName, $default='' ){
		return ( isset($_POST[$varName]) ? $_POST[$varName] : $default );
	} // end getPost()
	
	/**
	 * Returns a valid (and available API key) to be used in the system.
	 *
	 * Border-line irrelevant note: There is a potential race-condition that you
	 * could get this key and store it to the database at approximately the same time as someone who generated the same key
	 * (prior to you storing) but that should be approximately a one in 16^40 chance (unless you seed the PRNG with
	 * a timestamp or something patently wrong like that) so I'm not going to spend time preventing that at the moment.
	 *
	 * Takes NO parameters and is static so that the generation isn't affected by state at all... the 
	 * generation is supposed to be random and using any state from the user or registration object would
	 * just reduce the entropy of the pseudo-random number generator.
	 */
	protected static function generateKey(){
		wfProfileIn( __METHOD__ );

		do {
			$keyHash = sha1( mt_rand() );
		} while( ApiGate_Register::keyExists( $keyHash ) );
		
		wfProfileOut( __METHOD__ );
		return $keyHash;
	} // end generateKey()
	
	/**
	 * @param keyToTest - an API key which will be checked to see if it is already registered in the system.
	 * @return bool - true if 'keyToTest' is a registered API key in the system, false if 'keyToTest' is NOT registered.
	 */
	protected static function keyExists( $keyToTest){
		wfProfileIn( __METHOD__ );
		$keyExists = false;

		$queryString = "SELECT count(*) FROM ".ApiGate::TABLE_KEYS." WHERE apiKey='". mysql_real_escape_string( $keyToTest ) ."'";
		$numKeys = ApiGate::simpleQuery( $queryString );
		$keyExists = ($numKeys > 0);

		wfProfileOut( __METHOD__ );
		return $keyExists;
	} // end keyExists()

} // end class ApiGate_Register
