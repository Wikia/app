describe('AdLogicHighValueCountry', function(){

	it('wgHighValueCountries present in window', function() {
		var windowMock = {},
			instantGlobalsMock = {wgHighValueCountries: {'XX': 5, 'YY': 7, 'ZZ': 0, 'aa': 7}},
			adLogicHighValueCountry = modules['ext.wikia.adEngine.adLogicHighValueCountry'](windowMock, instantGlobalsMock),
			undef;

		expect(adLogicHighValueCountry.isHighValueCountry('aa')).toBeFalsy('aa isHighValueCountry');

		expect(adLogicHighValueCountry.isHighValueCountry('XX')).toBeTruthy('XX isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('xx')).toBeTruthy('xx isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('YY')).toBeTruthy('YY isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('yy')).toBeTruthy('yy isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('ZZ')).toBeFalsy('ZZ isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('zz')).toBeFalsy('zz isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('BB')).toBeFalsy('BB isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('bb')).toBeFalsy('bb isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('CC')).toBeFalsy('CC isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('cc')).toBeFalsy('cc isHighValueCountry');

		expect(adLogicHighValueCountry.isHighValueCountry(undef)).toBeFalsy('undefined isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry(null)).toBeFalsy('null isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('unknown')).toBeFalsy('unknown isHighValueCountry');

		expect(adLogicHighValueCountry.getMaxCallsToDART('aa')).toBe(0, 'aa getMaxCallsToDART');

		expect(adLogicHighValueCountry.getMaxCallsToDART('XX')).toBe(5, 'XX getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('xx')).toBe(5, 'xx getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('YY')).toBe(7, 'YY getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('yy')).toBe(7, 'yy getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('ZZ')).toBe(0, 'ZZ getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('zz')).toBe(0, 'zz getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('BB')).toBe(0, 'BB getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('bb')).toBe(0, 'bb getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('CC')).toBe(0, 'CC getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('cc')).toBe(0, 'cc getMaxCallsToDART');

		expect(adLogicHighValueCountry.getMaxCallsToDART(undef)).toBeFalsy('undefined getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART(null)).toBeFalsy('null getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('unknown')).toBe(0, 'unknown getMaxCallsToDART');
	});

	it('wgHighValueCountries not present in window', function() {
		var windowMock = {},
			adLogicHighValueCountry = modules['ext.wikia.adEngine.adLogicHighValueCountry'](windowMock, {}),
			undef;

		expect(adLogicHighValueCountry.isHighValueCountry('CA')).toBeTruthy('CA isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('ca')).toBeTruthy('ca isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('US')).toBeTruthy('US isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('us')).toBeTruthy('us isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('UK')).toBeTruthy('UK isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('uk')).toBeTruthy('uk isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('RU')).toBeFalsy('RU isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('ru')).toBeFalsy('ru isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('BG')).toBeFalsy('BG isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('bg')).toBeFalsy('bg isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('RO')).toBeFalsy('RO isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('ro')).toBeFalsy('ro isHighValueCountry');

		expect(adLogicHighValueCountry.isHighValueCountry(undef)).toBeFalsy('undefined isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry(null)).toBeFalsy('null isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('unknown')).toBeFalsy('unknown isHighValueCountry');

		expect(adLogicHighValueCountry.getMaxCallsToDART('CA')).toBe(3, 'CA getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('ca')).toBe(3, 'ca getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('US')).toBe(3, 'US getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('us')).toBe(3, 'us getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('UK')).toBe(3, 'UK getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('uk')).toBe(3, 'uk getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('RU')).toBe(0, 'RU getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('ru')).toBe(0, 'ru getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('BG')).toBe(0, 'BG getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('bg')).toBe(0, 'bg getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('RO')).toBe(0, 'RO getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('ro')).toBe(0, 'ro getMaxCallsToDART');

		expect(adLogicHighValueCountry.getMaxCallsToDART(undef)).toBeFalsy('undefined getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART(null)).toBeFalsy('null getMaxCallsToDART');
		expect(adLogicHighValueCountry.getMaxCallsToDART('unknown')).toBe(0, 'unknown getMaxCallsToDART');
	});
});