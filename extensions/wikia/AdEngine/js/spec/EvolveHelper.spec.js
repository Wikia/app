/*global describe, it, modules, expect*/
describe('EvolveHelper', function () {
	'use strict';
	var logMock = function () {};

	function mockKrux(dartKeyValues) {
		return {
			dartKeyValues: dartKeyValues
		};
	}

	function mockAdContext(context) {
		context = context || { targeting: {} };

		return {
			getContext: function () {
				return context;
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

	it('getSect', function () {
		var logMock = function () {},
			adContextMock = {targeting: {}},
			adContextModuleMock = mockAdContext(adContextMock),
			evolveHelper;

		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock, mockAdLogicPageParams(), mockKrux());

		adContextMock.targeting.wikiDbName = null;
		adContextMock.targeting.wikiCustomKeyValues = null;
		adContextMock.targeting.wikiVertical = null;
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock, mockAdLogicPageParams(), mockKrux());

		expect(evolveHelper.getSect()).toBe('ros', 'ros');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar;media=tv';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock, mockAdLogicPageParams(), mockKrux());

		expect(evolveHelper.getSect()).toBe('tv', 'tv entertainment');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock, mockAdLogicPageParams(), mockKrux());

		expect(evolveHelper.getSect()).toBe('entertainment', 'foo entertainment');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar;media=movie';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock, mockAdLogicPageParams(), mockKrux());

		expect(evolveHelper.getSect()).toBe('movies', 'movie entertainment');
	});

	it('getTargeting returns nothing if nothing is set', function() {
		var dartUrlMock = {
				trimParam: function (param) { return param; },
				decorateParam: function (key, value) { return value ? key +'=' + value + ';' : ''; }
			},
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams(),
				mockKrux(),
				dartUrlMock
			);

		expect(evolveHelper.getTargeting()).toBe('');
	});

	it('getCustomKeyValues', function () {
		var paramToTrim,
			dartUrlMock = {
				trimParam: function (param) { paramToTrim = param; return 'trimmed'; },
				decorateParam: function (key, value) { return value ? key +'=' + value + ';' : ''; }
			},
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				logMock,
				mockAdContext({ targeting: { wikiCustomKeyValues: 'key1=value1;key2=value2' }}),
				mockAdLogicPageParams(),
				mockKrux(),
				dartUrlMock
			);

		expect(evolveHelper.getTargeting()).toBe('trimmed');
		expect(paramToTrim).toBe('key1=value1;key2=value2;');
	});

	it('getKruxKeyValues', function () {
		var paramToTrim,
			dartUrlMock = {
				trimParam: function (param) { paramToTrim = param; return 'trimmed'; },
				decorateParam: function (key, value) { return value ? key +'=' + value + ';' : ''; }
			},
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams(),
				mockKrux('krux=dart;key=values;'),
				dartUrlMock
			);

		expect(evolveHelper.getTargeting()).toBe('trimmed');
		expect(paramToTrim).toBe('krux=dart;key=values;');
	});

	it('getTargeting returns right targeting', function () {
		var logMock = function () {},
			result,
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				logMock,
				mockAdContext(),
				mockAdLogicPageParams({ hostpre: 'someprefix', rawDbName: 'mock' }),
				mockKrux(),
				modules['ext.wikia.adEngine.dartUrl']()
			);

		result = evolveHelper.getTargeting();

		expect(result).toBe('s1=mock;hostpre=someprefix;');
	});
});
