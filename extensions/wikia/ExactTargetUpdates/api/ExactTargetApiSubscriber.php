<?php
namespace Wikia\ExactTarget;

class ExactTargetApiSubscriber extends ExactTargetApi {

	public function createRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->helper->prepareSubscriberObjects( $aApiCallParams );

		$oRequest = $this->helper->wrapCreateRequest( $aSubscribers );

		$this->makeRequest( 'Create', $oRequest );
	}

	public function retrieveRequest( Array $aApiCallParams ) {
		$sRetrieveObjectType = "Subscriber";
		$aRetrieveProperties = $aApiCallParams['Subscriber']['Properties'];

		$oResults = parent::retrieveRequest( $aApiCallParams, $sRetrieveObjectType, $aRetrieveProperties );

		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->helper->prepareSubscriberObjects( $aApiCallParams );

		$oDeleteRequest = $this->helper->wrapDeleteRequest( $aSubscribers );

		$oResults = $this->makeRequest( 'Delete', $oDeleteRequest );
		return $oResults;
	}

}
