<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * This is the configuration file for API Gate.
 */

/** SETTINGS THAT MUST BE CUSTOMIZED **/
	$APIGATE_CONTACT_EMAIL = "api@wikia.com";
	
	global $wgScriptPath, $wgArticlePath, $wgDevelEnvironment;
	$APIGATE_LINK_ROOT = str_replace("$1", "Special:ApiGate", $wgArticlePath);

	// Wikia-specific settings (ie: not used by ApiGate in general)
	$WIKIA_CITYID_APIWIKI = "352316";
	if( empty( $wgDevelEnvironment ) ) {
		// used because Special:ApiGate should be on all wikis (where it will appear in user-links) but the page should redirect to the version on API Wiki.
		$APIGATE_API_WIKI_SPECIAL_PAGE = "http://api.wikia.com/wiki/Special:ApiGate";
	} else {
		$APIGATE_API_WIKI_SPECIAL_PAGE = "http://api.sean.wikia-dev.com/wiki/Special:ApiGate";
	}
/** /SETTINGS THAT MUST BE CUSTOMIZED **/
 

/** HEADERS **/
	// Expected & understood by Fastly (a CDN that has worked with API Gate) to indicate that this result requires a valid API key in the request.
	$APIGATE_HEADER_REQUIRES_API = "X-Requires-ApiKey";

	// Recommended that each app override this for clarity.  Example value (follows a widely used convention): "X-Wikia-API-Key".
	//$APIGATE_HEADER_API_KEY = "X-ApiGate-API-Key";
	$APIGATE_HEADER_API_KEY = "X-Wikia-API-Key"; // TODO: Can we separate Wikia's default config from ApiGate's default config easily?
/** /HEADERS **/


/** HTTP STATUS CODES **/
	$APIGATE_HTTP_STATUS_OK = 200;
	$APIGATE_HTTP_STATUS_FAILED_AUTH = 401;
	$APIGATE_HTTP_STATUS_RATE_LIMITED = 509; // 509 means "Bandwidth exceeded" which is the closest match.
	//$APIGATE_HTTP_STATUS_TEAPOT = 418; // unused, for now ;)
/** /HTTP STATUS CODES **/



// MediaWiki-specific wrapper to let us get the database connection using MediaWiki's normal connection and loadbalancing code.
$dir = dirname( __FILE__ );

/**
 * Class for holding static functions related specifically to config (database connections, accessing current user-id, etc.).
 *
 * If you're looking for the wrappers for doing the simple database operations such as simpleQuery() and sendQuery(), please see ApiGate.class.php.
 */
class ApiGate_Config{

	/**
	 * ApiGate has the concept of an admin of the system, whereas MediaWiki just assigns rights to users in given groups.  This function
	 * offers the bridge between ApiGate and any other permissions-management system.
	 *
	 * Function must return true if there is a user logged in and that user is an administrator of this ApiGate deployment.
	 */
	public static function isAdmin(){
		global $wgUser;
		return $wgUser->isAllowed( 'apigate_admin' );
	} // end isAdmin()

	public static function getSlaveDb(){
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbr =& wfGetDB (DB_SLAVE, array(), $wgExternalSharedDB);
		$db = self::extractDbConnection( $dbr );

		wfProfileOut( __METHOD__ );
		return $db;
	} // end getSlaveDb()

	public static function getMasterDb(){
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );
		
		$dbw =& wfGetDB (DB_MASTER, array(), $wgExternalSharedDB);
		$db = self::extractDbConnection( $dbw );

		wfProfileOut( __METHOD__ );
		return $db;
	} // end getMasterDb()
	
	public static function getUserId(){
		global $wgUser;
		return $wgUser->getId();
	} // end getUserId()
	
	public static function getUsername(){return self::getUserNameById( self::getUserId() );}
	
	/**
	 * TODO: ApiGate should have some default for this which just returns the userId, and an overriding implementation should decide on its own
	 * if it wants to make this do-able.  If ApiGate has its own system for creating users, then the default should be to get the username from the
	 * apiGate_users table's username field.
	 *
	 * @param - string - The user id from the apiGate_keys.user_id field.  This deployment of ApiGate should override it 
	 * @param - string - The username of the user with id 'userId' in the system (in our case, the Wikia userName). If no match is found, the userId will be used as the username.
	 */
	public static function getUserNameById( $userId ){
		wfProfileIn( __METHOD__ );

		$userName = $userId;
		$userObj = User::newFromId( $userId );
		if( is_object( $userObj ) ){
			$userName= $userObj->getName();
		}

		wfProfileOut( __METHOD__ );
		return $userName;
	} // end getUserNameById()
	
	/**
	 * Extracts the mConn mysql database resource from a MediaWiki database object.  The mConn
	 * is protected... but we really want to access it ;)
	 */
	private static function extractDbConnection( $dbObject ){
		wfProfileIn( __METHOD__ );

		$reflect = new ReflectionClass($dbObject);
		//$allProps = $reflect->getProperties();
		//$protectedProps = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
		$mConnProp = $reflect->getProperty('mConn');
		$mConnProp->setAccessible(true);
		$value = $mConnProp->getValue( $dbObject );

		wfProfileOut( __METHOD__ );
		return $value;
	} // end extractDbConnection()

	/**
	 * Purges the API key passed in.  This is in config so that each implementation can
	 * override it as needed.  This particular implmentation is MediaWiki-specific.
	 */
	public static function purgeKey( $apiKey ){
		global $wgUseSquid, $wgServer;
		wfProfileIn( __METHOD__ );

		if ( $wgUseSquid ) {
			// Send purge to Fastly so that it re-checks the auth on the next API request.
			$title = $wgServer."/api.php?checkKey=$apiKey";
			$update = SquidUpdate::newSimplePurge( $title );
			$update->doUpdate();
		}

		wfProfileOut( __METHOD__ );
	} // end purgeKey()
	
} // end class ApiGate_Config
