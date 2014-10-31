<?php
namespace Wikia\ExactTarget;

class ExactTargetApiDataExtension extends ExactTargetApi {

	public function createRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->helper->prepareSoapVars( $aDE );
		$oRequest = $this->helper->wrapCreateRequest( $aSoapVars );

		$oResults = $this->makeRequest( 'Create', $oRequest );
		return $oResults;
	}

	public function retrieveRequest( Array $aApiCallParams ) {
		$sRetrieveObjectType = "DataExtensionObject[{$aApiCallParams['DataExtension']['CustomerKey']}]";
		$aRetrieveProperties = $aApiCallParams['DataExtension']['Properties'];

		$oResults = parent::retrieveRequest( $aApiCallParams, $sRetrieveObjectType, $aRetrieveProperties );

		return $oResults;
	}

	public function updateRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->helper->prepareSoapVars( $aDE );
		$oRequest = $this->helper->wrapUpdateRequest( $aSoapVars );

		$oResults = $this->makeRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function updateFallbackCreateRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->helper->prepareSoapVars( $aDE );
		$oUpdateOptions = $this->helper->prepareUpdateCreateOptions();
		$oRequest = $this->helper->wrapUpdateRequest( $aSoapVars, $oUpdateOptions );

		$oResults = $this->makeRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->helper->prepareSoapVars( $aDE );

		$oDeleteRequest = $this->helper->wrapDeleteRequest( $aSoapVars );
		$oResults = $this->makeRequest( 'Delete', $oDeleteRequest );
		return $oResults;
	}

}
