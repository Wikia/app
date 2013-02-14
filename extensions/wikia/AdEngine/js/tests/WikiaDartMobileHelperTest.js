/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/DartUrl.js
 * @test-require-asset extensions/wikia/AdEngine/js/WikiaDartHelper.js
 * @test-require-asset extensions/wikia/AdEngine/js/WikiaDartMobileHelper.js
 */

module('WikiaDartMobileHelper');

test('getMobileUrl', function() {
	var logMock = function() {},
		windowMock = {
			location: {hostname: 'example.org'},
			cityShort: 'vertical',
			wgDBname: 'dbname',
			wgContentLanguage: 'xx'
		},
		documentMock = {documentElement: {}, body: {}},
		dartHelper = WikiaDartMobileHelper(logMock, windowMock, documentMock),
		expected = 'http://ad.mo.doubleclick.net/DARTProxy/mobile.handler?k=wka.vertical/_dbname/article;' +
			's0=vertical;s1=_dbname;s2=article;dmn=exampleorg;hostpre=example;pos=SLOTNAME_MOBILE;' +
			'lang=xx;hasp=no;positionfixed=css;src=mobile;sz=5x5;mtfIFPath=/extensions/wikia/AdEngine/;mtfInline=true;' +
			'tile=1;ord=XXX?&csit=1&dw=1&u=someuniqid';

	equal(dartHelper.getMobileUrl({
		slotname: 'SLOTNAME_MOBILE',
		positionfixed: 'css',
		uniqueId: 'someuniqid'
	}).replace(/ord=[0-9]+/, 'ord=XXX'), expected);
});
