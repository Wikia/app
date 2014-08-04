<?php

/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/29/14
 * Time: 2:43 PM
 */
class QuestDetailsApiController extends WikiaApiController {

	/**
	 * @var QuestDetailsSearchService
	 */
	protected $questDetailsSearch;

	public function getQuestDetails() {
		$fingerprintId = $this->getRequest()->getVal( 'fingerprint_id' );
		$questId = $this->getRequest()->getVal( 'quest_id' );
		$category = $this->getRequest()->getVal( 'category' );
		$limit = $this->getRequest()->getVal( 'limit' );

		$service = $this->getQuestDetailsSearch();
		$result = $service->query( [
			'fingerprint' => $fingerprintId,
			'questId' => $questId,
			'category' => $category,
			'limit' => $limit
		] );

		$this->setResponseData( $result );
	}

	/**
	 * @param QuestDetailsSearchService $service
	 */
	public function setQuestDetailsSearch( $service ) {
		$this->questDetailsSearch = $service;
	}

	/**
	 * @return QuestDetailsSearchService
	 */
	protected function getQuestDetailsSearch() {
		if ( !isset( $this->questDetailsSearch ) ) {
			// TODO: consider using of some dependency injection mechanism
			$this->questDetailsSearch = new QuestDetailsSearchService();
		}
		return $this->questDetailsSearch;
	}
}
