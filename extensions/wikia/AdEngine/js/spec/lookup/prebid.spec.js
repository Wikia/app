/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid', function () {
	'use strict';

	var insertBefore = jasmine.createSpy('insertBefore'),
		slotParams = {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: mocks.opts,
						slots: noop,
						targeting: mocks.targeting
					};
				}
			},
			tracker: {
				measureDiff: function () {
					return mocks.tracker;
				},
				track: noop
			},
			adTracker: {
				measureTime: function () {
					return mocks.tracker;
				},
				track: noop
			},
			adSlot: {
				getShortSlotName: function (slotName) {
					return slotName;
				}
			},
			adLogicZoneParams: {
				getSite: function () {
					return 'life';
				},
				getName: function () {
					return '_dragonball';
				},
				getPageType: function () {
					return 'article';
				},
				getLanguage: function () {
					return 'en';
				}
			},
			doc: {
				node: {
					parentNode: {
						insertBefore: noop
					}
				},
				createElement: createNode,
				getElementsByTagName: function () {
					return [createNode()];
				}
			},
			lazyQueue: {
				makeQueue: function (queue, callback) {
					queue.push = function () {
						callback();
					};
					queue.start = noop;
				}
			},
			log: noop,
			recoveryHelper: {
				addOnBlockingCallback: noop
			},
			win: {
				pbjs: {
					que: [],
					requestBids: function () {
					}
				}
			},
			adapters: {
				appnexus: {
					isEnabled: function () {
						return true;
					},
					getAdUnits: function () {
						return [
							{
								TOP_LEADERBOARD: {
									sizes: [
										[728, 90],
										[970, 250]
									],
									placementId: '5823300'
								}
							},
							{
								TOP_RIGHT_BOXAD: {
									sizes: [
										[300, 250],
										[300, 600]
									],
									placementId: '5823309'
								}
							}
						];
					}
				}
			}
		},
		prebid;

	function noop() {
	}

	function createNode() {
		return {
			parentNode: {
				insertBefore: insertBefore
			}
		}
	}

	function getFactory() {
		return modules['ext.wikia.adEngine.lookup.lookupFactory'](
			mocks.adContext,
			mocks.adTracker,
			mocks.recoveryHelper,
			mocks.lazyQueue,
			mocks.log
		);
	}

	function getPrebid() {
		return modules['ext.wikia.adEngine.lookup.prebid'](
			mocks.adapters.appnexus,
			getFactory(),
			mocks.doc,
			mocks.win
		);
	}

	beforeEach(function () {
		mocks.targeting = {
			pageType: 'article'
		};
		mocks.targeting.skin = 'oasis';
		slotParams = {};
		prebid = getPrebid();
		spyOn(mocks.adTracker, 'track');
		spyOn(mocks.win.pbjs.que, 'push');
	});

	it('Prebid script is appended to DOM and ad slots are pushed', function () {
		var predidScriptExpectedNode = {
			parentNode: {insertBefore: insertBefore},
			async: true,
			type: 'text/javascript',
			src: '//acdn.adnxs.com/prebid/prebid.js'
		};

		prebid.call('oasis', function () {
		});
		expect(mocks.win.pbjs.que.push).toHaveBeenCalled();
		expect(insertBefore).toHaveBeenCalledWith(predidScriptExpectedNode, createNode());
	});
});
