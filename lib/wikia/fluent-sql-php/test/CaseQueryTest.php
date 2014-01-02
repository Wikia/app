<?php
namespace FluentSql;

require_once(__DIR__.'/init.php');

class CaseQueryTest extends FluentSqlTest {
	public function testSimpleValueCase() {
		$expected = "
			SELECT
				(
					CASE ?
						WHEN ? THEN ?
						WHEN ? THEN ?
						ELSE ?
					END
				) AS someCol
		";

		$actual = (new SQL)
			->SELECT()
				->CASE_(1)
					->WHEN(1)->THEN('one')
					->WHEN(2)->THEN('two')
					->ELSE_('unknown')
				->AS_('someCol');

		$this->assertEquals($expected, $actual);
	}

	public function testSimpleConditionCase() {
		$expected = "
			SELECT
				(
					CASE
						WHEN ? > ? THEN ?
						ELSE ?
					END
				)
		";

		$actual = (new SQL)
			->SELECT()
				->CASE_()
					->WHEN(1)->GREATER_THAN(0)->THEN('one')
					->ELSE_('unknown');

		$this->assertEquals($expected, $actual);
	}

	public function testWhereCase() {
		$expected = "
			SELECT *
			FROM someTable
			WHERE (
				CASE
					WHEN date IS NOT NULL THEN ?
					ELSE ?
					END
				) = ?
		";

		$actual = (new SQL)
			->SELECT_ALL()
			->FROM('someTable')
			->WHERE(
				StaticSQL::CASE_()
					->WHEN_FIELD('date')->IS_NOT_NULL()->THEN(1)
					->ELSE_(0)
			)->EQUAL_TO(1);

		$this->assertEquals($expected, $actual);
	}

	public function testComplex() {
		$expected = "
			SELECT
				someCol,
				(
					CASE ( SELECT anotherCol FROM anotherTable WHERE id = '1' )
						WHEN '5' THEN 'five'
						WHEN '6' THEN 'six'
						ELSE 'unknown'
					END
				) AS someCol2
			FROM someTable
			WHERE (
				CASE
					WHEN ( SELECT anotherCol FROM anotherTable WHERE id = '2' ) = 'someValue' THEN ( SELECT anotherCol2 FROM anotherTable WHERE id = '17' )
				END
			) = 'someOtherValue'
				AND id = '98'
			ORDER BY someCol2
			LIMIT 5
		";

		$actual = (new SQL)
			->SELECT('someCol')
				->CASE_(
					(new SQL)
						->SELECT('anotherCol')
						->FROM('anotherTable')
						->WHERE('id')->EQUAL_TO(1)
				)
					->WHEN(5)->THEN('five')
					->WHEN(6)->THEN('six')
					->ELSE_('unknown')
				->AS_('someCol2')
			->FROM('someTable')
			->WHERE(
				StaticSQL::CASE_()
					->WHEN(
						(new SQL)
							->SELECT('anotherCol')
							->FROM('anotherTable')
							->WHERE('id')->EQUAL_TO(2)
					)->EQUAL_TO('someValue')->THEN(
						(new SQL)
							->SELECT('anotherCol2')
							->FROM('anotherTable')
							->WHERE('id')->EQUAL_TO(17)
					)
			)->EQUAL_TO('someOtherValue')
				->AND_('id')->EQUAL_TO(98)
			->ORDER_BY('someCol2')
			->LIMIT(5);

		$this->assertEquals($expected, $actual->injectParams(null, $actual->build()));
	}
}