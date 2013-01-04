/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/WikiaDartHelper.js
 */

module('WikiaDartHelper');

test('getUrl returns whatever comes from dartUrl.urlBuilder.toString method', function() {
	var logMock = function() {},
		windowMock = {
			location: {hostname: 'an.example.org'},
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

	equal(actual, expected);
});

test('getUrl Domain and prefix correct', function() {
	var logMock = function() {},
		windowMock = {
			location: {hostname: 'an.example.org'},
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

	equal(domainPassed, 'sub.doubleclick.net', 'domain');
	equal(prefixPassed, 'adj/wka.vertical/_dbname/article', 'prefix');
});

test('getUrl Simple params correct', function() {
	var logMock = function() {},
		windowMock = {
			location: {hostname: 'an.example.org'},
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

	equal(paramsPassed.s0, 'vertical');
	equal(paramsPassed.s1, '_dbname');
	equal(paramsPassed.s2, 'article');
	equal(paramsPassed.dmn, 'exampleorg');
	equal(paramsPassed.hostpre, 'an');
	equal(paramsPassed.pos, 'SLOT_NAME');
	equal(paramsPassed.lang, 'xx');
	equal(paramsPassed.dis, 'large');
	equal(paramsPassed.src, 'driver');
	equal(paramsPassed.sz, '100x200');
	equal(paramsPassed.tile, 3);
});

test('getUrl default DB name', function() {
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

	equal(paramsPassed.s1, '_wikia', 'in keyword');
	equal(prefixPassed, 'adj/wka.vertical/_wikia/article', 'in prefix');
});

test('getUrl page type', function() {
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

	equal(paramsPassed.s2, 'pagetype', 'in keyword');
	equal(prefixPassed, 'adj/wka.vertical/_dbname/pagetype', 'in prefix');
});

test('getUrl has pre footers', function() {
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
	dartHelper1 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMockTrue, dartUrlMock),
	dartHelper1.getUrl({});
	equal(paramsPassed.hasp, 'yes', 'yes');

	paramsPassed = {};
	dartHelper2 = WikiaDartHelper(logMock, windowMock, documentMock, {}, adLogicShortPageMockFalse, dartUrlMock);
	dartHelper2.getUrl({});
	equal(paramsPassed.hasp, 'no', 'no');
});


test('getUrl Auto tile, same ord', function() {
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

	equal(paramsPassed.tile, 1, 'tile 1');

	expectedOrd = actualOrd;

	ordStringPassed = undef;
	dartHelper.getUrl(anotherParams);
	actualOrd = ordStringPassed.match(/^ord=([0-9]*)\?/)[1];

	equal(paramsPassed.tile, 2, 'tile 2');
	equal(actualOrd, expectedOrd, 'same ord');

	ordStringPassed = undef;
	dartHelper.getUrl(yetAnotherParams);
	actualOrd = ordStringPassed.match(/^ord=([0-9]*)\?/)[1];

	equal(paramsPassed.tile, 3, 'tile 3');
	equal(actualOrd, expectedOrd, 'same ord');
});

test('getUrl Page categories', function() {
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

	deepEqual(paramsPassed.cat, ['category', 'another_category', 'yetanother_category']);
});



// Very specific tests for hubs:

test('getUrl Hub page: video games', function() {
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

	equal(paramsPassed.s0, 'hub');
	equal(paramsPassed.s1, '_gaming_hub');
	equal(paramsPassed.s2, 'hub');
	equal(paramsPassed.dmn, 'wikiacom');
	equal(paramsPassed.hostpre, 'www');
	equal(paramsPassed.pos, 'SLOT_NAME');
	equal(paramsPassed.lang, 'en');
	equal(paramsPassed.dis, 'large');
	equal(paramsPassed.hasp, 'yes');
	equal(paramsPassed.src, 'driver');
	equal(paramsPassed.sz, '100x200');
	equal(paramsPassed.tile, 3);

	equal(prefixPassed, 'adj/wka.hub/_gaming_hub/hub');
});

test('getUrl Hub page: entertainment', function() {
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

	equal(paramsPassed.s0, 'hub');
	equal(paramsPassed.s1, '_ent_hub');
	equal(paramsPassed.s2, 'hub');
	equal(paramsPassed.dmn, 'wikiacom');
	equal(paramsPassed.hostpre, 'www');
	equal(paramsPassed.pos, 'SLOT_NAME');
	equal(paramsPassed.lang, 'en');
	equal(paramsPassed.dis, 'large');
	equal(paramsPassed.hasp, 'yes');
	equal(paramsPassed.src, 'driver');
	equal(paramsPassed.sz, '100x200');
	equal(paramsPassed.tile, 3);

	equal(prefixPassed, 'adj/wka.hub/_ent_hub/hub');
});

test('getUrl Hub page: lifestyle', function() {
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

	equal(paramsPassed.s0, 'hub');
	equal(paramsPassed.s1, '_life_hub');
	equal(paramsPassed.s2, 'hub');
	equal(paramsPassed.dmn, 'wikiacom');
	equal(paramsPassed.hostpre, 'www');
	equal(paramsPassed.pos, 'SLOT_NAME');
	equal(paramsPassed.lang, 'en');
	equal(paramsPassed.dis, 'large');
	equal(paramsPassed.hasp, 'yes');
	equal(paramsPassed.src, 'driver');
	equal(paramsPassed.sz, '100x200');
	equal(paramsPassed.tile, 3);

	equal(prefixPassed, 'adj/wka.hub/_life_hub/hub');
});

test('getUrl Hub page: bogus one', function() {
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

	equal(paramsPassed.s0, 'hub');
	equal(paramsPassed.s1, '_life_hub');
	equal(paramsPassed.s2, 'hub');
	equal(paramsPassed.dmn, 'wikiacom');
	equal(paramsPassed.hostpre, 'www');
	equal(paramsPassed.pos, 'SLOT_NAME');
	equal(paramsPassed.lang, 'en');
	equal(paramsPassed.dis, 'large');
	equal(paramsPassed.hasp, 'yes');
	equal(paramsPassed.src, 'driver');
	equal(paramsPassed.sz, '100x200');
	equal(paramsPassed.tile, 3);

	equal(prefixPassed, 'adj/wka.hub/_life_hub/hub');
});
