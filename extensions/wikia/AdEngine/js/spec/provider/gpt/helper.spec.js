/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.helper', function () {
	'use strict';

	function noop() {
	}

	var AdElement,
		callbacks = {},
		mocks = {
			context: {
				opts: {
					premiumOnly: false
				},
				targeting: {
					hasFeaturedVideo: false,
					skin: 'oasis'
				}
			},
			adContext: {
				addCallback: noop,
				getContext: function () {
					return mocks.context;
				}
			},
			adBlockDetection: {
				isBlocking: noop
			},
			adBlockRecovery: {
				isEnabled: noop
			},
			adDetect: {},
			adLogicPageParams: {
				getPageLevelParams: function () {
					return [];
				}
			},
			pageFair: {
				isEnabled: noop,
				addMarker: noop
			},
			slotTweaker: {
				show: noop,
				hide: noop,
				removeDefaultHeight: noop
			},
			slotElement: {
				appendChild: noop
			},
			slotTargetingData: {},
			sraHelper: {
				shouldFlush: function () {
					return true;
				}
			},
			uapContext: {
				getUapId: noop
			},
			passbackHandler: {
				get: function() {
					return 'unknown';
				}
			},
			slotTargetingHelper: {
				getAbTestId: noop,
				getOutstreamData: noop,
				getWikiaSlotId: noop
			},
			googleTag: {
				isInitialized: function () {
					return true;
				},
				init: noop,
				registerCallback: function (id, callback) {
					callbacks.push(callback);
				},
				push: function (callback) {
					callback();
				},
				addSlot: noop,
				flush: noop,
				setPageLevelParams: noop
			},
			googleSlots: {
				getSlotByName: function () {
					return {};
				}
			},
			gptTargeting: {
				getSlotLevelTargeting: function () {
					return {};
				}
			},
			doc: {
				getElementById: function () {
					return {
						getAttribute: function () {
							return '{uap: "none"}';
						}
					}
				}
			},
			geo: {
				isProperGeo: function() {
					return false;
				}
			},
			log: noop
		};

	mocks.log.levels = {};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.helper'](
			mocks.adContext,
			mocks.adLogicPageParams,
			mocks.uapContext,
			mocks.adDetect,
			AdElement,
			mocks.googleTag,
			mocks.googleSlots,
			mocks.gptTargeting,
			mocks.passbackHandler,
			mocks.slotTargetingHelper,
			mocks.adBlockDetection,
			mocks.adBlockRecovery,
			mocks.slotTweaker,
			mocks.doc,
			mocks.geo,
			{},
			mocks.log,
			undefined,
			mocks.sraHelper,
			undefined,
			mocks.pageFair
		);
	}

	function createSlot(slotName) {
		return {
			name: slotName,
			container: mocks.slotElement,
			success: noop,
			collapse: noop,
			pre: function (methodName, callback) {
				callbacks[methodName] = [];
				callbacks[methodName].push(callback);
			}
		};
	}

	beforeEach(function () {
		AdElement = function (slotName, slotPath, slotTargetingData) {
			mocks.slotTargetingData = slotTargetingData;
		};

		AdElement.prototype.getId = function () {
			return 'TOP_LEADERBOARD';
		};

		AdElement.prototype.getNode = function () {
			return {};
		};

		AdElement.prototype.updateDataParams = noop;

		callbacks = {};

		mocks.context = {
			opts: {},
			targeting: {
				skin: 'oasis'
			}
		};
	});

	it('Initialize googletag when module is not initialized yet', function () {
		spyOn(mocks.googleTag, 'isInitialized').and.returnValue(false);
		spyOn(mocks.googleTag, 'init');

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {});

		expect(mocks.googleTag.init).toHaveBeenCalled();
	});

	it('Prevent initializing googletag if module is already initialized', function () {
		spyOn(mocks.googleTag, 'init');

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {});

		expect(mocks.googleTag.init).not.toHaveBeenCalled();
	});

	it('Push and flush ATF slot when SRA is not enabled', function () {
		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {});

		expect(mocks.googleTag.push).toHaveBeenCalled();
		expect(mocks.googleTag.flush).toHaveBeenCalled();
	});

	it('Only push ATF slot when SRA is enabled', function () {
		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');
		spyOn(mocks.sraHelper, 'shouldFlush').and.returnValue(false);

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {sraEnabled: true});

		expect(mocks.googleTag.push).toHaveBeenCalled();
		expect(mocks.googleTag.flush).not.toHaveBeenCalled();
	});

	it('Always push and flush BTF slot even if SRA is enabled', function () {
		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {sraEnabled: true});

		expect(mocks.googleTag.push).toHaveBeenCalled();
		expect(mocks.googleTag.flush).toHaveBeenCalled();
	});

	it('Prevent push when given slot is flushOnly', function () {
		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('GPT_FLUSH'), '/foo/slot/path', {flushOnly: true}, {});

		expect(mocks.googleTag.push).not.toHaveBeenCalled();
		expect(mocks.googleTag.flush).toHaveBeenCalled();
	});

	it('Register slot callback on push', function () {
		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {});

		expect(callbacks.renderEnded.length).toEqual(1);
	});

	it('Prevent push/flush when slot is not recoverable and pageview is blocked and recovery is enabled', function () {
		mocks.adBlockDetection.isBlocking = function () {
			return true;
		};
		mocks.adBlockRecovery.isEnabled = function () {
			return true;
		};

		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {
			sraEnabled: true,
			isSourcePointRecoverable: false
		});

		expect(mocks.googleTag.push).not.toHaveBeenCalled();
		expect(mocks.googleTag.flush).not.toHaveBeenCalled();
	});

	it('Should push/flush when slot is recoverable, is blocking and recovery is enabled', function () {
		mocks.adBlockDetection.isBlocking = function () {
			return true;
		};

		mocks.adBlockRecovery.isEnabled = function () {
			return true;
		};

		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {
			sraEnabled: true,
			isSourcePointRecoverable: true
		});

		expect(mocks.googleTag.push).toHaveBeenCalled();
		expect(mocks.googleTag.flush).toHaveBeenCalled();
	});

	it('Do not change src to rec if ad is not recoverable', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {
				isSourcePointRecoverable: false
			});
		};

		spyOn(mocks, 'slotTargetingData');
		spyOn(mocks.adBlockDetection, 'isBlocking');
		spyOn(mocks.adBlockRecovery, 'isEnabled');

		mocks.adBlockDetection.isBlocking.and.returnValue(true);
		mocks.adBlockRecovery.isEnabled.and.returnValue(true);

		pushAd();
		expect(mocks.slotTargetingData.src).not.toBeDefined();
	});

	it('Change src to rec if ad is recoverable', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {
				isSourcePointRecoverable: true
			});
		};

		spyOn(mocks, 'slotTargetingData');
		spyOn(mocks.adBlockDetection, 'isBlocking');
		spyOn(mocks.adBlockRecovery, 'isEnabled');

		mocks.adBlockDetection.isBlocking.and.returnValue(true);
		mocks.adBlockRecovery.isEnabled.and.returnValue(true);

		pushAd();
		expect(mocks.slotTargetingData.src).toBe('rec');
	});

	it('Should not set src=rec if SourcePoint is on, isSourcePointRecoverable but adblock is off', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {
				isSourcePointRecoverable: true
			});
		};

		spyOn(mocks, 'slotTargetingData');
		spyOn(mocks.adBlockDetection, 'isBlocking');
		spyOn(mocks.adBlockRecovery, 'isEnabled');

		mocks.adBlockDetection.isBlocking.and.returnValue(false);
		mocks.adBlockRecovery.isEnabled.and.returnValue(true);

		pushAd();
		expect(mocks.slotTargetingData.src).not.toBe('rec');
	});

	it('Should set src=rec if PageFair is on, adblock is on and isPageFairRecoverable', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {
				isPageFairRecoverable: true
			});
		};

		spyOn(mocks.pageFair, 'isEnabled');

		mocks.pageFair.isEnabled.and.returnValue(true);

		pushAd();
		expect(mocks.slotTargetingData.src).toBe('rec');
	});

	it('Should not set src=rec if PageFair is on, isPageFairRecoverable but adblock is off', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {
				isPageFairRecoverable: true
			});
		};

		spyOn(mocks.pageFair, 'isEnabled');
		spyOn(mocks.adBlockDetection, 'isBlocking');

		mocks.adBlockDetection.isBlocking.and.returnValue(false);
		mocks.pageFair.isEnabled.and.returnValue(true);

		pushAd();
		expect(mocks.slotTargetingData.src).not.toBe('rec');
	});

	it('Set src=premium if article is premium only', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {});
		};

		mocks.context.opts.premiumOnly = true;

		pushAd();
		expect(mocks.slotTargetingData.src).toBe('premium');
	});

	it('Don\'t set src-premium if article isn\'t premium', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {});
		};

		mocks.context.opts.premiumOnly = false;

		pushAd();
		expect(mocks.slotTargetingData.src).not.toBe('premium');
	});

	it('Don\'t change src to rec if on the page is premium video - we don\'t want to recover ads in that case', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {
				isSourcePointRecoverable: true
			});
		};

		spyOn(mocks, 'slotTargetingData');
		spyOn(mocks.adBlockDetection, 'isBlocking');
		spyOn(mocks.adBlockRecovery, 'isEnabled');

		mocks.context.opts.premiumOnly = true;
		mocks.adBlockDetection.isBlocking.and.returnValue(true);
		mocks.adBlockRecovery.isEnabled.and.returnValue(true);

		pushAd();
		expect(mocks.slotTargetingData.src).toBe('premium');
	});
});
