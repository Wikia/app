<?php

use PHPUnit\Framework\TestCase;

/**
 * @group Database
 */
class DatabaseTest extends TestCase {

	/**
	 * @param string $sql
	 * @param bool $expected
	 * @dataProvider writeQueriesProvider
	 */
	function testIsWriteQuery( string $sql, bool $expected ) {
		$this->assertEquals( $expected, DatabaseBase::isWriteQuery( $sql ) );
	}

	function writeQueriesProvider() {
		// write queries
		yield [ 'INSERT /* Wikia::updateMultiLookup */ INTO `multilookup` (ml_city_id,ml_ip_bin,ml_ts) VALUES (\'0\',\'0\',\'20180601142234\') ON DUPLICATE KEY UPDATE ml_ts = \'20180601142234\'', true ];
		yield [ 'UPDATE /* Title::invalidateCache */  `page` SET page_touched = \'20180601142344\' WHERE page_id = 13052', true ];

		// read queries
		yield [ 'SELECT * FROM foo', false ];
		yield [ '  SELECT * FROM foo', false ];
		yield [ 'SELECT /* test */ * FROM foo', false ];
		yield [ 'USE foo', false ];
		yield [ 'BEGIN', false ];
		yield [ 'COMMIT', false ];
	}

}