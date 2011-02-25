/*
@test-require-file extensions/wikia/includetest.js
*/
var test = {
	suiteName: 'DummyTest',
	setUp: function () {
		jsUnity.attachAssertions(this);
		window.console && console.log && console.log('test: setUp()');
	},
    tearDown: function () {
		window.console && console.log && console.log('test: tearDown()');
	},
	test1: function () {
		window.console && console.log && console.log('test: test1()');
	},
	test2: function () {
		window.console && console.log && console.log('test: test2()');
		this.fail('testing failure');
	},
	test3: function () {
		window.console && console.log && console.log('test: test3()');
		this.assertTrue(false,'custom assertTrue');
	}

}
window.jtr_framework = "jsUnity";
window.jtr_testsuite = test;