(function() {
	if(!jasmine) {
		throw new Exception("jasmine library does not exist in global namespace!");
	}

	var PhantomReporter = function() {
		this.console = jasmine.getGlobal().console;
	};

	PhantomReporter.prototype = {
		//runner
		reportRunnerResults: function(runner) {
			this.log({
				command: 'PHANTOM_EXIT'
			});
		},

		//suite
		reportSuiteStarting: function(suite){
			this.log({
				command: 'startSuite',
				name: suite.description
			});
		},

		reportSuiteResults: function(suite) {
			this.log({
				command: 'stopSuite'
			});
		},

		//test
		reportSpecStarting: function(spec) {
			this.log({
				command: 'startTest',
				name: spec.description
			});
		},

		reportSpecResults: function(spec) {
			var result = spec.results(),
				items = result.getItems(),
				l = items.length,
				msg = [],
				i = 0;

			//get messages
			for(; i < l; i++ ){
				msg.push(items[i].message);
			}

			this.log({
				command: 'stopTest',
				status: result.passed() ? 'SUCCESS' : 'FAILURE',
				assertions: result.totalCount,
				messages: msg.join('\n')
			});
		},

		//log
		log: function(data) {
			window.callPhantom(data);
		}
	};

	// export public
	jasmine.PhantomReporter = PhantomReporter;
})(); 