/**
 * Test showing the basics of QUnit framework features
 */

/*
 @test-exclude This test is just an example
// Set framework to QUnit
@test-framework QUnit
*/

// Start writing module A
module("Module A");
// Add first test to module A
test("first test within module", function() {
	// Assert that the passed value is true
	// the second argument should be a human readable message 
	// describing which particular test failed
	ok( true, "true" );
	ok( 2 == 2, "2 == 2" );
});
// Add second test to module A
test("second test within module", function() {
	// Just another assertion
	ok( 1 < 2, "1 < 2" );
});

// Start writing module B
module("Module B");

// Add some test to module B
test("some other test", function() {
	// Inform QUnit that this test has N assertions
	// (QUnit will then raise a failure if some of them will not be run)
	expect(2);
	// Another kind of QUnit assertion is comparing two values
	// (first and second arguments), you may pass the message 
	// in the third parameter as you do with ok() assertion
	equal( true, false, "failing test" );
	equal( true, true, "passing test" );
});
