<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * This class contains static functions for dealing with very simple requests
 * that are designed to be easily called from external code (ie: whatever framework
 * is using ApiGate inside of it).
 */

class ApiGate{
	// Status codes that we use. Commented out the status codes that we don't use yet but are likely to soon.
	const HTTP_STATUS_OK = 200;
	const HTTP_STATUS_UNAUTHORIZED = 401; // when there is no key provided (but should be) or the key is invalid (a bad format, or just isn't an actual key in the database).
	const HTTP_STATUS_FORBIDDEN = 403; // when an api key makes a request to a function that it is not allowed to use.
	//const HTTP_STATUS_IM_A_TEAPOT = 418; // not sure what this will come in use for ;)
	//const HTTP_STATUS_INSUFFICIENT_STORAGE = 507; // would come in handy for APIs which have per-key or per-user storage limits on accounts.
	
	// TODO: Do we need separate codes for rate-limiting and for when an admin blocks them?
	const HTTP_STATUS_LIMIT_EXCEEDED = 509; // bandwidth exceeded code. closest to rate-limiting. this is what the user will see when they have been blocked by automatic rate-limiting or manually by an admin.

	const TABLE_KEYS = "apiGate_keys";
	const TABLE_USERS = "apiGate_users";
	const TABLE_BANLOG = "apiGate_banLog";

