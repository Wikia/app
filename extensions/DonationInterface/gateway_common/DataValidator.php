<?php

/**
 * DataValidator
 * This class is responsible for performing all kinds of data validation, 
 * wherever we may need it. 
 * 
 * All functions should be static, so we don't have to construct anything in 
 * order to use it any/everywhere. 
 * 
 * @author khorn
 */
class DataValidator {
	
	/**
	 * $boolean_fields
	 * @var array All fields that should validate as boolean values
	 */
	protected static $boolean_fields = array(
		'comment-option',
		'email-opt',
		'_cache_',
		'anonymous',
		'optout',
		'recurring',
		'posted',
	); 
	
	/**
	 * $numeric_fields
	 * @var array All fields that should validate as numeric
	 */
	protected static $numeric_fields = array(
		'amount',
		'amountGiven',
		'amountOther',
		'cvv',
		'contribution_tracking_id',
		'account_number',
		'expiration',
		'order_id',
		'i_order_id',
		'numAttempt'
	);
	
	/**
	 * $gateway_classes
	 * @var array A list of all possible gateway classes. 
	 */
	protected static $gateway_classes = array(
		'globalcollect' => 'GlobalCollectAdapter',
		'payflowpro' => 'PayflowProAdapter'
	);
	
	/**
	 * $card_types
	 * @var array A list of all card types we recognize
	 */
	protected static $card_types = array( 
		'american',
		'mastercard',
		'visa',
		'discover'
	);

	
	/**
	 * getNumericFields returns a list of DonationInterface fields that are 
	 * expected to contain numeric values. 
	 * @return array A non-ordered array of field names. 
	 */
	public static function getNumericFields(){
		return self::$numeric_fields;
	}
	
	
	/**
	 * getBooleanFields returns a list of DonationInterface fields that are 
	 * expected to contain boolean values. 
	 * @return array A non-ordered array of field names. 
	 */
	public static function getBooleanFields(){
		return self::$boolean_fields;
	}
	
	
	/**
	 * getErrorToken, intended to be used by classes that exist relatively close 
	 * to the form classes, returns the error token (defined on the forms) that 
	 * specifies *where* the error will appear within the form output. 
	 * @param string $field The field that ostensibly has an error that needs to 
	 * be displayed to the user. 
	 * @return string The error token corresponding to a field, probably in 
	 * RapidHTML. 
	 */
	public static function getErrorToken( $field ){
		$error_token = 'general';
		switch ( $field ) {
			case 'amountGiven' :
			case 'amountOther' :
				$error_token = 'amount';
				break;
			case 'email' :
				$error_token = 'emailAdd';
				break;
			case 'amount' :
			case 'card_num':
			case 'card_type':
			case 'cvv':
			case 'fname':
			case 'lname':
			case 'city':
			case 'country':
			case 'street':
			case 'state':
			case 'zip':
				$error_token = $field;
				break;
		}
		return $error_token;
	}
	
