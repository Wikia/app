/**
 * @test-require-asset extensions/wikia/AdEngine/js/WikiaDartHelper.js
 */

describe('WikiaDartHelper', function(){
	it('getUrl returns whatever comes from dartUrl.urlBuilder.toString method', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname',
				wgContentLanguage: 'xx'
			},
			expected = 'http://some/url/from/dart+helper',
			urlBuilderMock = {
				addParam: function(key, value) {},
				addString: function() {},
				toString: function() {return expected;}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock),
			actual = dartHelper.getUrl({
				slotsize: '100x200',
				slotname: 'SLOT_NAME',
				tile: 3
			});

		expect(actual).toBe(expected);
	});

	it('getUrl Domain and prefix correct', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname'
			},
			domainPassed,
			prefixPassed,
			urlBuilderMock = {addParam: function() {}, addString: function() {}},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					domainPassed = domain;
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			subdomain: 'sub'
		});

		expect(domainPassed).toBe('sub.doubleclick.net', 'domain');
		expect(prefixPassed).toBe('adj/wka.vertical/_dbname/article', 'prefix');
	});

	it('getUrl Simple params correct', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname',
				wgContentLanguage: 'xx'
			},
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			tile: 3
		});

		expect(paramsPassed.s0).toBe('vertical');
		expect(paramsPassed.s1).toBe('_dbname');
		expect(paramsPassed.s2).toBe('article');
		expect(paramsPassed.pos).toBe('SLOT_NAME');
		expect(paramsPassed.lang).toBe('xx');
		expect(paramsPassed.dis).toBe('large');
		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.sz).toBe('100x200');
		expect(paramsPassed.tile).toBe(3);
	});

	it('getUrl hostprefix and domain params', function() {
		var logMock = function() {},
			windowMock = {location: {}},
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);


		windowMock.location.hostname = 'an.example.org';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('exampleorg');
		expect(paramsPassed.hostpre).toBe('an');

		windowMock.location.hostname = 'fallout.wikia.com';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('fallout');

		windowMock.location.hostname = 'www.wikia.com';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('www');

		windowMock.location.hostname = 'www.wowwiki.com';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('wowwikicom');
		expect(paramsPassed.hostpre).toBe('www');

		windowMock.location.hostname = 'wowwiki.com';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('wowwikicom');
		expect(paramsPassed.hostpre).toBe('wowwiki');

		windowMock.location.hostname = 'www.bbc.co.uk';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('bbccouk');
		expect(paramsPassed.hostpre).toBe('www');

		windowMock.location.hostname = 'externaltest.fallout.wikia.com';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('externaltest');
	});

	it('getUrl wpage param', function() {
		var undef,
			logMock = function() {},
			windowMock = {location: {hostname: 'an.example.org'}},
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.wpage).toBe(undef, 'undef');

		windowMock.wgPageName = 'Muppet_Wiki';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.wpage).toBe('muppet_wiki', 'Muppet_Wiki');

		windowMock.wgPageName = 'Assassin\'s_Creed_Wiki';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.wpage).toBe('assassin\'s_creed_wiki', 'Assassin\'s_Creed_Wiki');

		windowMock.wgPageName = 'Военная_база_Марипоза';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.wpage).toBe('военная_база_марипоза', 'Военная_база_Марипоза');
	});

	it('getUrl default DB name', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				cityShort: 'vertical'
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({});

		expect(paramsPassed.s1).toBe('_wikia', 'in keyword');
		expect(prefixPassed).toBe('adj/wka.vertical/_wikia/article', 'in prefix');
	});

	it('getUrl language', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'an.example.org'},
				cityShort: 'vertical'
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.lang).toBe('unknown', 'unknown');

		windowMock.wgContentLanguage = 'xyz';
		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.lang).toBe('xyz', 'xyz');
	});

	it('getUrl page type', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgContentLanguage: 'xx',
				wikiaPageType: 'pagetype',
				wgDBname: 'dbname'
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({});

		expect(paramsPassed.s2).toBe('pagetype', 'in keyword');
		expect(prefixPassed).toBe('adj/wka.vertical/_dbname/pagetype', 'in prefix');
	});

	it('getUrl article id', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				wgArticleId: 678
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({});

		expect(paramsPassed.artid).toBe(678, 'artid=678');
	});

	it('getUrl has pre footers', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'}
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMockTrue = {hasPreFooters: function() {return true;}},
			adLogicShortPageMockFalse = {hasPreFooters: function() {return false;}},
			paramsPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					return urlBuilderMock;
				}
			},
			dartHelper1,
			dartHelper2;

		paramsPassed = {};
		dartHelper1 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMockTrue, dartUrlMock);
		dartHelper1.getUrl({});
		expect(paramsPassed.hasp).toBe('yes', 'yes');

		paramsPassed = {};
		dartHelper2 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMockFalse, dartUrlMock);
		dartHelper2.getUrl({});
		expect(paramsPassed.hasp).toBe('no', 'no');
	});

	it('getUrl per-wiki key values', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'}
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock = {hasPreFooters: function() {return true;}},
			stringsPassed = {},
			urlBuilderMock = {
				addParam: function () {},
				addString: function (stringToAdd) {
					stringsPassed[stringToAdd] = true;
				}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					return urlBuilderMock;
				}
			},
			dartHelper;

		windowMock.wgDartCustomKeyValues = 'key1=value1;key2=value2';
		dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);
		dartHelper.getUrl({});
		expect(stringsPassed['key1=value1;key2=value2;']).toBe(true, 'values passed');
	});

	it('getUrl Auto tile, same ord', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname',
				wgContentLanguage: 'xx'
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			ordStringPassed,
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function(string) {
					if (string && string.match(/^ord=/)) {
						ordStringPassed = string;
					}
				}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock),
			params = {
				slotsize: '100x200',
				slotname: 'SLOT_NAME',
				subdomain: 'sub'
			},
			anotherParams = {
				slotsize: '200x300',
				slotname: 'ANOTHER_SLOT',
				subdomain: 'sub'
			},
			yetAnotherParams = {
				slotsize: '200x400',
				slotname: 'YET_ANOTHER_SLOT',
				subdomain: 'sub'
			},
			actualOrd,
			expectedOrd,
			undef;

		ordStringPassed = undef;
		dartHelper.getUrl(params);
		actualOrd = ordStringPassed.match(/^ord=([0-9]*)\?/)[1];

		expect(paramsPassed.tile).toBe(1, 'tile 1');

		expectedOrd = actualOrd;

		ordStringPassed = undef;
		dartHelper.getUrl(anotherParams);
		actualOrd = ordStringPassed.match(/^ord=([0-9]*)\?/)[1];

		expect(paramsPassed.tile).toBe(2, 'tile 2');
		expect(actualOrd).toBe(expectedOrd, 'same ord');

		ordStringPassed = undef;
		dartHelper.getUrl(yetAnotherParams);
		actualOrd = ordStringPassed.match(/^ord=([0-9]*)\?/)[1];

		expect(paramsPassed.tile).toBe(3, 'tile 3');
		expect(actualOrd).toBe(expectedOrd, 'same ord');
	});

	it('getUrl Page categories', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'},
				cityShort: 'vertical',
				wgDBname: 'dbname',
				wgContentLanguage: 'xx',
				wgCategories: ['Category', 'Another Category', 'YetAnother Category']
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function() {return urlBuilderMock;}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			ord: 7,
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			subdomain: 'sub',
			tile: 3
		});

		expect(paramsPassed.cat).toEqual(['category', 'another_category', 'yetanother_category']);
	});

	it('getUrl abTest info', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'example.org'}
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock,
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function() {return urlBuilderMock;}
			},
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
			dartHelper1,
			dartHelper2,
			dartHelper3,
			paramKey,
			abParamEmpty;

		paramsPassed = {};
		dartHelper1 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock, abTestMock);
		dartHelper1.getUrl({});
		expect(paramsPassed.ab).toEqual(['17_34', '19_45', '76_112'], 'ab params passed');

		paramsPassed = {};
		dartHelper2 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock, abTestMockEmpty);
		dartHelper2.getUrl({});
		abParamEmpty = !paramsPassed.ab || paramsPassed.ab.length === 0;
		expect(abParamEmpty).toBeTruthy('no ab param passed when no experiment is active');

		paramsPassed = {};
		dartHelper3 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock, abTestMockNone);
		dartHelper3.getUrl({});
		abParamEmpty = !paramsPassed.ab || paramsPassed.ab.length === 0;
		expect(abParamEmpty).toBeTruthy('no ab param passed when AbTesting is not passed to module');
	});



