describe('AdLogicPageParamsLegacy', function(){
	it('getCustomKeyValues', function() {
		var logMock = function() {},
			windowMock = {},
			kruxMock,
			paramToTrim,
			adLogicPageParamsMock = {getPageLevelParams: function() {}},
			dartUrlMock = {trimParam: function(param) {return param}},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](logMock, windowMock, adLogicPageParamsMock, kruxMock, dartUrlMock);

		expect(adLogicPageParamsLegacy.getCustomKeyValues()).toBe('');

		dartUrlMock.trimParam = function(param) {paramToTrim = param; return 'trimmed';};

		windowMock.wgDartCustomKeyValues = 'key1=value1;key2=value2';
		expect(adLogicPageParamsLegacy.getCustomKeyValues()).toBe('trimmed');
		expect(paramToTrim).toBe('key1=value1;key2=value2;');
	});

	it('getKruxKeyValues', function() {
		var logMock = function() {},
			windowMock,
			kruxMock = {},
			paramToTrim,
			adLogicPageParamsMock = {getPageLevelParams: function() {}},
			dartUrlMock = {trimParam: function (param) {return param}},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](logMock, windowMock, adLogicPageParamsMock, kruxMock, dartUrlMock);

		expect(adLogicPageParamsLegacy.getKruxKeyValues()).toBe('');

		dartUrlMock.trimParam = function (param) {paramToTrim = param; return 'trimmed';};
		kruxMock.dartKeyValues = 'krux=dart;key=values;';

		expect(adLogicPageParamsLegacy.getKruxKeyValues()).toBe('trimmed');
		expect(paramToTrim).toBe('krux=dart;key=values;');
	});

	it('getDomainKV', function() {
		var logMock = function() {},
			windowMock,
			kruxMock,
			paramToTrim,
			adLogicPageParamsMock = {getPageLevelParams: function() {
				return {
					dmn: 'examplecom'
				};
			}},
			passedKey,
			passedValue,
			dartUrlMock = {decorateParam: function(key, value) {passedKey = key; passedValue = value;}},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](logMock, windowMock, adLogicPageParamsMock, kruxMock, dartUrlMock);

		adLogicPageParamsLegacy.getDomainKV();
		expect(passedKey).toBe('dmn');
		expect(passedValue).toBe('examplecom');
	});

	it('getHostnamePrefix', function() {
		var logMock = function() {},
			windowMock,
			kruxMock,
			paramToTrim,
			adLogicPageParamsMock = {getPageLevelParams: function() {
				return {
					hostpre: 'someprefix'
				};
			}},
			passedKey,
			passedValue,
			dartUrlMock = {decorateParam: function(key, value) {passedKey = key; passedValue = value;}},
			adLogicPageParamsLegacy = modules['ext.wikia.adEngine.adLogicPageParamsLegacy'](logMock, windowMock, adLogicPageParamsMock, kruxMock, dartUrlMock);

		adLogicPageParamsLegacy.getHostnamePrefix();
		expect(passedKey).toBe('hostpre');
		expect(passedValue).toBe('someprefix');
	});
});
