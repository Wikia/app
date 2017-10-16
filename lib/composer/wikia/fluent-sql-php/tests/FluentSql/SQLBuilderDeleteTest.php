<?php
namespace FluentSql;

class SQLBuilderDeleteTest extends FluentSqlTestBase {
	public function test1() {
		$expected = "
			DELETE FROM products
			WHERE price IS NOT NULL
		";

		$actual = (new SQL)
			->DELETE()->FROM('products')
			->WHERE('price')->IS_NOT_NULL();

		$this->assertEquals($expected, $actual);
	}

	public function test2() {
		$expected = "
			DELETE FROM products
			WHERE price = ?
		";

		$actual = (new SQL)
			->DELETE('products')
			->WHERE('price')->EQUAL_TO(10);

		$this->assertEquals($expected, $actual);
	}
}
