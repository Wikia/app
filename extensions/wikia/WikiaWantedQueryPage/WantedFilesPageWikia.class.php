<?php
class WantedFilesPageWikia extends WantedFilesPage {


	public function getQueryInfo() {

		global $wgExcludedWantedFiles;

		$queryInfo = parent::getQueryInfo();

		if ( !empty($wgExcludedWantedFiles) && is_array($wgExcludedWantedFiles) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$queryInfo['conds'][] = "il_to not in (" . $dbr->makeList($wgExcludedWantedFiles) . ") ";
		}

		return $queryInfo;
	}
}