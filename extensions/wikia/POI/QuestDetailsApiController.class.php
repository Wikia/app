<?php

/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/29/14
 * Time: 2:43 PM
 */
class QuestDetailsApiController extends WikiaApiController {

	protected $service;

	public function getQuestDetails() {
		$fingerprintId = $this->getRequest()->getVal( 'fingerprint_id' );
		$questId = $this->getRequest()->getVal( 'quest_id' );
		$category = $this->getRequest()->getVal( 'category' );
		$limit = $this->getRequest()->getVal( 'limit' );

		$result = $this->findQuestDetails( $fingerprintId, $questId, $category, $limit );
		$this->setResponseData( $result );
	}

	protected function findQuestDetails( $fingerprintId, $questId, $category, $limit ) {
		$service = $this->getService();

		return $service->query( [
			'fingerprint' => $fingerprintId,
			'questId' => $questId,
			'category' => $category,
			'limit' => $limit
		] );
	}

	protected function getService() {
		if ( !isset( $this->service ) ) {
			$this->service = new QuestDetailsSearchService();;
		}
		return $this->service;
	}
}