/*
@test-require-module rte-test
*/
var test = {
	suiteName: 'DummyTest',
	setUp: function () {
		jsUnity.attachAssertions(this);
	},
    tearDown: function () {
	},
	testExistence: function () {
		this.assertNotUndefined(window.CKEDITOR);
	}
}
window.jtr_framework = "jsUnity";
window.jtr_testsuite = test;