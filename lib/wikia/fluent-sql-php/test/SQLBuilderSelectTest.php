<?php
namespace FluentSql;

require_once(__DIR__.'/init.php');

class SQLBuilderSelectTest extends FluentSqlTest {
	/**
	 * @param $expected
	 * @param $actual
	 * @dataProvider selectProvider
	 */
	public function testSelect($expected, $actual) {
		$this->assertEquals($expected, $actual);
	}

	public function selectProvider() {
		return [
			[
				"
				SELECT *
				FROM products
				WHERE price IS NOT NULL
				",
				(new SQL)
				->SELECT_ALL()
				->FROM('products')
				->WHERE('price')->IS_NOT_NULL()
			],
			[
				"
				SELECT name
				FROM products
				WHERE price >= ?
				",
				(new SQL)
				->SELECT('name')
				->FROM('products')
				->WHERE('price')->GREATER_THAN_OR_EQUAL(10)
			],
			[
				"
				SELECT name
				FROM products
				WHERE price < ?
				",
				(new SQL)
				->SELECT('name')
				->FROM('products')
				->WHERE('price')->LESS_THAN(10)
			],
			[
				"
				SELECT name
				FROM products
				WHERE price > ?
				LIMIT 10
				OFFSET 1
				",
				(new SQL)
				->SELECT('name')
				->FROM('products')
				->WHERE('price')->GREATER_THAN(10)
				->LIMIT(10)
				->OFFSET(1)
			],
			[
				"
				SELECT name
				FROM products
					LEFT JOIN items
						USING item_id, name
				WHERE price > ?
				LIMIT 10
				OFFSET 1
				",
				(new SQL)
				->SELECT('name')
				->FROM('products')
					->LEFT_JOIN('items')
						->USING('item_id', 'name')
				->WHERE('price')->GREATER_THAN(10)
				->LIMIT(10)
				->OFFSET(1)
			],
			[
				"
				SELECT name
				FROM products
					LEFT JOIN item
						ON item_id = product_id
							AND products.name = item.name
				WHERE price > ?
				LIMIT 10
				OFFSET 1
				",
				(new SQL)
					->SELECT('name')
					->FROM('products')
						->LEFT_JOIN('item')
							->ON('item_id', 'product_id')
								->AND_('products.name', 'item.name')
					->WHERE('price')->GREATER_THAN(20)
					->LIMIT(10)
					->OFFSET(1)
			]
		];
	}
}