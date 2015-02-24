/*global describe,it,expect,modules,spyOn*/
/*jshint maxlen:false, unused:false*/
/*jslint unparam:true*/
describe('AdProviderDirectGpt', function () {
	'use strict';

	var noop = function () { return; },
		mocks = {
			adContext: {
				getContext: function () {
					return {forceProviders: {}, opts: {}};
				}
			},
			adLogicHighValueCountry: {
				isHighValueCountry: noop,
				getMaxCallsToDART: noop
			},
			cacheStorage: {
				set: noop,
				get: noop,
				del: noop
			},
			factory: {
				getFillInSlot: function () {
					return mocks.factoryFillInSlot;
				}
			},
			factoryFillInSlot: noop,
			geo: {getCountryCode: function () { return; }},
			gptHelper: {},
			hop: noop,
			log: noop,
			slotTweaker: {
				removeDefaultHeight: noop,
				removeTopButtonIfNeeded: noop,
				adjustLeaderboardSize: noop
			},
			success: noop,
			window: {}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.directGpt'](
			mocks.cacheStorage,
			mocks.geo,
			mocks.log,
			mocks.window,
			mocks.adContext,
			mocks.adLogicHighValueCountry,
			mocks.gptHelper,
			mocks.factory,
			mocks.slotTweaker
		);
	}

	function checkFillInSlotSuccess(module, slotName) {
		spyOn(mocks, 'hop');
		spyOn(mocks, 'success');

		module.fillInSlot(slotName, mocks.success, mocks.hop);

		expect(mocks.factoryFillInSlot).toHaveBeenCalled();
		expect(mocks.success).toHaveBeenCalled();
		expect(mocks.hop).not.toHaveBeenCalled();
	}

	function checkFillInSlotHops(module, slotName) {
		spyOn(mocks, 'hop');
		spyOn(mocks, 'success');

		module.fillInSlot(slotName, mocks.success, mocks.hop);

		expect(mocks.factoryFillInSlot).toHaveBeenCalled();
		expect(mocks.success).not.toHaveBeenCalled();
		expect(mocks.hop).toHaveBeenCalled();
	}

	it('Leaderboard cannot handle slot in low value countries', function () {
		spyOn(mocks.adLogicHighValueCountry, 'isHighValueCountry').and.returnValue(false);
		spyOn(mocks.adLogicHighValueCountry, 'getMaxCallsToDART').and.returnValue(7);
		spyOn(mocks, 'factoryFillInSlot')

		expect(getModule().canHandleSlot('TOP_LEADERBOARD')).toBeFalsy('DART not called when user in low value country');
		expect(mocks.factoryFillInSlot).not.toHaveBeenCalled();
	});

	it('Leaderboard succeeds in high value countries in first call if factory fillInSlot succeeds', function () {
		spyOn(mocks.adLogicHighValueCountry, 'isHighValueCountry').and.returnValue(true);
		spyOn(mocks.adLogicHighValueCountry, 'getMaxCallsToDART').and.returnValue(7);
		spyOn(mocks, 'factoryFillInSlot').and.callFake(function (slotName, success, hop) {
			success();
		});

		var adProviderDirectGpt = getModule();
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country (and not exceeded number of DART calls');
		checkFillInSlotSuccess(adProviderDirectGpt, 'TOP_LEADERBOARD');
	});

	it('Leaderboard hops in high value countries in first call if factory fillInSlot hops', function () {
		spyOn(mocks.adLogicHighValueCountry, 'isHighValueCountry').and.returnValue(true);
		spyOn(mocks.adLogicHighValueCountry, 'getMaxCallsToDART').and.returnValue(7);
		spyOn(mocks, 'factoryFillInSlot').and.callFake(function (slotName, success, hop) {
			hop();
		});

		var adProviderDirectGpt = getModule();
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country (and not exceeded number of DART calls');
		checkFillInSlotHops(adProviderDirectGpt, 'TOP_LEADERBOARD');
	});

	it('Leaderboard cannot handle slot in high value countries after exceeding no ads limit', function () {
		var callsToTopLeaderboard, adProviderDirectGpt;

		function cacheGetMock(key) {
			if (key === 'dart_calls_TOP_LEADERBOARD') {
				return callsToTopLeaderboard;
			}
			if (key === 'dart_noad_TOP_LEADERBOARD') {
				return true;
			}
		}

		spyOn(mocks.adLogicHighValueCountry, 'isHighValueCountry').and.returnValue(true);
		spyOn(mocks.adLogicHighValueCountry, 'getMaxCallsToDART').and.returnValue(7);
		spyOn(mocks.cacheStorage, 'get').and.callFake(cacheGetMock);

		adProviderDirectGpt = getModule();

		callsToTopLeaderboard = 6;
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country and number of DART calls is not exceeded');

		callsToTopLeaderboard = 8;
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeFalsy('DART can\'t handle the slot when user in high value country and exceeded number of DART calls');
	});

	it('Leaderboard can handle slot in high value countries after exceeding no ads limit with context.opts.alwaysCallDart set', function () {
		var callsToTopLeaderboard, adProviderDirectGpt;

		function cacheGetMock(key) {
			if (key === 'dart_calls_TOP_LEADERBOARD') {
				return callsToTopLeaderboard;
			}
			if (key === 'dart_noad_TOP_LEADERBOARD') {
				return true;
			}
		}

		spyOn(mocks.adLogicHighValueCountry, 'isHighValueCountry').and.returnValue(true);
		spyOn(mocks.adLogicHighValueCountry, 'getMaxCallsToDART').and.returnValue(7);
		spyOn(mocks.cacheStorage, 'get').and.callFake(cacheGetMock);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			opts: {
				alwaysCallDart: true
			},
			forceProviders: {}
		});

		adProviderDirectGpt = getModule();
		callsToTopLeaderboard = 6;
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country and number of DART calls is not exceeded');

		callsToTopLeaderboard = 8;
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country and exceeded number of DART calls if wgAdDriverAlwaysCallDartInCountries set');
	});

	it('Skin re-uses the leaderboard show/hop decision', function () {
		var adProviderDirectGpt;

		function cacheGetMock(key) {
			if (key === 'dart_calls_TOP_LEADERBOARD') {
				return 6;
			}
			if (key === 'dart_noad_TOP_LEADERBOARD') {
				return true;
			}
			if (key === 'dart_calls_INVISIBLE_SKIN') {
				return 8;
			}
			if (key === 'dart_noad_INVISIBLE_SKIN') {
				return true;
			}
		}

		spyOn(mocks.adLogicHighValueCountry, 'isHighValueCountry').and.returnValue(true);
		spyOn(mocks.adLogicHighValueCountry, 'getMaxCallsToDART').and.returnValue(7);
		spyOn(mocks.cacheStorage, 'get').and.callFake(cacheGetMock);

		adProviderDirectGpt = getModule();

		expect(adProviderDirectGpt.canHandleSlot('INVISIBLE_SKIN')).toBeFalsy('DART does not call for skin after no ad limit is exceeded if leaderboard was not called');
		adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD');
		expect(adProviderDirectGpt.canHandleSlot('INVISIBLE_SKIN')).toBeTruthy('DART calls for skin even with no ad limit is exceeded if leaderboard was called');
	});
});
