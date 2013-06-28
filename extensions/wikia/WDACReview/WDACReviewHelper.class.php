<?php

/**
 * WDACReview Helper
 */
class WDACReviewHelper {

	const UPDATE_REASON = 'WDAC Review by Wikia Staff';
	/**
	 * Get list of wikis marked by wiki founders as directed at children
	 * @return array citiesList
	 */
	public function getCitiesForReviewList() {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$aCities = array();
		$byFounderVarId = WikiFactory::getVarByName( 'wgWikiDirectedAtChildrenByFounder', $wgCityId );
		if ( $byFounderVarId ) {
			$aCities = WikiFactory::getListOfWikisWithVar( $byFounderVarId->cv_id, 'bool', '=', true );
		}

		wfProfileOut( __METHOD__ );
		return $aCities;
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
				WikiFactory::setVarByName( 'wgWikiDirectedAtChildrenByStaff', $cityId, true, self::UPDATE_REASON );
				WikiFactory::removeVarByName( 'wgWikiDirectedAtChildrenByFounder', $cityId, self::UPDATE_REASON );
			} elseif ( $isDirectedAtCh == WDACReviewSpecialController::FLAG_DISAPPROVE ) {
				WikiFactory::setVarByName( 'wgWikiDirectedAtChildrenByStaff', $cityId, false, self::UPDATE_REASON );
				WikiFactory::removeVarByName( 'wgWikiDirectedAtChildrenByFounder', $cityId, self::UPDATE_REASON );
			}
		}

		wfProfileOut( __METHOD__ );
	}


}
