<?php

use Wikia\Logger\WikiaLogger;

class DumpUtils {

	public static function createInsert( $table, $cols, $data ) {
		$db = wfGetDB( DB_SLAVE );

		$insert = "INSERT INTO $table (`site_id`, " .
				  implode( ",", array_map( function ( $c ) use ( $db ) {
					  return 	$db->addIdentifierQuotes( $c );
				  }, $cols ) ) .
				  ")" .
				  " VALUES (" . \F::app()->wg->CityId;

		foreach ( $cols as $col ) {
			// Truncate long titles if necessary
			if ( $col == "title" ) {
				$value = mb_substr( $data[$col], 0, 512 );
			} else {
				$value = $data[$col];
			}

			$insert .= ', ' . $db->addQuotes( $value );
		}

		$insert .= ');';

		return $insert;
	}

	public static function createMultiInsert( $table, $cols, $inserts ) {
		$db = wfGetDB( DB_SLAVE );

		$insert = "INSERT INTO $table (`site_id`, " .
				  implode( ",", array_map( function ( $c ) use ( $db ) {
					  return 	$db->addIdentifierQuotes( $c );
				  }, $cols ) ) .
				  ")" .
				  " VALUES ";

		$numItems = count($inserts);
		$i = 0;
		foreach ( $inserts as $single ) {
			$values = [];
			preg_match('/VALUES (.*);/', $single, $values);

			$insert .= $values[1];

			if(++$i !== $numItems) {
				$insert .= ", ";
			}
		}

		$insert .= ';';

		return $insert;
	}

	public static function getDBWithRetries( $db ) {

		$tries = 0;
		$acquired = false;

		$dbh = null;

		do {
			try {
				$dbh = wfGetDB( $db );
				$acquired = true;
			} catch ( MWException $e ) {
				$tries++;
				sleep( 1 );
				WikiaLogger::instance()->warning( 'Cannot obtain db connection, reattempting: '.$tries );
			}
		} while ( !$acquired && $tries <= 3);

		return $dbh;
	}
}
