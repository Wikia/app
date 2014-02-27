<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 12:55 PM
 */

abstract class BaseLyricsEntity {

	const ES_INDEX = 'lyrics';

	protected $esClient;

	abstract public function getTableName();
	abstract public function getDataMap();
	abstract public function getESType();

	public function __construct( $esClient ) {
		return $this->esClient = $esClient;
	}

	protected function sanitiseData( $data, $dataMap, $keepEmpty = true) {
		$result = array();
		foreach ( $data as $key => $value ) {
			if ( isset( $dataMap[$key] ) ) {
				if ( !$keepEmpty && empty( $value ) ) {
					continue;
				}
				$result[$dataMap[$key]] = $value;
			}
		}
		return $result;
	}

	public function save( $data ) {
		$data = $this->sanitiseData( $data, $this->getDataMap(), false );
		$params = [
			'index' => self::ES_INDEX,
			'type' => $this->getESType(),
			'id' => (int)$data['article_id'],
			'body' => [],
		];
		unset($data['index']);
		unset($data['type']);
		unset($data['article_id']);
		$params['body'] = $data;
		$ret = $this->esClient->index( $params );
		if ( isset( $ret['_id'] ) ) {
			return $ret['_id'];
		}
		return false;
	}
} 