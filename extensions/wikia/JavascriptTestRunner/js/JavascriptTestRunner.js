(function() {

	
	var JTR = {
		status: {
			SUCCESS: 'success',
			FAILURE: 'failure',
			ERROR: 'error',
			SKIPPED: 'skipped',
			UNKNOWN: 'unknown'
		},
		statusList: {},
		frameworks: {},
		tools: {},
		outputs: {},
		TestRunner: null
	};
	
	for (var i in JTR.status) {
		JTR.statusList[JTR.status[i]] = true;
	}
	
	/**
	 * TestRunner - main testing class
	 */
	var TestRunner = function( outputs, name ) {
		this.configure(outputs,name);
	}
	TestRunner.prototype.configure = function( outputs, name ) {
		this.outputs = outputs;
		this.name = name;
	}
	TestRunner.prototype.run = function( frameworkName, testSuites ) {
		var framework = new JTR.frameworks[frameworkName](this);
		var args = Array.prototype.slice.call(arguments,1);
		framework.run.apply(framework,args);
		//var data = framework.run.apply(framework,args);
		//this.dispatch(data);
	}
	TestRunner.prototype.end = function( data ) {
		this.dispatch(data);
	}
	TestRunner.prototype.dispatch = function( data ) {
		for (var i=0;i<this.outputs.length;i++) {
			this.outputs[i].handle(data);
		}
	}
	TestRunner.prototype.newTestResult = function() {
		return new TestResult(this.name);
	}
	JTR.TestRunner = TestRunner;
	
	
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
		this.currentSuite = this.suites[name] = {
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
		this.currentTest = this.currentSuite.tests[name] = {
			name: name,
			status: JTR.status.UNKNOWN,
			time: 0,
			assertions: 0,
			messages: false,
			log: [],
			extra: extra || {},
			started: new Date()
		};
	};
	TestResult.prototype.stopTest = function(status,assertions,messages) {
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
	
	
	/**
	 * JUnit report toolkit
	 */
	var JUnitReport = {};
	JUnitReport.getXml = function( testResult ) {
		var Xml = window.WikiaXml;
		var xml = '';
		var suiteId = 1;
		var wrapperData = {
			name: testResult.name,
			'package': 'com.wikia.javascript.tests',
			errors: 0,
			failures: 0,
			skipped: 0,
			tests: 0,
			id: 0,
			time: 0
		};
		for (var suiteName in testResult.suites) {
			var suite = testResult.suites[suiteName];
			
			var suiteXml = '';
			for (var testName in suite.tests) {
				var test = suite.tests[testName];
				var testContent = '';
				if (test.status != JTR.status.SUCCESS) {
					testContent += Xml.element('failure',Xml.cdata(test.messages||''));
				}
				suiteXml += Xml.element('testcase',testContent,{
					name: testName,
					time: test.time / 1000
				});
			};
			
			suiteXml = Xml.element('properties') + suiteXml;
			var suiteData = {
					name: suiteName,
					'package': 'com.wikia.javascript.tests',
					errors: suite.stats[JTR.status.ERROR],
					failures: suite.stats[JTR.status.FAILURE],
					skipped: suite.stats[JTR.status.SKIPPED],
					tests: suite.stats.total,
					id: suiteId,
					time: suite.stats.time / 1000
			};
			var accumKeys = ['errors','failures','skipped','tests','time'];
			for (var i=0;i<accumKeys.length;i++) {
				wrapperData[accumKeys[i]] += suiteData[accumKeys[i]];
			}
			xml += Xml.element('testsuite',suiteXml,suiteData);
			suiteId++;
		}
		xml = Xml.element('testsuite',xml,wrapperData);
		//xml = Xml.intro() + Xml.element('testsuites',xml);
		xml = Xml.intro() + xml;
		return xml;
	};
	JTR.tools.JUnitReport = JUnitReport;
	
	
	/**
	 * Firebug/console output
	 */
	var consoleOutput = function() {}
	consoleOutput.prototype.handle = function( data ) {
		window.console && console.log && console.log('JTR: testSuite result = ',data);
	}
	JTR.outputs.console = consoleOutput;

	/**
	 * Firebug/console output
	 */
	var mwarticleOutput = function() {}
	mwarticleOutput.prototype.handle = function( data ) {
		var html = '';
		for (var suiteName in data.suites) {
			var suite = data.suites[suiteName];
			var ok = true;
			var testsHtml = '';
			for (var testName in suite.tests) {
				var test = suite.tests[testName];
				var testok = test.status == JTR.status.SUCCESS;
				var color = testok ? "green" : "red";
				var text = testok ? "[SUCCESS]" : "[FAILED]";
				ok = ok && testok;
				testsHtml += "<div style=\"margin-left: 20px\"><code style=\"color:"+color+"\">"+text+"</code> "+testName+"</div>";
				if (!testok)
					testsHtml += "<div style=\"margin-left: 40px\"> "+test.messages+"</div>";;
			}
			var color2 = ok ? "green" : "red";
			html += "<div style=\"color:"+color2+"\">"+suiteName+"</div>";
			html += testsHtml;
		}
		var e = document.getElementById('WikiaArticle');
		e.innerHTML = html;
	}
	JTR.outputs.mwarticle = mwarticleOutput;
	
	/**
	 * Selenium output
	 */
	var seleniumOutput = function() {}
	seleniumOutput.prototype.handle = function( data ) {
		var xml = JUnitReport.getXml(data);
		window.jtr_xml = xml;
		window.jtr_status = data.getStatus() ? "OK" : "FAIL";
		window.console && console.log && console.log(xml);
	};
	JTR.outputs.selenium = seleniumOutput;

	
	/**
	 * jsUnity framework adapter
	 */
	var jsUnityFramework = function( runner ) {
		this.testRunner = runner;
	}
	jsUnityFramework.prototype.run = function() {
		var args = Array.prototype.slice.call(arguments,0);
		var self = this;
		
		this.result = this.testRunner.newTestResult();
		
		var oldLogger = jsUnity.logger;
		jsUnity.logger = {log:function(){ self.log.apply(self,arguments);}};
		jsUnity.run.apply(jsUnity,args);
		jsUnity.logger = oldLogger;
		
		this.testRunner.end(this.result);
	}
	jsUnityFramework.prototype.log = function( action, name, error ) {
		switch(action) {
		case 'suite-error':
			this.result.errorSuite();
			break;
		case 'suite-start':
			this.result.startSuite(name);
			break;
		case 'suite-end':
			this.result.stopSuite(); 
			break;
		case 'test-start':
			this.result.startTest(name);
			break;
		case 'test-success':
			this.result.stopTest(JTR.status.SUCCESS);
			break;
		case 'test-failure':
			this.result.stopTest(JTR.status.FAILURE,0,error+'');
			break;
		}
	}
	JTR.frameworks.jsUnity = jsUnityFramework;
	
	
	/**
	 * QUnit framework adapter
	 */
	var QUnitFramework = function( runner ) {
		this.testRunner = runner;
	}
	QUnitFramework.prototype.run = function() {
		var args = Array.prototype.slice.call(arguments,0);
		var self = this;
		
		this.result = this.testRunner.newTestResult();
		
		/*
		var oldLogger = jsUnity.logger;
		jsUnity.logger = {log:function(){ self.log.apply(self,arguments);}};
		jsUnity.run.apply(jsUnity,args);
		jsUnity.logger = oldLogger;
		*/
		this.setupLogging();
		window.start();
		
		//this.testRunner.end(this.result);
	}
	QUnitFramework.prototype.setupLogging = function() {
		var self = this;
		var messages = [], assertions = 0;
		var result = this.result;
		QUnit.begin = function() {};
		QUnit.moduleStart = function(module) {
		    $().log('moduleStart','QUnit');
		    result.startSuite(module.name);
		}
		QUnit.moduleDone = function(module) {
		    $().log('moduleDone','QUnit');
		    result.stopSuite();
		}
		QUnit.testStart = function(test) {
		    $().log('testStart','QUnit');
		    result.startTest(test.name);
		    messages = [];
		    assertions = 0;
		}
		QUnit.log = function(assertion) {
		    $().log('log','QUnit');
		    assertions++;
		    if (!assertion.result) messages.push(assertion.message);
		}
		QUnit.testDone = function(test) {
		    $().log('testDone','QUnit');
		    var status = JTR.status[ test.failed == 0 ? 'SUCCESS' : 'FAILURE' ];
		    result.stopTest(status,assertions,messages.join('\n'));
		}
		QUnit.done = function(summary) {
		    self.testRunner.end(result);
		}
	}
	JTR.frameworks.QUnit = QUnitFramework;
	
	
	/**
	 * Mediawiki extension handler
	 */
	JTR.run = function() {
		var outputNames = window.jtr_outputs;
		var frameworkName = window.jtr_framework;
		var testSuite = window.jtr_testsuite;
		var testSuiteName = window.jtr_testname;
		
		if (!frameworkName) {
			throw new Exception("No framework name specified for test suite");
		}
		/*
		if (!testSuite) {
			throw new Exception("No tests specified as a test suite");
		}
		*/
		
		var outputs = [];
		for (var i in outputNames) {
			if (typeof JTR.outputs[outputNames[i]] != 'function') {
				throw new Exception("Filter \""+outputNames[i]+"\" does not exist");
			}
			outputs.push(new JTR.outputs[outputNames[i]]);
		}
		
		var jtr = new JTR.TestRunner();
		jtr.configure(outputs,testSuiteName);
		jtr.run(frameworkName,testSuite);
	}
	JTR.autorun = function() {
		if ( !window.document || window.document.readyState != "complete" ) {
			setTimeout(JTR.autorun,500);
			return;
		}
		JTR.run();
	}
	
	JTR.test = function(frameworkName,testSuite) {
		window.jtr_framework = frameworkName;
		window.jtr_testsuite = testSuite;
	}
	
	
	// Share UTI with the rest of world...
	window.WikiaJavascriptTestRunner = JTR;

})();