<?php

class MysqlKeyValueModel extends WikiaModel {

	const TABLE_NAME = 'common_key_value';
	const MEMC_KEY = 'key_val_v.1.0';
	const CACHE_DURATION = 86400; /* 24 hours */
	const DB_KEY_FIELD = 'identifier';
	const DB_VALUE_FIELD = 'content';

	public function get( $key ) {
		return WikiaDataAccess::cache(
			$this->getMemcacheKey( $key ),
			self::CACHE_DURATION,
			function() use ( $key ) {
				$db = $this->getSpecialsDB();
				$result = $db->selectField(
					self::TABLE_NAME,
					self::DB_VALUE_FIELD,
					[ self::DB_KEY_FIELD => $key ],
					__METHOD__
				);
				return $this->decodeData( $result );
			}
		);
	}

	public function set( $key, $value ) {
		$db = $this->getSpecialsDB( DB_MASTER );
		$db->replace(
			self::TABLE_NAME,
			[ self::DB_KEY_FIELD ],
			[ self::DB_KEY_FIELD => $key, self::DB_VALUE_FIELD => $this->encodeData( $value ) ]
		);
		WikiaDataAccess::cachePurge( $this->getMemcacheKey( $key ) );
	}

	public function delete( $key ) {
		$db = $this->getSpecialsDB( DB_MASTER );
		$result = $db->delete( self::TABLE_NAME, [ self::DB_KEY_FIELD => $key ], __METHOD__ );
		WikiaDataAccess::cachePurge( $this->getMemcacheKey( $key ) );
		return $result;
	}

	protected function getMemcacheKey( $key ) {
		return wfSharedMemcKey(
			self::MEMC_KEY,
			$key
		);
	}

	protected function encodeData( $data ) {
		return json_encode( $data );
	}

	protected function decodeData( $data ) {
		return json_decode( $data, true );
	}
}
