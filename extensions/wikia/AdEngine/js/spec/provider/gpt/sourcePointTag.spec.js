/*global describe, it, expect, modules, spyOn, document, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.googleTag', function () {
	'use strict';

	function noop() { return undefined; }

	var mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: {
							sourcePointUrl: '//foo.url'
						}
					};
				}
			},
			adSlot: {
				getShortSlotName: noop
			},
			callback: noop,
			cssTweaker: {
				copyStyles: noop
			},
			element: {
				getId: noop,
				getNode: function () {
					return {
						querySelector: noop
					};
				},
				setSizes: noop,
				getSizes: noop,
				getSlotPath: noop,
				setPageLevelParams: noop,
				configureSlot: noop
			},
			log: noop,
			pubads: {
				collapseEmptyDivs: noop,
				enableSingleRequest: noop,
				disableInitialLoad: noop,
				addEventListener: noop,
				refresh: noop,
				setTargeting: noop
			},
			slot: {
				addService: noop,
				getTargeting: noop,
				setCollapseEmptyDiv: noop
			},
			sourcePoint: {
				getClientId: function () {
					return 'fooClientId';
				}
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
						return mocks.slot;
					}
				}
			}
		},
		GoogleTag;

	function getApi() {
		var SourcePointTag = modules['ext.wikia.adEngine.provider.gpt.sourcePointTag'](
			mocks.adContext,
			GoogleTag,
			mocks.adSlot,
			mocks.sourcePoint,
			mocks.cssTweaker,
			document,
			mocks.log,
			mocks.window
		);

		return new SourcePointTag();
	}

	beforeEach(function () {
		GoogleTag = modules['ext.wikia.adEngine.provider.gpt.googleTag'](
			document,
			mocks.log,
			mocks.window
		);
	});

	it('Initialization should prepare googletag object and configure pubads', function () {
		var api = getApi();
		spyOn(mocks.pubads, 'addEventListener');
		spyOn(mocks.pubads, 'collapseEmptyDivs');
		spyOn(mocks.pubads, 'disableInitialLoad');
		spyOn(mocks.pubads, 'enableSingleRequest');
		spyOn(mocks.sourcePoint, 'getClientId');
		spyOn(mocks.window.googletag, 'enableServices');

		api.init();

		expect(api.isInitialized()).toBe(true);
		expect(mocks.pubads.addEventListener).toHaveBeenCalled();
		expect(mocks.pubads.collapseEmptyDivs).toHaveBeenCalled();
		expect(mocks.pubads.disableInitialLoad).toHaveBeenCalled();
		expect(mocks.pubads.enableSingleRequest).toHaveBeenCalled();
		expect(mocks.sourcePoint.getClientId).toHaveBeenCalled();
		expect(mocks.window.googletag.enableServices).toHaveBeenCalled();
	});

	it('Define collapsed slot by default if sp.block is set', function () {
		var api = getApi();
		spyOn(mocks.slot, 'getTargeting').and.callFake(function (key) {
			return key === 'sp.block' ? ['1'] : [];
		});
		spyOn(mocks.slot, 'setCollapseEmptyDiv');

		api.init();
		api.addSlot(mocks.element);

		expect(mocks.slot.setCollapseEmptyDiv).toHaveBeenCalled();
	});

	it('Define not collapsed slot if sp.block is not set', function () {
		var api = getApi();
		spyOn(mocks.slot, 'getTargeting').and.callFake(function () {
			return [];
		});
		spyOn(mocks.slot, 'setCollapseEmptyDiv');

		api.init();
		api.addSlot(mocks.element);

		expect(mocks.slot.setCollapseEmptyDiv).not.toHaveBeenCalled();
	});

	it('Call GoogleTag.onAdLoad if SP is not blocking (and by default)', function () {
		var api = getApi(),
			googleTagOnAdLoad = GoogleTag.prototype.onAdLoad;
		spyOn(GoogleTag.prototype, 'onAdLoad').and.callFake(googleTagOnAdLoad);

		api.init();
		api.onAdLoad('TOP_LEADERBOARD', mocks.element, {}, mocks.callback);

		expect(GoogleTag.prototype.onAdLoad).toHaveBeenCalled();
	});
});
