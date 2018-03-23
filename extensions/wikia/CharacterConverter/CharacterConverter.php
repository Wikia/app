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
				$this->processSingleTable( $row->table_name, $columnConfig[$row->table_name] );
			} else {
				$this->processSingleTable( $row->table_name );
			}
		}

		$safeDbName = $this->writeConnection->addIdentifierQuotes( $this->dbName );
		$this->writeConnection->query(
			"ALTER DATABASE $safeDbName DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
			__METHOD__
		);
	}

	/**
	 * @param string $tableName
	 * @param string $sourceEncoding
	 * @param array $textTypeFields
	 *
	 * @throws Exception
	 */
	private function processSingleTable( string $tableName, array $textTypeFields = [] ) {
		$safeTableName = $this->writeConnection->addIdentifierQuotes( $tableName );

		($this->preConversionCallback)($tableName, $textTypeFields);

		$this->writeConnection->begin( __METHOD__ );

		try {
			$this->writeConnection->query(
				"ALTER TABLE $safeTableName DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
				__METHOD__
			);

			foreach ( $textTypeFields as $filedConfig ) {
				try {
					$this->migrateColumn(
						$tableName,
						$filedConfig['columnName'],
						$filedConfig['columnType'],
						$filedConfig['sourceCharset'],
						$filedConfig['targetCollationName']
					);
				} catch (Exception $e) {
					// On duplicate key fallback to binary collation or crash
					$this->migrateColumn(
						$tableName,
						$filedConfig['columnName'],
						$filedConfig['columnType'],
						$filedConfig['sourceCharset'],
						'utf8mb4_bin'
					);
				}
			}
		} catch ( Exception $e ) {
			$this->writeConnection->rollback( __METHOD__ );
			throw $e;
		}

		$this->writeConnection->commit( __METHOD__ );

		// TODO check if OPTIMIZE gives us anything
		$this->writeConnection->query( "OPTIMIZE TABLE $safeTableName" );

		wfWaitForSlaves();
	}

	/**
	 * @return array
	 */
	private function getColumnsConfig(): array {
		$columns = $this->readConnection->select(
			'information_schema.columns',
			[ 'table_name', 'column_name', 'column_type', 'character_set_name', 'collation_name' ],
			[ 'table_schema' => $this->dbName, 'character_set_name is not null', 'character_set_name <> \'binary\'' ]
		);

		$columnConfig = [];
		foreach ( $columns as $column ) {
			if ( !isset( $columnConfig[$column->table_name] ) ) {
				$columnConfig[$column->table_name] = [];
			}
			$columnConfig[$column->table_name][$column->column_name] = [
				'columnName' => $column->column_name,
				'columnType' => $column->column_type,
				// don't use column charset as always use latin1 connection
				'sourceCharset' => 'latin1',
				'targetCollationName' => substr($column->collation_name, -3) === 'bin' ?
					'utf8mb4_bin' :
					'utf8mb4_unicode_ci',
			];
		}

		return $columnConfig;
	}

	private function migrateColumn($tableName, $columnName, $columnType, $sourceCharset, $targetCollation) {
		$safeTableName = $this->writeConnection->addIdentifierQuotes( $tableName );
		$safeColumnName = $this->writeConnection->addIdentifierQuotes( $columnName );
		$safeSourceCharset = $this->writeConnection->addIdentifierQuotes( $sourceCharset );

		$this->writeConnection->query(
			"ALTER TABLE $safeTableName MODIFY $safeColumnName $columnType CHARACTER SET utf8mb4 collate $targetCollation",
			__METHOD__
		);

		$sqlQuery = <<<SQL
				UPDATE $safeTableName
					SET $safeColumnName = CASE
						WHEN CONVERT(binary CONVERT($safeColumnName USING $safeSourceCharset) USING utf8mb4) is not null
							THEN CONVERT(binary CONVERT($safeColumnName USING $safeSourceCharset) USING utf8mb4)
						WHEN CONVERT(binary CONVERT(SUBSTR($safeColumnName, 1, CHAR_LENGTH($safeColumnName) - 1) USING $safeSourceCharset) USING utf8mb4) is not null
							THEN CONVERT(binary CONVERT(SUBSTR($safeColumnName, 1, CHAR_LENGTH($safeColumnName) - 1) USING $safeSourceCharset) USING utf8mb4)
						WHEN CONVERT(binary CONVERT(SUBSTR($safeColumnName, 1, CHAR_LENGTH($safeColumnName) - 2) USING $safeSourceCharset) USING utf8mb4) is not null
							THEN CONVERT(binary CONVERT(SUBSTR($safeColumnName, 1, CHAR_LENGTH($safeColumnName) - 2) USING $safeSourceCharset) USING utf8mb4)
						WHEN CONVERT(binary CONVERT(SUBSTR($safeColumnName, 1, CHAR_LENGTH($safeColumnName) - 3) USING $safeSourceCharset) USING utf8mb4) is not null
							THEN CONVERT(binary CONVERT(SUBSTR($safeColumnName, 1, CHAR_LENGTH($safeColumnName) - 3) USING $safeSourceCharset) USING utf8mb4)
					END
					WHERE LENGTH($safeColumnName) <> CHAR_LENGTH($safeColumnName)
SQL;

		$this->writeConnection->query( $sqlQuery, __METHOD__ );
	}
}
