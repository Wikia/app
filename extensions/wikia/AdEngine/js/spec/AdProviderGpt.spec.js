describe('AdProviderGpt', function(){
	var adTrackerMock = {trackSlot: function() { return {init: function () {}, success: function () {}, hop: function () {}}}};

	it('Leaderboard works as expected in low value countries', function() {
		var logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderGpt,
			wikiaGptMock = {
				init: function () {}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return false;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderGpt = AdProviderGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock
		);

		expect(adProviderGpt.canHandleSlot('TOP_LEADERBOARD')).toBeFalsy('DART not called when user in low value country');
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
			adProviderAdDriver2,
			wikiaGptMock = {
				init: function () {},
				pushAd: function () {
					dartCalled = true;
				}
			},
			successMock = function () {},
			hopMock = function (extra, hopTo) { liftiumCalled = (hopTo === 'Liftium'); };

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderAdDriver2 = AdProviderGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock
		);

		expect(adProviderAdDriver2.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country (and not exceeded number of DART calls');

		adProviderAdDriver2.fillInSlot('TOP_LEADERBOARD', successMock, hopMock);
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
			adProviderAdDriver2,
			wikiaGptMock = {
				init: function () {},
				pushAd: function (slotname, success, hop) {
					dartCalled = true;
					hop();
				}
			},
			successMock = function () {},
			hopMock = function (extra, hopTo) { liftiumCalled = (hopTo === 'Liftium'); };

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderAdDriver2 = AdProviderGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock
		);

		expect(adProviderAdDriver2.canHandleSlot('TOP_LEADERBOARD')).toBeTruthy('DART can handle the slot when user in high value country (and not exceeded number of DART calls');

		adProviderAdDriver2.fillInSlot('TOP_LEADERBOARD', successMock, hopMock);
		expect(liftiumCalled).toBeTruthy('Liftium called when user in high value country (and not exceeded number of DART calls) and GPT hops');
		expect(dartCalled).toBeTruthy('DART called when user in high value country (and not exceeded number of DART calls)');
	});

	it('Leaderboard works as expected in high value countries after exceeding no ads limit', function() {
		var liftiumCalled,
			dartCalled,
			logMock = function() {},
			windowMock = {},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheGetMock = function(key) {
				if (key === 'dart_calls_TOP_LEADERBOARD') {
					return 8;
				}
				if (key === 'dart_noad_TOP_LEADERBOARD') {
					return true;
				}
			},
			cacheStorageMock = {set: function() {}, get: cacheGetMock, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderAdDriver2,
			wikiaGptMock = {
				init: function () {}
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderAdDriver2 = AdProviderGpt(
			adTrackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock
		);

		expect(adProviderAdDriver2.canHandleSlot('TOP_LEADERBOARD')).toBeFalsy('DART can\'t handle the slot when user in high value country and exceeded number of DART calls');
	});
});
