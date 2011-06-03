/*
@test-framework jsUnity
@test-require-module rte-test
*/

/**
 * This is the exapmle test for dependency declaration
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