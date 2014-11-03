<?php
namespace Wikia\ExactTarget;

class ExactTargetApiSubscriber extends ExactTargetApi {

	/**
	 * An entry point for Subscriber Create requests
	 * @param  Array  $aApiCallParams
	 * This array must be prepared in the following format:
	 * 	Array (
	 * 		'Subscriber' => [
	 * 			[
	 * 				'SubscriberKey' => 'Subscriber email',
	 * 				'EmailAddress' => 'Subscriber email',
	 * 			],
	 * 		],
	 *  );
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function createRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->helper->prepareSubscriberObjects( $aApiCallParams['Subscriber'] );
		$oResults = $this->makeCreateRequest( $aSubscribers );
		return $oResults;
	}

	/**
	 * An entry point for Subscriber Delete requests
	 * @param  Array  $aApiCallParams
	 * This array must be prepared in the following format:
	 * 	Array (
	 * 		'Subscriber' => [
	 * 			[
	 * 				'SubscriberKey' => 'Subscriber email',
	 * 				'EmailAddress' => 'Subscriber email',
	 * 			],
	 * 		],
	 *  );
	 * @return stdObject|false  Returns false when an Exception happens and an stdObject otherwise
	 */
	public function deleteRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->helper->prepareSubscriberObjects( $aApiCallParams['Subscriber'] );
		$oResults = $this->makeDeleteRequest( $aSubscribers );
		return $oResults;
	}
}
