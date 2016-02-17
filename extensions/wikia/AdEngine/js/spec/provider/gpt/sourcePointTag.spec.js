/*global describe, it, expect, modules, spyOn, document, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.sourcePointTag', function () {
	'use strict';

	function noop() { return undefined; }

	var mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: {
							sourcePointRecoveryUrl: '//foo.url'
						}
					};
				}
			},
			adSlot: {
				getShortSlotName: noop
			},
			callback: noop,
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
		spyOn(mocks.sourcePoint, 'getClientId');

		api.init();

		expect(api.isInitialized()).toBe(true);
		expect(mocks.sourcePoint.getClientId).toHaveBeenCalled();
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
