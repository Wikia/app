var test = {
	suiteName: 'DummyTest',
	setUp: function () {
		console.log('test: setUp()');
	},
    tearDown: function () {
		console.log('test: tearDown()');
	},
	test1: function () {
		console.log('test: test1()');
	},
	test2: function () {
		console.log('test: test2()');
	}
}
window.jtr_framework = "jsUnity";
window.jtr_testsuite = test;