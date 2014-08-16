<?php

class PalantirApiController extends WikiaApiController {

	/**
	 * @var QuestDetailsSearchService
	 */
	protected $questDetailsSearch;

	public function getQuestDetails() {
		$fingerprintId = $this->getRequest()->getVal( 'fingerprint_id' );
		$questId = $this->getRequest()->getVal( 'quest_id' );
		$category = $this->getRequest()->getVal( 'category' );
		$limit = $this->getRequest()->getVal( 'limit' );

		$this->validateParameters( $limit );

		$result = $this->getQuestDetailsSearch()
			->newQuery()
			->withFingerprint( $fingerprintId )
			->withQuestId( $questId )
			->withCategory( $category )
			->withWikiId( $this->wg->CityId )
			->limit( $limit )
			->search();

		if( empty( $result ) ) {
			throw new NotFoundApiException();
		}

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

	protected function validateParameters( $limit ) {
		if ( !empty( $limit ) && !preg_match( '/^\d+$/i', $limit ) ) {
			throw new BadRequestApiException( "Parameter 'limit' is invalid" );
		}
	}
}
