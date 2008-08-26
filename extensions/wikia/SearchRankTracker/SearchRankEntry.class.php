<?php
/**
 * Data Access Object
 */
 
class SearchRankEntry {

	private $mId = 0;
	private $mCityId;
	private $mPageName;
	private $mPageUrl;
	private $mPhrase;
	private $mCreated;
	private $mIsMainPage = false;
	
 public function __construct($id = 0, $oRowData = null) {
	 global $wgCityId;
	 
	 $this->mCityId = $wgCityId; 
	 
	 if($id) {
	 	$this->loadFromDb($id);
	 }
	 elseif(is_object($oRowData)) {
	 	$this->feed($oRowData);
	 }
	}
	
	public function getId() {
		return $this->mId;
	}
	
	public function getCityId() {
		return $this->mCityId;
	}
	
	public function setCityId($iCityId) {
		$this->mCityId = $iCityId;
	}
	
	public function getPageName() {
		return $this->mPageName;
	}
	
	public function setPageName($sPageName) {
		$this->mPageName = $sPageName;

 	if(!empty($sPageName)) {
	 	// setting full url
	 	$oTitle = Title::newFromText($sPageName);
			$this->mPageUrl = urldecode($oTitle->getFullUrl());
			
			// checking whether is main page
			$this->mIsMainPage = SearchRankTracker::isWikiMainPage($oTitle);		
 	}
	}
	
	public function getPageUrl() {
		return $this->mPageUrl;
	}
	
	public function getWikiUrl() {
		$sUrl = "";
		if($this->mPageUrl) {
			preg_match('/(http:\/\/[a-z0-9-_.]{1,})\//si', $this->mPageUrl, $aMatches);
			$sUrl =  isset($aMatches[1]) ? $aMatches[1] : "";
		}
		return $sUrl;
	}
	
	public function isMainPage() {
		return $this->mIsMainPage;
	}
	
	public function getPhrase() {
		return $this->mPhrase;
	}
	
	public function setPhrase($sPhrase) {
		$this->mPhrase = $sPhrase;
	}
	
	public function getCreated() {
		return $this->mCreated;
	}
	
	private function feed($data) {
		if(is_object($data)) {
			$this->mId = $data->ren_id;
			$this->setCityId($data->ren_city_id);
			$this->mPageName = $data->ren_page_name;
			$this->mPageUrl = $data->ren_page_url;
			$this->mIsMainPage = ($data->ren_is_main_page == '0') ? false : true;
			$this->setPhrase($data->ren_phrase);
			$this->mCreated = $data->ren_created;
		}
	}
	
	private function loadFromDb($id) {
		global $wgSharedDB;

		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);

		$data = $dbr->selectRow('rank_entry', array( '*' ), array( 'ren_id' => $id ), __METHOD__);
 	
 	if(is_object($data)) {
 		$this->feed($data);
 	}
	}
	
	public function update() {
		global $wgSharedDB;
		
		if($this->mId) {			
			$dbw = wfGetDB(DB_MASTER);
			$dbw->selectDB($wgSharedDB);

			$fields = array();
			$fields['ren_page_name'] = addslashes($this->mPageName);
			$fields['ren_page_url'] = addslashes($this->mPageUrl);
			$fields['ren_is_main_page'] = ($this->mIsMainPage ? '1' : '0');
			$fields['ren_phrase'] = addslashes($this->mPhrase);

			$dbw->update(wfSharedTable('rank_entry'), $fields, array( 'ren_id' => $this->mId ), __METHOD__);
			$dbw->immediateCommit();							
		}
		else {
			$this->create();			
		} 
		
	}
	
	public function delete() {
		global $wgSharedDB;

		if($this->mId) {
			$dbw = wfGetDB(DB_MASTER);
			$dbw->selectDB($wgSharedDB);

			$dbw->delete('rank_result', array('rre_ren_id' => $this->mId), __METHOD__);
			$dbw->delete('rank_entry', array('ren_id' => $this->mId), __METHOD__);
			$dbw->immediateCommit();
		}
	}
	
	private function create() {
		global $wgSharedDB;

		$dbw = wfGetDB(DB_MASTER);
		$dbw->selectDB($wgSharedDB);
		
		$fields = array();
		$fields['ren_city_id'] = $this->mCityId;
		$fields['ren_page_name'] = addslashes($this->mPageName);
		$fields['ren_page_url'] = addslashes($this->mPageUrl);
		$fields['ren_is_main_page'] = ($this->mIsMainPage ? '1' : '0');
		$fields['ren_phrase'] = addslashes($this->mPhrase);
		$fields['ren_created'] = date('Y-m-d H:i:s');
		
		$dbw->insert(wfSharedTable('rank_entry'), $fields, __METHOD__);	
		$this->mId = $dbw->insertId();
		
		$dbw->immediateCommit();
	}
	
	public static function getList() {
	 global $wgCityId, $wgSharedDB;
	 $aEntries = array();

		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);
		
		$oResource = $dbr->query("SELECT * FROM rank_entry WHERE ren_city_id='" . $wgCityId. "' ORDER BY ren_id");
		
		while($oResultRow = $dbr->fetchObject($oResource)) {
			$aEntries[] = new SearchRankEntry(0, $oResultRow);
		}
		
		return $aEntries;
	}
	
	public function getRankResults($sSearchEngine, $iYear = 0, $iMonth = 0 , $iDay = 0, $iDaysBack = 0) {
		global $wgSharedDB;
  
		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);

		$sWhereClause = "rre_ren_id='" . $this->mId . "' AND rre_engine='" . addslashes($sSearchEngine) . "'";
		$sOrderByClause = "ORDER BY rre_date";
		if($iDaysBack) {
			// get all results starts from x days back from yyyy-mm-dd
			$sWhereClause .= " AND rre_date<='" . addslashes($iYear). "-" . addslashes($iMonth) . "-" . addslashes($iDay) . " 23:59:59'"; 
		 $sOrderByClause = "ORDER BY rre_date ASC LIMIT $iDaysBack";
		}
		else {
			// just get all results for year/month/day
			if($iYear) {
				$sWhereClause .= " AND YEAR(rre_date)='" . addslashes($iYear) . "'";
			}
			if($iMonth) {
				$sWhereClause .= " AND MONTH(rre_date)='" . addslashes($iMonth) . "'";
			}
			if($iDay) {
				$sWhereClause .= " AND DAYOFMONTH(rre_date)='" . addslashes($iDay) . "'";
			}
			
		}

		$oResource = $dbr->query("SELECT *, CONCAT(YEAR(rre_date),'-',MONTH(rre_date),'-',DAYOFMONTH(rre_date)) AS date_formatted FROM rank_result WHERE $sWhereClause $sOrderByClause");
		
		if($oResource->numRows()) {
			return $oResource;
		}
		else {
			return false;
		}
  		
	}
	
	public function setRankResult($sSearchEngine, $sDate, $iRank) {
		global $wgSharedDB;

		$dbw = wfGetDB(DB_MASTER);
		$dbw->selectDB($wgSharedDB);
		
		$fields = array();
		$fields['rre_ren_id'] = $this->mId;
		$fields['rre_engine'] = addslashes($sSearchEngine);
		$fields['rre_date'] = addslashes($sDate);
		$fields['rre_rank'] = addslashes($iRank);
		
		$dbw->insert(wfSharedTable('rank_result'), $fields, __METHOD__);	
		return $dbw->insertId();
	}
		
}
