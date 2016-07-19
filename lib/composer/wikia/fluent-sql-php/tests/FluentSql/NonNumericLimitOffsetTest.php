<?php
/**
 * Test non-numeric LIMIT and OFFSET
 *
 * @author Mix <mix@wikia.com>
 */

namespace FluentSql;

class NonNumericLimitOffsetTest extends FluentSqlTestBase {

	/**
	 * numeric LIMIT
	 */
	public function test1() {
		$expected = 'SELECT Customers.CustomerName FROM Customers LIMIT 5';
		$actual = (new SQL)->SELECT('Customers.CustomerName')->FROM('Customers')->LIMIT(5);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * numeric OFFSET
	 */
	public function test2() {
		$expected = 'SELECT Customers.CustomerName FROM Customers LIMIT 5 OFFSET 10';
		$actual = (new SQL)->SELECT('Customers.CustomerName')->FROM('Customers')->LIMIT(5)->OFFSET(10);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * non-numeric LIMIT not allowed
	 *
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage using non-numeric LIMIT when not allowed
	 */
	public function test3() {
		$actual = (new SQL)->SELECT('Customers.CustomerName')->FROM('Customers')->LIMIT('0; SQL INJECTION -- ');
		$this->expectException(InvalidArgumentException::class);
	}

	/**
         * non-numeric OFFSET
	 *
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage using non-numeric OFFSET when not allowed
	 */
	public function test4() {
		$actual = (new SQL)->SELECT('Customers.CustomerName')->FROM('Customers')->LIMIT(5)->OFFSET('0; SQL INJECTION -- ');
	}

	/**
	 * non-numeric LIMIT allowed
	 */
	public function test5() {
		$expected = "SELECT Customers.CustomerName FROM Customers LIMIT SOME_FUNCTION('some_param')";
		$actual = (new SQL)->SELECT('Customers.CustomerName')->FROM('Customers')->LIMIT("SOME_FUNCTION('some_param')", \FluentSql\SQL::FORCE_NON_NUMERIC_LIMIT);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * non-numeric OFFSET allowed
	 */
	public function test6() {
		$expected = "SELECT Customers.CustomerName FROM Customers LIMIT 5 OFFSET SOME_FUNCTION('some_param')";
		$actual = (new SQL)->SELECT('Customers.CustomerName')->FROM('Customers')->LIMIT(5)->OFFSET("SOME_FUNCTION('some_param')", \FluentSql\SQL::FORCE_NON_NUMERIC_OFFSET);
		$this->assertEquals($expected, $actual);
	}

}
