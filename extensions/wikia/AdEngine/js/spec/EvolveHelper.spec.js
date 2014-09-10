/*global describe, it, modules, expect*/
describe('EvolveHelper', function () {
	'use strict';
	it('getSect', function () {
		var logMock = function () {},
			adContextMock = {targeting: {}},
			adContextModuleMock = {
				getContext: function () { return adContextMock; }
			},
			evolveHelper;

		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock);

		adContextMock.targeting.wikiDbName = null;
		adContextMock.targeting.wikiCustomKeyValues = null;
		adContextMock.targeting.wikiVertical = null;
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock);

		expect(evolveHelper.getSect()).toBe('ros', 'ros');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar;media=tv';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock);

		expect(evolveHelper.getSect()).toBe('tv', 'tv entertainment');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock);

		expect(evolveHelper.getSect()).toBe('entertainment', 'foo entertainment');

		adContextMock.targeting.wikiCustomKeyValues = 'foo=bar;media=movie';
		adContextMock.targeting.wikiVertical = 'Entertainment';
		evolveHelper = modules['ext.wikia.adEngine.evolveHelper'](logMock, adContextModuleMock);

		expect(evolveHelper.getSect()).toBe('movies', 'movie entertainment');
	});
});
