/**
 * Test explaining how to test features from extensions which need including 
 * specific source files
 */

/*
 @test-exclude This test is just an example
// Set framework to QUnit
@test-framework QUnit
// Specify dependency list
@test-require-asset extensions/wikia/JavascriptTestRunner/js/tests/features/Calculator.js
*/

// Define new QUnit test module
module("Calculator Test");

// Add the following tests to current test module
test("add", function () {
	var c = new Calculator();
	equal(c.add(1, 1), 2, "1 + 1");
	equal(c.add(2, 2), 4, "2 + 2");
});

test("subtract", function () {
	var c = new Calculator();
	equal(c.subtract(1, 1), 0, "1 - 1");
	equal(c.subtract(100, 1), 99, "100 - 1");
});

test("multiply", function () {
	var c = new Calculator();
	equal(c.multiply(1, 1), 1, "1 * 1");
	equal(c.multiply(2, 2), 4, "2 * 2");
	equal(c.multiply(17, 23), 391, "17 * 23");
});

test("divide", function () {
	var c = new Calculator();
	equal(c.divide(1, 1), 1, "1 / 1");
	equal(c.divide(8, 2), 4, "8 / 2");
	equal(c.divide(1, 0), Infinity, "1 / 0");
});
