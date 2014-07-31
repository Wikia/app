<?php

class MetaCSVService {
	protected $availFields = [ 'Title', 'wb_alias', 'Fingerprint_ID' ];
	protected $inputFile;

	const CSV_MAX_LEN = 1000;
	const CSV_DELIMITER = ";";
	const CSV_QUOTE = '"';

	public function LoadDataFromFile( $f ) {
		if ( !file_exists( $f ) || !is_readable( $f ) ) {
			throw new MetaException( "Unable to load file" );
		}
		$fp = fopen( $f, 'r' );
		$out = [ ];
		while ( $data = fgetcsv( $fp, self::CSV_MAX_LEN, self::CSV_DELIMITER, self::CSV_QUOTE ) ) {
			$row = [ ];
			foreach ( $this->availFields as $key => $field ) {
				$row[ $field ] = $data[ $key ];
			}
			$out[ ] = $row;
		}
		return $out;
	}


}

class MetaException extends WikiaException {
}