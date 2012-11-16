/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdLogicHighValueCountry.js
 */

module('AdLogicHighValueCountry');

test('wgHighValueCountries present in window', function() {
	var windowMock = {wgHighValueCountries: {'XX': 5, 'YY': 7, 'ZZ': 0, 'aa': 7}},
		adLogicHighValueCountry = AdLogicHighValueCountry(windowMock),
		undef;

	equal(adLogicHighValueCountry.isHighValueCountry('aa'), false, 'aa isHighValueCountry');

	equal(adLogicHighValueCountry.isHighValueCountry('XX'), true, 'XX isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('xx'), true, 'xx isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('YY'), true, 'YY isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('yy'), true, 'yy isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('ZZ'), false, 'ZZ isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('zz'), false, 'zz isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('BB'), false, 'BB isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('bb'), false, 'bb isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('CC'), false, 'CC isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('cc'), false, 'cc isHighValueCountry');

	equal(adLogicHighValueCountry.isHighValueCountry(undef), false, 'undefined isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry(null), false, 'null isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('unknown'), false, 'unknown isHighValueCountry');

	equal(adLogicHighValueCountry.getMaxCallsToDART('aa'), 0, 'aa getMaxCallsToDART');

	equal(adLogicHighValueCountry.getMaxCallsToDART('XX'), 5, 'XX getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('xx'), 5, 'xx getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('YY'), 7, 'YY getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('yy'), 7, 'yy getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('ZZ'), 0, 'ZZ getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('zz'), 0, 'zz getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('BB'), 0, 'BB getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('bb'), 0, 'bb getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('CC'), 0, 'CC getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('cc'), 0, 'cc getMaxCallsToDART');

	equal(adLogicHighValueCountry.getMaxCallsToDART(undef), 0, 'undefined getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART(null), 0, 'null getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('unknown'), 0, 'unknown getMaxCallsToDART');
});

test('wgHighValueCountries not present in window', function() {
	var windowMock = {},
		adLogicHighValueCountry = AdLogicHighValueCountry(windowMock),
		undef;

	equal(adLogicHighValueCountry.isHighValueCountry('CA'), true, 'CA isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('ca'), true, 'ca isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('US'), true, 'US isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('us'), true, 'us isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('UK'), true, 'UK isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('uk'), true, 'uk isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('RU'), false, 'RU isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('ru'), false, 'ru isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('BG'), false, 'BG isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('bg'), false, 'bg isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('RO'), false, 'RO isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('ro'), false, 'ro isHighValueCountry');

	equal(adLogicHighValueCountry.isHighValueCountry(undef), false, 'undefined isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry(null), false, 'null isHighValueCountry');
	equal(adLogicHighValueCountry.isHighValueCountry('unknown'), false, 'unknown isHighValueCountry');

	equal(adLogicHighValueCountry.getMaxCallsToDART('CA'), 3, 'CA getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('ca'), 3, 'ca getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('US'), 3, 'US getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('us'), 3, 'us getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('UK'), 3, 'UK getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('uk'), 3, 'uk getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('RU'), 0, 'RU getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('ru'), 0, 'ru getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('BG'), 0, 'BG getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('bg'), 0, 'bg getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('RO'), 0, 'RO getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('ro'), 0, 'ro getMaxCallsToDART');

	equal(adLogicHighValueCountry.getMaxCallsToDART(undef), 0, 'undefined getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART(null), 0, 'null getMaxCallsToDART');
	equal(adLogicHighValueCountry.getMaxCallsToDART('unknown'), 0, 'unknown getMaxCallsToDART');
});
