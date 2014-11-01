<?php
namespace Wikia\ExactTarget;

class ExactTargetApiDataExtension extends ExactTargetApi {

	public function createRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$oResults = $this->makeCreateRequest( $aDE );
		return $oResults;
	}

	public function retrieveRequest( Array $aApiCallParams ) {
		$aCallObjectParams = $aApiCallParams['DataExtension'];
		$aSimpleFilterParams = $aApiCallParams['SimpleFilterPart'];
		$oResults = makeRetrieveRequest( $aCallObjectParams, $aSimpleFilterParams );
		return $oResults;
	}

	public function updateRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$oResults = $this->makeUpdateRequest( $aDE );
		return $oResults;
	}

	public function updateFallbackCreateRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$oResults = $this->makeUpdateCreateRequest( $aDE );
		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aDE = $this->helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );		
		$oResults = $this->makeDeleteRequest( $aDE );
		return $oResults;
	}

}
