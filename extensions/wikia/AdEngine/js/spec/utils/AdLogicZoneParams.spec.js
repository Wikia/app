/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.utils.adLogicZoneParams', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
			context: {},
			adContext: {
				addCallback: noop,
				getContext: function () {
					return mocks.context;
				}
			},
			loc: {},
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.utils.adLogicZoneParams'](
			mocks.adContext,
			mocks.log,
			mocks.loc
		);
	}

	function setUpContext(targeting, opts) {
		mocks.context = {
			targeting: targeting || {},
			opts: opts || {}
		};
	}

	function setUpLocation(hostname) {
		mocks.loc.hostname = hostname;
	}

	beforeEach(function () {
		setUpContext();
		setUpLocation('www.wikia.com');
	});

	it('Hostname and domain for an.example.org', function () {
		setUpLocation('an.example.org');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('exampleorg');
		expect(zoneParams.getHostnamePrefix()).toBe('an');
	});

	it('Hostname and domain for fallout.wikia.com', function () {
		setUpLocation('fallout.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('fallout');
	});

	it('Hostname and domain for www.wikia.com', function () {
		setUpLocation('www.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('www');
	});

	it('Hostname and domain for www.wowwiki.com', function () {
		setUpLocation('www.wowwiki.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wowwikicom');
		expect(zoneParams.getHostnamePrefix()).toBe('www');
	});

	it('Hostname and domain for wowwiki.com', function () {
		setUpLocation('wowwiki.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wowwikicom');
		expect(zoneParams.getHostnamePrefix()).toBe('wowwiki');
	});

	it('Hostname and domain for www.bbc.co.uk', function () {
		setUpLocation('www.bbc.co.uk');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('bbccouk');
		expect(zoneParams.getHostnamePrefix()).toBe('www');
	});

	it('Hostname and domain for externaltest.fallout.wikia.com', function () {
		setUpLocation('externaltest.fallout.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('externaltest');
	});

	it('Hostname and domain for fallout.externaltest.wikia.com', function () {
		setUpLocation('fallout.externaltest.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('externaltest');
	});

	it('Hostname and domain for showcase.gta.wikia.com', function () {
		setUpLocation('showcase.gta.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('showcase');
	});

	it('Hostname and domain for gta.showcase.wikia.com', function () {
		setUpLocation('gta.showcase.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('showcase');
	});

	it('Hostname and domain for sandbox-adeng05.gta.wikia.com', function () {
		setUpLocation('sandbox-adeng05.gta.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('sandbox-adeng05');
	});

	it('Hostname and domain for gta.sandbox-adeng05.wikia.com', function () {
		setUpLocation('gta.sandbox-adeng05.wikia.com');
		var zoneParams = getModule();

		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('sandbox-adeng05');
	});

	it('Simple base params', function () {
		setUpContext({
			mappedVerticalName: 'mappedVertical',
			wikiCategory: 'category',
			wikiDbName: 'dbname'
		});
		var zoneParams = getModule();

		expect(zoneParams.getSite()).toBe('mappedVertical');
		expect(zoneParams.getName()).toBe('_dbname');
		expect(zoneParams.getPageType()).toBe('article');
	});

	it('Name default DB name', function () {
		var zoneParams = getModule();

		expect(zoneParams.getName()).toBe('_wikia', 's1=_wikia');
	});

	it('getPageType', function () {
		setUpContext({
			pageType: 'pagetype'
		});
		var zoneParams = getModule();

		expect(zoneParams.getPageType()).toBe('pagetype', 's2=pagetype');
	});

	it('getPageCategories - Empty page categories', function () {
		setUpContext({
			pageCategories: []
		});
		var zoneParams = getModule();

		expect(zoneParams.getPageCategories()).toBeFalsy('No categories');
	});

	it('getPageCategories - Two categories', function () {
		setUpContext({
			pageCategories: ['Category', 'Another Category']
		});
		var zoneParams = getModule();

		expect(zoneParams.getPageCategories()).toEqual(['category', 'another_category']);
	});

	it('getPageCategories - 4 categories stripped down to first 3', function () {
		setUpContext({
			pageCategories: ['A Category', 'Another Category', 'Yet Another Category', 'Aaaand One More']
		});
		var zoneParams = getModule();

		expect(zoneParams.getPageCategories()).toEqual(['a_category', 'another_category', 'yet_another_category']);
	});

	it('getWikiCategories - from context targeting', function () {
		setUpContext({
			newWikiCategories: ['foo', 'bar']
		});
		var zoneParams = getModule();

		expect(zoneParams.getWikiCategories()).toEqual(['foo', 'bar']);
	});

	it('getVertical - from context targeting', function () {
		setUpContext({
			wikiVertical: 'foo_vertical'
		});
		var zoneParams = getModule();

		expect(zoneParams.getVertical()).toEqual('foo_vertical');
	});

	it('getRawDbName', function () {
		setUpContext({
			wikiDbName: 'xyz'
		});
		var zoneParams = getModule();

		expect(zoneParams.getRawDbName()).toBe('_xyz');
	});

	it('getLanguage', function () {
		var zoneParams = getModule();

		expect(zoneParams.getLanguage()).toBe('unknown', 'lang=unknown');
	});

	it('getLanguage', function () {
		setUpContext({
			wikiLanguage: 'xyz'
		});
		var zoneParams = getModule();

		expect(zoneParams.getLanguage()).toBe('xyz', 'lang=xyz');
	});

	// Very specific tests for hubs:

	it('Hub page: games', function () {
		setUpContext({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'games',
			mappedVerticalName: 'gaming'
		});
		var zoneParams = getModule();

		expect(zoneParams.getSite()).toBe('hub');
		expect(zoneParams.getName()).toBe('_gaming_hub');
		expect(zoneParams.getPageType()).toBe('hub');
		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('www');
		expect(zoneParams.getLanguage()).toBe('en');
	});

	it('Hub page: TV', function () {
		setUpContext({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'tv',
			mappedVerticalName: 'ent'
		});
		var zoneParams = getModule();

		expect(zoneParams.getSite()).toBe('hub');
		expect(zoneParams.getName()).toBe('_ent_hub');
		expect(zoneParams.getPageType()).toBe('hub');
		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('www');
		expect(zoneParams.getLanguage()).toBe('en');
	});

	it('Hub page: lifestyle', function () {
		setUpContext({
			pageIsHub: true,
			wikiCategory: 'wikia',
			wikiDbName: 'wikiaglobal',
			wikiLanguage: 'en',
			wikiVertical: 'lifestyle',
			mappedVerticalName: 'life'
		});
		var zoneParams = getModule();

		expect(zoneParams.getSite()).toBe('hub');
		expect(zoneParams.getName()).toBe('_life_hub');
		expect(zoneParams.getPageType()).toBe('hub');
		expect(zoneParams.getDomain()).toBe('wikiacom');
		expect(zoneParams.getHostnamePrefix()).toBe('www');
		expect(zoneParams.getLanguage()).toBe('en');
	});
});
