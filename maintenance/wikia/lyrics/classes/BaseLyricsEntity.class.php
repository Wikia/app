<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/26/14
 * Time: 12:55 PM
 */

abstract class BaseLyricsEntity {

	protected $db;

	abstract public function getTableName();
	abstract public function getDataMap();

	public function __construct( $db ) {
		return $this->db = $db;
	}

	protected function sanitiseData( $data, $dataMap) {
		$result = array();
		foreach ( $data as $key => $value ) {
			if ( isset( $dataMap[$key] ) ) {
				$result[$dataMap[$key]] = $value;
			}
		}
		return $result;
	}

	public function save( $data ) {
		$data = $this->sanitiseData( $data, $this->getDataMap() );
		// TODO: Remove me
		echo 'Saving ... '.PHP_EOL; print_r($data); return 1;

		$this->db->replace(
			$this->getTableName(),
			null,
			$data,
			__METHOD__
		);
	}

	public function getIdByName( $name ) {
		return 1; // TODO: REMOVE_ME
		return $this->db->selectField(
			self::TABLE_NAME,
			'article_id',
			[ 'name' =>	$albumName],
			__METHOD__);
	}
} 