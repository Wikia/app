<?php
namespace Wikia\ExactTarget;

class ExactTargetRetrieveUserTask extends ExactTargetTask {

	/**
	 * Retrieves user email from ExactTarget based on provided user ID
	 * @param int $iUserId
	 * @return null|string
	 */
	public function getUserEmail( $iUserId ) {
		/* Prepare retrieve params */
		$aProperties = [ 'user_email' ];
		$sFilterProperty = 'user_id';
		$aFilterValues = [ $iUserId ];
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );

		$oApiDataExtension = $this->getApiDataExtension();
		/* Send retrieve request */
		$oEmailResult = $oApiDataExtension->retrieveRequest( $aApiParams );
		$this->info( __METHOD__ . ' OverallStatus: ' . $oEmailResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oEmailResult ) );

		if ( $oEmailResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oEmailResult->Results->StatusMessage
			);
		}

		if ( empty( $oEmailResult->Results->Properties->Property->Value ) ) {
			$this->info( __METHOD__ . ' User DataExtension object not found for user_id = ' . $iUserId );
			return null;
		}

		return $oEmailResult->Results->Properties->Property->Value;
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

		if ( isset( $oUserResult->OverallStatus ) && $oUserResult->OverallStatus !== 'OK' ) {
			throw new \Exception( $oUserResult->OverallStatus );
		}

		$aExactTargetUsersData = [];
		if ( !empty( $oUserResult->Results ) ) {
			/* Multiple records returned */
			if ( is_array( $oUserResult->Results ) ) {
				foreach ( $oUserResult->Results as $oResults ) {
					$aExactTargetUserData = [];
					$aProperties = $oResults->Properties->Property;
					foreach ( $aProperties as $value ) {
						$aExactTargetUserData[$value->Name] = $value->Value;
					}
					$aExactTargetUsersData[] = $aExactTargetUserData;
				}
			} else {
				$aProperties = $oUserResult->Results->Properties->Property;
				foreach ( $aProperties as $value ) {
					$oExactTargetUserData[$value->Name] = $value->Value;
				}
				$aExactTargetUsersData = [ $oExactTargetUserData ];
			}
		}
		return $aExactTargetUsersData;
	}

	public function retrieveUserPropertiesByUserId( $iUserId ) {
		$aFieldsList = [
			'up_property',
			'up_value',
		];

		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserPropertiesRetrieveParams( $aFieldsList, 'up_user', [ $iUserId ] );

		$oApiDataExtension = $this->getApiDataExtension();
		$oUserPropertiesResult = $oApiDataExtension->retrieveRequest( $aApiParams );

		if ( isset( $oUserPropertiesResult->OverallStatus ) && $oUserPropertiesResult->OverallStatus !== 'OK' ) {
			throw new \Exception( $oUserPropertiesResult->OverallStatus );
		}

		if ( !empty( $oUserPropertiesResult->Results ) ) {
			foreach ( $oUserPropertiesResult->Results as $oResult ) {
				$sPropertyName = null;
				$sPropertyValue = null;
				foreach ( $oResult->Properties->Property as $oPropertyEntry ) {
					if ( $oPropertyEntry->Name === 'up_property' ) {
						$sPropertyName = $oPropertyEntry->Value;
					} elseif ( $oPropertyEntry->Name === 'up_value' ) {
						$sPropertyValue = $oPropertyEntry->Value;
					}
				}
				$oExactTargetUserPropertiesData[$sPropertyName] = $sPropertyValue;
			}
			return $oExactTargetUserPropertiesData;
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
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiRetrieveParams ) );
		$oApiDataExtension = $this->getApiDataExtension();
		$oUserEditsResult = $oApiDataExtension->retrieveRequest( $aApiRetrieveParams );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oUserEditsResult ) );
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
		if ( empty( $oUserEditsResult ) || empty( $oUserEditsResult->Results ) ) {
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
		$aFilterValues = [ $sEmail ];
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserRetrieveParams( $aProperties, $sFilterProperty, $aFilterValues );

		$oApiDataExtension = $this->getApiDataExtension();
		$oIdsListResult = $oApiDataExtension->retrieveRequest( $aApiParams );
		return $oIdsListResult;
	}

}
