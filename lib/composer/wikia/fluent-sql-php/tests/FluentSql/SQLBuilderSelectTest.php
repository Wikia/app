<?php
namespace FluentSql;

class SQLBuilderSelectTest extends FluentSqlTestBase {
	/**
	 * @param $expected
	 * @param $actual
	 * @param $fill
	 * @dataProvider selectProvider
	 */
	public function testSelect($expected, $actual, $fill=false) {
		if ($fill) {
			/** @var SQL $actual */
			$actual = $actual->injectParams(null, $actual->build());
		}

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
						USING (item_id, name)
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
			],
			[
				"
				SELECT name, count(*) as c
				FROM products
				GROUP BY name
				HAVING c BETWEEN ? AND ?
				",
				(new SQL)
					->SELECT('name', 'count(*) as c')
					->FROM('products')
					->GROUP_BY('name')
					->HAVING('c')->BETWEEN(1, 2)
			],
			[
				"
				SELECT name, count(*) as c
				FROM products
				GROUP BY name
				HAVING c > ?
				",
				(new SQL)
					->SELECT('name', 'count(*) as c')
					->FROM('products')
					->GROUP_BY('name')
					->HAVING('c')->GREATER_THAN(1)
			],
			[
				"
				SELECT name, address
				FROM people
				WHERE name LIKE '%nelson%'
				",
				(new SQL)
					->SELECT('name', 'address')
					->FROM('people')
					->WHERE('name')->LIKE('%nelson%'),
				true
			],
			[
				"
				SELECT name, address, birthday
				FROM people
				WHERE name LIKE '%nelson%'
					AND (
						address IS NULL OR
						birthday = '19851212'
					)
					AND some_col > '5'
				",
				(new SQL)
					->SELECT('name', 'address', 'birthday')
					->FROM('people')
					->WHERE('name')->LIKE('%nelson%')
						->AND_(StaticSQL::RAW(
							'( address is null or birthday = ? )', ['19851212']
						))
						->AND_('some_col')->GREATER_THAN(5),
				true
			],
			[
				"
				SELECT *
				FROM a
					LEFT JOIN b
						USING (c1, c2, c3)
				",
				(new SQL)
					->SELECT('*')
					->FROM('a')
						->LEFT_JOIN('b')
						->USING('c1', 'c2')
						->USING('c3'),
				true
			]
		];
	}
}
