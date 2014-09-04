/*global describe,it,modules,expect*/
describe('AdLogicPageParamsLegacy', function () {
	'use strict';

	function mockKrux(dartKeyValues) {
		return {
			dartKeyValues: dartKeyValues
		};
	}

	function mockAdContext(targeting) {
		return {
			getContext: function () {
				return {
					targeting: targeting || {}
				};
			}
		};
	}

	function mockAdLogicPageParams(pageParams) {
		return {
			getPageLevelParams: function () {
				return pageParams || {};
			}
		};
	}

	var logMock = function () {};

	it('getCustomKeyValues', function () {
		var paramToTrim,
			dartUrlMock = {trimParam: function (param) { return param; }},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams(),
				mockKrux(),
				dartUrlMock
			);

		expect(adLogicPageParamsLegacy.getCustomKeyValues()).toBe('');

		dartUrlMock.trimParam = function (param) { paramToTrim = param; return 'trimmed'; };
		adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](
			logMock,
			mockAdContext({wikiCustomKeyValues: 'key1=value1;key2=value2'}),
			mockAdLogicPageParams(),
			mockKrux(),
			dartUrlMock
		);

		expect(adLogicPageParamsLegacy.getCustomKeyValues()).toBe('trimmed');
		expect(paramToTrim).toBe('key1=value1;key2=value2;');
	});

	it('getKruxKeyValues', function () {
		var paramToTrim,
			dartUrlMock = { trimParam: function (param) { return param; }},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams(),
				mockKrux(),
				dartUrlMock
			);

		expect(adLogicPageParamsLegacy.getKruxKeyValues()).toBe('');

		dartUrlMock.trimParam = function (param) { paramToTrim = param; return 'trimmed'; };
		adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](
			logMock,
			mockAdContext(),
			mockAdLogicPageParams(),
			mockKrux('krux=dart;key=values;'),
			dartUrlMock
		);

		expect(adLogicPageParamsLegacy.getKruxKeyValues()).toBe('trimmed');
		expect(paramToTrim).toBe('krux=dart;key=values;');
	});

	it('getDomainKV', function () {
		var logMock = function () {},
			passedKey,
			passedValue,
			dartUrlMock = { decorateParam: function (key, value) {passedKey = key; passedValue = value; }},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams({dmn: 'examplecom'}),
				mockKrux(),
				dartUrlMock
			);

		adLogicPageParamsLegacy.getDomainKV();
		expect(passedKey).toBe('dmn');
		expect(passedValue).toBe('examplecom');
	});

	it('getHostnamePrefix', function () {
		var logMock = function () {},
			passedKey,
			passedValue,
			dartUrlMock = { decorateParam: function (key, value) {passedKey = key; passedValue = value; }},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams({hostpre: 'someprefix'}),
				mockKrux(),
				dartUrlMock
			);

		adLogicPageParamsLegacy.getHostnamePrefix();
		expect(passedKey).toBe('hostpre');
		expect(passedValue).toBe('someprefix');
	});
});
