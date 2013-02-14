/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdLogicDartSubdomain.js
 */

module('AdLogicDartSubdomain');

test('Geo discovery', function() {
	var geoMock = {getCountryCode: function() {return 'XX';}},
		undef,
		adLogic = AdLogicDartSubdomain(geoMock);

	// Continent-only checks:
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

	// Country-level checks:
	geoMock.getContinentCode = function() {return 'EU'};
	geoMock.getCountryCode = function() {return 'DE'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'DE -> ad-emea');

	geoMock.getContinentCode = function() {return 'AF'};
	geoMock.getCountryCode = function() {return 'ZE'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'ZE -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'AE'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'AE -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'CY'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'CY -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'BH'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'BH -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'IL'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'IL -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'IQ'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'IQ -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'IR'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'IR -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'JO'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'JO -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'KW'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'KW -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'LB'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'LB -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'OM'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'OM -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'PS'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'PS -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'QA'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'QA -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'CN'};
	equal(adLogic.getSubdomain(), 'ad-apac', 'CN -> ad-apac');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'LB'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'LB -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'OM'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'OM -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'PS'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'PS -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'SA'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'SA -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'SY'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'SY -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'TR'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'TR -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'YE'};
	equal(adLogic.getSubdomain(), 'ad-emea', 'YE -> ad-emea');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'IN'};
	equal(adLogic.getSubdomain(), 'ad-apac', 'IN -> ad-apac');

	geoMock.getContinentCode = function() {return 'AS'};
	geoMock.getCountryCode = function() {return 'JP'};
	equal(adLogic.getSubdomain(), 'ad-apac', 'JP -> ad-apac');

	geoMock.getContinentCode = function() {return 'OC'};
	geoMock.getCountryCode = function() {return 'AU'};
	equal(adLogic.getSubdomain(), 'ad-apac', 'AU -> ad-apac');

	geoMock.getContinentCode = function() {return 'NA'};
	geoMock.getCountryCode = function() {return 'US'};
	equal(adLogic.getSubdomain(), 'ad', 'US -> ad');

	geoMock.getContinentCode = function() {return 'SA'};
	geoMock.getCountryCode = function() {return 'AR'};
	equal(adLogic.getSubdomain(), 'ad', 'AR -> ad');
});
