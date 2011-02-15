(function() {
	
	var JTR = {
		frameworks: {},
		filters: {},
		outputs: {},
		TestRunner: null
	};
	
	/**
	 * TestRunner - main testing class
	 */
	var TestRunner = function( filters, outputs ) {
		this.configure(filters,outputs);
	}
	TestRunner.prototype.configure = function( filters, outputs ) {
		this.filters = filters;
		this.outputs = outputs;
	}
	TestRunner.prototype.run = function( frameworkName, testSuites ) {
		var framework = new JTR.frameworks[frameworkName];
		var args = Array.prototype.slice.call(arguments,1);
		var data = framework.run.apply(framework,args);
		this.dispatch(data);
	}
	TestRunner.prototype.dispatch = function( data ) {
		for (var i=0;i<this.filters.length;i++) {
			data = this.filters[i].filter(data);
		}
		for (var i=0;i<this.outputs.length;i++) {
			this.outputs[i].handle(data);
		}
	}
	JTR.TestRunner = TestRunner;
	
	
	/**
	 * CruiseControl xml report generator
	 */
	var ccXmlFilter = function() {}
	ccXmlFilter.prototype.filter = function( data ) {
		// convert json data to xml...
		return xml;
	}
	JTR.filters.ccXml = ccXmlFilter;
	
	
	/**
	 * Firebug/console output
	 */
	var consoleOutput = function() {}
	consoleOutput.prototype.handle = function( data ) {
		console.log('JTR: testSuite result = ',data);
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
				var color = test.status == "success" ? "green" : "red";
				var text = test.status == "success" ? "[SUCCESS]" : "[FAILED]";
				ok = ok && test.status == "success";
				testsHtml += "<div style=\"margin-left: 20px\"><code style=\"color:"+color+"\">"+text+"</code> "+testName+"</div>";
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
		
	}
	JTR.outputs.selenium = seleniumOutput;
	
	
	/**
	 * jsUnity framwork adapter
	 */
	var jsUnityFramework = function() {}
	jsUnityFramework.prototype.run = function() {
		var args = Array.prototype.slice.call(arguments,0);
		var self = this;
		
		this.data = {
			suites: {},
			errors: 0
		};
		var oldLogger = jsUnity.logger;
		jsUnity.logger = {log:function(){ self.log.apply(self,arguments);}};
		jsUnity.run.apply(jsUnity,args);
		jsUnity.logger = oldLogger;
		
		return this.data;
	}
	jsUnityFramework.prototype.findName = function( o, name ) {
		if (!name) name = 'unnamed';
		if (typeof o[name] == 'undefined')
			return name;
		for (var i=1;i<5000;i++) {
			if (typeof o[name+'_'+i] == 'undefined') {
				return name+'_'+i;
			}
		}
		return 'unnamed';
	}
	jsUnityFramework.prototype.log = function( action, name, error ) {
		switch(action) {
		case 'suite-error':
			this.data.errors++;
			break;
		case 'suite-start':
			this.suiteName = this.findName(this.data.suites,name);
			this.suiteStarted = new Date();
			this.data.suites[this.suiteName] = {
				time: 0,
				tests: {}
			};
			break;
		case 'suite-end':
			var suite = this.data.suites[this.suiteName];
			suite.time = new Date() - this.suiteStarted; 
			break;
		case 'test-start':
			var suite = this.data.suites[this.suiteName];
			this.testName = this.findName(suite.tests,name);
			this.testStarted = new Date();
			suite.tests[this.testName] = {
				time: 0,
				status: 'unknown',
				info: ''
			};
			break;
		case 'test-success':
			var test = this.data.suites[this.suiteName].tests[this.testName];
			test.time = new Date() - this.testStarted;
			test.status = 'success';
			break;
		case 'test-failure':
			var test = this.data.suites[this.suiteName].tests[this.testName];
			test.time = new Date() - this.testStarted;
			test.status = 'failure';
			test.info = "" + error;
			break;
		}
	}
	JTR.frameworks.jsUnity = jsUnityFramework;
	
	
	/**
	 * Mediawiki extension handler
	 */
	JTR.run = function() {
		var filterNames = window.jtr_filters;
		var outputNames = window.jtr_outputs;
		var frameworkName = window.jtr_framework;
		var testSuite = window.jtr_testsuite;
		
		/*
		if (!outputNames || outputNames.length == 0) {
			throw new Exception("No output specified for test suite");
		}
		*/
		if (!frameworkName) {
			throw new Exception("No framework name specified for test suite");
		}
		if (!testSuite) {
			throw new Exception("No tests specified as a test suite");
		}
		
		var filters = [], outputs = [];
		for (var i in filterNames) {
			if (typeof JTR.filters[filterNames[i]] != 'function') {
				throw new Exception("Filter \""+filterNames[i]+"\" does not exist");
			}
			filters.push(new JTR.filters[filterNames[i]]);
		}
		for (var i in outputNames) {
			if (typeof JTR.outputs[outputNames[i]] != 'function') {
				throw new Exception("Filter \""+outputNames[i]+"\" does not exist");
			}
			outputs.push(new JTR.outputs[outputNames[i]]);
		}
		
		var jtr = new JTR.TestRunner();
		jtr.configure(filters,outputs);
		jtr.run(frameworkName,testSuite);
	}
	JTR.autorun = function() {
		if ( !window.document || window.document.readyState != "complete" ) {
			setTimeout(JTR.autorun,500);
			return;
		}
		JTR.run();
	}
	
	
	// Share UTI with the rest of world...
	window.WikiaJavascriptTestRunner = JTR;

})();