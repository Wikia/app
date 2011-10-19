<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * This is the configuration file for API Gate.
 */


/** HEADERS **/
	// Expected & understood by Fastly (a CDN that has worked with API Gate) to indicate that this result requires a valid API key in the request.
	$APIGATE_HEADER_REQUIRES_API = "X-Requires-ApiKey";

	// Recommended that each app override this for clarity.  Example value (follows a widely used convention): "X-Wikia-API-Key".
	//$APIGATE_HEADER_API_KEY = "X-ApiGate-API-Key";
	$APIGATE_HEADER_API_KEY = "X-Wikia-API-Key"; // TODO: Can we separate Wikia's default config from 
/** /HEADERS **/


/** HTTP STATUS CODES **/
	$APIGATE_HTTP_STATUS_OK = 200;
	$APIGATE_HTTP_STATUS_FAILED_AUTH = 401;
	$APIGATE_HTTP_STATUS_RATE_LIMITED = 509; // 509 means "Bandwidth exceeded" which is the closest match.
	//$APIGATE_HTTP_STATUS_TEAPOT = 418; // unused, for now ;)
/** /HTTP STATUS CODES **/



// MediaWiki-specific wrapper to let us get the database connection using MediaWiki's normal connection and loadbalancing code.
$dir = dirname( __FILE__ );
include "$dir/DatabaseConnectionWrapper.php";

/**
 * Class for holding static functions related specifically to config (database connections, accessing current user-id, etc.).
 *
 * If you're looking for the wrappers for doing the simple database operations such as simpleQuery() and sendQuery(), please see ApiGate.class.php.
 */
class ApiGate_Config{

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
	}
	
} // end class ApiGate_Config
