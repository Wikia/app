<?php

class SqlParserTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/convertionUtils.php';
		parent::setUp();
	}

	/**
	 * @param $sqlLine
	 * @param $expected
	 * @dataProvider sqlColumnLinesDataProvider
	 */
	public function testColumnParse( $sqlLine, $expected ) {
		$parse = new ConvertionSqlParser( null );

		$result = $parse->parseColumn( $sqlLine );

		$this->assertSame( $expected, (array)$result );
	}

	public function sqlColumnLinesDataProvider() {
		return [
			[
				'  `cat` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL',
				[
					'COLUMN_NAME' => 'cat',
					'COLUMN_TYPE' => 'varchar(255)',
					'EXTRA' => '',
					'IS_NULLABLE' => 'YES',
					'COLUMN_DEFAULT' => null,
					'COLUMN_DEFAULT_EXPR' => 'NULL',
					'COLLATION_NAME' => 'utf8mb4_bin',
					'COLUMN_COMMENT' => null,
					'COLUMN_ONUPDATE_EXPR' => null
				]
			],
			[
				'  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL',
				[
					'COLUMN_NAME' => 'data',
					'COLUMN_TYPE' => 'text',
					'EXTRA' => '',
					'IS_NULLABLE' => 'NO',
					'COLUMN_DEFAULT' => null,
					'COLUMN_DEFAULT_EXPR' => null,
					'COLLATION_NAME' => 'utf8_unicode_ci',
					'COLUMN_COMMENT' => null,
					'COLUMN_ONUPDATE_EXPR' => null
				]
			],
		];
	}

	/**
	 * @param $sql
	 * @param $expected
	 * @dataProvider sqlTablesProvider
	 */
	public function testTableParse( $sql, $expected ) {
		$parser = new ConvertionSqlParser( null );

		$result = $parser->parseTable( $sql );

		//		$this->assertSame( $expected, $result );
		foreach ( $result['fields'] as $key => $data ) {
			$this->assertSame( $expected['fields'][$key], (array)$data );
		}
	}

	public function sqlTablesProvider() {
		$createSql = 'CREATE TABLE `ach_custom_badges` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cat` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT \'0\'
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin';

		return [
			[
				$createSql,
				[
					'sql' => $createSql,
					'table' => (object)[
						'TABLE_NAME' => 'ach_custom_badges',
						'ENGINE' => 'InnoDB',
						'TABLE_COLLATION' => 'utf8mb4_bin'
					],
					'fields' => [
						// `id` int(10) NOT NULL AUTO_INCREMENT,
						[
							'TABLE_NAME' => 'ach_custom_badges',
							'COLLATION_NAME' => null,
							'COLUMN_NAME' => 'id',
							'COLUMN_TYPE' => 'int(10)',
							'EXTRA' => 'auto_increment',
							'IS_NULLABLE' => 'NO',
							'COLUMN_DEFAULT' => null,
							'COLUMN_DEFAULT_EXPR' => null,
							'COLUMN_COMMENT' => null,
							'COLUMN_ONUPDATE_EXPR' => null,

						],
						// `cat` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
						[
							'TABLE_NAME' => 'ach_custom_badges',
							'COLLATION_NAME' => 'utf8mb4_bin',
							'COLUMN_NAME' => 'cat',
							'COLUMN_TYPE' => 'varchar(255)',
							'EXTRA' => '',
							'IS_NULLABLE' => 'YES',
							'COLUMN_DEFAULT' => null,
							'COLUMN_DEFAULT_EXPR' => 'NULL',
							'COLUMN_COMMENT' => null,
							'COLUMN_ONUPDATE_EXPR' => null
						],
						// `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
						[
							'TABLE_NAME' => 'ach_custom_badges',
							'COLLATION_NAME' => 'utf8_unicode_ci',
							'COLUMN_NAME' => 'data',
							'COLUMN_TYPE' => 'text',
							'EXTRA' => '',
							'IS_NULLABLE' => 'NO',
							'COLUMN_DEFAULT' => null,
							'COLUMN_DEFAULT_EXPR' => null,
							'COLUMN_COMMENT' => null,
							'COLUMN_ONUPDATE_EXPR' => null
						],
						// `enabled` tinyint(1) NOT NULL DEFAULT '0'
						[
							'TABLE_NAME' => 'ach_custom_badges',
							'COLLATION_NAME' => null,
							'COLUMN_NAME' => 'enabled',
							'COLUMN_TYPE' => 'tinyint(1)',
							'EXTRA' => '',
							'IS_NULLABLE' => 'NO',
							'COLUMN_DEFAULT' => '0',
							'COLUMN_DEFAULT_EXPR' => '\'0\'',
							'COLUMN_COMMENT' => null,
							'COLUMN_ONUPDATE_EXPR' => null
						],
					]
				]
			]
		];
	}
}
