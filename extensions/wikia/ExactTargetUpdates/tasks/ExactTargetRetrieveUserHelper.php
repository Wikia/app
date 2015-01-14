<?php
namespace Wikia\ExactTarget;

class ExactTargetRetrieveUserHelper extends ExactTargetTask {

	/**
	 * Retrieves user email from ExactTarget based on provided user ID
	 * @param int $iUserId
	 * @return null|string
	 */
	public function getUserEmail( $iUserId ) {
		$aProperties = [ 'user_email' ];
		$sFilterProperty = 'user_id';
		$aFilterValues = [ $iUserId ];
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues );

		$oApiDataExtension = $this->getApiDataExtension();
		$oEmailResult = $oApiDataExtension->retrieveRequest( $aApiParams );

		if ( isset( $oEmailResult->Results->Properties->Property->Value ) ) {
			return $oEmailResult->Results->Properties->Property->Value;
		}

		// $this->info( __METHOD__ . ' user DataExtension object not found for user_id = ' . $iUserId );
		return null;
	}

	/**
	 * Retrieve from ExactTarget a list of user IDs that use provided email
	 * @param string $sEmail
	 * @return stdClass
	 * e.g. many results
	 *     stdClass Object (
	 *         [Results] => Array of stdClass Objects
	 *     );
	 * e.g. one result
	 *     stdClass Object (
	 *         [Results] => stdClass Object (
	 *             [Properties] => stdClass Object (
	 *                 [Property] => stdClass Object (
	 *                     [Name] => string
	 *                     [Value] => int
	 *                 )
	 *             )
	 *         )
	 *      );
	 */
	public function retrieveUserIdsByEmail( $sEmail ) {
		$aProperties = [ 'user_id' ];
		$sFilterProperty = 'user_email';
		$aFilterValues = [ $sEmail ];
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues );

		$oApiDataExtension = $this->getApiDataExtension();
		$oIdsListResult = $oApiDataExtension->retrieveRequest( $aApiParams );
		return $oIdsListResult;
	}

}
