/*global describe, it, expect, modules, spyOn, document, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.googleTag', function () {
	'use strict';

	function noop() { return undefined; }

	var googleApi,
		mocks = {
			callback: noop,
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
				configureSlot: noop
			},
			elementSizes: null,
			log: noop,
			pubads: {
				collapseEmptyDivs: noop,
				enableSingleRequest: noop,
				disableInitialLoad: noop,
				addEventListener: noop,
				refresh: noop,
				setTargeting: noop
			},
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
					}
				}
			}
		};

	beforeEach(function () {
		var GoogleTag = modules['ext.wikia.adEngine.provider.gpt.googleTag'](
			document,
			mocks.log,
			mocks.window
		);
		googleApi = new GoogleTag();
		mocks.elementSizes = [[300, 250]];
	});

	it('Initialization should prepare googletag object and configure pubads', function () {
		spyOn(mocks.pubads, 'collapseEmptyDivs');
		spyOn(mocks.pubads, 'enableSingleRequest');
		spyOn(mocks.pubads, 'disableInitialLoad');
		spyOn(mocks.pubads, 'addEventListener');
		spyOn(mocks.window.googletag, 'enableServices');

		googleApi.init();

		expect(googleApi.isInitialized()).toBe(true);
		expect(mocks.pubads.collapseEmptyDivs).toHaveBeenCalled();
		expect(mocks.pubads.enableSingleRequest).toHaveBeenCalled();
		expect(mocks.pubads.disableInitialLoad).toHaveBeenCalled();
		expect(mocks.pubads.addEventListener).toHaveBeenCalled();
		expect(mocks.window.googletag.enableServices).toHaveBeenCalled();
	});

	it('Push should call googletag cmd method', function () {
		spyOn(mocks.window.googletag.cmd, 'push');
		googleApi.init();

		googleApi.push(noop);

		expect(mocks.window.googletag.cmd.push).toHaveBeenCalled();
	});

	it('Cannot flush without initialization', function () {
		spyOn(mocks.window.googletag.cmd, 'push');

		googleApi.flush();

		expect(mocks.window.googletag.cmd.push).not.toHaveBeenCalled();
	});

	it('Flush with empty slots queue should not refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleApi.init();

		googleApi.flush();

		expect(mocks.pubads.refresh).not.toHaveBeenCalled();
	});

	it('Flush with not empty slots queue should refresh pubads', function () {
		spyOn(mocks.pubads, 'refresh');
		googleApi.init();
		googleApi.addSlot(mocks.element);

		googleApi.flush();

		expect(mocks.pubads.refresh).toHaveBeenCalled();
	});

	it('Already added slot should be displayed once (called display method on googletag)', function () {
		spyOn(mocks.window.googletag, 'display');
		googleApi.init();

		googleApi.addSlot(mocks.element);
		googleApi.addSlot(mocks.element);

		expect(mocks.window.googletag.display.calls.count()).toEqual(1);
	});

	it('Define out of page slot when element sizes are not defined', function () {
		spyOn(mocks.window.googletag, 'defineSlot').and.callThrough();
		spyOn(mocks.window.googletag, 'defineOutOfPageSlot').and.callThrough();
		mocks.elementSizes = null;
		googleApi.init();

		googleApi.addSlot(mocks.element);

		expect(mocks.window.googletag.defineSlot).not.toHaveBeenCalled();
		expect(mocks.window.googletag.defineOutOfPageSlot).toHaveBeenCalled();
	});

	it('Define regular slot when element sizes are defined', function () {
		spyOn(mocks.window.googletag, 'defineSlot').and.callThrough();
		spyOn(mocks.window.googletag, 'defineOutOfPageSlot').and.callThrough();
		googleApi.init();

		googleApi.addSlot(mocks.element);

		expect(mocks.window.googletag.defineSlot).toHaveBeenCalled();
		expect(mocks.window.googletag.defineOutOfPageSlot).not.toHaveBeenCalled();
	});

	it('Set page targeting params using pubads', function () {
		spyOn(mocks.pubads, 'setTargeting');
		googleApi.init();

		googleApi.setPageLevelParams({
			foo: 7,
			bar: 6
		});

		expect(mocks.pubads.setTargeting.calls.count()).toEqual(2);
	});

	it('onAdCallback call given callback', function () {
		spyOn(mocks, 'callback');
		googleApi.onAdLoad('TOP_LEADERBOARD', mocks.element, {}, mocks.callback);

		expect(mocks.callback).toHaveBeenCalled();
	});
});
