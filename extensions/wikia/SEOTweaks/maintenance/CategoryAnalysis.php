<?php

class CategoryAnalysis {
	static $counter = 0;

	public static function run( DatabaseMysqli $db, $test = false, $verbose = false, $params = [] ) {
		( new \WikiaSQL() )
			->SELECT( 'count(0) as cnt' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( 14 )
			->AND_( 'page_len' )->GREATER_THAN_OR_EQUAL( 10000 )
			->run(
				$db,
				function ( $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return;
					}

					$row = $result->fetchObject();
					if ( empty( $row ) ) {
						return;
					}

					self::$counter += $row->cnt;
					echo self::$counter . PHP_EOL;
				}
			);
	}
}
