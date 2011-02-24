var test = {
	suiteName: 'SuccessTest',
	testOk: function () {
		jsUnity.attachAssertions(this);
		this.assertTrue(true);
	}
}
window.jtr_framework = "jsUnity";
window.jtr_testsuite = test;