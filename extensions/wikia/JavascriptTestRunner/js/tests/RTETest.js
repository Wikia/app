/**
 * Test showing how to include assets manager group
 */

/*
@test-exclude AssetsManager packages are not supported
// Set framework to QUnit
@test-framework QUnit
// Specify dependency list
@test-require-asset rte
*/

// Start writing module A
module("RTE test");
// Add first test to module A
test("existence", function() {
	// Assert that the passed value is true
	// the second argument should be a human readable message 
	// describing which particular test failed
	ok( typeof window.CKEDITOR == 'object', "typeof window.CKEDITOR" );
	ok( typeof window.RTE == 'object', "typeof window.RTE" );
});

