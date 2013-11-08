<?php
/**
 * Created by PhpStorm.
 * User: suchy
 * Date: 08.11.13
 * Time: 10:25
 */

namespace Wikia\SolrHelper;

use \Solarium_Client;

class Query {
	public static function getByArticleId( $wikiID, $articleId, $fields = [], $config = null ) {
		if ( !$config ) {
			//For testing only!
			$config = [
				'adapter' => 'Solarium_Client_Adapter_Curl',
				'adapteroptions' => [
					'host' => 'search-s10',
					'port' => 8983,
					'path' => '/solr/',
					'core' => 'main'
				]
			];
		}

		if ( $fields && !is_array( $fields ) ) {
			$fields = [$fields];
		}

		if ( $articleId && !is_array( $articleId ) ) {
			$articleId = [(int)$articleId];
		}

		$query = '+(wid:' . (int)$wikiID . ') AND ';
		$ids = '';
		foreach ( $articleId as &$val ) {
			if ( $ids > '' ) {
				$ids .= ' OR ';
			}
			$ids .= (int)$val;
		}
		$query .= ' pageid:(' . $ids . ')';

		$client = new Solarium_Client($config);
		$queryObj = $client->createSelect();

		if ( !empty($fields) ) {
			$queryObj->setFields( $fields );
		}

		$queryObj->setQuery( $query );
		$results = $client->select( $queryObj );

		return $results->getDocuments();
	}
}