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
	public function getApiKeySqlSafe(){return mysql_real_escape_string($this->getApiKey(), ApiGate_Config::getSlaveDb());}
	public function getNickName(){return $this->nickName;}
	public function isEnabled(){return $this->enabled;}
	public function getFirstName(){return $this->firstName;}
	public function getLastName(){return $this->lastName;}
	public function getEmail(){return $this->email;}
	
	/**
	 * Lazy-loads and returns the reason that this key is disabled. If the key is NOT disabled, then this will return null.
	 *
	 * If the key is banned, but no reason could be found, then this will return an empty string.
	 */
	public function getReasonBanned(){
		$reason = null;
		if(!$this->isEnabled()){
			if($this->reasonBanned == null){
				$queryString = "SELECT reason FROM ".ApiGate::TABLE_BANLOG." WHERE apiKey='{$this->getApiKeySqlSafe()}'";
				$queryString.= " ORDER BY createdOn DESC LIMIT 1";
				$this->reasonBanned = ApiGate::simpleQuery( $queryString );
				$reason = $this->reasonBanned;
			} else {
				$reason = $this->reasonBanned;
			}
		}
		return $reason;
	} // end getReasonBanned()

	/**
	 * Returns HTML of the banlog. If there were no records of the key being disabled/enabled it will
	 * also return HTML which indicates that there were no records found.
	 */
	public function getBanLogHtml(){
		$html = "";
		$dbr = ApiGate_Config::getSlaveDb();
		$queryString = "SELECT createdOn,action,username,reason FROM ".ApiGate::TABLE_BANLOG." WHERE apiKey='{$this->getApiKeySqlSafe()}'";
		$queryString.= " ORDER BY createdOn DESC";
		if( $result = mysql_query( $queryString, $dbr ) ){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				$html .= "<ul>\n";
				for($cnt=0; $cnt<$numRows; $cnt++){
					$createdOn = mysql_result($result, $cnt, "createdOn");
					$action = mysql_result($result, $cnt, "action");
					$username = mysql_result($result, $cnt, "username");
					$reason = mysql_result($result, $cnt, "reason");
					$username = ($username=="" ? "<em>[no username recorded]</em>" : $username);

					$date = date("Y/m/d H:i:s", strtotime($createdOn));
					$html .= "<li>$date - $username - <strong>$action</strong> - <em>$reason</em></li>\n";
				}
				$html .= "</ul>\n";
			}
		} else {
// TODO: PRINT SQL ERROR
print "Error loading ban-log with query:<br/>$queryString<br/>mysql_error: ".mysql_error($dbr)."<br/>\n";
		}

		if( $html == "" ){
			$html .= i18n( 'apigate-keyinfo-banlog-empty' );
		}

		return $html;
	} // end getBanLogHtml()

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
