/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfigLate2.js
 */

module('AdConfigLate2');

test('getProvider failsafe to AdDriver', function() {
	var adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, logMock = function() {}
		, adConfig;

	adConfig = AdConfigLate2(
		logMock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderAdDriverMock, 'adProviderAdDriverMock');
});
