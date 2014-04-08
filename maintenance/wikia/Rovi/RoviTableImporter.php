<?php

abstract class RoviTableImporter {
	const DELTA_COLUMN = 'delta';
	protected $primary_key;
	protected $fields;
	protected $table;
	protected $db;

	public function __construct() {
		$this->command_column = array_search( self::DELTA_COLUMN, $this->fields );
		unset( $this->fields[ $this->command_column ] );
	}

	protected function preparePKMap( $row ) {
		$map = [ ];
		foreach ( $this->primary_key as $field ) {
			$map[ $field ] = $row[ array_search( $field, $this->fields ) ];
		}
		return $map;
	}

	protected function prepareColumnMap( $row ) {
		$map = [ ];
		foreach ( $this->fields as $field ) {
			$map[ $field ] = $row[ array_search( $field, $this->fields ) ];
		}
		return $map;
	}

	public function processRow( array $row, $db ) {
		$primaryKeyMap = $this->preparePKMap( $row );
		$columnMap = $this->prepareColumnMap( $row );
		$command = $row[ $this->command_column ];
		$keyFields = '(' . implode( ',', $primaryKeyMap ) . ')';
		try {
			switch ( $command ) {
				case 'INS':
					$select = $db->select( $this->table, [ '1' ], $primaryKeyMap );
					if ( $select->numRows() == 0 ) {
						$res = $db->insert( $this->table, $columnMap );
					} else {
						$res = false;
					}
					break;
				case 'DEL':
					$res = $db->delete( $this->table, $primaryKeyMap );
					break;
				case 'UPD':
					$res = $db->update( $this->table, $columnMap, $primaryKeyMap );
					break;
				default:
					return "Unknown command: $command";
			}
		} catch ( DBQueryError $e ) {
			return "EXCEPTION FOUND! ($keyFields): " . $e->error;
		}
		return "$command: $keyFields:" . ( $res ? "OK" : "FAIL" );
	}

	public function checkFileHeader( $row ) {
		return ( is_array( $row ) && count( $row ) === count( $this->fields ) + 1 );
	}

}