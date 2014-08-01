<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/30/14
 * Time: 11:27 AM
 */

use Wikia\Search\Services\EntitySearchService;

class QuestDetailsSearchService extends EntitySearchService {

	const FINGERPRINT_CRITERIA = 'fingerprint';

	const QUEST_ID_CRITERIA = 'questId';

	const CATEGORY_CRITERIA = 'category';

	const LIMIT_CRITERIA = 'limit';

	const SOLR_FINGERPRINT_FIELD = 'metadata_fingerprint_ids_ss';

	const SOLR_QUEST_ID_FIELD = 'metadata_quest_id_s';

	const SOLR_CATEGORY_FIELD = 'categories_mv_en';

	const SOLR_AND = ' AND ';

	/**
	 * @var QuestDetailsSolrHelper
	 */
	protected $solrHelper;

	public function setSolrHelper( $solrHelper ) {
		$this->solrHelper = $solrHelper;
	}

	public function getSolrHelper() {
		if( empty( $this->solrHelper ) ) {
			// TODO: consider using of some dependency injection mechanism
			$this->solrHelper = new QuestDetailsSolrHelper();
		}
		return $this->solrHelper;
	}

	protected function prepareQuery( $criteria ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$query = $this->constructQuery( $criteria );

		$select->setQuery( $query );

		$select->setFields( $this->getSolrHelper()->getRequiredSolrFields() );

		$limit = $this->getLimit( $criteria );
		if( $limit != null ) {
			$select->setRows( $limit );
		}

		return $select;
	}

	public function consumeResponse( $response ) {
		return $this->getSolrHelper()->consumeResponse( $response );
	}

	public function constructQuery( $criteria ) {
		$conditions = [ ];

		if ( !empty( $criteria[ self::FINGERPRINT_CRITERIA ] ) ) {
			$conditions[ ] = $this->queryExactMatch( self::SOLR_FINGERPRINT_FIELD, $criteria[ self::FINGERPRINT_CRITERIA ] );
		}
		if ( !empty( $criteria[ self::QUEST_ID_CRITERIA ] ) ) {
			$conditions[ ] = $this->queryExactMatch( self::SOLR_QUEST_ID_FIELD, $criteria[ self::QUEST_ID_CRITERIA ] );
		}
		if ( !empty( $criteria[ self::CATEGORY_CRITERIA ] ) ) {
			$conditions[ ] = $this->queryExactMatch( self::SOLR_CATEGORY_FIELD, $criteria[ self::CATEGORY_CRITERIA ] );
		}

		$query = join( self::SOLR_AND, $conditions );

		return $query;
	}

	protected function queryExactMatch( $field, $value ) {
		return $field.':"'.$value.'"';
	}

	public function getLimit( $criteria ) {
		if( !empty( $criteria[ self::LIMIT_CRITERIA ] ) ) {
			return $criteria[ self::LIMIT_CRITERIA ];
		}
		return null;
	}
}