/*global describe, expect, it, modules*/
describe('AdLogicHighValueCountry', function () {
	'use strict';

	it('wgHighValueCountries present in InstantGlobals', function () {
		var instantGlobalsMock = {wgHighValueCountries: {'XX': 5, 'YY': 7, 'ZZ': 0, 'aa': 7}},
			adLogicHighValueCountry = modules['ext.wikia.adEngine.adLogicHighValueCountry'](instantGlobalsMock);

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

		expect(adLogicHighValueCountry.isHighValueCountry()).toBeFalsy('undefined isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry(null)).toBeFalsy('null isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('unknown')).toBeFalsy('unknown isHighValueCountry');
	});

	it('wgHighValueCountries not present in InstantGlobals', function () {
		var adLogicHighValueCountry = modules['ext.wikia.adEngine.adLogicHighValueCountry']({});

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

		expect(adLogicHighValueCountry.isHighValueCountry()).toBeFalsy('undefined isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry(null)).toBeFalsy('null isHighValueCountry');
		expect(adLogicHighValueCountry.isHighValueCountry('unknown')).toBeFalsy('unknown isHighValueCountry');
	});
});
