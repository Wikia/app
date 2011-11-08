<?php
/**
 * @author Sean Colombo
 * @date 20111107
 *
 * Represents a single API key in the API Gate system.
 */

class ApiGate_ApiKey {
	private $userId; // who owns this key
	private $apiKey;
	private $nickName;
	private $enabled;
	private $email;
	private $firstName;
	private $lastName;
	private $reasonBanned = null; // lazy-loaded. Null if not loaded. If loaded and empty, it will be an empty-string.
	
	public function getApiKey(){return $this->apiKey;}
	public function getNickName(){return $this->nickName;}
	public function isEnabled(){return $this->enabled;}
	public function getFirstName(){return $this->firstName;}
	public function getLastName(){return $this->lastName;}
	public function getEmail(){return $this->email;}

	/**
	 * Tries to mutate this object to have all the traits of the apiKey defined in the parameters (as loaded from the
	 * database).
	 *
	 * @return boolean - true if the key was found & loaded, false if the key was not found in the database.
	 */
	public function loadFromDb( $apiKey ){
		$wasLoaded = false;

		$dbr = ApiGate_Config::getSlaveDb();
		$queryString = "SELECT * FROM ".ApiGate::TABLE_KEYS." WHERE apiKey='". mysql_real_escape_string($apiKey, $dbr) ."'";
		if( $result = mysql_query( $queryString, $dbr ) ){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				for($cnt=0; $cnt<$numRows; $cnt++){
					$this->apiKey = $apiKey;
					$this->userId = mysql_result($result, $cnt, "user_id");
					$this->nickName = mysql_result($result, $cnt, "nickName");
					$this->enabled = (mysql_result($result, $cnt, "enabled") != "0");
					$this->email = mysql_result($result, $cnt, "email");
					$this->firstName = mysql_result($result, $cnt, "firstName");
					$this->lastName = mysql_result($result, $cnt, "lastName");
					$this->reasonBanned = null; // clear it out to be lazy-loaded later
				}
				$wasLoaded = true;
			}
		}

		return $wasLoaded;
	} // end loadFromDb()

	/**
	 * Factory-method to return an ApiGate_ApiKey with the given apiKey, loaded from the database.
	 *
	 * If the key does not exist in the database, then this will return null.
	 */
	public static function newFromDb( $apiKey ){
		$apiKeyObj = new ApiGate_ApiKey();
		$wasLoaded = $apiKeyObj->loadFromDb( $apiKey );
		if( !$wasLoaded ){
			$apiKeyObj = null;
		}
		return $apiKeyObj;
	} // end newFromDb()

	/**
	 * @return boolean - true if the currently-logged in user is allowed to view the info for this key, false otherwise.
	 *                   Currently, to view the key, the user must be the owner of the key or an API Gate admin.
	 */
	public function canBeViewedByCurrentUser(){
		return ( ($this->userId == ApiGate_Config::getUserId()) || (ApiGate_Config::isAdmin()) );
	} // end canBeViewedByCurrentUser()

} // end class ApiGate_ApiKey
