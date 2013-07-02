<?php

/**
 * WDACReview Helper
 */
class WDACReviewHelper {

	const UPDATE_REASON = 'WDAC Review by Wikia Staff';
	private $byFounderVarId = NULL;
	private $byStaffVarId = NULL;

	public function __construct() {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$byFounderVar = WikiFactory::getVarByName( 'wgWikiDirectedAtChildrenByFounder', $wgCityId );
		$this->byFounderVarId = $byFounderVar->cv_id;
		$byStaffVar = WikiFactory::getVarByName( 'wgWikiDirectedAtChildrenByStaff', $wgCityId );
		$this->byStaffVarId = $byStaffVar->cv_id;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get list of wikis marked by wiki founders as directed at children
	 * @return array citiesList
	 */
	public function getCitiesForReviewList( $limit = 20, $page = 0 ) {
		wfProfileIn( __METHOD__ );

		if ( $page < 0 ) {
			$page = 0;
		}
		$offset = $page * $limit;
		$aCities = array();
		if ( $this->byFounderVarId ) {
			$aCities = WikiFactory::getListOfWikisWithVar( $this->byFounderVarId, 'bool', '=', true, '', $offset, $limit );
		}

		wfProfileOut( __METHOD__ );
		return $aCities;
	}


	/**
	 * Get number of all wikis queued for WDAC review
	 * @return int $iCount
	 */
	public function getCountWikisForReview() {
		wfProfileIn( __METHOD__ );

		$iCount = WikiFactory::getCountOfWikisWithVar( $this->byFounderVarId, 'bool', '=', true );

		wfProfileOut( __METHOD__ );
		return $iCount;
	}


	/**
	 * Update variables in WikiFactory
	 * @param array $cities List of wikis to update flags
	 * containg wikis IDs and values: True - is WDAC, False - is not WDAC
	 * Struncture of param
	 * $city = array( $cityId => $isDirectedAtCh )
	 */
	public function updateWDACFlags( $cities ) {
		wfProfileIn( __METHOD__ );

		foreach ( $cities as $cityId => $isDirectedAtCh) {
			if ( $isDirectedAtCh == WDACReviewSpecialController::FLAG_APPROVE ) {
				WikiFactory::setVarById( $this->byStaffVarId, $cityId, true, self::UPDATE_REASON );
				WikiFactory::removeVarByName( $this->byFounderVarId, $cityId, self::UPDATE_REASON );
			} elseif ( $isDirectedAtCh == WDACReviewSpecialController::FLAG_DISAPPROVE ) {
				WikiFactory::setVarById( $this->byStaffVarId, $cityId, false, self::UPDATE_REASON );
				WikiFactory::removeVarById( $this->byFounderVarId, $cityId, self::UPDATE_REASON );
			}
		}

		wfProfileOut( __METHOD__ );
	}


}
