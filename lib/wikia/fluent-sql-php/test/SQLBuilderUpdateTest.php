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
}