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

	/**
	 * Calling this funcction will ban the API key from all apiKey-required api calls.
	 *
	 * The reason will be recorded & displayed to the user on their error page.
	 *
	 * @param apiKey - string - the API key that should be banned.
	 * @param reason - string - a human-readable string explaning why they were banned (this will be shown to
	 *                          the owner of the key so that they can figure out what went wrong).
	 * @return void
	 */
	public static function banKey( $apiKey, $reason ){
		wfProfileIn( __METHOD__ );

		// TODO: IMPLEMENT
		// TODO: IMPLEMENT
		
		self::purgeKey( $apiKey );
		
		wfProfileOut( __METHOD__ );
	} // end banKey()

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
	 * @return boolean - true if the key is valid (ie: it exists) and is not banned, false if the key is not known or is banned.
	 */
	public static function checkKey( $apiKey ){
		wfProfileIn( __METHOD__ );

		// TODO: IMPLEMENT
		// TODO: IMPLEMENT

		wfProfileOut( __METHOD__ );
		return true;
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
	 * @param apiKey - string - the API key of the app which this method will check the permissions for
	 * @param fullRequest - [mixed] - information about the full request. This should be an associative array of this structure:
	 *                                array(method => (the method name), params => (associative array of key-value pairs of parameters and their values)).
	 *                                TODO: For XML-RPC, JSON-RPC, etc. have a static function that will parse a query-string into these for the caller so
	 *                                that they don't have to do a bunch of work just to fill in that second parameter.
	 * @return boolean - true if the given request is allowed for the given api key, false if it is not allowed (this may be because of rate-limiting, or
	 *                   just that the key does not have permission to access the requested resource.  TODO: Figure out a good way to pass the error back
	 *                   if desired (so that the developer isn't confused about why they got bounced & can work towards solving the issue).
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
	 * During the serving of an API request, prior to finishing of sending headers, this function should
	 * be called if the API request should require an API key.  This will set the appropriate header to let
	 * the proxy know that the resource should only be served if a valid API key was provided.
	 */
	public static function requiresApiKey(){
		wfProfileIn( __METHOD__ );
		global $APIGATE_HEADER_REQUIRES_API;

		header( "{$APIGATE_HEADER_REQUIRES_API}: 1" );

		// TODO: LATER: For users who DON'T use the proxy method, there should probably be a call to isRequestAllowed() and a handling of the failure case.
		// TODO: LATER: For users who DON'T use the proxy method, there should probably be a call to isRequestAllowed() and a handling of the failure case.

 		wfProfileOut( __METHOD__ );
	} // end requiresApiKey()

	/**
	 * If this installation of API Gate is using the proxy system (as opposed to running inline), then this method will purge any
	 * caches of key-state for the provided key. For instance, Fastly caches a page which says whether an API key is valid & within its rate-limit.
	 * When that key gets banned, this page needs to be purged, so code which uses ApiGate in conjunction with Fastly will override this method with
	 * code that will purge this Fastly page.
	 *
	 * Among other things, this method is called by ApiGate::banKey() after the ban takes place.
	 *
	 * @param apiKey - string - the API key to purge from caches as needed.
	 */
	private static function purgeKey( $apiKey ){
		wfProfileIn( __METHOD__ );

		// TODO: If your implementation needs to purge something after a ban, extend this class and override this method.
		// TODO: If your implementation needs to purge something after a ban, extend this class and override this method.

		wfProfileOut( __METHOD__ );
	} // end purgeKey()

} // end class ApiGate