	/**
	 * Checks to see if the API Key is valid and allowed to make calls (ie: is not banned).
	 *
	 * If more specific checking is needed (method-specific), use ApiGate::isRequestAllowed() instead. Please
	 * note that isRequestAllowed might not be any different (at the time of this writing, method-specific permissions
	 * per key are not implemented, so isRequestAllowed() is identical to checkKey()).
	 *
	 * For most uses, you'll probably want to use isRequestAllowed() since that will allow the method-specific permissions
	 * per key once implemented.
	 *
	 * @param apiKey - string - the API key to check for validity.
	 * @return int - an HTTP status code such as 200 if okay, 401 if auth wasn't provided (but was needed), 509 if the key has been rate-limited, etc..
	 */
	public static function checkKey( $apiKey ){
		wfProfileIn( __METHOD__ );

		$retVal = ApiGate::HTTP_STATUS_OK;
		
		// HARDCODED FOR DEBUGGING.  An "apiKey" of 509 (which wouldn't be an actual API key) will return a status-code of 509 for testing/debugging.
		if($apiKey == "509"){
			$retVal = ApiGate::HTTP_STATUS_LIMIT_EXCEEDED;
		} else if($apiKey == ""){
			// TODO: If the API gets to a point where the auth is always required, uncomment this.
			//$retVal = ApiGate::HTTP_STATUS_UNAUTHORIZED;
		} else {
			// Find if the API key is in the database and is enabled.
			$dbr = ApiGate_Config::getSlaveDb();
			$queryString = "SELECT enabled FROM ".ApiGate::TABLE_KEYS." WHERE apiKey='".mysql_real_escape_string( $apiKey, $dbr )."'";
			$enabled = ApiGate::simpleQuery( $queryString );
			if($enabled === ""){
				// The API key was not in the database.
				$retVal = ApiGate::HTTP_STATUS_UNAUTHORIZED;
			} else if($enabled === "0"){
				$retVal = ApiGate::HTTP_STATUS_LIMIT_EXCEEDED;
			} else {
				$retVal = ApiGate::HTTP_STATUS_OK;
			}
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end checkKey()
	
	/**
	 * Returns true if the apiKey provided is allowed to access the methods defined in the fullRequest.
	 *
	 * NOTE: For now, this is just a wrapper around checkKey(), but you should use this wherever possible in order to
	 * be forward-compatible for when this function has the ability to do method-specific permissions per API key.
	 *
	 * Initially, API Gate will have functionality which allows functions to specify whether or not they require an API
	 * key (see ApiGate::requiresApiKey()) and then keys will be checked for validity (and whether or not they are banned)
	 * on those calls. However, there is not initially going to be the ability to say (for example) that "key A can access
	 * foo() but not bar() and key B can access foo() and bar()".  That will probably be implemented eventually though (when
	 * someone needs it).
	 * 
	 * @param apiKey - string - the API key of the app which this method will check the permissions for.
	 * @param fullRequest - [mixed] - information about the full request. This should be an associative array of this structure:
	 *                                array(method => (the method name), params => (associative array of key-value pairs of parameters and their values)).
	 *                                TODO: For XML-RPC, JSON-RPC, etc. have a static function that will parse a query-string into these for the caller so
	 *                                that they don't have to do a bunch of work just to fill in that second parameter.
	 * @return int - an HTTP status code such as 200 if okay, 401 if auth wasn't provided (but was needed), 403 if auth was provided but does not have
	 *               permission to make the requested call, 509 if the key has been rate-limited, etc..
	 */
	public static function isRequestAllowed($apiKey, $fullRequest){
		wfProfileIn( __METHOD__ );

		$isAllowed = self::checkKey($apiKey);

		// LATER: In future versions, implement this so that API keys can be given access to certain methods and not others.
		// LATER: In future versions, implement this so that API keys can be given access to certain methods and not others.

		wfProfileOut( __METHOD__ );
		return $isAllowed;
	} // end isRequestAllowed()
	
	/**
	 * This function will return appropriate headers and a message-body which just indicate whether the given API key
	 * has permission to access the request in fullRequest.
	 *
	 * This is meant to be called and in the majority of uses, the calling-code should immediately exit afterwards.
	 *
	 * @param apiKey - string - the API key of the app which this method will check the permissions for.
	 * @param fullRequest - [mixed] - information about the full request. This should be an associative array of this structure:
	 *                                array(method => (the method name), params => (associative array of key-value pairs of parameters and their values)).
	 *                                TODO: For XML-RPC, JSON-RPC, etc. have a static function that will parse a query-string into these for the caller so
	 *                                that they don't have to do a bunch of work just to fill in that second parameter.
	 */
	public static function isRequestAllowed_endpoint( $apiKey, $fullRequest ){
		wfProfileIn( __METHOD__ );

		$responseCode = self::isRequestAllowed( $apiKey, $fullRequest );

		// Based on the response-code, set the headers and give a reasonable human-readable error-message.
		switch( $responseCode ){ // in numerical order except for 200 since that's the default (so it goes at the end)
			case ApiGate::HTTP_STATUS_UNAUTHORIZED:
				//header("Status: 401 Unauthorized"); // Fast CGI need status.  TODO: Have a way to detect if this is Fast CGI or not and choose the correct header type.
				header("HTTP/1.0: 401 Unauthorized");
				if( empty($apiKey) ){
					print i18n('apigate-checkkey-no-apikey-found');
				} else {
					print i18n('apigate-checkkey-invalid-apikey', $apiKey);
				}
			break;

			case ApiGate::HTTP_STATUS_FORBIDDEN:
				header("HTTP/1.0: 403 Forbidden");
				print i18n( 'apigate-checkkey-forbidden' );
			break;

			case ApiGate::HTTP_STATUS_LIMIT_EXCEEDED:
				header("HTTP/1.0: 509 Bandwidth Limit Exceeded");
				print i18n( 'apigate-checkkey-limit-exceeded' );
			break;

			case ApiGate::HTTP_STATUS_OK:
			default:
				header("HTTP/1.0: 200 OK");
				print i18n( 'apigate-checkkey-ok' );
			break;
		}

		wfProfileOut( __METHOD__ );
	} // end isRequestAllowed_endpoint()

	/**
	 * During the serving of an API request, prior to finishing of sending headers, this function should
	 * be called if the API request should require an API key.  This will set the appropriate header to let
	 * the proxy know that the resource should only be served if a valid API key was provided.
	 */
	public static function requiresApiKey(){
		wfProfileIn( __METHOD__ );
		global $APIGATE_HEADER_REQUIRES_API;

		header( "{$APIGATE_HEADER_REQUIRES_API}: 1" );

		// TODO: LATER: For users who DON'T use the proxy method, there should probably be a call to isRequestAllowed() and a handling of the failure case.

 		wfProfileOut( __METHOD__ );
	} // end requiresApiKey()

	/**
	 * If this installation of API Gate is using the proxy system (as opposed to running inline), then this method will purge any
	 * caches of key-state for the provided key. For instance, Fastly caches a page which says whether an API key is valid & within its rate-limit.
	 * When that key gets banned, this page needs to be purged, so code which uses ApiGate in conjunction with Fastly will implement the code that
	 * will purge this Fastly page inside of its ApiGate_Config::purgeKey() function.
	 *
	 * Among other things, this method is called by  teh functionality to ban keys, after the ban takes place.
	 *
	 * @param apiKey - string - the API key to purge from caches as needed.
	 */
	protected static function purgeKey( $apiKey ){
		wfProfileIn( __METHOD__ );

		// NOTE: If your implementation needs to purge something after a ban, implement that in ApiGate_Config::purgeKey().
		ApiGate_Config::purgeKey( $apiKey );

		wfProfileOut( __METHOD__ );
	} // end purgeKey()
	
	/**
	 * @param userId - user id to use to search for associated api keys.
	 * @return array - array of API keys (empty array if there are no keys associated with that user-id)
	 */
	public static function getKeysByUserId( $userId ) {
		wfProfileIn( __METHOD__ );
		
		$apiKeys = array();
		
		$dbr = ApiGate_Config::getSlaveDb();
		$queryString = "SELECT apiKey FROM ".ApiGate::TABLE_KEYS." WHERE user_id='". mysql_real_escape_string( $userId, $dbr ). "'";
		if( $result = mysql_query( $queryString, $dbr ) ){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				for($cnt=0; $cnt<$numRows; $cnt++){
					$apiKeys[] = mysql_result($result, $cnt, "apiKey");
				}
			}
		} else {
			ApiGate::queryError($queryString, $dbr);
		}

		wfProfileOut( __METHOD__ );
		return $apiKeys;
	} // end getKeysByUserId()
	
	/**
	 * @param userId - user id to use to search for associated api keys.
	 * @return array - array of API keys and their nicknames (empty array if there are no keys associated with that user-id). Each
	 *                 element of the array is an associative array with two keys: "apiKey" and "nickName". If the key does not have an explicit nickname,
	 *                 the apiKey will be put into the nickName field (so the calling code can always count on a nickName being present).
	 */
	public static function getKeyDataByUserId( $userId ) {
		wfProfileIn( __METHOD__ );

		$apiKeys = array();

		$dbr = ApiGate_Config::getSlaveDb();
		$queryString = "SELECT * FROM ".ApiGate::TABLE_KEYS." WHERE user_id='". mysql_real_escape_string( $userId, $dbr ). "'";
		if( $result = mysql_query( $queryString, $dbr ) ){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				for($cnt=0; $cnt<$numRows; $cnt++){
					$apiKey = mysql_result($result, $cnt, "apiKey");
					$enabled = (mysql_result($result, $cnt, "enabled") === "1");
					$nickName = mysql_result($result, $cnt, "nickName");
					$nickName = ($nickName=="" ? $apiKey : $nickName); // use apiKey as default if no nickName provided
					$userId = mysql_result($result, $cnt, "user_id");
					$userName = ApiGate_Config::getUserNameById( $userId );
					$apiKeys[] = array(
						"apiKey" => $apiKey,
						"nickName" => $nickName,
						"userId" => $userId,
						"userName" => $userName,
						"enabled" => $enabled
					);
				}
			}
		} else {
			ApiGate::queryError($queryString, $dbr);
		}

		wfProfileOut( __METHOD__ );
		return $apiKeys;
	} // end getKeyDataByUserId()
	
