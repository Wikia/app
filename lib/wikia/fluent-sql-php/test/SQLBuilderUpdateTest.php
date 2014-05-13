<?php
namespace FluentSql;

require_once(__DIR__.'/init.php');

class SQLBuilderUpdateTest extends FluentSqlTest {
	public function testUpdate() {
		$expected = "
			UPDATE films
			SET genre = 'horror'
			WHERE genre = 'comedy'
		";

		$sql = (new SQL)
			->UPDATE('films')
			->SET('genre', 'horror')
			->WHERE('genre')->EQUAL_TO('comedy');

		$this->assertEquals($expected, $sql->injectParams(null, $sql->build()));
	}

	public function testUpdate2() {
		$expected = "
			UPDATE films
			SET genre = ?, director = ?
			WHERE director = ?
				AND release_date BETWEEN ? AND ?
		";

		$actual = (new SQL)
			->UPDATE('films')
			->SET('genre', 'awesome')
				->SET('director', 'someAwesomeGuy')
			->WHERE('director')->EQUAL_TO('someLameGuy')
				->AND_('release_date')->BETWEEN('2004', '2005');

		$this->assertEquals($expected, $actual);
	}

	public function testUpdate3() {
		$expected = "
			UPDATE some_table
			SET some_field = null, some_other_field = '', another_field = 'null'
			WHERE something = '4'
		";

		$sql = (new SQL)
			->UPDATE('some_table')
			->SET_RAW('some_field', 'null', true)
				->SET('some_other_field', null)
				->SET('another_field', 'null')
			->WHERE('something')->EQUAL_TO(4);

		$this->assertEquals($expected, $sql->injectParams(null, $sql->build()));
	}
}