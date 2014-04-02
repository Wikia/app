describe('WikiaDartHelper', function(){
	it('getUrl returns whatever comes from dartUrl.urlBuilder.toString method', function() {
		var logMock = function() {},
			expected = 'http://some/url/from/dart+helper',
			urlBuilderMock = {
				addParam: function(key, value) {},
				addString: function() {},
				toString: function() {return expected;}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			adLogicPageParamsMock = {
				getPageLevelParams: function() {return {}},
				getCustomKeyValues: function() {return ''}
			},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock),
			actual = dartHelper.getUrl({
				slotsize: '100x200',
				slotname: 'SLOT_NAME',
				tile: 3
			});

		expect(actual).toBe(expected);
	});

	it('getUrl respects page level params', function() {
		var undef,
			logMock = function() {},
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			adLogicPageParamsMock = {
				getPageLevelParams: function() {
					return {
						key1: 'value1',
						key2: 'value2',
						key3: ['val3', 'val4'],
						key4: false
					};
				},
				getCustomKeyValues: function() {
					return '';
				}
			},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

		paramsPassed = {};
		dartHelper.getUrl({});
		expect(paramsPassed.key1).toBe('value1', 'key1=value1');
		expect(paramsPassed.key2).toBe('value2', 'key2=value2');
		expect(paramsPassed.key3).toEqual(['val3', 'val4'], 'array');
		expect(paramsPassed.key4).toBe(undef, 'falsy value not passed');
	});

	it('getUrl builds properly the domain and prefix', function() {
		var logMock = function() {},
			adLogicPageParamsMock = {
				getPageLevelParams: function() {
					return {
						s0: 'vertical',
						s1: '_dbname',
						s2: 'pagetype'
					};
				},
				getCustomKeyValues: function() {
					return '';
				}
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
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

		dartHelper.getUrl({
			subdomain: 'sub'
		});

		expect(domainPassed).toBe('sub.doubleclick.net', 'domain');
		expect(prefixPassed).toBe('adj/wka.vertical/_dbname/pagetype', 'prefix');
	});

	it('getUrl passes slot params correctly', function() {
		var logMock = function() {},
			adLogicPageParamsMock = {
				getPageLevelParams: function() {return {};},
				getCustomKeyValues: function() {return '';}
			},
			paramsPassed = {},
			urlBuilderMock = {
				addParam: function(key, value) {
					paramsPassed[key] = value;
				},
				addString: function() {}
			},
			dartUrlMock = {urlBuilder: function() {return urlBuilderMock;}},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

		dartHelper.getUrl({
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
			tile: 3
		});

		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.pos).toBe('SLOT_NAME');
		expect(paramsPassed.sz).toBe('100x200');
		expect(paramsPassed.tile).toBe(3);
	});

	it('getUrl sets global params correctly', function() {
		var logMock = function() {},
			adLogicPageParamsMock = {
				getPageLevelParams: function() {return {};},
				getCustomKeyValues: function() {return '';}
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
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

		dartHelper.getUrl({});

		expect(paramsPassed.src).toBe('driver');
		expect(paramsPassed.mtfInline).toBe('true');
	});

	it('getUrl Auto tile, same ord', function() {
		var logMock = function() {},
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
			adLogicPageParamsMock = {
				getPageLevelParams: function() {return {};},
				getCustomKeyValues: function() {return '';}
			},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock),
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


// Very specific tests for hubs:

	it('getUrl Hub page: video games', function() {
		var logMock = function() {},
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
			adLogicPageParamsMock = {
				getPageLevelParams: function() {
					return {
						s0: 'hub',
						s1: '_gaming_hub',
						s2: 'hub',
						dmn: 'wikiacom',
						hostpre: 'www',
						lang: 'en',
						dis: 'large',
						hasp: 'yes'
					};
				},
				getCustomKeyValues: function() {
					return '';
				}
			},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

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
			adLogicPageParamsMock = {
				getPageLevelParams: function() {
					return {
						s0: 'hub',
						s1: '_ent_hub',
						s2: 'hub',
						dmn: 'wikiacom',
						hostpre: 'www',
						lang: 'en',
						dis: 'large',
						hasp: 'yes'
					};
				},
				getCustomKeyValues: function() {
					return '';
				}
			},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

		dartHelper.getUrl({
			ord: 7,
			slotsize: '100x200',
			slotname: 'SLOT_NAME',
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
			adLogicPageParamsMock = {
				getPageLevelParams: function() {
					return {
						s0: 'hub',
						s1: '_life_hub',
						s2: 'hub',
						dmn: 'wikiacom',
						hostpre: 'www',
						lang: 'en',
						dis: 'large',
						hasp: 'yes'
					};
				},
				getCustomKeyValues: function() {
					return '';
				}
			},
			dartHelper = WikiaDartHelper(logMock, adLogicPageParamsMock, dartUrlMock);

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
