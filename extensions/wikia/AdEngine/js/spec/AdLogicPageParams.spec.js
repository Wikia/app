/*global describe, it, expect, modules*/
/*jshint camelcase:false*/
/*jshint maxlen:200*/
describe('AdLogicPageParams', function () {
	'use strict';

	var logMock = function () { return;},
		geoMock = {
			getCountryCode: function() {
				return 'PL';
			}
		};

	function mockAdContext(targeting) {
		return {
			getContext: function () {
				return {
					opts: {},
					targeting: targeting || {},
					forcedProvider: null
				};
			},
			addCallback: function () {
				return;
			}
		};
	}

	function mockWindow(opts) {
		opts.hostname = opts.hostname || 'example.org';

		return {
			innerWidth: opts.innerWidth,
			innerHeight: opts.innerHeight,
			document: opts.document || {},
			location: { origin: 'http://' + opts.hostname, hostname: opts.hostname },
			amzn_targs: opts.amzn_targs,
			wgCookieDomain: opts.hostname.substr(opts.hostname.indexOf('.')),
			wgABPerformanceTest: opts.perfab
		};
	}

	function mockPageViewCounter(pvCount) {
		return {
			get: function () { return pvCount || 0; },
			increment: function () { return pvCount || 1; }
		};
	}

	function mockAdLogicZoneParams() {
		return {
			getDomain: function () {
				return 'zone_domain';
			},
			getHostnamePrefix: function () {
				return 'zone_hostname_prefix';
			},
			getSite: function () {
				return 'zone_site';
			},
			getName: function () {
				return 'zone_name';
			},
			getPageType: function () {
				return 'zone_page_type';
			},
			getVertical: function () {
				return 'zone_vertical';
			},
			getPageCategories: function () {
				return ['zone_page_category'];
			},
			getWikiCategories: function () {
				return ['zone_wiki_category'];
			},
			getLanguage: function () {
				return 'zl';
			},
			getRawDbName: function () {
				return 'zone_db_name';
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
			windowMock = mockWindow(opts);

		return modules['ext.wikia.adEngine.adLogicPageParams'](
			mockAdContext(targeting),
			mockPageViewCounter(opts.pvCount),
			mockAdLogicZoneParams(),
			logMock,
			windowMock.document,
			windowMock.location,
			windowMock,
			geoMock,
			abTestMock,
			kruxMock
		).getPageLevelParams(opts.getPageLevelParamsOptions);
	}

	it('getPageLevelParams simple params correct', function () {
		var params = getParams();

		expect(params.s0).toBe('zone_site');
		expect(params.s0v).toBe('zone_vertical');
		expect(params.s0c).toEqual(['zone_wiki_category']);
		expect(params.s1).toBe('zone_name');
		expect(params.s2).toBe('zone_page_type');
		expect(params.cat).toEqual(['zone_page_category']);
		expect(params.dmn).toBe('zone_domain');
		expect(params.hostpre).toBe('zone_hostname_prefix');
		expect(params.lang).toBe('zl');
		expect(params.geo).toBe('PL');
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

		params = getParams({enableKruxTargeting: true}, {kruxSegments: kruxSegmentsNone});
		expect(params.ksgmnt).toEqual(kruxSegmentsNone, 'No segments');

		params = getParams({enableKruxTargeting: true}, {kruxSegments: kruxSegmentsFew});
		expect(params.ksgmnt).toEqual(kruxSegmentsFew, 'A few segments');
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

	it('getPageLevelParams abPerfTest info', function () {
		var params;

		params = getParams();
		expect(params.perfab).toEqual(undefined);

		params = getParams({}, {perfab: 'foo'});
		expect(params.perfab).toEqual('foo');
	});

	it('getPageLevelParams includeRawDbName', function () {
		var params = getParams();

		expect(params.rawDbName).toBeUndefined();

		params = getParams({}, {
			getPageLevelParamsOptions: {
				includeRawDbName: true
			}
		});

		expect(params.rawDbName).toBe('zone_db_name');
	});

	it('getPageLevelParams Krux segments on regular and on COPPA wiki', function () {
		var kruxSegments = ['kxsgmntA', 'kxsgmntB', 'kxsgmntC', 'kxsgmntD'],
			params;

		params = getParams({enableKruxTargeting: true}, {kruxSegments: kruxSegments});
		expect(params.ksgmnt).toEqual(kruxSegments, 'Krux on regular wiki');

		params = getParams({wikiDirectedAtChildren: true}, {kruxSegments: kruxSegments});
		expect(params.ksgmnt).toBeUndefined('No Krux on COPPA wiki');
	});

	it('decodeLegacyDartParams should skip esrb', function () {
		var params = getParams({
			wikiCustomKeyValues: 'key1=value1;esrb=rating;key2=value2'
		});

		expect(params.esrb).not.toBeDefined();
		expect(params.key1.toString()).toBe('value1');
		expect(params.key2.toString()).toBe('value2');
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

	it('getPageLevelParams aspect ratio for landscape orientation', function () {
		var params = getParams({}, {
			innerWidth: 1024,
			innerHeight: 600
		});

		expect(params.ar).toBe('4:3');
	});

	it('getPageLevelParams aspect ratio for portrait orientation', function () {
		var params = getParams({}, {
			innerWidth: 360,
			innerHeight: 640
		});

		expect(params.ar).toBe('3:4');
	});
});
