/*
@test-framework jsUnity
*/

/**
 * This is the simplest successful test for jsUnity framework
 */
var test = {
	suiteName: 'SuccessTest',
	testOk: function () {
		jsUnity.attachAssertions(this);
		this.assertTrue(true);
	}
}
window.jtr_testsuite = test;