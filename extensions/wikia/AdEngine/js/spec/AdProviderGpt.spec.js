describe('AdProviderGpt', function(){
	it('Leaderboard works as expected in low value countries', function() {
		var dartCalled,
			liftiumCalled,
			trackerMock = {track: function() {}},
			logMock = function() {},
			windowMock = {adslots2: {push: function() {
				liftiumCalled = true;
			}}},
			geoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adProviderGpt,
			wikiaGptMock = {
				init: function () {},
				pushAd: function () {
					dartCalled = true;
				}
			};

		dartCalled = false;
		liftiumCalled = false;
		adLogicHighValueCountryMock.isHighValueCountry = function() {return false;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 0;};

		adProviderGpt = AdProviderGpt(
			trackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock
		);

		adProviderGpt.fillInSlot(['TOP_LEADERBOARD']);
		expect(dartCalled).toBeFalsy('DART not called when user in low value country');
		expect(liftiumCalled).toBeTruthy('Liftium called when user in low value country');
	});


	it('Leaderboard works as expected in high value countries', function() {
		var dartCalled,
			liftiumCalled,
			trackerMock = {track: function() {}},
			logMock = function() {},
			windowMock = {adslots2: {push: function() {
				liftiumCalled = true;
			}}},
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
			};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderAdDriver2 = AdProviderGpt(
			trackerMock,
			logMock,
			windowMock,
			geoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			wikiaGptMock
		);

		dartCalled = false;
		liftiumCalled = false;
		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(liftiumCalled).toBeFalsy('Liftium not called when user in high value country (and not exceeded number of DART calls)');
		expect(dartCalled).toBeTruthy('DART called when user in high value country (and not exceeded number of DART calls)');
	});
});
