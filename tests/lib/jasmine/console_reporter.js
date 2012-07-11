(function() {
	if(!jasmine) {
		throw new Exception("jasmine library does not exist in global namespace!");
	}

	var ConsoleReporter = function() {
		this.console = jasmine.getGlobal().console;
	};

	ConsoleReporter.prototype = {
		//runner
		reportRunnerResults : function(runner) {
			this.log(JSON.stringify({
				command: 'PHANTOM_EXIT'
			}));
		},

		//suite
		reportSuiteStarting: function(suite){
			this.log(JSON.stringify({
				command: 'startSuite',
				name: suite.description
			}));
		},

		reportSuiteResults : function(suite) {
			this.log(JSON.stringify({
				command: 'stopSuite',
				name: suite.description
			}));
		},

		//test
		reportSpecStarting : function(spec) {
			this.log(JSON.stringify({
				command: 'startTest',
				name: spec.description
			}));
		},

		reportSpecResults : function(spec) {
			var result = spec.results(),
				items = result.getItems(),
				l = items.length,
				msg = [],
				i = 0;

			for(; i < l; i++ ){
				msg.push(items[i].message);
			}

			this.log(JSON.stringify({
				command: 'stopTest',
				name: spec.description,
				status: result.passed() ? 'SUCCESS' : 'FAILURE',
				assertions: result.totalCount,
				messages: msg.join('\n')
			}));

		},

		//log

		log : function(str) {
			this.console.log(str);
		}
	};

	// export public
	jasmine.ConsoleReporter = ConsoleReporter;
})(); 