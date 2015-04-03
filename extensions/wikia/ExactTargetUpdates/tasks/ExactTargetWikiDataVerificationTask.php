<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiDataVerificationTask extends ExactTargetTask {

	/**
	 * Retrieves data from ExactTarget and compares it with data in Wikia database
	 * @return bool
	 * return true if data is equal
	 * if data isn't equal throws exception with result diff
	 */
	public function verifyWikiData( $iWikiId ) {
		// Fetch data from ExactTarget
		$oRetrieveWikiHelperTask = $this->getRetrieveWikiHelper();
		$aExactTargetWikiData = $oRetrieveWikiHelperTask->retrieveWikiDataById( $iWikiId );
		$this->info( __METHOD__ . ' ExactTarget wiki data record: ' . json_encode( $aExactTargetWikiData ) );

		// Fetch data from Wikia DB
		$oWikiHelper = $this->getWikiHelper();
		$aWikiaWikiData = $oWikiHelper->getWikiDataArray( $iWikiId );
		$this->info( __METHOD__ . ' Wikia DB wiki data record: ' . json_encode( $aWikiaWikiData ) );

		// Compare results
		$bResult = $this->compareResults( $aExactTargetWikiData, $aWikiaWikiData, __METHOD__ );

		return $bResult;
	}

	/**
	 * Compare results
	 * @param array $aExactTargetData Array with results from ExactTarget
	 * @param array $aWikiaData Array with results from Wikia DB
	 * @param string $sCallerName name of function that called this one, needed for logs
	 * @param string $sIgnoredProperty Name of property that doesn't have to be equal
	 * @return bool true if equal
	 * @throws \Exception when results are not equals
	 */
	protected function compareResults( $aExactTargetData, $aWikiaData, $sCallerName, $sIgnoredProperty = '' ) {
		// Remove ignored property from compared arrays
		if ( !empty( $sIgnoredProperty ) ) {
			unset( $aExactTargetData[$sIgnoredProperty] );
			unset( $aWikiaData[$sIgnoredProperty] );
		}

		// Compare results
		$aDiffWikiaDB = array_diff_assoc( $aExactTargetData, $aWikiaData );

		if ( count( $aDiffWikiaDB ) > 0 ) {
			// There are unacceptable differences. Prepare diff and throw exception
			$aDiffExactTarget = array_diff_assoc( $aWikiaData, $aExactTargetData );
			$aDiffRes = [];
			$aDiffRes[] = "--- Expected (Wikia DB)";
			$aDiffRes[] = "+++ Actual (ExactTarget)";
			foreach ( $aDiffExactTarget as $key => $val ) {
				$aDiffRes[] = "- '$key' => '{$aDiffExactTarget[$key]}'";
				$aDiffRes[] = "+ '$key' => '{$aDiffWikiaDB[$key]}'";
			}
			$this->debug( $sCallerName . ' ' . json_encode( $aDiffRes ) );
			throw new \Exception( $sCallerName . " Verification failed, Record in ExactTarget doesn't match record in Wikia database.");
		}

		$this->info( 'Verification passed. Record in ExactTarget match record in Wikia database' );
		return true;
	}
}
