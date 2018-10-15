/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.adEngineRunner', function () {
	'use strict';
	function noop() {
	}

	function runCallback(callback) {
		callback();
	}

	var mocks = {
		adContext: {
			get: noop
		},
		adEngine: {
			run: noop
		},
		adTracker: {
			measureTime: function () {
				return {
					track: noop
				};
			}
		},
		fvLagger: {
			addResponseListener: noop,
			wasCalled: function () {
				return false;
			},
			getName: noop
		},
		log: noop,
		win: {},
		a9: {
			getName: function () {
				return 'a9';
			}
		}
	};

	mocks.log.levels = {};

	function getRunner(bidders, instantGlobals, fvLagger) {
		bidders = bidders || {};
		instantGlobals = instantGlobals || {};
		fvLagger = fvLagger || fvLagger;
		return modules['ext.wikia.adEngine.adEngineRunner'](
			mocks.adContext,
			mocks.adEngine,
			mocks.adTracker,
			instantGlobals,
			mocks.log,
			mocks.win,
			bidders.a9,
			null,
			null,
			null,
			fvLagger
		);
	}

	function mockContext(map) {
		spyOn(mocks.adContext, 'get').and.callFake(function (name) {
			return map[name];
		});
	}

	beforeEach(function () {
		mocks.a9.addResponseListener = noop;
		mocks.a9.wasCalled = noop;
		mocks.win.setTimeout = noop;
	});

	it('Run adEngine immediately when delay is disabled', function () {
		var runner = getRunner();
		spyOn(mocks.adEngine, 'run');

		runner.run({}, [], 'queue.name', false);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine immediately when all bidders are not defined', function () {
		var runner = getRunner();
		spyOn(mocks.adEngine, 'run');

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine immediately when all bidders are disabled', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine when all bidders responded and delay is enabled', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.a9, 'addResponseListener').and.callFake(runCallback);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine when enabled bidder responded and delay is enabled', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(false);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine when enabled bidder responded and delay is enabled', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.a9, 'addResponseListener').and.callFake(runCallback);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine by setTimeout when bidders not responded and delay is enabled', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.win, 'setTimeout').and.callFake(runCallback);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	// Shouldn't happen, but it's needed to verify all above positive test cases
	it('Negative test case: bidders called but not responded, setTimeout is broken and delay is enabled', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).not.toHaveBeenCalled();
	});

	it('sets timeout to default if nothing else is defined', function () {
		var runner = getRunner({
			a9: mocks.a9
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.win, 'setTimeout');

		runner.run({}, [], 'queue.name', true);
		expect(mocks.win.setTimeout.calls.first().args[1]).toEqual(2000);
	});

	it('sets overwritten timeout value by instant global', function () {
		mockContext({
			'opts.overwriteDelayEngine': true
		});
		var runner = getRunner({
			a9: mocks.a9
		}, {
			wgAdDriverDelayTimeout: 666
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.win, 'setTimeout');

		runner.run({}, [], 'queue.name', true);
		expect(mocks.win.setTimeout.calls.first().args[1]).toEqual(666);
	});

	it('overwrites overwritten timeout value by instant global for featured video on mercury (mobile-wiki)', function () {
		mockContext({
			'targeting.skin': 'mercury',
			'targeting.hasFeaturedVideo': true
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.fvLagger, 'wasCalled').and.returnValue(true);
		spyOn(mocks.win, 'setTimeout');

		var runner = getRunner({
			a9: mocks.a9
		}, {
			wgAdDriverFVDelayTimeoutOasis: 666,
			wgAdDriverFVDelayTimeoutMobileWiki: 11111
		}, mocks.fvLagger);

		runner.run({}, [], 'queue.name', true);
		expect(mocks.win.setTimeout.calls.first().args[1]).toEqual(11111);
	});

	it('overwrites overwritten timeout value by instant global for featured video on oasis', function () {
		mockContext({
			'targeting.skin': 'oasis',
			'targeting.hasFeaturedVideo': true
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.fvLagger, 'wasCalled').and.returnValue(true);
		spyOn(mocks.win, 'setTimeout');

		var runner = getRunner({
			a9: mocks.a9
		}, {
			wgAdDriverFVDelayTimeoutOasis: 666,
			wgAdDriverFVDelayTimeoutMobileWiki: 11111
		}, mocks.fvLagger);

		runner.run({}, [], 'queue.name', true);
		expect(mocks.win.setTimeout.calls.first().args[1]).toEqual(666);
	});
});
