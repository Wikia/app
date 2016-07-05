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
		mercuryAdsModule: {
			pushSlotToQueue: noop
		},
		win: {
			innerHeight: 1000,
			adslots2: {
				push: noop
			},
			addEventListener: function (event, callback) {
				if (event === 'scroll') {
					callback();
				}
			},
			Mercury: {
				Modules: {
					Ads: {
						getInstance: function () {
							return mocks.mercuryAdsModule;
						}
					}
				}
			}
		},
		doc: {
			getElementById: function () {
				return {};
			}
		},
		domCalculator: {
			getTopOffset: function () {
				return 3000;
			}
		}
	};

	beforeEach(function () {
		mocks.win.scrollY = 0;
		setContext(mocks, {});
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.scrollHandler'](
			mocks.context,
			mocks.adHelper,
			mocks.domCalculator,
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

	it('Prefooter should not be refreshed when trigger is not scroll', function () {
		shouldNotBeRefreshed({trigger: 'delay.5s'});
	});

	it('Prefooter should be refreshed when reloadedViewMax is 1', function () {
		shouldBeRefreshed({reloadedViewMax: 1});
	});

	it('Prefooter should be refreshed when reloadedViewMax is -1', function () {
		shouldBeRefreshed({reloadedViewMax: -1});
	});

	it('Prefooter should be refreshed by mercury module on mercury skin', function () {
		shouldBeRefreshed({reloadedViewMax: -1, skin: 'mercury'});
	});

	it('RV count equals null when scrollHandler is disabled', function () {
		setContext(mocks, {enableScrollHandler: false});

		var scrollHandler = getModule();
		scrollHandler.init('oasis');

		expect(scrollHandler.getReloadedViewCount('PREFOOTER_LEFT_BOXAD')).toBe(null);
	});

	it('RV count of unsupported slot equals null', function () {
		setContext(mocks, {enableScrollHandler: true});

		var scrollHandler = getModule();
		scrollHandler.init('oasis');

		expect(scrollHandler.getReloadedViewCount('TOP_LEADERBOARD')).toBe(null);
	});

	function shouldBeRefreshed(params) {
		var scrollHandler,
			pushMethod,
			skin = params.skin || 'oasis';
		spyOn(mocks.win.adslots2, 'push');
		spyOn(mocks.mercuryAdsModule, 'pushSlotToQueue');
		mocks.win.scrollY = params.scrollY || 2000;
		params.enableScrollHandler = true;
		setContext(mocks, params);

		pushMethod = params.skin === 'mercury' ? mocks.mercuryAdsModule.pushSlotToQueue : mocks.win.adslots2.push;
		scrollHandler = getModule();
		scrollHandler.init(skin);

		expect(pushMethod).toHaveBeenCalled();
		expect(scrollHandler.getReloadedViewCount('PREFOOTER_LEFT_BOXAD')).toEqual(1);
	}

	function shouldNotBeRefreshed(params) {
		var scrollHandler,
			skin = params.skin || 'oasis';
		spyOn(mocks.win.adslots2, 'push');
		mocks.win.scrollY = params.scrollY || 2000;
		params.enableScrollHandler = true;
		setContext(mocks, params);

		scrollHandler = getModule();
		scrollHandler.init(skin);

		expect(mocks.win.adslots2.push).not.toHaveBeenCalled();
		expect(scrollHandler.getReloadedViewCount('PREFOOTER_LEFT_BOXAD')).toEqual(0);
	}

	function setContext(mocks, params) {
		mocks.context = {
			getContext: function () {
				return {
					opts: {
						enableScrollHandler: params.enableScrollHandler,
						scrollHandlerConfig: {
							oasis: {
								PREFOOTER_LEFT_BOXAD: {
									reloadedViewMax: params.reloadedViewMax,
										trigger: params.trigger || 'scroll.top'
								}
							},
							mercury: {
								PREFOOTER_LEFT_BOXAD: {
									reloadedViewMax: params.reloadedViewMax,
										trigger: params.trigger || 'scroll.top'
								}
							}
						}
					}
				};
			},
			addCallback: noop
		};
	}

});
