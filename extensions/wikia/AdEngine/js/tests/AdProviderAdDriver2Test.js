/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderAdDriver2.js
 */

module('AdProviderAdDriver2');

test('Leaderboard experiment works as expected in low value countries', function() {
	var wikiaDartMock = {getUrl: function() {return 'http://example.org/'}},
		dartCalled,
		liftiumCalled,
		scriptWriterMock = {injectScriptByUrl: function() {
			dartCalled = true;
		}},
		wikiaTrackerMock = {track: function() {}},
		logMock = function() {},
		windowMock = {adslots2: {push: function() {liftiumCalled = true;}}},
		GeoMock = {getCountryCode: function() {}},
		slotTweakerMock,
		cacheStorageMock,
		adLogicHighValueCountryMock = {},
		adLogicDartSubdomainMock = {getSubdomain: function() {return 'sub';}},
		abTestMock,
		adProviderAdDriver2;

	dartCalled = false;
	liftiumCalled = false;
	adLogicHighValueCountryMock.isHighValueCountry = function() {return false;};
	adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 0;};

	adProviderAdDriver2 = AdProviderAdDriver2(
		wikiaDartMock,
		scriptWriterMock,
		wikiaTrackerMock,
		logMock,
		windowMock,
		GeoMock,
		slotTweakerMock,
		cacheStorageMock = {set: function() {}, get: function() {}, del: function() {}},
		adLogicHighValueCountryMock,
		adLogicDartSubdomainMock,
		abTestMock = {
			getGroup: function(exp) {
				if (exp === 'LEADERBOARD_TESTS') {
					return 'SOME_GROUP';
				}
			}
		}
	);

	adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
	equal(dartCalled, true, 'DART called when user in low value country and in experiment');
	equal(liftiumCalled, false, 'Liftium not called when user in low value country and in experiment');

	dartCalled = false;
	liftiumCalled = false;
	abTestMock.getGroup = function() {};
	adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
	equal(dartCalled, false, 'DART not called when user in low value country and not in experiment');
	equal(liftiumCalled, true, 'Liftium called when user in low value country and not in experiment');
});


test('Leaderboard experiment works as expected in high value countries', function() {
	var wikiaDartMock = {getUrl: function() {return 'http://example.org/'}},
		dartCalled,
		liftiumCalled,
		scriptWriterMock = {injectScriptByUrl: function() {
			dartCalled = true;
		}},
		wikiaTrackerMock = {track: function() {}},
		logMock = function() {},
		windowMock = {adslots2: {push: function() {liftiumCalled = true;}}},
		GeoMock = {getCountryCode: function() {}},
		slotTweakerMock,
		cacheStorageMock,
		adLogicHighValueCountryMock = {},
		adLogicDartSubdomainMock = {getSubdomain: function() {return 'sub';}},
		abTestMock,
		adProviderAdDriver2;

	dartCalled = false;
	liftiumCalled = false;
	adLogicHighValueCountryMock.isHighValueCountry = function() {return true;};
	adLogicHighValueCountryMock.getMaxCallsToDART = function() {return 7;};

	adProviderAdDriver2 = AdProviderAdDriver2(
		wikiaDartMock,
		scriptWriterMock,
		wikiaTrackerMock,
		logMock,
		windowMock,
		GeoMock,
		slotTweakerMock,
		cacheStorageMock = {set: function() {}, get: function() {return 8;}, del: function() {}},
		adLogicHighValueCountryMock,
		adLogicDartSubdomainMock,
		abTestMock = {
			getGroup: function(exp) {
				if (exp === 'LEADERBOARD_TESTS') {
					return 'SOME_GROUP';
				}
			}
		}
	);

	adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
	equal(dartCalled, true, 'DART called when user in high value country (but exceeded number of DART calls) and in experiment');
	equal(liftiumCalled, false, 'Liftium not called when user in high value country (but exceeded number of DART calls) and in experiment');

	dartCalled = false;
	liftiumCalled = false;
	abTestMock.getGroup = function() {};
	adProviderAdDriver2.fillInSlot(['TOP_LEADERBOARD']);
	equal(dartCalled, false, 'DART not called when user in high value country (but exceeded number of DART calls) and not in experiment');
	equal(liftiumCalled, true, 'Liftium called when user in high value country (but exceeded number of DART calls) and not in experiment');
});
