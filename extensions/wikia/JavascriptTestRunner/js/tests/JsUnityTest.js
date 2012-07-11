/**
 * Simple jsUnity test
 */

/*
// Set the testing framework to "jsUnity"
@test-exclude This test is just an example
@test-framework jsUnity
*/

// Define test suite in the local variable
var test = {

	// Give a name to this test suite
	suiteName: 'DummyTest',

	// This method is run before every test
	setUp: function () {
		jsUnity.attachAssertions(this);
		window.console && console.log && console.log('test: setUp()');
	},

	// This method is run after every test
	tearDown: function () {
		window.console && console.log && console.log('test: tearDown()');
	},

	// The first simple test which outputs something to console
	// and doesn't have any assertions (which is pointless though)
	test1: function () {
		window.console && console.log && console.log('test: test1()');
	},

	// The second test just fails every time you run it
	test2: function () {
		window.console && console.log && console.log('test: test2()');
		this.fail('testing failure');
	},

	// The third test has one assertion checking if the value is true 
	// (in this case it will fail), for full list of supported assertions
	// take a look at jsUnity documentation or source code (which is 
	// pretty small and readable)
	test3: function () {
		window.console && console.log && console.log('test: test3()');
		this.assertTrue(false,'custom assertTrue');
	}

}

// Assign the test suite to the special variable which should have the test suite definition
window.jtr_testsuite = test;

