fluent-sql
==========

A minimalistic Fluent SQL API for PHP aimed to resemble the code to your original SQL code.  This is a direct clone of https://github.com/ivanceras/fluent-sql rewritten for PHP.

Example Usage: 

  A complex query:
  
	   WITH LatestOrders AS
	  ( SELECT MAX (ID)
	   FROM dbo.Orders
	   GROUP BY CustomerID )
	SELECT Customers.*,
	       Orders.OrderTime AS LatestOrderTime,
	
	  (SELECT COUNT (*)
	   FROM dbo.OrderItems
	   WHERE OrderID IN
	       (SELECT ID
	        FROM dbo.Orders
	        WHERE CustomerID = Customers.ID)) AS TotalItemsPurchased
	FROM dbo.Customers
	INNER JOIN dbo.Orders ON Customers.ID = Orders.CustomerID
	WHERE Orders.ID IN
	    (SELECT ID
	     FROM LatestOrders)
     
Using String concatenation:
  
  	String sql = 		" WITH LatestOrders AS (" +
				"		SELECT MAX ( ID ) " +
				"			FROM dbo.Orders " +
				"			GROUP BY CustomerID" +
				"		) "+
				" SELECT "+
				"    Customers.*, "+
				"    Orders.OrderTime AS LatestOrderTime, "+
				"    ( SELECT COUNT ( * ) " +
				"		FROM dbo.OrderItems " +
				"		WHERE OrderID IN "+
				"        ( SELECT ID FROM dbo.Orders WHERE CustomerID = Customers.ID ) ) "+
				"            AS TotalItemsPurchased "+
				" FROM dbo.Customers " +
				" INNER JOIN dbo.Orders "+
				"        ON Customers.ID = Orders.CustomerID "+
				" WHERE "+
				"    Orders.ID IN ( SELECT ID FROM LatestOrders )";
  
  
In fluent SQL:
  
    	String actual = new SQL()
			.WITH("LatestOrders", 
					new SQL().SELECT()
							.MAX("ID")
							.FROM("dbo.Orders")
							.GROUP_BY("CustomerID")
			)
			.SELECT()
				.FIELD("Customers.*")
				.FIELD("Orders.OrderTime").AS("LatestOrderTime")
				.FIELD(new SQL().SELECT().COUNT("*")
							.FROM("dbo.OrderItems")
							.WHERE("OrderID").IN(new SQL()
										.SELECT("ID")
										.FROM("dbo.Orders")
										.WHERE("CustomerID").EQUAL_TO_FIELD("Customers.ID"))
							
						).AS("TotalItemsPurchased")
				.FROM("dbo.Customers")
				.INNER_JOIN("dbo.Orders")
					.ON("Customers.ID", "Orders.CustomerID")
				.WHERE("Orders.ID").IN(new SQL()
							.SELECT("ID").FROM("LatestOrders"))
			.build().sql;
      
      

Features
--------------

A SQL breakdown result:
 * breakdown.getSql() (String) - the SQL string built
 * breakdown.getParameters() (Object[]) - the resulted array of the parameters that is gathered by the SQL builder, with the correct order as they are mentioned in the query
	This will be used in as parameters in your preparedStatment 
 * stmt.setObject(i,parameter[i]), in turn SQL injection is already mitigated


Usage of Static methods

		...
	
		public static SQL WITH(String name, SQL sql){
			return new SQL().WITH(name, sql);
		}
		public static SQL SELECT(){
			return new SQL().SELECT();
		}
		public static SQL COUNT(String column){
			return new SQL().COUNT(column);
		}
		public static SQL COUNT(SQL sql){
			return new SQL().COUNT(sql);
		}
		public static SQL SUM(String column){
			return new SQL().SUM(column);
		}
		public static SQL SUM(SQL sql){
			return new SQL().SUM(sql);
		}
		....

A more complex example with nested functions

		String expected =
				" SELECT "+
				"		( SELECT SUM ( COUNT ( ID ) )," +
				"				COUNT ( MAX ( n_items ) ), " +
				"				CustomerName " +
				"			FROM dbo.Orders" +
				"			RIGHT JOIN Customers" +
				"				on Orders.Customer_ID = Customers.ID " +
				"			LEFT JOIN Persons" +
				"				ON Persons.name = Customer.name" +
				"				AND Persons.lastName = Customer.lastName" +
				"			GROUP BY CustomerID " +
				"		) AS LatestOrders," +
				"    Customers.*, "+
				"    Orders.OrderTime AS LatestOrderTime, "+
				"    ( SELECT COUNT ( * ) " +
				"		FROM dbo.OrderItems " +
				"		WHERE OrderID IN "+
				"        ( SELECT ID FROM dbo.Orders WHERE CustomerID = Customers.ID ) ) "+
				"            AS TotalItemsPurchased "+
				" FROM dbo.Customers " +
				" INNER JOIN dbo.Orders "+
				"        USING ID" +
				" WHERE "+
				"	Orders.n_items > ? "+
				"   AND Orders.ID IN ( SELECT ID FROM LatestOrders )" +
				"	ORDER BY ID DESC " +
				" LIMIT 100 " +
				" OFFSET 20" ;

		...	
	
In Fluent SQL
	
		import static com.ivanceras.fluent.StaticSQL.*;
		...
	
		Breakdown actual = 
			SELECT()
				.FIELD(SELECT("CustomerName")
							.SUM(COUNT("ID"))
							.COUNT(MAX("n_items"))
							.FROM("dbo.Orders")
							.RIGHT_JOIN("Customers")
								.ON("Orders.customer_ID", "Customers.ID")
							.LEFT_JOIN("Persons")
								.ON("Persons.name", "Customer.name")
								.AND("Persons.lastName", "Customer.lastName")
							.GROUP_BY("CustomerID")
				).AS("LatestOrders")
				.FIELD("Customers.*")
				.FIELD("Orders.OrderTime").AS("LatestOrderTime")
				.FIELD(SELECT().COUNT("*")
							.FROM("dbo.OrderItems")
							.WHERE("OrderID").IN(
										SELECT("ID")
										.FROM("dbo.Orders")
										.WHERE("CustomerID").EQUAL_TO_FIELD("Customers.ID"))
							
						).AS("TotalItemsPurchased")
				.FROM("dbo.Customers")
				.INNER_JOIN("dbo.Orders")
					.USING("ID")
				.WHERE("Orders.n_items").GREATER_THAN(0)
				.AND("Orders.ID").IN(SELECT("ID").FROM("LatestOrders"))
				.ORDER_BY("ID").DESC()
				.LIMIT(100)
				.OFFSET(20)
			.build();
		...
				CTest.cassertEquals(expected, actual.getSql());
		...
	
Notice the nested functions?

			.SUM(COUNT("ID"))
            .COUNT(MAX("n_items"))
            
Yes, you can have as many nested functions as you require.

More examples
-------------

https://github.com/ivanceras/fluent-sql/tree/master/test/com/ivanceras/fluent

Similar Projects
------------------

https://github.com/ivanceras/fluent-sql

MIT License

