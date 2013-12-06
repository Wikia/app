<?php
/**
 * TestComplexQuery
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

require_once(__DIR__.'/init.php');

class ComplexQueryTest extends FluentSqlTest {
	public function test1() {
		$expected = "
			SELECT Customers.CustomerName, Orders.OrderID
			FROM Customers
				INNER JOIN Orders
					ON Customers.CustomerID = Orders.CustomerID
			ORDER BY Customers.CustomerName
		";

		$actual = (new SQL)
			->SELECT('Customers.CustomerName', 'Orders.OrderID')
			->FROM('Customers')
				->JOIN('Orders')->ON('Customers.CustomerID', 'Orders.CustomerID')
			->ORDER_BY('Customers.CustomerName');

		$this->assertEquals($expected, $actual);
	}

	public function test2() {
		$expected = "
			WITH LatestOrders AS (
				SELECT MAX( ID )
				FROM dbo.Orders
				GROUP BY CustomerID
			)
			SELECT
				Customers.*,
				Orders.OrderTime AS LatestOrderTime,
				(
					SELECT COUNT( * )
					FROM dbo.OrderItems
					WHERE OrderID IN (
						SELECT ID
						FROM dbo.Orders
						WHERE CustomerID = Customers.ID
					)
				) AS TotalItemsPurchased
			FROM dbo.Customers
				INNER JOIN dbo.Orders
					ON Customers.ID = Orders.CustomerID
			WHERE Orders.ID IN (
				SELECT ID
				FROM LatestOrders
			)
		";

		$actual = (new SQL)
			->WITH(
				'LatestOrders',
				(new SQL)
					->SELECT()
						->MAX('ID')
						->FROM('dbo.Orders')
						->GROUP_BY('CustomerID')
			)
			->SELECT()
				->FIELD('Customers.*')
				->FIELD('Orders.OrderTime')->AS_('LatestOrderTime')
				->FIELD(
					(new SQL)
						->SELECT()
							->COUNT('*')
						->FROM('dbo.OrderItems')
						->WHERE('OrderID')->IN(
							(new SQL)
								->SELECT('ID')
								->FROM('dbo.Orders')
								->WHERE('CustomerID')->EQUAL_TO_FIELD('Customers.ID')
						)
				)->AS_('TotalItemsPurchased')
			->FROM('dbo.Customers')
				->JOIN('dbo.Orders')->ON('Customers.ID', 'Orders.CustomerID')
			->WHERE('Orders.ID')->IN(
				(new SQL)
					->SELECT('ID')
					->FROM('LatestOrders')
			);

		$this->assertEquals($expected, $actual);
	}
}