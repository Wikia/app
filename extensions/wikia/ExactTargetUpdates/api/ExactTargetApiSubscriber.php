<?php
namespace Wikia\ExactTarget;

class ExactTargetApiSubscriber extends ExactTargetApi {

	public function createRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->helper->prepareSubscriberObjects( $aApiCallParams );
		$oResults = $this->makeCreateRequest( $aSubscribers );
		return $oResults;
	}

	public function retrieveRequest( Array $aApiCallParams ) {
		$aCallObjectParams = $aApiCallParams['Subscriber'];
		$aSimpleFilterParams = $aApiCallParams['SimpleFilterPart'];
		$oResults = $this->makeRetrieveRequest( $aCallObjectParams, $aSimpleFilterParams );
		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->helper->prepareSubscriberObjects( $aApiCallParams );
		$oResults = $this->makeDeleteRequest( $aSubscribers );
		return $oResults;
	}
}
