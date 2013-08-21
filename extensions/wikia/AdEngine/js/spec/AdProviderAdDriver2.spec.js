describe('AdProviderAdDriver2', function(){
	it('Leaderboard experiment works as expected in low value countries', function() {
		var wikiaDartMock = {getUrl: function() {return 'http://example.org/'}},
			dartCalled,
			liftiumCalled,
			scriptWriterMock = {injectScriptByUrl: function() {
				dartCalled = true;
			}},
			trackerMock = {track: function() {}},
			logMock = function() {},
			windowMock = {adslots2: {push: function() {liftiumCalled = true;}}},
			GeoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock = {},
			adLogicDartSubdomainMock = {getSubdomain: function() {return 'sub';}},
			abTestMock = {
				getGroup: function(exp) {
					if (exp === 'LEADERBOARD_TESTS') {
						return 'SOME_GROUP';
					}
				}
			},
			wikiaGptMock = {
				init: function() {}
			},
			adProviderAdDriver2;

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
			cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
			adLogicHighValueCountryMock,
			adLogicDartSubdomainMock,
			abTestMock,
			wikiaGptMock
		);

		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(dartCalled).toBeTruthy('DART called when user in low value country and in experiment');
		expect(liftiumCalled).toBeFalsy('Liftium not called when user in low value country and in experiment');

		dartCalled = false;
		liftiumCalled = false;
		abTestMock.getGroup = function() {};
		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(dartCalled).toBeFalsy('DART not called when user in low value country and not in experiment');
		expect(liftiumCalled).toBeTruthy('Liftium called when user in low value country and not in experiment');
	});


	it('Leaderboard experiment works as expected in high value countries', function() {
		var wikiaDartMock = {getUrl: function() {return 'http://example.org/'}},
			dartCalled,
			liftiumCalled,
			scriptWriterMock = {injectScriptByUrl: function() {
				dartCalled = true;
			}},
			trackerMock = {track: function() {}},
			logMock = function() {},
			windowMock = {adslots2: {push: function() {liftiumCalled = true;}}},
			GeoMock = {getCountryCode: function() {}},
			slotTweakerMock,
			cacheStorageMock,
			adLogicHighValueCountryMock = {},
			adLogicDartSubdomainMock = {getSubdomain: function() {return 'sub';}},
			abTestMock = {
				getGroup: function(exp) {
					if (exp === 'LEADERBOARD_TESTS') {
						return 'SOME_GROUP';
					}
				}
			},
			wikiaGptMock = {
				init: function() {}
			},
			adProviderAdDriver2;

		dartCalled = false;
		liftiumCalled = false;
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
			cacheStorageMock = {set: function() {}, get: function() {return 8;}, del: function() {}},
			adLogicHighValueCountryMock,
			adLogicDartSubdomainMock,
			abTestMock,
			wikiaGptMock
		);

		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(dartCalled).toBeTruthy('DART called when user in high value country (but exceeded number of DART calls) and in experiment');
		expect(liftiumCalled).toBeFalsy('Liftium not called when user in high value country (but exceeded number of DART calls) and in experiment');

		dartCalled = false;
		liftiumCalled = false;
		abTestMock.getGroup = function() {};
		adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
		expect(dartCalled).toBeFalsy('DART not called when user in high value country (but exceeded number of DART calls) and not in experiment');
		expect(liftiumCalled).toBeTruthy('Liftium called when user in high value country (but exceeded number of DART calls) and not in experiment');
	});
});
