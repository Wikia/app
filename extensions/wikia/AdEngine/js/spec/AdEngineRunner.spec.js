/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.adEngineRunner', function () {
	'use strict';
	function noop() {
	}

	function runCallback(callback) {
		callback();
	}

	var mocks = {
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
			instantGlobals: {},
			log: noop,
			win: {},
			amazonMatch: {
				getName: function () {
					return 'amazon';
				}
			},
			rubiconFastlane: {
				getName: function () {
					return 'rubicon_fastlane';
				}
			}
		};

	function getRunner(bidders) {
		bidders = bidders || {};
		return modules['ext.wikia.adEngine.adEngineRunner'](
			mocks.adEngine,
			mocks.adTracker,
			mocks.instantGlobals,
			mocks.log,
			mocks.win,
			bidders.amazonMatch,
			bidders.rubiconFastlane
		);
	}

	beforeEach(function () {
		mocks.rubiconFastlane.addResponseListener = noop;
		mocks.amazonMatch.addResponseListener = noop;
		mocks.rubiconFastlane.wasCalled = noop;
		mocks.amazonMatch.wasCalled = noop;
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
			amazonMatch: mocks.amazonMatch,
			rubiconFastlane: mocks.rubiconFastlane
		});
		spyOn(mocks.adEngine, 'run');

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine when all bidders responded and delay is enabled', function () {
		var runner = getRunner({
			amazonMatch: mocks.amazonMatch,
			rubiconFastlane: mocks.rubiconFastlane
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.amazonMatch, 'wasCalled').and.returnValue(true);
		spyOn(mocks.rubiconFastlane, 'wasCalled').and.returnValue(true);
		spyOn(mocks.amazonMatch, 'addResponseListener').and.callFake(runCallback);
		spyOn(mocks.rubiconFastlane, 'addResponseListener').and.callFake(runCallback);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine when enabled bidder responded and delay is enabled', function () {
		var runner = getRunner({
			amazonMatch: mocks.amazonMatch,
			rubiconFastlane: mocks.rubiconFastlane
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.amazonMatch, 'wasCalled').and.returnValue(false);
		spyOn(mocks.rubiconFastlane, 'wasCalled').and.returnValue(true);
		spyOn(mocks.rubiconFastlane, 'addResponseListener').and.callFake(runCallback);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine when enabled bidder responded and delay is enabled', function () {
		var runner = getRunner({
			amazonMatch: mocks.amazonMatch,
			rubiconFastlane: mocks.rubiconFastlane
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.amazonMatch, 'wasCalled').and.returnValue(true);
		spyOn(mocks.amazonMatch, 'addResponseListener').and.callFake(runCallback);
		spyOn(mocks.rubiconFastlane, 'wasCalled').and.returnValue(false);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	it('Run adEngine by setTimeout when bidders not responded and delay is enabled', function () {
		var runner = getRunner({
			rubiconFastlane: mocks.rubiconFastlane
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.rubiconFastlane, 'wasCalled').and.returnValue(true);
		spyOn(mocks.win, 'setTimeout').and.callFake(runCallback);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).toHaveBeenCalled();
	});

	// Shouldn't happen, but it's needed to verify all above positive test cases
	it('Negative test case: bidders called but not responded, setTimeout is broken and delay is enabled', function () {
		var runner = getRunner({
			amazonMatch: mocks.amazonMatch
		});
		spyOn(mocks.adEngine, 'run');
		spyOn(mocks.amazonMatch, 'wasCalled').and.returnValue(true);

		runner.run({}, [], 'queue.name', true);

		expect(mocks.adEngine.run).not.toHaveBeenCalled();
	});
});
