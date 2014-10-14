describe('AdLogicPageLevelParamsLegacy', function(){
	it('getCustomKeyValues', function() {
		var logMock = function() {},
			windowMock = {},
			kruxMock,
			paramToTrim,
			adLogicPageLevelParamsMock = {getPageLevelParams: function() {}},
			dartUrlMock = {trimParam: function(param) {return param}},
			adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(logMock, windowMock, adLogicPageLevelParamsMock, kruxMock, dartUrlMock);

		expect(adLogicPageLevelParamsLegacy.getCustomKeyValues()).toBe('');

		dartUrlMock.trimParam = function(param) {paramToTrim = param; return 'trimmed';};

		windowMock.wgDartCustomKeyValues = 'key1=value1;key2=value2';
		expect(adLogicPageLevelParamsLegacy.getCustomKeyValues()).toBe('trimmed');
		expect(paramToTrim).toBe('key1=value1;key2=value2;');
	});

	it('getKruxKeyValues', function() {
		var logMock = function() {},
			windowMock,
			kruxMock = {},
			paramToTrim,
			adLogicPageLevelParamsMock = {getPageLevelParams: function() {}},
			dartUrlMock = {trimParam: function (param) {return param}},
			adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(logMock, windowMock, adLogicPageLevelParamsMock, kruxMock, dartUrlMock);

		expect(adLogicPageLevelParamsLegacy.getKruxKeyValues()).toBe('');

		dartUrlMock.trimParam = function (param) {paramToTrim = param; return 'trimmed';};
		kruxMock.dartKeyValues = 'krux=dart;key=values;';

		expect(adLogicPageLevelParamsLegacy.getKruxKeyValues()).toBe('trimmed');
		expect(paramToTrim).toBe('krux=dart;key=values;');
	});

	it('getDomainKV', function() {
		var logMock = function() {},
			windowMock,
			kruxMock,
			paramToTrim,
			adLogicPageLevelParamsMock = {getPageLevelParams: function() {
				return {
					dmn: 'examplecom'
				};
			}},
			passedKey,
			passedValue,
			dartUrlMock = {decorateParam: function(key, value) {passedKey = key; passedValue = value;}},
			adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(logMock, windowMock, adLogicPageLevelParamsMock, kruxMock, dartUrlMock);

		adLogicPageLevelParamsLegacy.getDomainKV();
		expect(passedKey).toBe('dmn');
		expect(passedValue).toBe('examplecom');
	});

	it('getHostnamePrefix', function() {
		var logMock = function() {},
			windowMock,
			kruxMock,
			paramToTrim,
			adLogicPageLevelParamsMock = {getPageLevelParams: function() {
				return {
					hostpre: 'someprefix'
				};
			}},
			passedKey,
			passedValue,
			dartUrlMock = {decorateParam: function(key, value) {passedKey = key; passedValue = value;}},
			adLogicPageLevelParamsLegacy = AdLogicPageLevelParamsLegacy(logMock, windowMock, adLogicPageLevelParamsMock, kruxMock, dartUrlMock);

		adLogicPageLevelParamsLegacy.getHostnamePrefix();
		expect(passedKey).toBe('hostpre');
		expect(passedValue).toBe('someprefix');
	});
});
