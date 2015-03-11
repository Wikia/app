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

	public function retrieveUserDataById( $iUserId ) {
		$aProperties = [
			'user_id',
			'user_name',
			'user_real_name',
			'user_email',
			'user_email_authenticated',
			'user_registration',
			'user_editcount',
			'user_touched'
		];

		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserRetrieveParams( $aProperties, 'user_id', [ $iUserId ] );

		$oApiDataExtension = $this->getApiDataExtension();
		$oUserResult = $oApiDataExtension->retrieveRequest( $aApiParams );
		if ( !empty( $oUserResult->Results->Properties->Property ) ) {
			$aProperties = $oUserResult->Results->Properties->Property;
			foreach ( $aProperties as $value ) {
				$oExactTargetUserData[$value->Name] = $value->Value;
			}
			return $oExactTargetUserData;
		}

		return null;
	}

	/**
	 * Retrieve user edits on wikis from ExactTarget
	 * @param array $aUsersIds
	 * e.g. [ 12345, 321 ]
	 * @return array
	 */
	public function retrieveUserEdits( array $aUsersIds ) {
		$oHelper = $this->getUserHelper();
		$aApiRetrieveParams = $oHelper->prepareUserEditsRetrieveParams( $aUsersIds );
		$oApiDataExtension = $this->getApiDataExtension();
		$oUserEditsResult = $oApiDataExtension->retrieveRequest( $aApiRetrieveParams );
		$aUserEdits = $this->formatUserEditsResult( $oUserEditsResult );
		return $aUserEdits;
	}

	/**
	 * Format result retrieved by ExactTarget Api to desired format for app
	 * @param stdObject|false $oUserEditsResult
	 * @return array
	 * e.g. [ 1234 => [ 177 => 5500 ] ] That means user with id 1234 made 5500 edits on wiki with 177 id
	 */
	protected function formatUserEditsResult( $oUserEditsResult ) {
		if ( empty( $oUserEditsResult ) ) {
			return [];
		}

		$aUserEditsDataFromET = [];
		foreach ( $oUserEditsResult->Results as $oResult ) {
			$aProperty = $oResult->Properties->Property;
			/* Order of values are determined by Properties order defined in
			 * ExactTargetUserTaskHelper::prepareUserEditsRetrieveParams
			 * 'Properties' => [ 'user_id', 'wiki_id', 'contributions' ],
			 */
			$iUserId = $aProperty[0]->Value;
			$iWikiId = $aProperty[1]->Value;
			$iContributions = $aProperty[2]->Value;
			$aUserEditsDataFromET[$iUserId][$iWikiId] = intval( $iContributions );
		}
		return $aUserEditsDataFromET;
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
		$aProperties = ['user_id'];
		$sFilterProperty = 'user_email';
		$aFilterValues = [$sEmail];
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues );

		$oApiDataExtension = $this->getApiDataExtension();
		$oIdsListResult = $oApiDataExtension->retrieveRequest( $aApiParams );
		return $oIdsListResult;
	}

}
