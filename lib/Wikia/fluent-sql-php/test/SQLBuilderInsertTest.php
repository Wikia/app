<?php
namespace FluentSql;

require_once(__DIR__.'/init.php');

class SQLBuilderInsertTest extends FluentSqlTest {
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
}