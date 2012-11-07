<?php

class CensusDataRetrieval {

	public static function execute( &$text, &$title ) {
		$query = ''; // get article name from request

		$data = self::fetchData( $query );

		if ( empty( $data ) ) {
			return true;
		}

		$infoboxText = self::parseData( $data );

		$typeLayout = ''; //to be filled based on data

		$text = $infoboxText . $typeLayout;

		return true;
	}

	private static function fetchData( $query ) {
		return 'test';
	}

	private static function parseData( $data ) {
		return 'test';
	}
}
