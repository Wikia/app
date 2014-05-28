<?php
namespace FluentSql;

require_once(__DIR__.'/init.php');

class SimpleComplexFunctionsTest extends FluentSqlTest {
	public function testRecursiveComplexFunctions() {
		$expected =
			" WITH LatestOrders AS (" .
			"		SELECT SUM( COUNT( ID ) )," .
			"				COUNT( MAX( n_items ) ), " .
			"				CustomerName " .
			"			FROM dbo.Orders" .
			"			RIGHT JOIN Customers AS c" .
			"				ON Orders.Customer_ID = Customers.ID " .
			"			LEFT JOIN Persons" .
			"				ON Persons.name = Customer.name" .
			"				AND Persons.lastName = Customer.lastName" .
			"			GROUP BY CustomerID" .
			"		) ".
			" SELECT ".
			"    Customers.*, ".
			"    Orders.OrderTime AS LatestOrderTime, ".
			"    ( SELECT COUNT( * ) " .
			"		FROM dbo.OrderItems " .
			"		WHERE OrderID IN ".
			"        ( SELECT ID FROM dbo.Orders WHERE CustomerID = Customers.ID ) ) ".
			"            AS TotalItemsPurchased ".
			" FROM dbo.Customers " .
			" INNER JOIN dbo.Orders ".
			"        USING ID" .
			" WHERE ".
			"	Orders.n_items > ? ".
			"			AND CustomerID IN ( ?, ?, ?, ?, ? )".
			"   AND Orders.ID IN ( SELECT ID FROM LatestOrders )";

		$actual =
			StaticSQL::WITH("LatestOrders",
				StaticSQL::SELECT("CustomerName")
					->SUM(StaticSQL::COUNT("ID"))
					->COUNT(StaticSQL::MAX("n_items"))
					->FROM("dbo.Orders")
						->RIGHT_JOIN("Customers")->AS_('c')
							->ON("Orders.Customer_ID", "Customers.ID")
						->LEFT_JOIN("Persons")
							->ON("Persons.name", "Customer.name")
								->AND_("Persons.lastName", "Customer.lastName")
					->GROUP_BY("CustomerID")
			)
				->SELECT()
					->FIELD("Customers.*")
					->FIELD("Orders.OrderTime")->AS_("LatestOrderTime")
					->FIELD(
						StaticSQL::SELECT()->COUNT("*")
							->FROM("dbo.OrderItems")
							->WHERE("OrderID")->IN(
								StaticSQL::SELECT("ID")
								->FROM("dbo.Orders")
								->WHERE("CustomerID")->EQUAL_TO_FIELD("Customers.ID")
							)
				)->AS_("TotalItemsPurchased")
				->FROM("dbo.Customers")
					->INNER_JOIN("dbo.Orders")->USING("ID")
				->WHERE("Orders.n_items")->GREATER_THAN(0)
					->AND_('CustomerID')->IN(1, 2, 3, 4, 5)
					->AND_("Orders.ID")->IN(StaticSQL::SELECT("ID")->FROM("LatestOrders"));

		$this->assertEquals($expected, $actual);
	}
}