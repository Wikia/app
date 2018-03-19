<?php

class CharacterConverter {
	/** @var string $dbName */
	private $dbName;

	/** @var DatabaseBase $readConnection */
	private $readConnection;

	/** @var DatabaseBase $writeConnection */
	private $writeConnection;

	/** @var callable $preConversionCallback */
	private $preConversionCallback;

	private function __construct( string $dbName ) {
		$this->dbName = $dbName;
	}

	public static function newFromDatabase( string $dbName ): CharacterConverter {
		return new self( $dbName );
	}

	/**
	 * @param callable $preConversionCallback
	 */
	public function registerPreConversionCallback( callable $preConversionCallback ) {
		$this->preConversionCallback = $preConversionCallback;
	}

	public function convert( array $columnConfig ) {
		global $wgUseUnicode;

		// This point forward, use utf8mb4 for all new connections! 🤞
		$wgUseUnicode = true;

		$this->readConnection = wfGetDB( DB_SLAVE, [], $this->dbName );
		$this->writeConnection = wfGetDB( DB_MASTER, [], $this->dbName );

		$tables = $this->readConnection->select(
			'information_schema.tables',
			[ 'table_name', "SUBSTRING_INDEX(table_collation,'_',1) AS table_charset" ],
			[ 'table_schema' => $this->dbName ]
		);

		foreach ( $tables as $row ) {
			if ( isset( $columnConfig[$row->table_name] ) ) {
				$this->processSingleTable( $row->table_name, $row->table_charset, $columnConfig[$row->table_name] );
			} else {
				$this->processSingleTable( $row->table_name, $row->table_charset );
			}
		}
	}

	/**
	 * @param string $tableName
	 * @param string $sourceEncoding
	 * @param array $textTypeFields
	 *
	 * @throws Exception
	 */
	private function processSingleTable( string $tableName, string $sourceEncoding, array $textTypeFields = [] ) {
		$safeTableName = $this->writeConnection->addIdentifierQuotes( $tableName );
		$safeSourceEncoding = $this->writeConnection->addIdentifierQuotes( $sourceEncoding );

		call_user_func( $this->preConversionCallback, $tableName );

		$this->writeConnection->begin( __METHOD__ );

		$this->writeConnection->query(
			"ALTER TABLE $safeTableName CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin",
			__METHOD__
		);

		try {
			foreach ( $textTypeFields as $fieldName ) {
				$safeFieldName = $this->writeConnection->addIdentifierQuotes( $fieldName );

				$sqlQuery = <<<SQL
				UPDATE $safeTableName
					SET $safeFieldName = CONVERT(binary CONVERT($safeFieldName using $safeSourceEncoding) using utf8mb4)
					WHERE LENGTH($safeFieldName) <> CHAR_LENGTH($safeFieldName)
SQL;

				$this->writeConnection->query( $sqlQuery, __METHOD__ );
			}
		} catch ( Exception $e ) {
			$this->writeConnection->rollback( __METHOD__ );
			throw $e;
		}

		$this->writeConnection->commit( __METHOD__ );

		$this->writeConnection->query( "OPTIMIZE TABLE $safeTableName" );

		wfWaitForSlaves();
	}
}
