/*global describe, it, expect, AdLogicPageLevelParams*/
describe('AdLogicPageLevelParams', function(){
	it('getPageLevelParams Simple params correct', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname',
				wgContentLanguage: 'xx'
			},
			documentMock,
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.s0).toBe('vertical');
		expect(params.s1).toBe('_dbname');
		expect(params.s2).toBe('article');
		expect(params.lang).toBe('xx');
	});

	it('getPageLevelParams hostprefix and domain params', function() {
		var logMock = function() {},
			windowMock = {location: {}},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams,
			params;

		windowMock.location.hostname = 'an.example.org';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('exampleorg');
		expect(params.hostpre).toBe('an');

		windowMock.location.hostname = 'fallout.wikia.com';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('fallout');

		windowMock.location.hostname = 'www.wikia.com';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');

		windowMock.location.hostname = 'www.wowwiki.com';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('wowwikicom');
		expect(params.hostpre).toBe('www');

		windowMock.location.hostname = 'wowwiki.com';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('wowwikicom');
		expect(params.hostpre).toBe('wowwiki');

		windowMock.location.hostname = 'www.bbc.co.uk';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('bbccouk');
		expect(params.hostpre).toBe('www');

		windowMock.location.hostname = 'externaltest.fallout.wikia.com';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('externaltest');
	});

	it('getPageLevelParams wpage param', function() {
		var undef,
			logMock = function() {},
			windowMock = {location: {hostname: 'an.example.org'}},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams,
			params;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.wpage).toBe(undef, 'undef');

		windowMock.wgPageName = 'Muppet_Wiki';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.wpage).toBe('muppet_wiki', 'Muppet_Wiki');

		windowMock.wgPageName = 'Assassin\'s_Creed_Wiki';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.wpage).toBe('assassin\'s_creed_wiki', 'Assassin\'s_Creed_Wiki');

		windowMock.wgPageName = 'Военная_база_Марипоза';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.wpage).toBe('военная_база_марипоза', 'Военная_база_Марипоза');
	});

	it('getPageLevelParams default DB name', function() {
		var logMock = function() {},
			windowMock = {location: {hostname: 'an.example.org'}},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.s1).toBe('_wikia', 's1=_wikia');
	});

	it('getPageLevelParams language', function() {
		var logMock = function() {},
			windowMock = {location: {hostname: 'an.example.org'}},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams,
			params;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.lang).toBe('unknown', 'lang=unknown');

		windowMock.wgContentLanguage = 'xyz';
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.lang).toBe('xyz', 'lang=xyz');
	});

	it('getPageLevelParams page type', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				wikiaPageType: 'pagetype'
			},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.s2).toBe('pagetype', 's2=pagetype');
	});

	it('getPageLevelParams article id', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				wgArticleId: 678
			},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.artid).toBe('678', 'artid=678');
	});

	it('getPageLevelParams has pre footers', function() {
		var logMock = function() {},
			windowMock = {location: {hostname: 'an.example.org'}},
			adLogicPageDimensionsMockTrue = {hasPreFooters: function() {return true;}},
			adLogicPageDimensionsMockFalse = {hasPreFooters: function() {return false;}},
			kruxMock,
			abTestMock,
			adLogicPageLevelParams,
			params;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMockTrue, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.hasp).toBe('yes', 'yes');

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMockFalse, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.hasp).toBe('no', 'no');
	});

	it('getPageLevelParams per-wiki custom DART params', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				wgDartCustomKeyValues: 'key1=value1;key2=value2;key3=value3;key3=value4'
			},
			adLogicPageDimensionsMock = {hasPreFooters: function() {return true;}},
			kruxMock,
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.key1).toEqual(['value1'], 'key1=value1');
		expect(params.key2).toEqual(['value2'], 'key2=value2');
		expect(params.key3).toEqual(['value3', 'value4'], 'key3=value3;key3=value4');
	});

	it('getPageLevelParams Amazon Direct Targeted Buy params', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				amzn_targs: 'amzn_300x250=1;amzn_728x90=1;'
			},
			adLogicPageDimensionsMock = {hasPreFooters: function() {return true;}},
			kruxMock,
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.amzn_300x250).toEqual(['1']);
		expect(params.amzn_728x90).toEqual(['1']);
	});

	it('getPageLevelParams Krux segments', function() {
		var logMock = function() {},
			kruxMockNone = {segments: []},
			kruxMockFew = {segments: ['kxsgmntA', 'kxsgmntB', 'kxsgmntC', 'kxsgmntD']},
			kruxMockLots = {segments: ['kxsgmnt1', 'kxsgmnt2', 'kxsgmnt3', 'kxsgmnt4', 'kxsgmnt5',
				'kxsgmnt6', 'kxsgmnt7', 'kxsgmnt8', 'kxsgmnt9', 'kxsgmnt10', 'kxsgmnt11',
				'kxsgmnt12', 'kxsgmnt13', 'kxsgmnt14', 'kxsgmnt15', 'kxsgmnt16', 'kxsgmnt17',
				'kxsgmnt18', 'kxsgmnt19', 'kxsgmnt20', 'kxsgmnt21', 'kxsgmnt22', 'kxsgmnt23',
				'kxsgmnt24', 'kxsgmnt25', 'kxsgmnt26', 'kxsgmnt27', 'kxsgmnt28', 'kxsgmnt29',
				'kxsgmnt30', 'kxsgmnt31', 'kxsgmnt32', 'kxsgmnt33', 'kxsgmnt34', 'kxsgmnt35'
			]},
			kruxMock27 = {segments: ['kxsgmnt1', 'kxsgmnt2', 'kxsgmnt3', 'kxsgmnt4', 'kxsgmnt5',
				'kxsgmnt6', 'kxsgmnt7', 'kxsgmnt8', 'kxsgmnt9', 'kxsgmnt10', 'kxsgmnt11',
				'kxsgmnt12', 'kxsgmnt13', 'kxsgmnt14', 'kxsgmnt15', 'kxsgmnt16', 'kxsgmnt17',
				'kxsgmnt18', 'kxsgmnt19', 'kxsgmnt20', 'kxsgmnt21', 'kxsgmnt22', 'kxsgmnt23',
				'kxsgmnt24', 'kxsgmnt25', 'kxsgmnt26', 'kxsgmnt27'
			]},
			windowMock = {
				location: {hostname: 'an.example.org'}
			},
			adLogicPageDimensionsMock,
			kruxMock = {},
			abTestMock,
			adLogicPageLevelParams,
			params;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMockNone, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.ksgmnt).toEqual(kruxMockNone.segments, 'No segments');

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMockFew, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.ksgmnt).toEqual(kruxMockFew.segments, 'A few segments');

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMockLots, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.ksgmnt).toEqual(kruxMock27.segments, 'A lot of segments (stripped to first 27 segments)');
	});

	it('getPageLevelParams Page categories', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				wgCategories: []
			},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock,
			adLogicPageLevelParams,
			params,
			undef;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.cat).toBeFalsy('No categories');

		windowMock.wgCategories = ['Category', 'Another Category'];
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.cat).toEqual(['category', 'another_category'], 'Two categories');

		windowMock.wgCategories = ['A Category', 'Another Category', 'Yet Another Category', 'Aaaand One More'];
		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.cat).toEqual(['a_category', 'another_category', 'yet_another_category'], '4 categories stripped down to first 3');
	});

	it('getPageLevelParams abTest info', function() {
		var logMock = function() {},
			windowMock = {location: {hostname: 'an.example.org'}},
			adLogicPageDimensionsMock,
			kruxMock,
			abTestMock = {
				getExperiments: function() {
					return [
						{ id: 17, group: { id: 34 } },
						{ id: 19, group: { id: 45 } },
						{ id: 76, group: { id: 112 } }
					];
				}
			},
			abTestMockEmpty = {getExperiments: function() {return [];}},
			abTestMockNone,
			adLogicPageLevelParams,
			params,
			abParamEmpty;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.ab).toEqual(['17_34', '19_45', '76_112'], 'ab params passed');

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMockEmpty);
		params = adLogicPageLevelParams.getPageLevelParams();
		abParamEmpty = !params.ab || params.ab.length === 0;
		expect(abParamEmpty).toBeTruthy('no ab param passed when no experiment is active');

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMockNone);
		params = adLogicPageLevelParams.getPageLevelParams();
		abParamEmpty = !params.ab || params.ab.length === 0;
		expect(abParamEmpty).toBeTruthy('no ab param passed when AbTesting is not passed to module');
	});


