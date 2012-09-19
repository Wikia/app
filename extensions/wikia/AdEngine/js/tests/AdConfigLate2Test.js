/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2Late.js
 */

module('AdConfig2Late');

test('getProvider failsafe to AdDriver', function() {
	var adProviderAdDriverMock = {name: 'AdDriverMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock'}
		, logMock = function() {}
		, adConfig;

	adConfig = AdConfig2Late(
		logMock,
		adProviderAdDriverMock,
		adProviderLiftium2Mock
	);

	equal(adConfig.getProvider(['foo']), adProviderAdDriverMock, 'adProviderAdDriverMock');
});
