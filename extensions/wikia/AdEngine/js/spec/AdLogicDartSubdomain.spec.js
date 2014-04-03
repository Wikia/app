describe('AdLogicDartSubdomain', function(){
	it('Geo discovery', function() {
		var geoMock = {getCountryCode: function() {return 'XX';}},
			undef,
			adLogic = modules['ext.wikia.adEngine.adLogicDartSubdomain'](geoMock);

		// Continent-only checks:
		geoMock.getContinentCode = function() {return 'NA';};
		expect(adLogic.getSubdomain()).toBe('ad', 'North America -> ad');

		geoMock.getContinentCode = function() {return 'SA'};
		expect(adLogic.getSubdomain()).toBe('ad', 'South America -> ad');

		geoMock.getContinentCode = function() {return 'XX'};
		expect(adLogic.getSubdomain()).toBe('ad', 'Unknown -> ad');

		geoMock.getContinentCode = function() {return 'AF'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'Africa -> ad-emea');

		geoMock.getContinentCode = function() {return 'OC'};
		expect(adLogic.getSubdomain()).toBe('ad-apac', 'Oceania -> ad-apac');

		geoMock.getContinentCode = function() {return 'EU'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'Europe -> ad-emea');

		// Country-level checks:
		geoMock.getContinentCode = function() {return 'EU'};
		geoMock.getCountryCode = function() {return 'DE'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'DE -> ad-emea');

		geoMock.getContinentCode = function() {return 'AF'};
		geoMock.getCountryCode = function() {return 'ZE'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'ZE -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'AE'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'AE -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'CY'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'CY -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'BH'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'BH -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'IL'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'IL -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'IQ'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'IQ -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'IR'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'IR -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'JO'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'JO -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'KW'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'KW -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'LB'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'LB -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'OM'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'OM -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'PS'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'PS -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'QA'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'QA -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'CN'};
		expect(adLogic.getSubdomain()).toBe('ad-apac', 'CN -> ad-apac');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'LB'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'LB -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'OM'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'OM -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'PS'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'PS -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'SA'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'SA -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'SY'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'SY -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'TR'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'TR -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'YE'};
		expect(adLogic.getSubdomain()).toBe('ad-emea', 'YE -> ad-emea');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'IN'};
		expect(adLogic.getSubdomain()).toBe('ad-apac', 'IN -> ad-apac');

		geoMock.getContinentCode = function() {return 'AS'};
		geoMock.getCountryCode = function() {return 'JP'};
		expect(adLogic.getSubdomain()).toBe('ad-apac', 'JP -> ad-apac');

		geoMock.getContinentCode = function() {return 'OC'};
		geoMock.getCountryCode = function() {return 'AU'};
		expect(adLogic.getSubdomain()).toBe('ad-apac', 'AU -> ad-apac');

		geoMock.getContinentCode = function() {return 'NA'};
		geoMock.getCountryCode = function() {return 'US'};
		expect(adLogic.getSubdomain()).toBe('ad', 'US -> ad');

		geoMock.getContinentCode = function() {return 'SA'};
		geoMock.getCountryCode = function() {return 'AR'};
		expect(adLogic.getSubdomain()).toBe('ad', 'AR -> ad');
	});
});