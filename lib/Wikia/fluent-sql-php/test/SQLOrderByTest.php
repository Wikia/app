<?php
namespace FluentSql;

require_once(__DIR__.'/init.php');

class SQLOrderByTest extends FluentSqlTest {
	public function testOrderBy() {
		$expected = "
			SELECT Customers.CustomerName, Orders.OrderID
			FROM Customers AS c
			ORDER BY name DESC, description
		";

		$actual = (new SQL)
			->SELECT('Customers.CustomerName', 'Orders.OrderID')
			->FROM('Customers')->AS_('c')
			->ORDER_BY(['name', 'desc'], 'description');

		$this->assertEquals($expected, $actual);
	}
}