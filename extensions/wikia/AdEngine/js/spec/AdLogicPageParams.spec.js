/*global describe, it, expect, modules*/
/*jshint camelcase:false*/
/*jshint maxlen:200*/
describe('AdLogicPageParams', function () {
	'use strict';

	var logMock = function () { return; };

	function mockAdContext(targeting) {
		return {
			getContext: function () {
				return {
					opts: {},
					targeting: targeting || {},
					forceProviders: {}
				};
			},
			addCallback: function () {
				return;
			}
		};
	}

	function mockWindow(document, hostname, amzn_targs) {

		hostname = hostname || 'example.org';

		return {
			document: document || {},
			location: { origin: 'http://' + hostname, hostname: hostname },
			amzn_targs: amzn_targs,
			wgCookieDomain: hostname.substr(hostname.indexOf('.'))
		};
	}

	function mockPageViewCounter(pvCount) {
		return {
			get: function () { return pvCount || 0; },
			increment: function () { return pvCount || 1; }
		};
	}

	function mockAmazonMatch(amazonPageParams) {
		return {
			getPageParams: function () {
				return amazonPageParams;
			},
			wasCalled: function () {
				return !!amazonPageParams;
			},
			trackState: function () {
				return;
			}
		};
	}

	function mockAmazonMatchOld(enabled) {
		return {
			wasCalled: function () {
				return !!enabled;
			},
			trackState: function () {
				return;
			}
		};
	}

	/**
	 * Keys for opts:
	 *  - amazonPageParams
	 *  - amzn_targs
	 *  - kruxSegments
	 *  - abExperiments
	 *  - hostname
	 *  - getPageLevelParamsOptions
	 *  - pvCount
	 */
	function getParams(targeting, opts) {
		opts = opts || {};

		var kruxMock = {
				getSegments: function () {
					return opts.kruxSegments || [];
				},
				getUser: function () {
					return '';
				}
			},
			abTestMock = opts.abExperiments ? {
				getExperiments: function () {
					return opts.abExperiments || [];
				},
				getGroup: function () { return; }
			} : undefined,
			windowMock = mockWindow(opts.document, opts.hostname, opts.amzn_targs);

		return modules['ext.wikia.adEngine.adLogicPageParams'](
			mockAdContext(targeting),
			mockPageViewCounter(opts.pvCount),
			logMock,
			windowMock.document,
			windowMock.location,
			undefined,
			abTestMock,
			kruxMock
		).getPageLevelParams(opts.getPageLevelParamsOptions);
	}

	it('getPageLevelParams simple params correct', function () {
		var params = getParams({
			wikiCategory: 'category',
			wikiDbName: 'dbname',
			wikiLanguage: 'xx'
		});

		expect(params.s0).toBe('category');
		expect(params.s1).toBe('_dbname');
		expect(params.s2).toBe('article');
		expect(params.lang).toBe('xx');
	});

	it('getPageLevelParams hostprefix and domain params', function () {
		var params;

		params = getParams({}, {hostname: 'an.example.org'});
		expect(params.dmn).toBe('exampleorg');
		expect(params.hostpre).toBe('an');

		params = getParams({}, {hostname: 'fallout.wikia.com'});
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('fallout');

		params = getParams({}, {hostname: 'www.wikia.com'});
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');

		params = getParams({}, {hostname: 'www.wowwiki.com'});
		expect(params.dmn).toBe('wowwikicom');
		expect(params.hostpre).toBe('www');

		params = getParams({}, {hostname: 'wowwiki.com'});
		expect(params.dmn).toBe('wowwikicom');
		expect(params.hostpre).toBe('wowwiki');

		params = getParams({}, {hostname: 'www.bbc.co.uk'});
		expect(params.dmn).toBe('bbccouk');
		expect(params.hostpre).toBe('www');

		params = getParams({}, {hostname: 'externaltest.fallout.wikia.com'});
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('externaltest');
	});

	it('getPageLevelParams wpage param', function () {
		var params;

		params = getParams({});
		expect(params.wpage).toBe(undefined, 'undefined');

		params = getParams({pageName: 'Muppet_Wiki'});
		expect(params.wpage).toBe('muppet_wiki', 'Muppet_Wiki');

		params = getParams({pageName: 'Assassin\'s_Creed_Wiki'});
		expect(params.wpage).toBe('assassin\'s_creed_wiki', 'Assassin\'s_Creed_Wiki');

		params = getParams({pageName: 'Военная_база_Марипоза'});
		expect(params.wpage).toBe('военная_база_марипоза', 'Военная_база_Марипоза');
	});

	it('getPageLevelParams default DB name', function () {
		var params = getParams();

		expect(params.s1).toBe('_wikia', 's1=_wikia');
	});

	it('getPageLevelParams language', function () {
		var params;

		params = getParams();
		expect(params.lang).toBe('unknown', 'lang=unknown');

		params = getParams({wikiLanguage: 'xyz'});
		expect(params.lang).toBe('xyz', 'lang=xyz');
	});

	it('getPageLevelParams page type', function () {
		var params = getParams({pageType: 'pagetype'});

		expect(params.s2).toBe('pagetype', 's2=pagetype');
	});

	it('getPageLevelParams article id', function () {
		var params = getParams({pageArticleId: 678});

		expect(params.artid).toBe('678', 'artid=678');
	});

	it('getPageLevelParams per-wiki custom DART params', function () {
		var params = getParams({
			wikiCustomKeyValues: 'key1=value1;key2=value2;key3=value3;key3=value4'
		});

		expect(params.key1).toEqual(['value1'], 'key1=value1');
		expect(params.key2).toEqual(['value2'], 'key2=value2');
		expect(params.key3).toEqual(['value3', 'value4'], 'key3=value3;key3=value4');
	});

	it('getPageLevelParams Krux segments', function () {
		var kruxSegmentsNone = [],
			kruxSegmentsFew = ['kxsgmntA', 'kxsgmntB', 'kxsgmntC', 'kxsgmntD'],
			params;

		params = getParams({}, {kruxSegments: kruxSegmentsNone});
		expect(params.ksgmnt).toEqual(kruxSegmentsNone, 'No segments');

		params = getParams({}, {kruxSegments: kruxSegmentsFew});
		expect(params.ksgmnt).toEqual(kruxSegmentsFew, 'A few segments');
	});

	it('getPageLevelParams Page categories', function () {
		var params;

		params = getParams({pageCategories: []});
		expect(params.cat).toBeFalsy('No categories');

		params = getParams({pageCategories: ['Category', 'Another Category']});
		expect(params.cat).toEqual(['category', 'another_category'], 'Two categories');

		params = getParams({pageCategories: ['A Category', 'Another Category', 'Yet Another Category', 'Aaaand One More']});
		expect(params.cat).toEqual(['a_category', 'another_category', 'yet_another_category'], '4 categories stripped down to first 3');
	});

	it('getPageLevelParams abTest info', function () {
		var params,
			abParamEmpty;

		params = getParams();
		abParamEmpty = !params.ab || params.ab.length === 0;
		expect(abParamEmpty).toBeTruthy('no ab param passed when AbTesting is not passed to module');

		params = getParams({}, {abExperiments: []});
		abParamEmpty = !params.ab || params.ab.length === 0;
		expect(abParamEmpty).toBeTruthy('no ab param passed when no experiment is active');

		params = getParams({}, {abExperiments: [
			{ id: 17, group: { id: 34 } },
			{ id: 19, group: { id: 45 } },
			{ id: 76, group: { id: 112 } }
		]});
		expect(params.ab).toEqual(['17_34', '19_45', '76_112'], 'ab params passed');
	});

	it('getPageLevelParams includeRawDbName', function () {
		var params = getParams({
			wikiDbName: 'xyz'
		});

		expect(params.rawDbName).toBeUndefined();

		params = getParams({
			wikiDbName: 'xyz'
		}, {
			getPageLevelParamsOptions: {
				includeRawDbName: true
			}
		});

		expect(params.rawDbName).toBe('_xyz');
	});


// Very specific tests for hubs:

	it('getPageLevelParams Hub page: video games', function () {
		var params = getParams({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'Gaming'
		}, {
			hostname: 'www.wikia.com'
		});

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_gaming_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
	});

	it('getUrl Hub page: entertainment', function () {
		var params = getParams({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'Entertainment'
		}, {
			hostname: 'www.wikia.com'
		});

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_ent_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
	});

	it('getUrl Hub page: lifestyle', function () {
		var params = getParams({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'Lifestyle'
		}, {
			hostname: 'www.wikia.com'
		});

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_life_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
	});

	it('getPageLevelParams Krux segments on regular and on COPPA wiki', function () {
		var kruxSegments = ['kxsgmntA', 'kxsgmntB', 'kxsgmntC', 'kxsgmntD'],
			params;

		params = getParams({}, {kruxSegments: kruxSegments});
		expect(params.ksgmnt).toEqual(kruxSegments, 'Krux on regular wiki');

		params = getParams({wikiDirectedAtChildren: true}, {kruxSegments: kruxSegments});
		expect(params.ksgmnt).toBeUndefined('No Krux on COPPA wiki');
	});

	it('getPageLevelParams esrb + COPPA', function () {
		var params;

		params = getParams({
			wikiCustomKeyValues: 'key1=value1;esrb=rating;key2=value2'
		});
		expect(params.esrb.toString()).toBe('rating', 'esrb=yes, COPPA=no');

		params = getParams({
			wikiCustomKeyValues: 'key1=value1;esrb=rating;key2=value2',
			wikiDirectedAtChildren: true
		});
		expect(params.esrb.toString()).toBe('rating', 'esrb=yes, COPPA=yes');

		params = getParams({
			wikiCustomKeyValues: 'key1=value1;key2=value2'
		});
		expect(params.esrb.toString()).toBe('teen', 'esrb=null, COPPA=no');

		params = getParams({
			wikiCustomKeyValues: 'key1=value1;key2=value2',
			wikiDirectedAtChildren: true
		});
		expect(params.esrb.toString()).toBe('ec', 'esrb=null, COPPA=yes');
	});

	it('getPageLevelParams pv param - oasis', function () {
		var params = getParams({skin: 'oasis'}, {pvCount: 13});

		expect(params.pv).toBe('13');
	});

	it('getPageLevelParams pv param - mercury', function () {
		var params = getParams({skin: 'mercury'}, {pvCount: 13});

		expect(params.pv).toBe('13');
	});

	it('getPageLevelParams ref param', function () {
		var params;


		params = getParams({}, { document: {
			referrer: ''
		}});

		expect(params.ref).toBe('direct');

		params = getParams({}, {
			document: { referrer: 'http://gta.wikia.com/wiki/Special:Search?search=text' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('wiki_search');

		params = getParams({}, {
			document: { referrer: 'http://gta.wikia.com/wiki/Other_PAGE' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('wiki');

		params = getParams({}, {
			document: { referrer: 'http://gaming.wikia.com/wiki/Special:Search?search=text' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('wikia_search');

		params = getParams({}, {
			document: { referrer: 'http://wikia.com/wiki/Special:Search?search=text' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('wikia_search');

		params = getParams({}, {
			document: { referrer: 'http://gaming.wikia.com/wiki/Other_PAGE' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('wikia');

		params = getParams({}, {
			document: { referrer: 'http://wowwiki.com/' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('wikia');

		params = getParams({}, {
			document: { referrer: 'http://www.google.com/' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('external_search');

		params = getParams({}, {
			document: { referrer: 'http://yahoo.com/' },
			hostname: 'gta.wikia.com'
		});

		expect(params.ref).toBe('external');


	});
});
