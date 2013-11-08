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

	/**
	 * @var \Solarium_Client
	 */
	protected $client;


	public function __construct( $config ) {
		if ( !$config || !is_array( $config ) ) {
			throw new \InvalidArgumentException('No config specified');
		}
		$this->client = new Solarium_Client($config);
	}

	public function updateDocuments( $documents ) {
		if ( !is_array( $documents ) || !is_array( $documents[ 0 ] ) ) {
			throw new \InvalidArgumentException('Expected format: [ [xxx=>1,yyy=>2} , ... ]');
		}

		$update = $this->client->createUpdate();

		$list = [];
		foreach ( $documents as $current ) {
			$doc = $update->createDocument();
			foreach ( $current as $fName => $fvalue ) {
				$doc->setField( $fName, $fvalue );
			}

			$list[ ] = $doc;
		}

		$update->addDocuments( $list, true );
		$update->addCommit();
		$result = $this->client->update( $update );

		return $result->getStatus();
	}

	public function deleteDocuments( $wikiID, $from, $to = null ) {
		$range = false;
		$wikiID = (int)$wikiID;
		$to = (int)$to;
		if ( !$wikiID ) {
			throw new \InvalidArgumentException('wikiID not specified');
		}

		if ( $to ) {
			if ( is_array( $from ) ) {
				throw new \InvalidArgumentException('Expected format: ID | [A,B,C,D] | FROM, TO ');
			}
			$from = (int)$from;
			$range = true;
		}
		else {
			if ( !is_array( $from ) ) {
				$from = [(int)$from];
			}
		}

		$update = $this->client->createUpdate();
		$query = '+(wid:' . (int)$wikiID . ') AND ';
		if ( $range ) {
			$query .= ' pageid:[' . $from . ' TO ' . $to . ']';
		}
		else {
			$ids = '';
			foreach ( $from as &$val ) {
				if ( $ids > '' ) {
					$ids .= ' OR ';
				}
				$ids .= (int)$val;
			}
			$query .= ' pageid:(' . $ids . ')';

		}

		$update->addDeleteQuery( $query );
		$update->addCommit();
		$result = $this->client->update( $update );

		return $result->getStatus();
	}


	public function getByArticleId( $wikiID, $articleId, $fields = [], $config = null ) {
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
		$queryObj = $this->client->createSelect();

		if ( !empty($fields) ) {
			$queryObj->setFields( $fields );
		}

		$queryObj->setQuery( $query );
		$results = $this->client->select( $queryObj );

		return $results->getDocuments();
	}
}