	/**
	 * Returns an array of all keys in the system and their associated data(nicknames, whether they're enabled or not, etc.) in the system (with optional limit & offset).
	 *
	 * This data should NOT be displayed to end-users other than admins.
	 */
	public static function getAllKeyData( $limit="", $offset=""){
		wfProfileIn( __METHOD__ );

		$apiKeys = array();

		$dbr = ApiGate_Config::getSlaveDb();
		$queryString = "SELECT apiKey,nickName,enabled,user_id FROM ".ApiGate::TABLE_KEYS;
		if($limit != ""){
			$offsetStr = (($offset == "") ? "" : ",".mysql_real_escape_string( $offset, $dbr ) );
			$queryString .= " LIMIT ".mysql_real_escape_string( $limit, $dbr )."$offsetStr";
		}
		if( $result = mysql_query( $queryString, $dbr ) ){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				for($cnt=0; $cnt<$numRows; $cnt++){
					$apiKey = mysql_result($result, $cnt, "apiKey");
					$enabled = (mysql_result($result, $cnt, "enabled") === "1");
					$nickName = mysql_result($result, $cnt, "nickName");
					$nickName = ($nickName=="" ? $apiKey : $nickName); // use apiKey as default if no nickName provided
					$userId = mysql_result($result, $cnt, "user_id");
					$userName = ApiGate_Config::getUserNameById( $userId );

					$apiKeys[] = array(
						"apiKey" => $apiKey,
						"nickName" => $nickName,
						"enabled" => $enabled,
						"userId" => $userId,
						"userName" => $userName,
					);
				}
			}
		} else {
			ApiGate::queryError($queryString, $dbr);
		}

