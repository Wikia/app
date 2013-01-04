/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js
 */

module('AdLogicDartSubdomain');

test('Geo discovery', function() {
	var geoMock = {getCountryCode: function() {return 'XX';}},
		undef,
		adLogic = AdLogicDartSubdomain(geoMock);

	geoMock.getContinentCode = function() {return 'NA';};
	equal(adLogic.getSubdomain(), 'ad', 'North America -> ad');

	geoMock.getContinentCode = function() {return 'SA'};
	equal(adLogic.getSubdomain(), 'ad', 'South America -> ad');

	geoMock.getContinentCode = function() {return 'XX'};
	equal(adLogic.getSubdomain(), 'ad', 'Unknown -> ad');

	geoMock.getContinentCode = function() {return 'AF'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'Africa -> ad-emea');

	geoMock.getContinentCode = function() {return 'OC'};
	equal(adLogic.getSubdomain(), 'ad-apac', 'Oceania -> ad-apac');

	geoMock.getContinentCode = function() {return 'EU'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'Europe -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'QA'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'Qatar -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'CN'};
	equal(adLogic.getSubdomain(), 'ad-apac', 'China -> ad-apac');
});
