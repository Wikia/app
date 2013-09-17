<?php
class WantedFilesPageWikia extends WantedFilesPage {


	public function getQueryInfo() {

		global $wgExcludedWantedFiles;

		$queryInfo = parent::getQueryInfo();

		if ( !empty($wgExcludedWantedFiles) && is_array($wgExcludedWantedFiles) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$queryInfo['conds'][] = "il_to not in (" . $dbr->makeList($wgExcludedWantedFiles) . ") ";
		}

		// Make sure the video_info table exists before adding this additional condition
		$infoHelper = new VideoInfoHelper();
		if ( $infoHelper->videoInfoExists() ) {
			// Ignore any missing images that are actually premium video.  Premium video comes from the
			// video.wikia.com wiki and will not have local image table entries
			$queryInfo['tables'][] = 'video_info';
			$queryInfo['join_conds']['video_info'] = array( 'LEFT JOIN',
															array("il_to = video_title", "premium = 1"));
			$queryInfo['conds'][] = 'video_title IS NULL';
		}

		return $queryInfo;
	}
}