	/**
	 * getEmptyErrorArray
	 * This only exists anymore, to make badly-coded forms happy when they start
	 * pulling keys all over the place without checking to see if they're set or
	 * not. 
	 * @return array All the possible error tokens as keys, with blank errors. 
	 */
	public static function getEmptyErrorArray() {
		return array(
			'general' => '',
			'retryMsg' => '',
			'amount' => '',
			'card_num' => '',
			'card_type' => '',
			'cvv' => '',
			'fname' => '',
			'lname' => '',
			'city' => '',
			'country' => '',
			'street' => '',
			'state' => '',
			'zip' => '',
			'emailAdd' => '',
		);
	}
	
	
	/**
	 * getErrorMessage - returns the translated error message appropriate for a 
	 * validation error on the specified field, of the specified type. 
	 * @param string $field - The common name of the field containing the data 
	 * that is causing the error.
	 * @param type $type - The type of error being caused, from a set. 
	 *	Possible values are: 
	 *		'non_empty' - the value is required and not currently present
	 *		'valid_type' - in general, the wrong format
	 *		'calculated' - fields that failed some kind of multiple-field data 
	 * integrity check.
	 * @param string $value - The value of the field. So far, only used to say 
	 * more precise things about Credit Cards. 
	 */
	public static function getErrorMessage( $field, $type, $language, $value = null ){
		//this is gonna get ugly up in here. 
		//error_log( __FUNCTION__ . " $field, $type, $value " );

		//Empty messages should get: 
		//'donate_interface-error-msg' => 'Please enter your $1';
		//If they have no defined error message, give 'em the default. 
		if ($type === 'non_empty'){
			//NOTE: We are just using the next bit because it's convenient. 
			//getErrorToken is actually for something entirely different: 
			//Figuring out where on the form the error should land.  
			$message_field = self::getErrorToken( $field );
			if ( $field === 'expiration' ){
				$message_field = $field;
			}
			//postal code is a weird one. More L10n than I18n. 
			//'donate_interface-error-msg-postal' => 'postal code',
			
			$error_message_field_string = 'donate_interface-error-msg-' . $message_field;
			if ( $message_field != 'general' && self::wmfMessageExists( $error_message_field_string, $language ) ) {
				return wfMsg( 'donate_interface-error-msg', wfMsg( $error_message_field_string ) );
			} 
		}
		
		if ( $type === 'valid_type' || $type === 'calculated' ) {
			//NOTE: We are just using the next bit because it's convenient. 
			//getErrorToken is actually for something entirely different: 
			//Figuring out where on the form the error should land.  
			$token = self::getErrorToken( $field );
			$suffix = $token; //defaultness
			switch ($token){
				case 'amount': 
					$suffix = 'invalid-amount';
					break;
				case 'emailAdd': 
					$suffix = 'email';
					break;
				case 'card_num': //god damn it.
					$suffix = 'card_num'; //more defaultness.
					if (!is_null($value)){
						$fake_suffix = self::getCardType($value);
						switch ( $fake_suffix ){
							case 'american':
								$suffix = 'amex';
								break;
							case 'mastercard':
								$suffix = 'mc';
								break;
							case 'visa':
							case 'discover':
								$suffix = $fake_suffix;
								break;
						}
					}
					break;
			}
			
			$error_message_field_string = 'donate_interface-error-msg-' . $suffix;			
			if ( self::wmfMessageExists( $error_message_field_string, $language ) ) {
				return wfMsg( $error_message_field_string );
			}
		}
		
		//ultimate defaultness. 
		return wfMsg( 'donate_interface-error-msg-general' );		
	}
	
	
	/**
	 * wmfMessageExists returns true if a translatable message has been defined 
	 * for the string and language that have been passed in, false if none is 
	 * present. 
	 * @param string $msg_key The message string to look up.
	 * @param string $language A valid mediawiki language code.
	 * @return boolean - true if message exists, otherwise false.
	 */
	public static function wmfMessageExists( $msg_key, $language ){
		return wfMessage( $msg_key )->inLanguage( $language )->exists();
	}


