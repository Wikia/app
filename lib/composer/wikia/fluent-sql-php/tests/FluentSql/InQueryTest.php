<?php
namespace FluentSql;

class InQueryTest extends FluentSqlTestBase {

	public function testArrayInQuery() {
		$expected = 'SELECT * FROM test_table WHERE test_column IN ( ?, ?, ? )';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE('test_column')
			->IN([1,2,3]);

		$this->assertEquals($expected, $actual);
	}

	public function testSingleValueInQuery() {
		$expected = 'SELECT * FROM test_table WHERE test_column = ?';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE('test_column')
			->IN([1]);

		$this->assertEquals($expected, $actual);
	}

	public function testEmptyArrayInQuery() {
		$expected = 'SELECT * FROM test_table WHERE test_column IN ( NULL )';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE('test_column')
			->IN([]);

		$this->assertEquals($expected, $actual);
	}

	public function testNoValueInQuery() {
		$expected = 'SELECT * FROM test_table WHERE test_column IN ( NULL )';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE('test_column')
			->IN();

		$this->assertEquals($expected, $actual);
	}

	public function testNotInQuery() {
		$expected = 'SELECT * FROM test_table WHERE test_column NOT IN ( ?, ? )';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE('test_column')
			->NOT_IN([1,2]);

		$this->assertEquals($expected, $actual);
	}

	public function testExistsQuery() {
		$expected = 'SELECT * FROM test_table WHERE EXISTS ( SELECT * FROM second_table )';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE(null)
			->EXIST((new SQL())->SELECT_ALL()->FROM('second_table'));

		$this->assertEquals($expected, $actual);
	}

	public function testNotExistsQuery() {
		$expected = 'SELECT * FROM test_table WHERE NOT EXISTS ( SELECT * FROM second_table )';
		$actual = (new SQL())
			->SELECT_ALL()
			->FROM('test_table')
			->WHERE(null)
			->NOT_EXISTS((new SQL())->SELECT_ALL()->FROM('second_table'));

		$this->assertEquals($expected, $actual);
	}
}
