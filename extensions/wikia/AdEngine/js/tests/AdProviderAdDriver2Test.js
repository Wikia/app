/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdProviderAdDriver2.js
 */

module('AdProviderAdDriver2');

test('fillInSlot Geo discovery', function() {
	var logMock = function() {},
		wikiaDartMockSubdomainPassed,
		wikiaDartMock = {
			getUrl: function(params) {
				wikiaDartMockSubdomainPassed = params.subdomain;
			}
		},
		scriptWriterMock = {injectScriptByUrl: function() {}},
		wikiaTrackerMock = {trackAdEvent: function() {}},
		slotTweakerMock = {},
		cacheStorageMock = {get: function() {}, set: function() {}, del: function() {}},
		adLogicHighValueCountryMock = {getMaxCallsToDART: function() {return 3;}, isHighValueCountry: function() {return true;}},
		windowMock = {
			location: {hostname: 'example.org'},
			cityShort: 'vertical',
			wgDBname: 'dbname',
			wgContentLanguage: 'xx'
		},
		geoMock = {getCountryCode: function() {return 'XX';}},
		adProvider,
		undef;

	adProvider = AdProviderAdDriver2(
		wikiaDartMock, scriptWriterMock, wikiaTrackerMock, logMock, windowMock, geoMock,
		slotTweakerMock, cacheStorageMock, adLogicHighValueCountryMock
	);
	geoMock.getContinentCode = function() {return 'NA';};

	wikiaDartMockSubdomainPassed = undef;
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad', 'North America -> ad');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'SA'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad', 'South America -> ad');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'XX'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad', 'Unknown -> ad');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'AF'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad-emea', 'Africa -> ad-emea');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'OC'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad-apac', 'Oceania -> ad-apac');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'EU'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad-emea', 'Europe -> ad-emea');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'QA'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad-emea', 'Qatar -> ad-emea');

	wikiaDartMockSubdomainPassed = undef;
	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'CN'};
	adProvider.fillInSlot(['TOP_LEADERBOARD']);
	equal(wikiaDartMockSubdomainPassed, 'ad-apac', 'China -> ad-apac');
});
