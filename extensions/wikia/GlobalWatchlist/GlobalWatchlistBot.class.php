<?php

class GlobalWatchlistBot {

	private $mDb;
	private $mDebugMode;
	private $mUsers;
	private $mStartTime;
	private $mWatchlisters;
		
	public function __construct($bDebugMode = false, $aUsers = array()) {
	 global $wgExtensionMessagesFiles;
	 $this->mDebugMode = $bDebugMode;
	 $this->mUsers = $aUsers;
	 $this->mDb = wfGetDB(DB_SLAVE);
	 
		$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname(__FILE__) . '/GlobalWatchlist.i18n.php';
	 wfLoadExtensionMessages('GlobalWatchlist');
	}
	
	/**
	 * get all global watchlist users
	 */
	public function getGlobalWatchlisters() {		
		global $wgSharedDB;
		$aUsers = array();
		
		if(count($this->mUsers)) {
			// get only users passed by --users argument
			$sUserNames = "";
			foreach($this->mUsers as $sUserName) {
				$sUserNames.= ($sUserNames ? "," : "") . "'" . addslashes($sUserName) . "'";
			}
			$sWhereClause = "user_name IN ($sUserNames)";
		}
		else {
			$sWhereClause = "user_options LIKE '%watchlist_digest=1%'";
		}
		
		$oResource = $this->mDb->query("SELECT user_id, user_name, user_email FROM " . $wgSharedDB. ".user WHERE (user_email_authenticated IS NOT NULL) AND " . $sWhereClause . " ORDER BY user_id");
		
		if($oResource) {
			$iWatchlisters = 0;
			
			while($oResultRow = $this->mDb->fetchObject($oResource)) {
				$iWatchlisters++;
				print "User: " . $oResultRow->user_name . "\n";
				$aUsers[$oResultRow->user_id] = array( 'name' => $oResultRow->user_name, 'email' => $oResultRow->user_email );
			}
			$this->printDebug("$iWatchlisters global watchilster(s) found. (time: " . $this->calculateDuration( time() - $this->mStartTime ). ")");
		}		
		else {
			$this->printDebug("No global watchlist users were found.", true);
		}

		$this->mWatchlisters = $aUsers;
		return $aUsers;
	}
	
	/**
	 * get all watchlisted pages by user (per wiki) 
	 */
	private function getUserWatchlistPages($wikiDb, $userId) {
		$pages = array();

		$oResource = $this->mDb->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . addslashes($wikiDb) . "'");
		
		if(!$oResult = $this->mDb->fetchObject($oResource)) {
			$this->printDebug("ERROR: Wiki database: $wikiDb not found!");
			return $pages;
		}
		
		$oResource = $this->mDb->query("SELECT wl_title FROM " . addslashes($wikiDb) . ".watchlist WHERE wl_user='" . addslashes($userId) . "' AND (wl_notificationtimestamp IS NOT NULL) ORDER BY wl_notificationtimestamp");
		if($oResource) {
			while($oResultRow = $this->mDb->fetchObject($oResource)) {
				$pages[] = $oResultRow->wl_title;
			}
		}
		
		return $pages;
	}
	
	/**
	 * gather digest data for all users
	 */
	public function getWatchlistDigests() {
		global $wgSharedDB;
		$aDigests = array();
		$this->getGlobalWatchlisters();
		$this->printDebug("Gathering watchlist data ...");

		foreach($this->mWatchlisters as $iUserId => $aUserData) {
			$oResource = $this->mDb->query("SELECT city_id, city_dbname, city_url, city_title FROM " . $wgSharedDB . ".city_list ORDER BY city_sitename");
			
			$aDigests[$iUserId] = array();
			while($oResultRow = $this->mDb->fetchObject($oResource)) {
	  	$aPages = $this->getUserWatchlistPages($oResultRow->city_dbname, $iUserId);
	  	if(count($aPages)) {
	  		$aWikiDigest = array(
						'wikiName' => $oResultRow->city_title,
						'wikiUrl' => $oResultRow->city_url,
						'wikiScriptPath' => WikiFactory::getVarValueByName('wgScriptPath', $oResultRow->city_id),
						'pages' => $aPages
	  		);
	  		$aDigests[$iUserId][] = $aWikiDigest;
	  	}
			}
		}
		
		$this->printDebug("Gathering watchlist data ... done! (time: " . $this->calculateDuration(time() - $this->mStartTime ) . ")");
		return $aDigests;
	}
	
	/**
	 * compose digest email for user
	 */
	private function composeMail($iUserId, $aDigestsData) {
		global $wgScriptPath;
		
		$sDigests = "";
		foreach($aDigestsData as $aDigest) {
			$sDigests .= $aDigest['wikiName'] . ":\n";
			
			// remove trailing slash from url
			$aDigest['wikiUrl'] = ( substr( $aDigest['wikiUrl'], -1, 1 ) == '/' ? substr( $aDigest['wikiUrl'], 0, -1 ) : $aDigest['wikiUrl'] );
			$sPageUrl = $aDigest['wikiUrl'] . (!empty($aDigest['wikiScriptPath']) ? $aDigest['wikiScriptPath'] : $wgScriptPath) . "/index.php?title=";
			foreach($aDigest['pages'] as $sPageTitle) {
				$sDigests .= $sPageUrl . $sPageTitle . "\n";
			}
			$sDigests .= "\n";
		}
		
		$aEmailArgs = array(
		 0 => ucfirst($this->mWatchlisters[$iUserId]['name']),
		 1 => $sDigests 
		);
		
		$sMessage = wfMsg('globalwatchlist-digest-email-body');
		$sBody = wfMsgReplaceArgs($sMessage, $aEmailArgs);

		return $sBody;
	}
	
	public function run() {
		$this->mStartTime = time();
		$this->printDebug("Script started.");
		
		$aDigests = $this->getWatchlistDigests();

		$this->printDebug("Sending digest emails ... ");
		$sEmailSubject = wfMsg('globalwatchlist-digest-email-subject');
		foreach($aDigests as $iUserId => $aDigestsData) {
			$sEmailBody = $this->composeMail($iUserId, $aDigestsData);

			$oUser = User::newFromId($iUserId);
			$oUser->load();
			
			$oUser->sendMail($sEmailSubject, $sEmailBody, 'Wikia <community@wikia.com>');			
		}
		
		$this->printDebug("Sending digest emails ... Done!");
		$this->printDebug("Script finished. (total time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")");
	}

	private function printDebug($sMessage, $bForceDebugMode = false) {
		if($this->mDebugMode || $bForceDebugMode) {  
			print "[GlobalWatchlistBot] " . $sMessage . "\n";
		}
	}

	private function calculateDuration($iSeconds) {
		if(!$iSeconds) {
			return "0s";
		}
		
		$aValues = array(
			'w' => (int) ($iSeconds / 86400 / 7),
			'd' => $iSeconds / 86400 % 7,
			'h' => $iSeconds / 3600 % 24,
			'm' => $iSeconds / 60 % 60,
			's' => $iSeconds % 60 
		);		
		$aResult = array();
		$added = false;
		
		foreach ($aValues as $k => $v) {
			if ($v > 0 || $added) {
				$added = true;
				$aResult[] = $v . $k;
			}
		}
 
		return join(' ', $aResult);
	}
	 	
}
