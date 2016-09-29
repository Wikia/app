/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.helper', function () {
	'use strict';

	function noop() {
	}

	var AdElement,
		callbacks = [],
		mocks = {
			log: noop,
			context: {
				opts: {},
				targeting: {
					skin: 'oasis'
				}
			},
			adContext: {
				addCallback: noop,
				getContext: function () {
					return mocks.context;
				}
			},
			adDetect: {},
			adLogicPageParams: {
				getPageLevelParams: function () {
					return [];
				}
			},
			recoveryHelper: {
				recoverSlots: noop,
				isBlocking: noop,
				isRecoverable: noop,
				isRecoveryEnabled: noop
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
			slotTargetingHelper: {
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
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.helper'](
			mocks.log,
			mocks.adContext,
			mocks.adLogicPageParams,
			mocks.uapContext,
			mocks.adDetect,
			AdElement,
			mocks.googleTag,
			mocks.slotTargetingHelper,
			mocks.recoveryHelper,
			mocks.slotTweaker,
			mocks.sraHelper
		);
	}

	function createSlot(slotName) {
		return {
			name: slotName,
			container: mocks.slotElement,
			success: noop,
			pre: noop
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

		callbacks = [];

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

		expect(callbacks.length).toEqual(1);
	});

	it('Prevent push/flush when slot is not recoverable and pageview is blocked and recovery is enabled', function () {
		mocks.recoveryHelper.isBlocking = function () {
			return true;
		};

		mocks.recoveryHelper.isRecoverable = function () {
			return false;
		};

		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {sraEnabled: true});

		expect(mocks.googleTag.push).not.toHaveBeenCalled();
		expect(mocks.googleTag.flush).not.toHaveBeenCalled();
	});

	it('Should push/flush when slot is recoverable', function () {
		mocks.recoveryHelper.isBlocking = function () {
			return true;
		};

		mocks.recoveryHelper.isRecoverable = function () {
			return true;
		};

		spyOn(mocks.googleTag, 'push');
		spyOn(mocks.googleTag, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {
			sraEnabled: true,
			recoverableSlots: ['TOP_RIGHT_BOXAD']
		});

		expect(mocks.googleTag.push).toHaveBeenCalled();
		expect(mocks.googleTag.flush).toHaveBeenCalled();
	});

	it('Change src to rec if ad is recoverable', function () {
		var pushAd = function () {
			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {});
		};
		spyOn(mocks, 'slotTargetingData');
		mocks.recoveryHelper.isBlocking = function () {
			return true;
		};

		mocks.recoveryHelper.isRecoverable = function () {
			return false;
		};
		pushAd();
		expect(mocks.slotTargetingData.src).not.toBeDefined();

		mocks.recoveryHelper.isRecoverable = function () {
			return true;
		};
		pushAd();
		expect(mocks.slotTargetingData.src).toBe('rec');
	});
});
