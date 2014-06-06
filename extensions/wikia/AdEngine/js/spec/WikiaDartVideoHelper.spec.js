/* global describe, it, expect, modules */
describe('WikiaDartVideoHelper', function () {
	'use strict';

	var logMock = function(){},
		locationMock = {origin: 'http://wikia.com'};

	it('getUrl has all required tag params', function () {
		var resultUrl, adLogicPageLevelParamsMock = {
			getPageLevelParams: function () {
				return {};
			}
		},
		wikiaDartVideoHelper = modules['ext.wikia.adEngine.dartVideoHelper'](logMock, locationMock, adLogicPageLevelParamsMock);

		resultUrl = wikiaDartVideoHelper.getUrl();

		expect(resultUrl).toMatch('http://pubads.g.doubleclick.net/gampad/ads');
		expect(resultUrl).toMatch('ciu_szs');
		expect(resultUrl).toMatch('iu=/5441/wka.ooyalavideo/_page_targeting');
		expect(resultUrl).toMatch('sz=');
		expect(resultUrl).toMatch('impl=s');
		expect(resultUrl).toMatch('output=xml_vast2');
		expect(resultUrl).toMatch('gdfp_req=1');
		expect(resultUrl).toMatch('env=vp');
		expect(resultUrl).toMatch('ad_rule=0');
		expect(resultUrl).toMatch('unviewed_position_start=1');
		expect(resultUrl).toMatch('url=' + locationMock.origin);
		expect(resultUrl).toMatch('correlator=');
	});

	it('getUrl adds src page parameter', function () {
		var resultUrl, adLogicPageLevelParamsMock = {
			getPageLevelParams: function () {
				return {};
			}
		},
		wikiaDartVideoHelper = modules['ext.wikia.adEngine.dartVideoHelper'](logMock, locationMock, adLogicPageLevelParamsMock);

		resultUrl = wikiaDartVideoHelper.getUrl();

		expect(resultUrl).toMatch(encodeURIComponent('src=ooyala'));
	});


	it('getUrl encodes page parameters', function () {
		var resultUrl, adLogicPageLevelParamsMock = {
			getPageLevelParams: function () {
				return {
					pageid: '_adtest/2021',
					artid: '2021',
					cat: ['test', 'test2', 'test3']
				};
			}
		},
		wikiaDartVideoHelper = modules['ext.wikia.adEngine.dartVideoHelper'](logMock, locationMock, adLogicPageLevelParamsMock);

		resultUrl = wikiaDartVideoHelper.getUrl();

		expect(resultUrl).toMatch(encodeURIComponent('pageid=_adtest/2021'));
		expect(resultUrl).toMatch(encodeURIComponent('cat=test,test2,test3'));
	});


});
