<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/30/14
 * Time: 11:27 AM
 */

use Wikia\Search\Services\EntitySearchService;

class QuestDetailsSearchService extends EntitySearchService {

	protected $solrHelper;

	public function setSolrHelper( $solrHelper ) {
		$this->solrHelper = $solrHelper;
	}

	public function getSolrHelper() {
		if( empty( $this->solrHelper ) ) {
			$this->solrHelper = new QuestDetailsSolrHelper();
		}
		return $this->solrHelper;
	}

	protected function prepareQuery( $criteria ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$conditions = [ ];

		if ( !empty( $criteria[ 'fingerprint' ] ) ) {
			$conditions[ ] = 'metadata_fingerprint_ids_ss:"' . $criteria[ 'fingerprint' ] . '"';
		}
		if ( !empty( $criteria[ 'questId' ] ) ) {
			$conditions[ ] = 'metadata_quest_id_s:"' . $criteria[ 'questId' ] . '"';
		}
		if ( !empty( $criteria[ 'category' ] ) ) {
			$conditions[ ] = 'categories_mv_en:"' . $criteria[ 'category' ] . '"';
		}

		$query = join( ' AND ', $conditions );

		$select->setQuery( $query );

		$select->setFields( $this->getSolrHelper()->getRequiredSolrFields() );

		if( !empty( $criteria[ 'limit' ] ) ) {
			$select->setRows( intval( $criteria[ 'limit' ] ) );
		}

		return $select;
	}

	public function consumeResponse( $response ) {
		return $this->getSolrHelper()->consumeResponse( $response );
	}
}