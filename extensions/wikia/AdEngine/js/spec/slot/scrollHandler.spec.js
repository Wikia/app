/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.slot.scrollHandler', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		adHelper: {
			throttle: function (func) {
				return func;
			}
		},
		log: noop,

		win: {
			innerHeight: 1000,
			adslots2: {
				push: noop
			},
			addEventListener: function (event, callback) {
				if (event === 'scroll') {
					callback();
				}
			}
		},
		doc: {
			getElementById: function () {
				return {
					offsetTop: 3000,
					offsetParent: null
				};
			}
		}
	};

	beforeEach(function () {
		mocks.win.scrollY = 0;
		setContext(mocks, {reloadedViewMax: -1});
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.scrollHandler'](
			mocks.context,
			mocks.adHelper,
			mocks.log,
			mocks.doc,
			mocks.win
		);
	}

	it('Prefooters should not be refreshed', function () {
		shouldNotBeRefreshed({scrollY: 1000});
	});

	it('Prefooter should not be refreshed when reloadedViewMax is 0', function () {
		shouldNotBeRefreshed({reloadedViewMax: 0});
	});

	it('Prefooter should be refreshed when reloadedViewMax is 1', function () {
		shouldBeRefreshed({reloadedViewMax: 1});
	});

	it('Prefooter should be refreshed when reloadedViewMax is -1', function () {
		shouldBeRefreshed({reloadedViewMax: -1});
	});

	it('RV count of unsupported slot equals null', function () {
		expect(getModule().getReloadedViewCount('TOP_LEADERBOARD')).toBe(null);
	});

	function shouldBeRefreshed(params) {
		spyOn(mocks.win.adslots2, 'push');
		mocks.win.scrollY = params.scrollY || 2000;
		setContext(mocks, params);

		var scrollHandler = getModule();
		scrollHandler.init();

		expect(mocks.win.adslots2.push).toHaveBeenCalled();
		expect(scrollHandler.getReloadedViewCount('PREFOOTER_LEFT_BOXAD')).toEqual(1);
	}

	function shouldNotBeRefreshed(params) {
		spyOn(mocks.win.adslots2, 'push');
		mocks.win.scrollY = params.scrollY || 2000;
		setContext(mocks, params);

		var scrollHandler = getModule();
		scrollHandler.init();

		expect(mocks.win.adslots2.push).not.toHaveBeenCalled();
		expect(scrollHandler.getReloadedViewCount('PREFOOTER_LEFT_BOXAD')).toEqual(0);
	}

	function setContext(mocks, params) {
		mocks.context = {
			getContext: function () {
				return {
					opts: {
						enableScrollHandler: true,
						scrollHandlerConfig: {PREFOOTER_LEFT_BOXAD: {reloadedViewMax: params.reloadedViewMax}}
					}
				};
			}
		};
	}

});
