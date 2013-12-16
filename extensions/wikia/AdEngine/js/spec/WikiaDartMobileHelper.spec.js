// TODO: proper UNIT tests for this

describe('WikiaDartMobileHelper', function(){
	it('getMobileUrl', function () {
		var logMock = function () {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname',
				wgContentLanguage: 'xx',
				Features: {positionfixed: true}
			},
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock),
			dartUrl = DartUrl(),
			dartHelper = WikiaDartMobileHelper(logMock, windowMock, adLogicPageLevelParams, dartUrl),
			expected = 'http://ad.mo.doubleclick.net/DARTProxy/mobile.handler?k=wka.vertical/_dbname/article;' +
				's0=vertical;s1=_dbname;s2=article;' +
				'dmn=exampleorg;' +
				'hostpre=example;' +
				'lang=xx;' +
				'positionfixed=css;' +
				'src=mobile;' +
				'mtfIFPath=/extensions/wikia/AdEngine/;mtfInline=true;' +
				'pos=SLOTNAME_MOBILE;' +
				'sz=5x5;' +
				'tile=1;' +
				'ord=XXX?' +
				'&csit=1&dw=1&u=someuniqid';

		expect(
			dartHelper.getMobileUrl({
				slotname: 'SLOTNAME_MOBILE',
				size: '5x5',
				uniqueId: 'someuniqid'
			}).replace(/ord=[0-9]+/, 'ord=XXX')
		).toBe(expected);
	});
});
