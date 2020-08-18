<?php

use Wikia\Logger\WikiaLogger;

class DumpUtils {

	// Discussions uses TEXT columns for content, which are limited to 2**16 bytes.  Also
	// subtracting 16 bytes from the max size since going right up to the limit still causes
	// MySQL to fail the insert.
	const MAX_CONTENT_SIZE = 65520;

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

			if ( $col == "raw_content" || $col == "content" ) {
				//addQuotes performs additional escaping, so it can make string out of bytes range
				$dbValue = substr($db->addQuotes( $value ), 1, -1);

				if ( strlen($dbValue) > self::MAX_CONTENT_SIZE ) {
					$dbValue = mb_strcut( $dbValue, 0, DumpUtils::MAX_CONTENT_SIZE );
				}

				$insert .= ', ' . "'" . $dbValue . "'";
			} else {
				$insert .= ', ' . $db->addQuotes( $value );
			}
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