		wfProfileOut( __METHOD__ );
		return $apiKeys;
	} // end getAllKeyData()

	/**
	 * Sends a WRITE query (usually an insert/update/delete) and returns true on success false on failure.
	 * Nothing sophisticated here, just makes the code shorter by saving the need
	 * for other pieces of code to get the global connection to the db.
	 *
	 * NOTE: for WRITE queries primarily (although both will work, use simpleQuery() for read-only queries).
	 */
	public static function sendQuery( $queryString ){
		wfProfileIn( __METHOD__ );

		$dbw = ApiGate_Config::getMasterDb();
		$retVal = mysql_query($queryString, $dbw);

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end sendQuery()

	/**
	 * Returns the result of a READ-ONLY mySQL query that only has one result (one column and one row)
	 *
	 * NOTE: for READ-ONLY operations
	 */
	public static function simpleQuery( $queryString ){
		wfProfileIn( __METHOD__ );

		$dbr = ApiGate_Config::getSlaveDb();
		$retVal = "";
		if($result = mysql_query($queryString,$dbr)){
			if(mysql_num_rows($result) > 0){
				if($myRow = mysql_fetch_row($result)){
					$retVal = $myRow[0];
				}
			}
		} else {
			ApiGate::queryError($queryString, $dbr);
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end simpleQuery()
	
	/**
	 * Prints a mysql error.
	 */
	public static function queryError( $queryString, $db, $returnAsString=false ){
		$errorString = i18n( 'apigate-mysql-error', $queryString, mysql_error( $db ) );
		if($returnAsString){
			return ApiGate::getErrorHtml( $errorString );
		} else {
			ApiGate::printError( $errorString );
		}
	} // end queryError()
	
	/**
	 * Prints the provided error string inside of some standard HTML for errors in the system.
	 */
	public static function printError( $errorString ){
		print ApiGate::getErrorHtml( $errorString );
	} // end printError()
	
	/**
	 * Returns a string containing the error message inside of some standard HTML for errors in the system.
	 */
	public static function getErrorHtml( $errorString ){
		ApiGate_Dispatcher::renderTemplate( "error", array('message' => $errorString));
	} // end getErrorHtml()

	/**
	 * Helper-function to grab a posted value with an optional default value (which itself defaults to empty-string).
	 */
	public static function getPost( $varName, $default='' ){
		return ( isset($_POST[$varName]) ? $_POST[$varName] : $default );
	} // end getPost()
	
	/**
	 * Returns true if the string passed in is a valid format to be an email addr.
	 */
	public static function isValidEmail( $emailAddr ){
		return ( preg_match('/^[a-z0-9._%+-]+@(?:[a-z0-9\-]+\.)+[a-z]{2,4}$/i', $emailAddr) !== 0 );
	} // end isValidEmail()

} // end class ApiGate
