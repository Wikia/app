<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 7/30/14
 * Time: 11:27 AM
 */

use Wikia\Search\Services\EntitySearchService;

class QuestDetailsSearchService extends EntitySearchService {

	protected function prepareQuery( $fingerprintId ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( 'metadata_fingerprint_ids_ss:'.$fingerprintId );

		return $select;
	}

	protected function consumeResponse( $response ) {
		$result = [];
		foreach ( $response as $item ) {

			$result[] = [
				'id' => $item['pageid'],
				'title' => $this->getTitle( $item ),
				'url' => $item['url'],
				'ns' => $item['ns'],
				'fingerprints' => $item['metadata_fingerprint_ids_ss'],
			];
		}
		return $result;
	}

	/**
	 * @param $item
	 * @return string
	 */
	protected function getTitle( &$item ) {
		$title = '';
		foreach ( $item as $key => $value ) {
			if ( strpos( $key, 'title_' ) === 0 ) {
				$title = $value;
				break;
			}
		}
		return $title;
	}
} 