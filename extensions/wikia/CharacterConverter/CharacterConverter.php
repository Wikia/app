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

	public function convert() {
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

		$columnConfig = $this->getColumnsConfig();

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

		($this->preConversionCallback)($tableName, $textTypeFields);

		$this->writeConnection->begin( __METHOD__ );

		$this->writeConnection->query(
			// TODO use 'unicode_ci' when possible
			"ALTER TABLE $safeTableName CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin",
			__METHOD__
		);

		try {
			foreach ( $textTypeFields as $fieldName ) {
				$safeFieldName = $this->writeConnection->addIdentifierQuotes( $fieldName );

				$sqlQuery = <<<SQL
				UPDATE $safeTableName
					SET $safeFieldName = CASE
						WHEN CONVERT(binary CONVERT($safeFieldName USING $safeSourceEncoding) USING utf8mb4) is not null 
							THEN CONVERT(binary CONVERT($safeFieldName USING $safeSourceEncoding) USING utf8mb4)
						WHEN CONVERT(binary CONVERT(SUBSTR($safeFieldName, 1, CHAR_LENGTH($safeFieldName) - 1) USING $safeSourceEncoding) USING utf8mb4) is not null 
							THEN CONVERT(binary CONVERT(SUBSTR($safeFieldName, 1, CHAR_LENGTH($safeFieldName) - 1) USING $safeSourceEncoding) USING utf8mb4)
						WHEN CONVERT(binary CONVERT(SUBSTR($safeFieldName, 1, CHAR_LENGTH($safeFieldName) - 2) USING $safeSourceEncoding) USING utf8mb4) is not null 
							THEN CONVERT(binary CONVERT(SUBSTR($safeFieldName, 1, CHAR_LENGTH($safeFieldName) - 2) USING $safeSourceEncoding) USING utf8mb4)
						WHEN CONVERT(binary CONVERT(SUBSTR($safeFieldName, 1, CHAR_LENGTH($safeFieldName) - 3) USING $safeSourceEncoding) USING utf8mb4) is not null 
							THEN CONVERT(binary CONVERT(SUBSTR($safeFieldName, 1, CHAR_LENGTH($safeFieldName) - 3) USING $safeSourceEncoding) USING utf8mb4)
					END
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

	/**
	 * @return array
	 */
	private function getColumnsConfig(): array {
		$columns = $this->readConnection->select(
			'information_schema.columns',
			[ 'table_name', 'column_name', 'character_set_name' ],
			[ 'table_schema' => $this->dbName, 'character_set_name is not null' ]
		);

		$columnConfig = [];
		foreach ( $columns as $column ) {
			if ( !isset( $columnConfig[$column->table_name] ) ) {
				$columnConfig[$column->table_name] = [];
			}
			$columnConfig[$column->table_name][] = $column->column_name;
		}

		return $columnConfig;
	}
}