	/**
	 * validate
	 * Run all the validation rules we have defined against a (hopefully 
	 * normalized) DonationInterface data set. 
	 * @param array $data The DonationInterface data set, or a subset thereof. 
	 * @param array $check_not_empty An array of fields to do empty validation 
	 * on. If this is not populated, no fields will throw errors for being empty, 
	 * UNLESS they are required for a field that uses them for more complex 
	 * validation (the 'calculated' phase). 
	 * @return array An array of errors in a format ready for any derivitive of 
	 * the main DonationInterface Form class to display. The array will be empty 
	 * if no errors were generated and everything passed OK.  
	 */
	public static function validate( $data, $check_not_empty = array()  ){
		//return the array of errors that should be generated on validate.
		//just the same way you'd do it if you were a form passing the error array around. 
		
		/**
		 * We need to run the validation in an order that makes sense. 
		 * 
		 * First: If we need to validate that some things are not empty, do that. 
		 * Second: Do regular data type validation on things that are not empty.
		 * Third: Do validation that depends on multiple fields (making sure you 
		 * validated that all the required fields exist on step 1, regardless of 
		 * $check_not_empty)
		 * 
		 * So, we need to know what we're about to do for #3 before we actually do #1. 
		 * 
		 * $check_not_empty should contain an array of values that need to be populated. 
		 * One likely candidate for a source there, is the required stomp fields as defined in DonationData. 
		 * Although, a lot of those don't have to have any data in them either. Boo.
		 * 
		 * How about we build an array of shit to do, 
		 * look at it to make sure it's complete, and in order...
		 * ...and do it. 
		 */
		
		$instructions = array(
			'non_empty' => array(),
			'valid_type' => array(), //simple 'valid_type' check functions only have one parameter.
			'calculated' => array(), //'calculated' check functions depend on (or optionally have) more than one value.
		);
		
		if ( !is_array( $check_not_empty ) ){
			$check_not_empty = array( $check_not_empty );
		}
		
		foreach ( $check_not_empty as $field ){ 
			$instructions['non_empty'][$field] = 'validate_not_empty';
		}		
		
		foreach ( $data as $field => $value ){
			//first, unset everything that's an empty string, or null, as there's nothing to validate. 
			if ( $value !== '' && !is_null( $value ) ){
			
				$function_name = self::getValidationFunction( $field );
				$check_type = 'valid_type';
				switch ( $function_name ) {
					case 'validate_amount':
						//Note: We could do something like also validate amount not empty, and then that it's numeric
						//That way we'd get more precisely granular error messages. 
						$check_type = 'calculated';
						$instructions['non_empty']['amount'] = 'validate_not_empty';
						$instructions['valid_type']['amount'] = 'validate_numeric';
						$instructions['non_empty']['currency_code'] = 'validate_not_empty';
						$instructions['valid_type']['currency_code'] = self::getValidationFunction( 'currency_code' );
						$instructions['non_empty']['gateway'] = 'validate_not_empty';
						$instructions['valid_type']['gateway'] = self::getValidationFunction( 'gateway' );
						break;
					case 'validate_card_type':
						$check_type = 'calculated';
						break;
				}
				$instructions[$check_type][$field] = $function_name;
			}
		}
		
		$errors = array();
		
		$self = get_called_class();
		$language = self::getLanguage( $data );
		
		foreach ( $instructions['non_empty'] as $field => $function ){
			if ( method_exists( $self, $function ) && $function === 'validate_not_empty' ) {
				if ( $self::$function( $field, $data ) ){
					$instructions['non_empty'][$field] = true;
				} else {
					$instructions['non_empty'][$field] = false;
					$errors[ self::getErrorToken( $field ) ] = self::getErrorMessage( $field, 'non_empty', $language );
				}
			} else {
				$instructions['non_empty'][$field] === 'exception';
				$errors[ self::getErrorToken( $field ) ] = self::getErrorMessage( $field, 'non_empty', $language );
				throw new MWException( __FUNCTION__ . " BAD PROGRAMMER. No $function function. ('non_empty' rule for $field )" );
			}
		}
		
		foreach ( $instructions['valid_type'] as $field => $function ){
			if ( method_exists( $self, $function ) ) {
				if ( $self::$function( $data[$field] ) ){
					$instructions['valid_type'][$field] = true;
				} else {
					$instructions['valid_type'][$field] = false;
					$errors[ self::getErrorToken( $field ) ] = self::getErrorMessage( $field, 'valid_type', $language );
				}
			} else {
				$instructions['valid_type'][$field] === 'exception';
				$errors[ self::getErrorToken( $field ) ] = self::getErrorMessage( $field, 'valid_type', $language );
				throw new MWException( __FUNCTION__ . " BAD PROGRAMMER. No $function function. ('valid_type' rule for $field)" );
			}
		}
		
		//don't bail out now. Just don't set errors for calculated fields that 
		//have failures in their dependencies. 
		foreach ( $instructions['calculated'] as $field => $function ){
			if ( method_exists( $self, $function ) ) {
				//each of these is going to have its own set of overly 
				//complicated rules and things to check, or we wouldn't be down 
				//here in the calculated section. 
				$result = null;
				switch ( $function ){
					case 'validate_amount':
						if ( self::checkValidationPassed( array( 'currency_code', 'gateway' ), $instructions ) ){
							$result = $self::$function( $data[$field], $data['currency_code'], $data['gateway'] );
						} //otherwise, just don't do the validation. The other stuff will be complaining already. 
						break;
					case 'validate_card_type':
						//the contingent field in this case isn't strictly required, so this is going to look funny. 
						if ( array_key_exists( 'card_number', $instructions['valid_type'] ) && $instructions['valid_type']['card_number'] === true ){
							//if it's there, it had better match up.
							$result = $self::$function( $data[$field], $data['card_number'] );
						} else {
							$result = $self::$function( $data[$field] );
						}
						break;
				}
				
				$instructions['calculated'][$field] = $result;
				if ($result === false){ //implying we did the check, and it failed. 
					$errors[ self::getErrorToken( $field ) ] = self::getErrorMessage( $field, 'calculated', $language, $data[$field] );
				}
				
			} else {
				$instructions['calculated'][$field] === 'exception';
				$errors[ self::getErrorToken( $field ) ] = self::getErrorMessage( $field, 'calculated', $language, $data[$field] );
				throw new MWException( __FUNCTION__ . " BAD PROGRAMMER. No $function function. ('calculated' rule for $field)" );
			}
		}
//		error_log( __FUNCTION__ . " " . print_r( $instructions, true ) );
//		error_log( print_r( $errors, true ) );
		return $errors;
	}
	
	
	/**
	 * checkValidationPassed is a validate helper function. 
	 * In order to determine that we are ready to do the third stage of data 
	 * validation (calculated) for any given field, we need to determine that 
	 * all fields required to validate the original have, themselves, passed 
	 * validation. 
	 * @param array $fields An array of field names to check.
	 * @param array $instruction_results The $instructions array used in the 
	 * validate function. 
	 * @return boolean true if all fields specified in $fields passed their 
	 * non_empty and valid_type validation. Otherwise, false.
	 */
	protected static function checkValidationPassed( $fields, $instruction_results ){
		foreach ( $fields as $field ){
			if ( !array_key_exists( $field, $instruction_results['non_empty'] ) || $instruction_results['non_empty'][$field] !== true ){
				return false;
			}
			if ( !array_key_exists( $field, $instruction_results['valid_type'] ) || $instruction_results['valid_type'][$field] !== true ){
				return false;
			}
		}
		return true;
	}
	
	
	/**
	 * getValidationFunction returns the function to use to validate the given field. 
	 * @param string $field The name of the field we need to validate. 
	 */
	static function getValidationFunction( $field ){
		switch ( $field ){
			case 'email':
				return 'validate_email';
				break;
			case 'amount': //we only have to do the one: It will have been normalized by now. 
				return 'validate_amount'; //this one is interesting. Needs two params. 
				break;
			case 'card_num':
				return 'validate_credit_card';
				break;
			case 'card_type':
				return 'validate_card_type';
				break;
			case 'gateway':
				return 'validate_gateway';
				break;
		}

		if ( in_array( $field, self::getNumericFields() ) ){
			return 'validate_numeric';
		}
		
		if ( in_array( $field, self::getBooleanFields() ) ){
			return 'validate_boolean';
		}
		
		return 'validate_alphanumeric'; //Yeah, this won't work.  
	}
	
	
	/**
	 * validate_email
	 * Determines if the $value passed in is a valid email address. 
	 * @param string $value The piece of data that is supposed to be an email 
	 * address. 
	 * @return boolean True if $value is a valid email address, otherwise false.  
	 */
	protected static function validate_email( $value ){
		// is email address valid?
		$isEmail = User::isValidEmailAddr( $value );
		return $isEmail;
	}
	
	
	/**
	 * validate_amount
	 * Determines if the $value passed in is a valid amount. 
	 * NOTE: You will need to make sure that currency_code is populated before 
	 * you get here. 
	 * @param string $value The piece of data that is supposed to be an amount. 
	 * @param string $currency_code Valid amounts depend on there being a 
	 * currency code also. This also needs to be passed in. 
	 * @param string $gateway The gateway needs to be provided so we can 
	 * determine that gateway's current price floor and ceiling.  
	 * @return boolean True if $value is a valid amount, otherwise false.  
	 */
	protected static function validate_amount( $value, $currency_code, $gateway ){
		if ( !$value || !$currency_code || !is_numeric( $value ) ) {
			return false;
		}
		
		// check amount
		$gateway_class = self::getGatewayClass($gateway);
		if ( !$gateway_class ){
			return false;
		}
		
		$priceFloor = $gateway_class::getGlobal( 'PriceFloor' );
		$priceCeiling = $gateway_class::getGlobal( 'PriceCeiling' );
		if ( !preg_match( '/^\d+(\.(\d+)?)?$/', $value ) ||
			( ( float ) self::convert_to_usd( $currency_code, $value ) < ( float ) $priceFloor ||
			( float ) self::convert_to_usd( $currency_code, $value ) > ( float ) $priceCeiling ) ) {
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * validate_card_type
	 * Determines if the $value passed in is (possibly) a valid credit card type.
	 * @param string $value The piece of data that is supposed to be a credit card type.
	 * @param string $card_number The card number associated with this card type. Optional.
	 * @return boolean True if $value is a reasonable credit card type, otherwise false.  
	 */
	protected static function validate_card_type( $value, $card_number = '' ) {
		if ( !array_key_exists( $value, self::$card_types ) ){
			return false;
		}
		
		if ( $card_number != '' ){
			$calculated_card_type = self::getCardType( $card_number );
			if ( $calculated_card_type != $value ){
				return false;
			}
		}
		
		return true;
	}
	
	
	/**
	 * validate_credit_card
	 * Determines if the $value passed in is (possibly) a valid credit card number.
	 * @param string $value The piece of data that is supposed to be a credit card number.
	 * @return boolean True if $value is a reasonable credit card number, otherwise false.  
	 */
	protected static function validate_credit_card( $value ) {
		$calculated_card_type = self::getCardType( $value );
		if ( !$calculated_card_type ){
			return false;
		}
		
		return true;
	}
	
	
	/**
	 * validate_boolean
	 * Determines if the $value passed in is a valid boolean. 
	 * @param string $value The piece of data that is supposed to be a boolean.
	 * @return boolean True if $value is a valid boolean, otherwise false.  
	 */
	protected static function validate_boolean( $value ){
		switch ($value) {
			case 0:
			case '0':
			case false:
			case 'false':
			case 1:
			case '1':
			case true:
			case 'true':
				return true;
				break;
		}
		return false;
	}
	
	
	/**
	 * validate_numeric
	 * Determines if the $value passed in is numeric. 
	 * @param string $value The piece of data that is supposed to be numeric.
	 * @return boolean True if $value is numeric, otherwise false.  
	 */
	protected static function validate_numeric( $value ){
		//instead of validating here, we should probably be doing something else entirely. 
		if ( is_numeric( $value ) ) { 
			return true;
		}
		return false;
	}
	
	
	/**
	 * validate_gateway
	 * Checks to make sure the gateway is populated with a valid and enabled 
	 * gateway. 
	 * @param string $value The value that is meant to be a gateway. 
	 * @return boolean True if $value is a valid gateway, otherwise false
	 */
	protected static function validate_gateway( $value ){
		if ( self::getGatewayClass( $value ) ){
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * validate_not_empty
	 * Checks to make sure that the $value is present in the $data array, and not null or an empty string. 
	 * Anything else that is 'falseish' is still perfectly valid to have as a data point. 
	 * TODO: Consider doing this in a batch. 
	 * @param string $value The value to check for non-emptyness.
	 * @param array $data The whole data set. 
	 * @return boolean True if the $value is not missing or empty, otherwise false.
	 */
	protected static function validate_not_empty( $value, $data ){
		if ( !array_key_exists( $value, $data ) || is_null( $data[$value] ) || $data[$value] === '' ){
			return false;
		}
		return true;
	}
	
	/**
	 * validate_alphanumeric
	 * Checks to make sure the value is populated with an alphanumeric value...
	 * ...which would be great, if it made sense at all. 
	 * TODO: This is duuuuumb. Make it do something good, or get rid of it.
	 * If we can think of a way to make this useful, we should do something here. 
	 * @param string $value The value that is meant to be alphanumeric
	 * @return boolean True if $value is ANYTHING. Or not. :[
	 */
	protected static function validate_alphanumeric( $value ){
		return true;
	}
	
	
	/**
	 * getGatewayClass
	 * This exists to enable things like logging to the correct gateway, and 
	 * retrieving gateway-specific globals. 
	 * @param string $gateway The gateway identifier. 
	 * @return string The name of the gateway class associated with that 
	 * identifier, or false if none exists. 
	 */
	protected static function getGatewayClass( $gateway ) {
		if ( array_key_exists( $gateway, self::$gateway_classes ) && class_exists( self::$gateway_classes[$gateway] ) ){
			return self::$gateway_classes[$gateway];
		}
		return false;
	}
	
	
	/**
	 * Convert an amount for a particular currency to an amount in USD
	 *
	 * This is grosley rudimentary and likely wildly inaccurate.
	 * This mimicks the hard-coded values used by the WMF to convert currencies
	 * for validatoin on the front-end on the first step landing pages of their
	 * donation process - the idea being that we can get a close approximation
	 * of converted currencies to ensure that contributors are not going above
	 * or below the price ceiling/floor, even if they are using a non-US currency.
	 *
	 * In reality, this probably ought to use some sort of webservice to get real-time
	 * conversion rates.
	 *
	 * @param string $currency_code
	 * @param float $amount
	 * @return float
	 */
	public static function convert_to_usd( $currency_code, $amount ) {
		require_once( dirname( __FILE__ ) . '/currencyRates.inc' );
		$rates = getCurrencyRates();
		$code = strtoupper( $currency_code );
		if ( array_key_exists( $code, $rates ) ) {
			$usd_amount = $amount / $rates[$code];
		} else {
			$usd_amount = $amount;
		}
		return $usd_amount;
	}
	
	
	/**
	 * Calculates and returns the card type for a given credit card number. 
	 * @param numeric $card_num A credit card number.
	 * @return mixed 'american', 'mastercard', 'visa', 'discover', or false. 
	 */
	public static function getCardType( $card_num ) {
		// validate that credit card number entered is correct and set the card type
		if ( preg_match( '/^3[47][0-9]{13}$/', $card_num ) ) { // american express
			return 'american';
		} elseif ( preg_match( '/^5[1-5][0-9]{14}$/', $card_num ) ) { //	mastercard
			return 'mastercard';
		} elseif ( preg_match( '/^4[0-9]{12}(?:[0-9]{3})?$/', $card_num ) ) {// visa
			return 'visa';
		} elseif ( preg_match( '/^6(?:011|5[0-9]{2})[0-9]{12}$/', $card_num ) ) { // discover
			return 'discover';
		} else { // an unrecognized card type was entered
			return false;
		}
	}
	
	/**
	 * getLanguage
	 * Returns a valid mediawiki language code to use for all the 
	 * DonationInterface translations.
	 * Will only look at the currently configured language if the 'language' key 
	 * doesn't exist in the data set: Users may not have a language preference 
	 * set if we're bouncing between mediawiki instances for payments.
	 * @param array $data A normalized DonationInterface data set. 
	 * @return string A valid mediawiki language code. 
	 */
	public static function getLanguage( $data ) {
		global $wgLang;
		if ( array_key_exists( 'language', $data )
			&& Language::isValidBuiltInCode( $data['language'] ) ) {
			return $data['language'];
		} else {
			return $wgLang->getCode();
		}		
	}
	
}
