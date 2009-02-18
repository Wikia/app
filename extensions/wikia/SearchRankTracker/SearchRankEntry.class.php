<?php
/**
 * Data Access Object
 */

class SearchRankEntry {

	private $mId = 0;
	private $mCityId = 0;
	private $mPageName;
	private $mPhrase;
	private $mCreated;
	private $mIsMainPage = true;

 public function __construct($id = 0, $oRowData = null) {
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
		$fields['ren_is_main_page'] = ($this->mIsMainPage ? '1' : '0');
		$fields['ren_phrase'] = addslashes($this->mPhrase);
		$fields['ren_created'] = date('Y-m-d H:i:s');

		$dbw->insert(wfSharedTable('rank_entry'), $fields, __METHOD__);
		$this->mId = $dbw->insertId();

		$dbw->immediateCommit();
	}

	public static function getList() {
		global $wgSharedDB;
		$aEntries = array();

		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);

		$oResource = $dbr->query("SELECT * FROM rank_entry ORDER BY ren_id");

		while($oResultRow = $dbr->fetchObject($oResource)) {
			$aEntries[] = new SearchRankEntry(0, $oResultRow);
		}

		return $aEntries;
	}

	public static function getResultDates() {
		global $wgSharedDB;
		$aDates = array();

		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);

		$oResource = $dbr->query("SELECT rre_date FROM rank_result GROUP BY rre_date ORDER BY rre_date");

		while($oResultRow = $dbr->fetchObject($oResource)) {
			$aDates[] = $oResultRow->rre_date;
		}

		return $aDates;
	}

	public function getRankResultByDate($sDate) {
		global $wgSharedDB;

		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);

		$oResource = $dbr->query("SELECT rre_rank FROM rank_result WHERE rre_date='" . addslashes($sDate) . "' AND rre_ren_id='" . $this->mId . "' ORDER BY rre_id DESC LIMIT 1");
		$oResultRow = $dbr->fetchObject($oResource);

		return is_object($oResultRow) ? $oResultRow->rre_rank : null;
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
