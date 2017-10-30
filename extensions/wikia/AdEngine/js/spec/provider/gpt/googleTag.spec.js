/*global describe, it, expect, modules, spyOn, document, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.googleTag', function () {
	'use strict';

	function noop() {
		return undefined;
	}

	var googleTag,
		mocks = {
			callback: noop,
			adSlot: {
				getIframe: noop
			},
			element: {
				getId: noop,
				getNode: function () {
					return {
						querySelector: noop
					};
				},
				setSizes: noop,
				getSizes: function () {
					return mocks.elementSizes;
				},
				getSlotPath: noop,
				setPageLevelParams: noop,
				configureSlot: noop,
				getSlotName: noop
			},
			elementSizes: null,
			log: noop,
			pubads: {
				collapseEmptyDivs: noop,
				enableSingleRequest: noop,
				disableInitialLoad: noop,
				getTargeting: noop,
				addEventListener: noop,
				refresh: noop,
				setTargeting: noop,
				getSlots: noop
			},
			slotRegistry: {
				get: noop
			},
			srcProvider: {},
			window: {
				googletag: {
					cmd: {
						push: function (callback) {
							callback();
						}
					},
					pubads: function () {
						return mocks.pubads;
					},
					enableServices: noop,
					display: noop,
					defineSlot: function () {
						return {
							addService: noop
						};
					},
					defineOutOfPageSlot: function () {
						return {
							addService: noop
						};
					},
					destroySlots: noop
				}
			},
			allSlots: [
				{
					getTargeting: function () {
						return ['TOP_LEADERBOARD']
					}
				}, {
					getTargeting: function () {
						return ['TOP_RIGHT_BOXAD']
					}
				}, {
					getTargeting: function () {
						return ['INVISIBLE_HIGH_IMPACT']
					}
				}
			],
			googleSlots: {
				addSlot: noop,
				getSlot: noop,
				removeSlots: noop
			}
		};

	mocks.log.levels = {};

	beforeEach(function () {
		googleTag = modules['ext.wikia.adEngine.provider.gpt.googleTag'](
			mocks.googleSlots,
			mocks.adSlot,
			mocks.slotRegistry,
			mocks.srcProvider,
			document,
			mocks.log,
			mocks.window
		);

		mocks.elementSizes = [[300, 250]];
	});

	it('Initialization should prepare googletag object and configure pubads', function () {
		spyOn(mocks.pubads, 'collapseEmptyDivs');
		spyOn(mocks.pubads, 'enableSingleRequest');
		spyOn(mocks.pubads, 'disableInitialLoad');
		spyOn(mocks.pubads, 'addEventListener');
		spyOn(mocks.window.googletag, 'enableServices');

		googleTag.init();

		expect(googleTag.isInitialized()).toBe(true);
		expect(mocks.pubads.collapseEmptyDivs).toHaveBeenCalled();
		expect(mocks.pubads.enableSingleRequest).toHaveBeenCalled();
		expect(mocks.pubads.disableInitialLoad).toHaveBeenCalled();
		expect(mocks.pubads.addEventListener).toHaveBeenCalled();
		expect(mocks.window.googletag.enableServices).toHaveBeenCalled();
	});

	it('Push should call googletag cmd method', function () {
		spyOn(mocks.window.googletag.cmd, 'push');
		googleTag.init();

		googleTag.push(noop);

		expect(mocks.window.googletag.cmd.push).toHaveBeenCalled();
	});

	it('Cannot flush without initialization', function () {
		spyOn(mocks.window.googletag.cmd, 'push');

		googleTag.flush();

		expect(mocks.window.googletag.cmd.push).not.toHaveBeenCalled();
	});

	it('Flush with empty slots queue should not refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleTag.init();

		googleTag.flush();

		expect(mocks.pubads.refresh).not.toHaveBeenCalled();
	});

	it('Flush with not empty slots queue should refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleTag.init();
		googleTag.addSlot(mocks.element);

		googleTag.flush();

		expect(mocks.pubads.refresh).toHaveBeenCalled();
	});

	it('Display is not called on already added slots', function () {
		spyOn(mocks.window.googletag, 'display');
		spyOn(mocks.googleSlots, 'getSlot').and.returnValue(mocks.allSlots[0]);
		googleTag.init();

		googleTag.addSlot(mocks.element);
		expect(mocks.window.googletag.display.calls.count()).toEqual(0);
	});

	it('Display is called on not added slots', function () {
		spyOn(mocks.window.googletag, 'display');
		spyOn(mocks.googleSlots, 'getSlot').and.returnValue(undefined);
		googleTag.init();

		googleTag.addSlot(mocks.element);
		expect(mocks.window.googletag.display.calls.count()).toEqual(1);
	});

	it('Define out of page slot when element sizes are not defined', function () {
		spyOn(mocks.window.googletag, 'defineSlot').and.callThrough();
		spyOn(mocks.window.googletag, 'defineOutOfPageSlot').and.callThrough();
		mocks.elementSizes = null;
		googleTag.init();

		googleTag.addSlot(mocks.element);

		expect(mocks.window.googletag.defineSlot).not.toHaveBeenCalled();
		expect(mocks.window.googletag.defineOutOfPageSlot).toHaveBeenCalled();
	});

	it('Define regular slot when element sizes are defined', function () {
		spyOn(mocks.window.googletag, 'defineSlot').and.callThrough();
		spyOn(mocks.window.googletag, 'defineOutOfPageSlot').and.callThrough();
		googleTag.init();

		googleTag.addSlot(mocks.element);

		expect(mocks.window.googletag.defineSlot).toHaveBeenCalled();
		expect(mocks.window.googletag.defineOutOfPageSlot).not.toHaveBeenCalled();
	});

	it('Set page targeting params using pubads', function () {
		spyOn(mocks.pubads, 'setTargeting');
		googleTag.init();

		googleTag.setPageLevelParams({
			foo: 7,
			bar: 6
		});

		expect(mocks.pubads.setTargeting.calls.count()).toEqual(2);
	});

	it('onAdCallback call given callback', function () {
		spyOn(mocks, 'callback');
		googleTag.onAdLoad('TOP_LEADERBOARD', mocks.element, {}, mocks.callback);

		expect(mocks.callback).toHaveBeenCalled();
	});

	it('destroySlots destroys all slots when nothing passed', function () {
		spyOn(mocks.window.googletag, 'destroySlots');
		spyOn(mocks.pubads, 'getSlots').and.returnValue(mocks.allSlots);

		googleTag.init();
		googleTag.destroySlots();

		expect(mocks.window.googletag.destroySlots).toHaveBeenCalledWith(mocks.allSlots);
	});

	it('destroySlots destroys only passed slot', function () {
		spyOn(mocks.window.googletag, 'destroySlots');
		spyOn(mocks.pubads, 'getSlots').and.returnValue(mocks.allSlots);

		googleTag.init();
		googleTag.destroySlots(['TOP_LEADERBOARD']);

		expect(mocks.window.googletag.destroySlots).toHaveBeenCalledWith([mocks.allSlots[0]]);
	});

	it('destroySlots doesn\'t destroy slot if incorrect slot name is passed', function () {
		spyOn(mocks.window.googletag, 'destroySlots');
		spyOn(mocks.pubads, 'getSlots').and.returnValue(mocks.allSlots);

		googleTag.init();
		googleTag.destroySlots(['foo']);

		expect(mocks.window.googletag.destroySlots).not.toHaveBeenCalled();
	});
});
