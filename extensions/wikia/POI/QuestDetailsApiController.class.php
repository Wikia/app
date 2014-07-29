<?php

/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/29/14
 * Time: 2:43 PM
 */
class QuestDetailsApiController extends WikiaApiController {

	const RESPONSE_CACHE_VALIDITY = 3600;

	protected $service;

	public function getQuestDetails() {
		$fingerprintId = $this->getRequest()->getVal( 'fingerprint_id' );
		$questId = $this->getRequest()->getVal( 'quest_id' );
		$limit = $this->getRequest()->getVal( 'limit' );

		$result = $this->findQuestDetails( $fingerprintId, $questId, $limit );
		$this->setResponseData( $result );
	}

	protected function findQuestDetails( $fingerprintId, $questId, $limit ) {
		$service = $this->getService();
		return [ 'stub' ];
	}

	protected function getService() {
		if ( !isset( $this->service ) ) {
			// TODO
			$this->service = null;
		}
		return $this->service;
	}

} 