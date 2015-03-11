/*global describe, it, modules, expect*/
describe('EvolveHelper', function () {
	'use strict';
	var noop = function () { return; },
		logMock = noop;

	function mockKrux() {
		return {
			getSegments: function () {
				return '';
			},
			getUser: function () {
				return '';
			}
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

	function mockDartUrl() {
		return {
			trimParam: noop,
			decorateParam: noop
		};
	}

	it('getSect', function () {
		var adContextMock = {targeting: {}},
			adContextModuleMock = mockAdContext(adContextMock),
			evolveHelper;

		adContextMock.targeting.wikiDbName = null;
		adContextMock.targeting.wikiCustomKeyValues = null;
		adContextMock.targeting.wikiVertical = null;
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](adContextModuleMock, mockAdLogicPageParams(), mockDartUrl(), mockKrux(), logMock);

		expect(evolveHelper.getSect()).toBe('ros', 'ros');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar;media=tv';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](adContextModuleMock, mockAdLogicPageParams(), mockDartUrl(), mockKrux(), logMock);

		expect(evolveHelper.getSect()).toBe('tv', 'tv entertainment');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](adContextModuleMock, mockAdLogicPageParams(), mockDartUrl(), mockKrux(), logMock);

		expect(evolveHelper.getSect()).toBe('entertainment', 'foo entertainment');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar;media=movie';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](adContextModuleMock, mockAdLogicPageParams(), mockDartUrl(), mockKrux(), logMock);

		expect(evolveHelper.getSect()).toBe('movies', 'movie entertainment');
	});

	it('getTargeting returns nothing if nothing is set', function() {
		var dartUrlMock = mockDartUrl(),
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				mockAdContext(),
				mockAdLogicPageParams(),
				dartUrlMock,
				mockKrux(),
				logMock
			);

		spyOn(dartUrlMock, 'decorateParam').and.returnValue('');

		expect(evolveHelper.getTargeting()).toBe('');
	});

	it('getCustomKeyValues', function () {
		var dartUrlMock = mockDartUrl(),
			customKeyValuesMock = 'key1=value1;key2=value2',
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				mockAdContext({ targeting: { wikiCustomKeyValues: customKeyValuesMock }}),
				mockAdLogicPageParams(),
				dartUrlMock,
				mockKrux(),
				logMock
			);

		spyOn(dartUrlMock, 'trimParam').and.returnValue(customKeyValuesMock + ';');
		spyOn(dartUrlMock, 'decorateParam').and.returnValue('');
		expect(evolveHelper.getTargeting()).toBe(customKeyValuesMock + ';');
	});

	it('getKruxKeyValues', function () {
		var dartUrlMock = mockDartUrl(),
			kruxMock = mockKrux(),
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				mockAdContext(),
				mockAdLogicPageParams(),
				dartUrlMock,
				kruxMock,
				logMock
			);

		spyOn(dartUrlMock, 'decorateParam').and.callFake(function (key) {
			if ( key === 'segments' ) {
				return 'segments=segment1,segment2;';
			}

			return '';
		});

		expect(evolveHelper.getTargeting()).toBe('segments=segment1,segment2;');
	});

	it('getTargeting returns right targeting', function () {
		var result,
			evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](
				mockAdContext(),
				mockAdLogicPageParams({ hostpre: 'someprefix', rawDbName: 'mock' }),
				modules['ext.wikia.adEngine.dartUrl'](),
				mockKrux(),
				logMock
			);

		result = evolveHelper.getTargeting();

		expect(result).toBe('s1=mock;hostpre=someprefix;');
	});
});
