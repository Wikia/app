describe('AdProviderAdDriver2', function(){
	it('Leaderboard works as expected in low value countries', function() {
		var wikiaDartMock = {getUrl: function() {return 'http://example.org/'}},
			dartCalled,
			liftiumCalled,
			scriptWriterMock,
			trackerMock = {track: function() {}},
			logMock = function() {},
			windowMock = {adslots2: {push: function() {
				liftiumCalled = true;
			}}},
			GeoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adLogicDartSubdomainMock = {getSubdomain: function() {return 'sub';}},
			adProviderAdDriver2,
			wikiaGptMock = {pushAd: function () {
				dartCalled = true;
			}};

		dartCalled = false;
		liftiumCalled = false;
		adLogicHighValueCountryMock.isHighValueCountry = function() {return false;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 0;};

		adProviderAdDriver2 = AdProviderAdDriver2(
			wikiaDartMock,
			scriptWriterMock,
			trackerMock,
			logMock,
			windowMock,
			GeoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			adLogicDartSubdomainMock,
			wikiaGptMock
		);

		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(dartCalled).toBeFalsy('DART not called when user in low value country');
		expect(liftiumCalled).toBeTruthy('Liftium called when user in low value country');
	});


	it('Leaderboard works as expected in high value countries', function() {
		var wikiaDartMock = {getUrl: function() {return 'http://example.org/'}},
			dartCalled,
			liftiumCalled,
			scriptWriterMock,
			trackerMock = {track: function() {}},
			logMock = function() {},
			windowMock = {adslots2: {push: function() {
				liftiumCalled = true;
			}}},
			GeoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock = {},
			adLogicDartSubdomainMock = {getSubdomain: function() {return 'sub';}},
			adProviderAdDriver2,
			wikiaGptMock = {pushAd: function () {
				dartCalled = true;
			}};

		adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
		adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

		adProviderAdDriver2 = AdProviderAdDriver2(
			wikiaDartMock,
			scriptWriterMock,
			trackerMock,
			logMock,
			windowMock,
			GeoMock,
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock,
			adLogicDartSubdomainMock,
			wikiaGptMock
		);

		dartCalled = false;
		liftiumCalled = false;
		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(liftiumCalled).toBeFalsy('Liftium not called when user in high value country (and not exceeded number of DART calls)');
		expect(dartCalled).toBeTruthy('DART called when user in high value country (and not exceeded number of DART calls)');
	});
});
