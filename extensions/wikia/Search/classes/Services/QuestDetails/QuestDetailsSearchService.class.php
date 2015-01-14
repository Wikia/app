<?php

use Wikia\Search\Services\EntitySearchService;

class QuestDetailsSearchService extends EntitySearchService {

	const DEFAULT_LIMIT_SOLR_RESPONSE = 300;

	const FINGERPRINT_CRITERIA = 'fingerprint';

	const QUEST_ID_CRITERIA = 'questId';

	const CATEGORY_CRITERIA = 'category';

	const LIMIT_CRITERIA = 'limit';

	const IDS_CRITERIA = 'ids';

	const METADATA_ONLY_CRITERIA = 'metadataOnly';

	const SOLR_FINGERPRINT_FIELD = 'fingerprint_ids_mv_s';

	const SOLR_QUEST_ID_FIELD = 'quest_id_s';

	const SOLR_CATEGORY_FIELD = 'categories_mv_en';

	const SOLR_ID_FIELD = 'id';

	const SOLR_WIKI_ID = 'wid_i';

	const SOLR_AND = ' AND ';

	const ARTICLE_METADATA_CORE = "article_metadata";

	/**
	 * @var QuestDetailsSolrHelper
	 */
	protected $solrHelper;

	protected $conditions = [ ];

	protected $requiredFields = [ ];

	protected $limit = self::DEFAULT_LIMIT_SOLR_RESPONSE;

	protected function getCore(){
		return self::ARTICLE_METADATA_CORE;
	}

	public function newQuery() {
		$this->conditions = [ ];
		$this->limit = self::DEFAULT_LIMIT_SOLR_RESPONSE;
		$this->requiredFields = "*";
		return $this;
	}

	public function withFingerprint( $fingerprint ) {
		if( !empty( $fingerprint ) ) {
			$this->conditions[ ] = $this->queryExactMatch( self::SOLR_FINGERPRINT_FIELD, $fingerprint );
		}
		return $this;
	}

	public function withQuestId( $questId ) {
		if( !empty( $questId ) ) {
			$this->conditions[ ] = $this->queryExactMatch( self::SOLR_QUEST_ID_FIELD, $questId );
		}
		return $this;
	}

	public function withCategory( $category ) {
		if( !empty( $category ) ) {
			$this->conditions[ ] = $this->queryExactMatch( self::SOLR_CATEGORY_FIELD, $category );
		}
		return $this;
	}

	public function withIds( $ids, $wikiId ) {
		if( !empty( $ids ) ) {
			$ids = $this->appendWikiIdToIds( $ids, $wikiId );
			$this->conditions[ ] = self::SOLR_ID_FIELD . ':(' . join( ' ', $ids ) . ')';
			$this->limit( count( $ids ) );
		}
		return $this;
	}

	public function withWikiId( $wikiId ) {
		if( !empty( $wikiId ) ) {
			$this->conditions[ ] = $this->queryExactMatch( self::SOLR_WIKI_ID, $wikiId );
		}
		return $this;
	}

	protected function appendWikiIdToIds( $ids, $wikiId ) {
		$idsWithWikiId = [ ];
		foreach( $ids as $id ) {
			$idsWithWikiId[] = $wikiId . '_' . $id;
		}
		return $idsWithWikiId;
	}

	public function limit( $limit ) {
		if( !empty( $limit ) ) {
			$this->limit = $limit;
		}
		return $this;
	}

	public function search() {
		$query = $this->makeQuery();
		return $this->query( $query );
	}

	public function makeQuery() {
		$query = join( self::SOLR_AND, $this->conditions );
		return $query;
	}

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $query );
		$select->setFields( $this->requiredFields );
		$select->setRows( $this->limit );

		return $select;
	}

	public function consumeResponse( $response ) {
		$data = [ ];
		foreach ( $response as $item ) {
			$data[ $item[ "id" ] ] = $item->getFields();
		}

		return $data;
	}

	public function setSolrHelper( $solrHelper ) {
		$this->solrHelper = $solrHelper;
	}

	public function getSolrHelper() {
		if( empty( $this->solrHelper ) ) {
			$this->solrHelper = new QuestDetailsSolrHelper();
		}
		return $this->solrHelper;
	}

	protected function queryExactMatch( $field, $value ) {
		return $field.':"'.$value.'"';
	}
}