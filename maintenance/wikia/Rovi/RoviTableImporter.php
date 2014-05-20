<?php

abstract class RoviTableImporter {
	const DELTA_COLUMN = 'delta';
	protected $primary_key;
	protected $fields;
	protected $table;
	protected $db;
	protected $stats;

	public function __construct() {
		$this->command_column = array_search( self::DELTA_COLUMN, $this->fields );
		unset( $this->fields[ $this->command_column ] );
		$this->stats = [
			'INS' => [ 'ok' => 0, 'fail' => 0 ],
			'UPD' => [ 'ok' => 0, 'fail' => 0 ],
			'DEL' => [ 'ok' => 0, 'fail' => 0 ],
			'UNKNOWN' => [ 'total' => 0 ]
		];
	}

	protected function preparePKMap( $row ) {
		$map = [ ];
		$flipped = array_flip($this->fields );
		foreach ( $this->primary_key as $field ) {
			$map[ $field ] = $row[ $flipped[ $field ] ];
		}
		return $map;
	}

	protected function prepareColumnMap( $row ) {
		$map = [ ];
		foreach ( $this->fields as $key => $field ) {
			$map[ $field ] = $row[ $key ];
		}
		return $map;
	}

	public function processRow( array $row, $db ) {
		$message = '';
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
					$this->stats[ 'UNKNOWN' ][ 'total' ]++;
					return "Unknown command: $command";
			}
			$message = "$command: $keyFields:" . ( $res ? "OK" : "FAIL" );
			$this->stats[ $command ][ $res ? 'ok' : 'fail' ]++;
		} catch ( DBQueryError $e ) {
			$this->stats[ $command ][ 'fail' ]++;
			$message = "EXCEPTION FOUND! ($keyFields): " . $e->error;
		}

		return $message;
	}

	public function getSummary() {
		$out = '';
		foreach ( $this->stats as $kind => $stat ) {
			$out .= $kind . ": ";
			foreach ( $stat as $keySum => $valSum ) {
				$out .= $keySum . ': ' . $valSum . ' ';
			}
			$out .= "\n";
		}
		return $out;
	}


	public function checkFileHeader( $row ) {
		return ( is_array( $row ) && count( $row ) === count( $this->fields ) + 1 );
	}

}