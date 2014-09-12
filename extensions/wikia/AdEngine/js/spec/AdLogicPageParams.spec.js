/*global describe, it, expect, modules*/
/*jshint camelcase:false*/
describe('AdLogicPageParams', function () {
	'use strict';

	var logMock = function () {},
		undef;

	function mockAdContext(targeting) {
		return {
			getContext: function () {
				return {
					opts: {},
					targeting: targeting || {},
					forceProviders: {}
				};
			}
		};
	}

	function mockWindow(hostname, amzn_targs) {
		return {
			location: {hostname: hostname || 'example.org'},
			amzn_targs: amzn_targs
		};
	}

	/**
	 * Keys for opts:
	 *  - hasPreFooters
	 *  - amzn_targs
	 *  - kruxSegments
	 *  - abExperiments
	 *  - hostname
	 */
	function getParams(targeting, opts) {
		opts = opts || {};

		var adLogicPageDimensionsMock = {
				hasPreFooters: function () {
					return !!opts.hasPreFooters;
				}
			},
			kruxMock = {
				segments: opts.kruxSegments || []
			},
			abTestMock = opts.abExperiments ? {
				getExperiments: function () {
					return opts.abExperiments || [];
				},
				getGroup: function () { }
			} : undef;

		return modules['ext.wikia.adEngine.adLogicPageParams'](
			logMock,
			mockWindow(opts.hostname, opts.amzn_targs),
			mockAdContext(targeting),
			kruxMock,
			adLogicPageDimensionsMock,
			abTestMock
		).getPageLevelParams();
	}

	it('getPageLevelParams Simple params correct', function () {
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
		var undef,
			params;

		params = getParams({});
		expect(params.wpage).toBe(undef, 'undef');

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

	it('getPageLevelParams has pre footers', function () {
		var params;

		params = getParams({}, {hasPreFooters: true});
		expect(params.hasp).toBe('yes', 'yes');

		params = getParams({}, {hasPreFooters: false});
		expect(params.hasp).toBe('no', 'no');
	});

	it('getPageLevelParams per-wiki custom DART params', function () {
		var params = getParams({
			wikiCustomKeyValues: 'key1=value1;key2=value2;key3=value3;key3=value4'
		});

		expect(params.key1).toEqual(['value1'], 'key1=value1');
		expect(params.key2).toEqual(['value2'], 'key2=value2');
		expect(params.key3).toEqual(['value3', 'value4'], 'key3=value3;key3=value4');
	});

	it('getPageLevelParams Amazon Direct Targeted Buy params', function () {
		var params = getParams({}, {amzn_targs: 'amzn_300x250=1;amzn_728x90=1;'});

		expect(params.amzn_300x250).toEqual(['1']);
		expect(params.amzn_728x90).toEqual(['1']);
	});

	it('getPageLevelParams Krux segments', function () {
		var kruxSegmentsNone = [],
			kruxSegmentsFew = ['kxsgmntA', 'kxsgmntB', 'kxsgmntC', 'kxsgmntD'],
			kruxSegmentsLots = ['kxsgmnt1', 'kxsgmnt2', 'kxsgmnt3', 'kxsgmnt4', 'kxsgmnt5',
					'kxsgmnt6', 'kxsgmnt7', 'kxsgmnt8', 'kxsgmnt9', 'kxsgmnt10', 'kxsgmnt11',
					'kxsgmnt12', 'kxsgmnt13', 'kxsgmnt14', 'kxsgmnt15', 'kxsgmnt16', 'kxsgmnt17',
					'kxsgmnt18', 'kxsgmnt19', 'kxsgmnt20', 'kxsgmnt21', 'kxsgmnt22', 'kxsgmnt23',
					'kxsgmnt24', 'kxsgmnt25', 'kxsgmnt26', 'kxsgmnt27', 'kxsgmnt28', 'kxsgmnt29',
					'kxsgmnt30', 'kxsgmnt31', 'kxsgmnt32', 'kxsgmnt33', 'kxsgmnt34', 'kxsgmnt35'
				],
			kruxSegments27 = ['kxsgmnt1', 'kxsgmnt2', 'kxsgmnt3', 'kxsgmnt4', 'kxsgmnt5',
					'kxsgmnt6', 'kxsgmnt7', 'kxsgmnt8', 'kxsgmnt9', 'kxsgmnt10', 'kxsgmnt11',
					'kxsgmnt12', 'kxsgmnt13', 'kxsgmnt14', 'kxsgmnt15', 'kxsgmnt16', 'kxsgmnt17',
					'kxsgmnt18', 'kxsgmnt19', 'kxsgmnt20', 'kxsgmnt21', 'kxsgmnt22', 'kxsgmnt23',
					'kxsgmnt24', 'kxsgmnt25', 'kxsgmnt26', 'kxsgmnt27'
				],
			params;

		params = getParams({}, {kruxSegments: kruxSegmentsNone});
		expect(params.ksgmnt).toEqual(kruxSegmentsNone, 'No segments');

		params = getParams({}, {kruxSegments: kruxSegmentsFew});
		expect(params.ksgmnt).toEqual(kruxSegmentsFew, 'A few segments');

		params = getParams({}, {kruxSegments: kruxSegmentsLots});
		expect(params.ksgmnt).toEqual(kruxSegments27, 'A lot of segments (stripped to first 27 segments)');
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


// Very specific tests for hubs:

	it('getPageLevelParams Hub page: video games', function () {
		var params = getParams({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'Gaming'
		}, {
			hostname: 'www.wikia.com',
			hasPreFooters: true
		});

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_gaming_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
		expect(params.hasp).toBe('yes');
	});

	it('getUrl Hub page: entertainment', function () {
		var params = getParams({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'Entertainment'
		}, {
			hostname: 'www.wikia.com',
			hasPreFooters: true
		});

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_ent_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
		expect(params.hasp).toBe('yes');
	});

	it('getUrl Hub page: lifestyle', function () {
		var params = getParams({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'Lifestyle'
		}, {
			hostname: 'www.wikia.com',
			hasPreFooters: true
		});

		expect(params.s0).toBe('hub');
		expect(params.s1).toBe('_life_hub');
		expect(params.s2).toBe('hub');
		expect(params.dmn).toBe('wikiacom');
		expect(params.hostpre).toBe('www');
		expect(params.lang).toBe('en');
		expect(params.hasp).toBe('yes');
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
});