// Very specific tests for hubs:

	it('getPageLevelParams Hub page: video games', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'www.wikia.com'},
				cityShort: 'wikia',
				cscoreCat: 'Gaming',
				wgDBname: 'wikiaglobal',
				wgContentLanguage: 'en',
				wgWikiaHubType: 'gaming',
				wikiaPageIsHub: true
			},
			kruxMock,
			adLogicPageDimensionsMock = {hasPreFooters: function() {return true;}},
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_gaming_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
		expect(params.hasp).toBe('yes');
	});

	it('getUrl Hub page: entertainment', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'www.wikia.com'},
				cityShort: 'wikia',
				cscoreCat: 'Entertainment',
				wgDBname: 'wikiaglobal',
				wgContentLanguage: 'en',
				wgWikiaHubType: 'ent',
				wikiaPageIsHub: true
			},
			kruxMock,
			adLogicPageDimensionsMock = {hasPreFooters: function() {return true;}},
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(	params.s0).toBe('hub');
		expect(	params.s1).toBe('_ent_hub');
		expect(	params.s2).toBe('hub');
		expect(	params.dmn).toBe('wikiacom');
		expect(	params.hostpre).toBe('www');
		expect(	params.lang).toBe('en');
		expect(	params.hasp).toBe('yes');
	});

	it('getUrl Hub page: lifestyle', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'www.wikia.com'},
				cityShort: 'wikia',
				cscoreCat: 'Lifestyle',
				wgDBname: 'wikiaglobal',
				wgContentLanguage: 'en',
				wgWikiaHubType: 'life',
				wikiaPageIsHub: true
			},
			kruxMock,
			adLogicPageDimensionsMock = {hasPreFooters: function() {return true;}},
			abTestMock,
			adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMock, kruxMock, adLogicPageDimensionsMock, abTestMock),
			params = adLogicPageLevelParams.getPageLevelParams();

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_life_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
		expect(params.hasp).toBe('yes');
	});

	it('getPageLevelParams Krux segments on regular and on COPPA wiki', function() {
		var logMock = function() {},
			kruxMockFew = {segments: ['kxsgmntA', 'kxsgmntB', 'kxsgmntC', 'kxsgmntD']},
			windowMockRegular = {
				location: {hostname: 'an.example.org'}
			},
			windowMockCOPPA = {
				location: {hostname: 'an.example.org'},
				wgWikiDirectedAtChildren: true
			},
			adLogicPageDimensionsMock,
			abTestMock,
			adLogicPageLevelParams,
			params;

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMockRegular, kruxMockFew, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.ksgmnt).toEqual(kruxMockFew.segments, 'Krux on regular wiki');

		adLogicPageLevelParams = AdLogicPageLevelParams(logMock, windowMockCOPPA, kruxMockFew, adLogicPageDimensionsMock, abTestMock);
		params = adLogicPageLevelParams.getPageLevelParams();
		expect(params.ksgmnt).toBeUndefined('No Krux on COPPA wiki');
	});
});