// Very specific tests for hubs:

	it('getUrl Hub page: video games', function() {
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
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock = {hasPreFooters: function() {return true;}},
			paramsPassed = {},
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			ord: 7,
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			tile: 3
		});

		expect(paramsPassed.s0).toBe('hub');
		expect(paramsPassed.s1).toBe('_gaming_hub');
		expect(paramsPassed.s2).toBe('hub');
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('www');
		expect(paramsPassed.pos).toBe('SLOT_NAME');
		expect(paramsPassed.lang).toBe('en');
		expect(paramsPassed.dis).toBe('large');
		expect(paramsPassed.hasp).toBe('yes');
		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.sz).toBe('100x200');
		expect(paramsPassed.tile).toBe(3);

		expect(prefixPassed).toBe('adj/wka.hub/_gaming_hub/hub');
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
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock = {hasPreFooters: function() {return true;}},
			paramsPassed = {},
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			ord: 7,
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			subdomain: 'sub',
			tile: 3
		});

		expect(paramsPassed.s0).toBe('hub');
		expect(paramsPassed.s1).toBe('_ent_hub');
		expect(paramsPassed.s2).toBe('hub');
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('www');
		expect(paramsPassed.pos).toBe('SLOT_NAME');
		expect(paramsPassed.lang).toBe('en');
		expect(paramsPassed.dis).toBe('large');
		expect(paramsPassed.hasp).toBe('yes');
		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.sz).toBe('100x200');
		expect(paramsPassed.tile).toBe(3);

		expect(prefixPassed).toBe('adj/wka.hub/_ent_hub/hub');
	});

	it('getUrl Hub page: lifestyle', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'www.wikia.com'},
				cityShort: 'wikia',
				cscoreCat: 'Lifestyle',
				wgDBname: 'dbname',
				wgContentLanguage: 'en',
				wgWikiaHubType: 'life',
				wikiaPageIsHub: true
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock = {hasPreFooters: function() {return true;}},
			paramsPassed = {},
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			ord: 7,
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			subdomain: 'sub',
			tile: 3
		});

		expect(paramsPassed.s0).toBe('hub');
		expect(paramsPassed.s1).toBe('_life_hub');
		expect(paramsPassed.s2).toBe('hub');
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('www');
		expect(paramsPassed.pos).toBe('SLOT_NAME');
		expect(paramsPassed.lang).toBe('en');
		expect(paramsPassed.dis).toBe('large');
		expect(paramsPassed.hasp).toBe('yes');
		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.sz).toBe('100x200');
		expect(paramsPassed.tile).toBe(3);

		expect(prefixPassed).toBe('adj/wka.hub/_life_hub/hub');
	});

	it('getUrl Hub page: bogus one', function() {
		var logMock = function() {},
			windowMock = {
				location: {hostname: 'www.wikia.com'},
				cityShort: 'wikia',
				cscoreCat: 'Wikia',
				wgDBname: 'dbname',
				wgContentLanguage: 'en',
				wgWikiaHubType: 'life',
				wikiaPageIsHub: true
			},
			documentMock = {documentElement: {}, body: {clientWidth: 1300}},
			adLogicShortPageMock = {hasPreFooters: function() {return true;}},
			paramsPassed = {},
			prefixPassed,
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {
				urlBuilder: function(domain, prefix) {
					prefixPassed = prefix;
					return urlBuilderMock;
				}
			},
			dartHelper = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMock, dartUrlMock);

		dartHelper.getUrl({
			ord: 7,
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			subdomain: 'sub',
			tile: 3
		});

		expect(paramsPassed.s0).toBe('hub');
		expect(paramsPassed.s1).toBe('_life_hub');
		expect(paramsPassed.s2).toBe('hub');
		expect(paramsPassed.dmn).toBe('wikiacom');
		expect(paramsPassed.hostpre).toBe('www');
		expect(paramsPassed.pos).toBe('SLOT_NAME');
		expect(paramsPassed.lang).toBe('en');
		expect(paramsPassed.dis).toBe('large');
		expect(paramsPassed.hasp).toBe('yes');
		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.sz).toBe('100x200');
		expect(paramsPassed.tile).toBe(3);

		expect(prefixPassed).toBe('adj/wka.hub/_life_hub/hub');
	});
});
