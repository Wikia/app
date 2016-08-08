/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.provider.gpt.helper', function () {
	'use strict';

	function noop() {}

	var AdElement,
		callbacks = [],
		mocks = {
			log: noop,
			googleTag: function () {},
			context: { opts: {} },
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
			slotTargeting: {},
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
			}
		};
	mocks.googleTag.prototype.isInitialized = function () {
		return true;
	};
	mocks.googleTag.prototype.init = noop;
	mocks.googleTag.prototype.registerCallback = function (id, callback) {
		callbacks.push(callback);
	};
	mocks.googleTag.prototype.push = function (callback) {
		callback();
	};
	mocks.googleTag.prototype.addSlot = noop;
	mocks.googleTag.prototype.flush = noop;
	mocks.googleTag.prototype.setPageLevelParams = noop;

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.helper'](
			mocks.log,
			mocks.adContext,
			mocks.adLogicPageParams,
			mocks.adDetect,
			AdElement,
			mocks.googleTag,
			mocks.slotTargetingHelper,
			mocks.uapContext,
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
		AdElement = function (slotName, slotPath, slotTargeting) {
			mocks.slotTargeting = slotTargeting;
		};

		AdElement.prototype.getId = function () {
			return 'TOP_LEADERBOARD';
		};

		AdElement.prototype.getNode = function () {
			return {};
		};

		AdElement.prototype.updateDataParams = noop;

		callbacks = [];

		mocks.context = { opts: {} };
	});

	it('Initialize googletag when module is not initialized yet', function () {
		spyOn(mocks.googleTag.prototype, 'isInitialized').and.returnValue(false);
		spyOn(mocks.googleTag.prototype, 'init');

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {});

		expect(mocks.googleTag.prototype.init).toHaveBeenCalled();
	});

	it('Prevent initializing googletag if module is already initialized', function () {
		spyOn(mocks.googleTag.prototype, 'init');

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {});

		expect(mocks.googleTag.prototype.init).not.toHaveBeenCalled();
	});

	it('Push and flush ATF slot when SRA is not enabled', function () {
		spyOn(mocks.googleTag.prototype, 'push');
		spyOn(mocks.googleTag.prototype, 'flush');

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, {});

		expect(mocks.googleTag.prototype.push).toHaveBeenCalled();
		expect(mocks.googleTag.prototype.flush).toHaveBeenCalled();
	});

	it('Only push ATF slot when SRA is enabled', function () {
		spyOn(mocks.googleTag.prototype, 'push');
		spyOn(mocks.googleTag.prototype, 'flush');
		spyOn(mocks.sraHelper, 'shouldFlush').and.returnValue(false);

		getModule().pushAd(createSlot('TOP_LEADERBOARD'), '/foo/slot/path', {}, { sraEnabled: true });

		expect(mocks.googleTag.prototype.push).toHaveBeenCalled();
		expect(mocks.googleTag.prototype.flush).not.toHaveBeenCalled();
	});

	it('Always push and flush BTF slot even if SRA is enabled', function () {
		spyOn(mocks.googleTag.prototype, 'push');
		spyOn(mocks.googleTag.prototype, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, { sraEnabled: true });

		expect(mocks.googleTag.prototype.push).toHaveBeenCalled();
		expect(mocks.googleTag.prototype.flush).toHaveBeenCalled();
	});

	it('Prevent push when given slot is flushOnly', function () {
		spyOn(mocks.googleTag.prototype, 'push');
		spyOn(mocks.googleTag.prototype, 'flush');

		getModule().pushAd(createSlot('GPT_FLUSH'), '/foo/slot/path', { flushOnly: true }, {});

		expect(mocks.googleTag.prototype.push).not.toHaveBeenCalled();
		expect(mocks.googleTag.prototype.flush).toHaveBeenCalled();
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

		spyOn(mocks.googleTag.prototype, 'push');
		spyOn(mocks.googleTag.prototype, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, { sraEnabled: true });

		expect(mocks.googleTag.prototype.push).not.toHaveBeenCalled();
		expect(mocks.googleTag.prototype.flush).not.toHaveBeenCalled();
	});

	it('Should push/flush when slot is recoverable', function () {
		mocks.recoveryHelper.isBlocking = function () {
			return true;
		};

		mocks.recoveryHelper.isRecoverable = function () {
			return true;
		};

		spyOn(mocks.googleTag.prototype, 'push');
		spyOn(mocks.googleTag.prototype, 'flush');

		getModule().pushAd(createSlot('TOP_RIGHT_BOXAD'), '/foo/slot/path', {}, {
			sraEnabled: true,
			recoverableSlots: ['TOP_RIGHT_BOXAD']
		});

		expect(mocks.googleTag.prototype.push).toHaveBeenCalled();
		expect(mocks.googleTag.prototype.flush).toHaveBeenCalled();
	});

	it('Change src to rec if ad is recoverable', function () {
		var pushAd = function() {
 			getModule().pushAd(createSlot('MY_SLOT'), '/blah/blah', {}, {});
		};
		spyOn(mocks, 'slotTargeting');
		mocks.recoveryHelper.isBlocking = function () { return true; };

		mocks.recoveryHelper.isRecoverable = function () { return false; };
		pushAd();
		expect(mocks.slotTargeting.src).not.toBeDefined();

		mocks.recoveryHelper.isRecoverable = function () { return true; };
		pushAd();
		expect(mocks.slotTargeting.src).toBe('rec');
	});
});
