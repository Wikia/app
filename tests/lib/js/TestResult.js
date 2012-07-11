/**
 * TestResult - results storage class
 */

var TestResult = function( name ) {
	this.suiteFailures = 0;
	this.suites = {};
	this.name = name || '(unnamed)';
};

TestResult.prototype.findName = function( o, name ) {
	name = name || 'unnamed';
	if (typeof o[name] == 'undefined')
		return name;
	for (var i=1;i<5000;i++) {
		if (typeof o[name+'_'+i] == 'undefined') {
			return name+'_'+i;
		}
	}
	return 'unnamed';
};
TestResult.prototype.errorSuite = function() {
	if (this.currentSuite)
		delete this.suites[this.currentSuite.name];
	this.suiteFailures++;
	this.currentSuite = false;
};
TestResult.prototype.startSuite = function(name,extra) {
	name = this.findName(this.suites,name);
	this.currentSuite = {
		name: name,
		tests: {},
		extra: extra || {},
		stats: {
			time: 0,
			total: 0,
			success: 0,
			failure: 0,
			error: 0,
			skipped: 0,
			unknown: 0,
			assertions: 0
		},
		started: new Date()
	}
	this.suites[name] = this.currentSuite;
};
TestResult.prototype.getStatus = function() {
	for (var i in this.suites) {
		if (this.suites[i].stats.total != this.suites[i].stats.success)
			return false;
	}
	return true;
};
TestResult.prototype.stopSuite = function() {
	var suite = this.currentSuite;
	suite.stats.time = (new Date()) - suite.started;
	delete suite.started;
	this.currentSuite = false;
};
TestResult.prototype.startTest = function(name,extra) {
	name = this.findName(this.currentSuite.tests,name);
	this.currentTest = {
		name: name,
		status: JTR.status.UNKNOWN,
		time: 0,
		assertions: 0,
		messages: false,
		log: [],
		extra: extra || {},
		started: new Date()
	};
	this.currentSuite.tests[name] = this.currentTest;
};
TestResult.prototype.stopTest = function(status, assertions, messages) {
	var suite = this.currentSuite;
	var test = this.currentTest;

	if (!(status in JTR.statusList))
		status = JTR.status.UNKNOWN;
	test.time = (new Date()) - test.started;
	delete test.started;
	test.status = status;
	if (typeof messages != 'undefined') 
		test.messages = messages;
	if (typeof assertions != 'undefined')
		test.assertions = assertions;
	suite.stats[test.status]++;
	suite.stats.total++;
	suite.stats.assertions += test.assertions;
	this.currentTest = false;
};
TestResult.prototype.logTest = function(text) {
	this.currentTest.log.push(text);
};
