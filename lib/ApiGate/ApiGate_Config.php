<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * MediaWiki-specific wrapper to let us get the database connection using MediaWiki's normal connection and loadbalancing code.
 */

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
