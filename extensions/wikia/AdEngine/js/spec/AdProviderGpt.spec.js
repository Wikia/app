describe('AdProviderDirectGpt', function(){
	var adTrackerMock = {trackSlot: function() { return {init: function () {}, success: function () {}, hop: function () {}}}};

	it('Leaderboard works as expected in low value countries', function() {
		var logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderDirectGpt,
			wikiaGptMock = {
				init: function () {}
			},
			GptSlotConfigMock = {
				getConfig: function () {
					return {
						'TOP_LEADERBOARD': {}
					};
				}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return false;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderDirectGpt = AdProviderDirectGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock,
			GptSlotConfigMock
		);

		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeFalsy('DART not called when user in low value country');
	});


	it('Leaderboard works as expected in high value countries in first call', function() {
		var liftiumCalled,
			dartCalled,
			logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderDirectGpt,
			wikiaGptMock = {
				init: function () {},
				pushAd: function () {
					dartCalled = true;
				}
			},
			successMock = function () {},
			hopMock = function (extra, hopTo) { liftiumCalled = (hopTo === 'Liftium'); },
			GptSlotConfigMock = {
				getConfig: function () {
					return {
						'TOP_LEADERBOARD': {}
					};
				}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderDirectGpt = AdProviderDirectGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock,
			GptSlotConfigMock
		);

		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country (and not exceeded number of DART calls');

		adProviderDirectGpt.fillInSlot('TOP_LEADERBOARD', successMock, hopMock);
		expect(liftiumCalled).toBeFalsy('Liftium not called when user in high value country (and not exceeded number of DART calls)');
		expect(dartCalled).toBeTruthy('DART called when user in high value country (and not exceeded number of DART calls)');
	});

	it('Leaderboard works as expected in high value countries in first call with hop', function() {
		var liftiumCalled,
			dartCalled,
			logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderDirectGpt,
			wikiaGptMock = {
				init: function () {},
				pushAd: function (slotname, success, hop) {
					dartCalled = true;
					hop();
				}
			},
			successMock = function () {},
			hopMock = function (extra, hopTo) { liftiumCalled = (hopTo === 'Liftium'); },
			GptSlotConfigMock = {
				getConfig: function () {
					return {
						'TOP_LEADERBOARD': {}
					};
				}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderDirectGpt = AdProviderDirectGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock,
			GptSlotConfigMock
		);

		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country (and not exceeded number of DART calls');

		adProviderDirectGpt.fillInSlot('TOP_LEADERBOARD', successMock, hopMock);
		expect(liftiumCalled).toBeTruthy('Liftium called when user in high value country (and not exceeded number of DART calls) and GPT hops');
		expect(dartCalled).toBeTruthy('DART called when user in high value country (and not exceeded number of DART calls)');
	});

	it('Leaderboard works as expected in high value countries after exceeding no ads limit', function() {
		var logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			callsToTopLeaderboard,
			cacheGetMock = function(key) {
				if (key === 'dart_calls_TOP_LEADERBOARD') {
					return callsToTopLeaderboard;
				}
				if (key === 'dart_noad_TOP_LEADERBOARD') {
					return true;
				}
			},
			cacheStorageMock = {set: function() {}, get: cacheGetMock, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderDirectGpt,
			wikiaGptMock = {
				init: function () {}
			},
			GptSlotConfigMock = {
				getConfig: function () {
					return {
						'TOP_LEADERBOARD': {}
					};
				}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderDirectGpt = AdProviderDirectGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock,
			GptSlotConfigMock
		);

		callsToTopLeaderboard = 6;
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country and number of DART calls is not exceeded');

		callsToTopLeaderboard = 8;
		expect(adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD')).toBeFalsy('DART can\'t handle the slot when user in high value country and exceeded number of DART calls');
	});

	it('Skin re-uses the leaderboard show/hop decision', function() {
		var logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			callsToTopLeaderboard,
			callsToInvisibleSkin,
			cacheGetMock = function(key) {
				if (key === 'dart_calls_TOP_LEADERBOARD') {
					return callsToTopLeaderboard;
				}
				if (key === 'dart_noad_TOP_LEADERBOARD') {
					return true;
				}
				if (key === 'dart_calls_INVISIBLE_SKIN') {
					return callsToInvisibleSkin;
				}
				if (key === 'dart_noad_INVISIBLE_SKIN') {
					return true;
				}
			},
			cacheStorageMock = {set: function() {}, get: cacheGetMock, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderDirectGpt,
			wikiaGptMock = {
				init: function () {}
			},
			GptSlotConfigMock = {
				getConfig: function () {
					return {
						'TOP_LEADERBOARD': {},
						'INVISIBLE_SKIN': {}
					};
				}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderDirectGpt = AdProviderDirectGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock,
			GptSlotConfigMock
		);

		callsToTopLeaderboard = 6;
		callsToInvisibleSkin = 8;

		expect(adProviderDirectGpt.canHandleSlot('INVISIBLE_SKIN')).toBeFalsy('DART don\' call for skin after no ad limit is exceeded if leaderboard was not called');
		adProviderDirectGpt.canHandleSlot('TOP_LEADERBOARD');
		expect(adProviderDirectGpt.canHandleSlot('INVISIBLE_SKIN')).toBeTruthy('DART calls for skin even with no ad limit is exceeded if leaderboard was called');
	});
});
