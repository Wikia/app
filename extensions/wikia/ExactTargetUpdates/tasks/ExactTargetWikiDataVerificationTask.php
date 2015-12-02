<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiDataVerificationTask extends ExactTargetTask {

	use ExactTargetDataComparisonHelper;

	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return bool
	 * return true if data is equal
	 * if data isn't equal throws exception with result diff
	 */
	public function verifyWikiData( $iWikiId ) {
		// Fetch data from ExactTarget
		$oRetrieveWikiTask = $this->getRetrieveWikiTask();
		$aExactTargetWikiData = $oRetrieveWikiTask->retrieveWikiDataById( $iWikiId );
		$this->info( __METHOD__ . ' ExactTarget wiki data record: ' . json_encode( $aExactTargetWikiData ) );

		// Fetch data from Wikia DB
		$oWikiHelper = $this->getWikiHelper();
		$aWikiaWikiData = $oWikiHelper->getWikiDataArray( $iWikiId );
		$this->info( __METHOD__ . ' Wikia DB wiki data record: ' . json_encode( $aWikiaWikiData ) );

		// Compare results
		$bResult = $this->compareResults( $aExactTargetWikiData, $aWikiaWikiData, __METHOD__ );

		return $bResult;
	}
}
