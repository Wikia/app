/*
@test-framework jsUnity
@test-require-module rte-test
*/
var test = {
	suiteName: 'RTETest',
	setUp: function () {
		jsUnity.attachAssertions(this);
	},
    tearDown: function () {
	},
	testExistence: function () {
		this.assertNotUndefined(window.CKEDITOR);
	}
}
window.jtr_testsuite = test;