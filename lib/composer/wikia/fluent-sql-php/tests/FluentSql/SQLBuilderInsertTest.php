<?php
namespace FluentSql;

class SQLBuilderInsertTest extends FluentSqlTestBase {
	public function testInsert() {
		$expected = "
			INSERT INTO films (
				SELECT *
				FROM tmp_films
				WHERE date_prod < ?
			)
		";

		$actual = (new SQL)
			->INSERT('films')
			->VALUE(
				(new SQL)
					->SELECT_ALL()
					->FROM('tmp_films')
					->WHERE('date_prod')->LESS_THAN('2004-05007')
			);

		$this->assertEquals($expected, $actual);
	}

	public function testSet() {
		$expected = "
			INSERT INTO files SET id = '1', location = '/path/to/file'
		";

		$sql = (new SQL)
			->INSERT('files')
			->SET('id', 1)
			->SET('location', '/path/to/file');

		$actual = $sql->injectParams(null, $sql->build());

		$this->assertEquals($expected, $actual);
	}

	public function testValues() {
		$expected = "
			INSERT INTO some_table (col1, col2, col3) VALUES ('1', '2', '3' ), ('4', '5', '6' )
		";

		$sql = (new SQL)
			->INSERT()->INTO('some_table', ['col1', 'col2', 'col3'])
			->VALUES([[1, 2, 3], [4, 5, 6]]);

		$actual = $sql->injectParams(null, $sql->build());

		$this->assertEquals($expected, $actual);
	}
}
