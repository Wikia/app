<?php

class DplTableSet {
	/** @var DatabaseBase $databaseConnection */
	private $databaseConnection;

	private $tableMap = [];

	public function __construct( DatabaseBase $databaseConnection ) {
		$this->databaseConnection = $databaseConnection;
	}

	public function addTable( string $tableName ) {
		if ( !isset( $this->tableMap[$tableName] ) ) {
			$this->tableMap[$tableName] = $this->databaseConnection->tableName( $tableName );
		}
	}

	public function addTableAlias( string $tableName, string $tableAlias ) {
		if ( !isset( $this->tableMap[$tableAlias] ) ) {
			$quotedTableName = $this->databaseConnection->tableName( $tableName );
			$quotedTableAlias = $this->databaseConnection->addIdentifierQuotes( $tableAlias );

			$this->tableMap[$tableAlias] = "$quotedTableName AS $quotedTableAlias";
		}
	}

	public function getTables(): string {
		if ( empty( $this->tableMap ) ) {
			return '';
		}

		return implode( ', ', $this->tableMap ) . ',';
	}
}
