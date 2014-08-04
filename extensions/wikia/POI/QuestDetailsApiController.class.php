<?php

/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/29/14
 * Time: 2:43 PM
 */
class QuestDetailsApiController extends WikiaApiController {

	const FINGERPRINT_REQUEST_PARAM = 'fingerprint_id';

	const QUEST_ID_REQUEST_PARAM = 'quest_id';

	const CATEGORY_REQUEST_PARAM = 'category';

	const LIMIT_REQUEST_PARAM = 'limit';

	/**
	 * @var QuestDetailsSearchService
	 */
	protected $questDetailsSearch;

	public function getQuestDetails() {
		$fingerprintId = $this->getRequest()->getVal( self::FINGERPRINT_REQUEST_PARAM );
		$questId = $this->getRequest()->getVal( self::QUEST_ID_REQUEST_PARAM );
		$category = $this->getRequest()->getVal( self::CATEGORY_REQUEST_PARAM );
		$limit = $this->getRequest()->getVal( self::LIMIT_REQUEST_PARAM );

		$service = $this->getQuestDetailsSearch();
		$result = $service->query( [
			QuestDetailsSearchService::FINGERPRINT_CRITERIA => $fingerprintId,
			QuestDetailsSearchService::QUEST_ID_CRITERIA => $questId,
			QuestDetailsSearchService::CATEGORY_CRITERIA => $category,
			QuestDetailsSearchService::LIMIT_CRITERIA => $limit
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
