<?php
namespace Wikia\ExactTarget;

class ExactTargetRetrieveUserTask extends ExactTargetTask {

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
