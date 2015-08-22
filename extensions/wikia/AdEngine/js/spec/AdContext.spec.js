/*global describe, it, modules, expect, spyOn*/
/*jshint maxlen:200*/
describe('AdContext', function () {
	'use strict';

	function noop() {
		return;
	}

	function getModule() {
		return modules['ext.wikia.adEngine.adContext'](
			mocks.win,
			mocks.doc,
			mocks.geo,
			mocks.instantGlobals,
			mocks.Querystring,
			mocks.abTesting
		);
	}

	var mocks = {
			abTesting: {},
			geo: {
				getCountryCode: function () {
					return 'XX';
				}
			},
			instantGlobals: {},
			win: {},
			Querystring: function () {
				return mocks.querystring;
			},
			querystring: {
				getVal: noop
			},
			callback: noop
		},
		queryParams = [
			'liftium',
			'openx',
			'turtle'
		];

	it(
		'fills getContext() with context, targeting, providers and forcedProvider ' +
		'even for empty (or missing) ads.context',
		function () {
			var adContext = getModule();

			expect(adContext.getContext().opts).toEqual({});
			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
			expect(adContext.getContext().providers).toEqual({});
			expect(adContext.getContext().forcedProvider).toEqual(null);

			mocks.win = {ads: {context: {}}};
			adContext = getModule();
			expect(adContext.getContext().opts).toEqual({});
			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
			expect(adContext.getContext().providers).toEqual({});
			expect(adContext.getContext().forcedProvider).toEqual(null);
		}
	);

	it('copies ads.context into the returned context', function () {
		var adContext;

		mocks.win = {
			ads: {
				context: {
					opts: {
						showAds: true,
						xxx: true
					},
					targeting: {
						yyy: true
					},
					providers: {
						someProvider: true,
						someProviderProperty: 7
					}
				}
			}
		};

		adContext = getModule();
		expect(adContext.getContext().opts.showAds).toBe(true);
		expect(adContext.getContext().opts.xxx).toBe(true);
		expect(adContext.getContext().targeting.yyy).toBe(true);
		expect(adContext.getContext().providers.someProvider).toBe(true);
		expect(adContext.getContext().providers.someProviderProperty).toBe(7);
	});

	it('makes opts.showAds false for sony tvs', function () {
		var adContext;

		mocks.win = {
			ads: {
				context: {
					opts: {
						showAds: true
					}
				}
			}
		};

		mocks.doc = {
			referrer: 'info.tvsideview.sony.net'
		};

		adContext = getModule();
		expect(adContext.getContext().opts.showAds).toBeFalsy();
	});

	it('makes targeting.pageCategories filled with categories properly', function () {
		var adContext;

		mocks.win = {
			ads: {context: {}}
		};
		adContext = getModule();
		expect(
			adContext.getContext().targeting.pageCategories &&
			adContext.getContext().targeting.pageCategories.length
		).toBeFalsy();

		mocks.win = {
			ads: {context: {}},
			wgCategories: ['Category1', 'Category2'],
			Wikia: {article: {article: {
				categories: [
					{title: 'Category1', url: '/wiki/Category:Category1'},
					{title: 'Category2', url: '/wiki/Category:Category2'}
				]
			}}}
		};
		adContext = getModule();
		expect(
			adContext.getContext().targeting.pageCategories &&
			adContext.getContext().targeting.pageCategories.length
		).toBeFalsy();

		mocks.win = {
			ads: {context: {targeting: {enablePageCategories: true}}}
		};
		adContext = getModule();
		expect(
			adContext.getContext().targeting.pageCategories &&
			adContext.getContext().targeting.pageCategories.length
		).toBeFalsy();

		mocks.win = {
			ads: {context: {targeting: {enablePageCategories: true}}},
			wgCategories: ['Category1', 'Category2']
		};
		adContext = getModule();
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);

		mocks.win = {
			ads: {context: {targeting: {enablePageCategories: true}}},
			Wikia: {
				article: {
					article: {
						categories: [
							{title: 'Category1', url: '/wiki/Category:Category1'},
							{title: 'Category2', url: '/wiki/Category:Category2'}
						]
					}
				}
			}
		};
		adContext = getModule();
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);
	});

	it(
		'makes targeting.enableKruxTargeting false when disaster recovery instant global variable is set to true',
		function () {
			var adContext;
			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};

			mocks.instantGlobals = {wgAdDriverKruxCountries: ['XX']};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['XX', 'ZZ'],
				wgSitewideDisableKrux: false
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['XX', 'ZZ'],
				wgSitewideDisableKrux: true
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['XX', 'ZZ', 'YY'],
				wgSitewideDisableKrux: 0
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['XX', 'ZZ'],
				wgSitewideDisableKrux: 1
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();
		}
	);

	it('makes providers.turtle true when country in instantGlobals.wgAdDriverTurtleCountries', function () {
		var adContext;

		mocks.win = {};
		mocks.instantGlobals = {wgAdDriverTurtleCountries: ['XX', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().providers.turtle).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverTurtleCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().providers.turtle).toBeFalsy();
	});

	it('makes providers.openX true when country in instantGlobals.wgAdDriverOpenXCountries', function () {
		var adContext;

		mocks.win = {};
		mocks.instantGlobals = {wgAdDriverOpenXCountries: ['AA', 'XX', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().providers.openX).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverOpenXCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().providers.openX).toBeFalsy();
	});

	it('calls whoever registered with addCallback each time setContext is called', function () {
		var adContext;

		spyOn(mocks, 'callback');

		mocks.win = {};
		mocks.instantGlobals = {};
		adContext = getModule();
		adContext.addCallback(mocks.callback);
		adContext.setContext({});
		expect(mocks.callback).toHaveBeenCalled();
	});

	it('enables high impact slot when country in instantGlobals.wgAdDriverHighImpactSlotCountries', function () {
		var adContext;

		mocks.win = {ads: {context: {slots: {invisibleHighImpact: true}}}};
		mocks.instantGlobals = {wgAdDriverHighImpactSlotCountries: ['HH', 'XX', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().slots.invisibleHighImpact).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverHighImpactSlotCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().slots.invisibleHighImpact).toBeFalsy();
	});

	it('enables high impact slot when url param highimpactslot is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'highimpactslot' ?  '1' : '0';
		});

		expect(getModule().getContext().slots.invisibleHighImpact).toBeTruthy();
	});

	it('query param is being passed to the adContext properly', function () {
		spyOn(mocks.querystring, 'getVal');

		Object.keys(queryParams).forEach(function (k) {
			var adContext;

			mocks.win = {};
			mocks.instantGlobals = {};
			mocks.querystring.getVal.and.returnValue(queryParams[k]);

			adContext = getModule();
			expect(mocks.querystring.getVal).toHaveBeenCalled();

			adContext = adContext.getContext();
			expect(adContext.forcedProvider).toEqual(queryParams[k]);
		});
	});

	it('enables krux when country in instantGlobals.wgAdDriverKruxCountries', function () {
		var adContext;
		mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
		mocks.instantGlobals = {wgAdDriverKruxCountries: ['AA', 'XX', 'BB']};
		adContext = getModule();
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverKruxCountries: ['AA', 'BB', 'CC']};
		adContext = getModule();
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();
	});

	it('disables krux when wiki is directed at children', function () {
		var adContext;

		mocks.win = {ads: {context: {targeting: {wikiDirectedAtChildren: false, enableKruxTargeting: true}}}};
		mocks.instantGlobals = {wgAdDriverKruxCountries: ['XX']};
		adContext = getModule();
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

		mocks.win = {ads: {context: {targeting: {wikiDirectedAtChildren: true, enableKruxTargeting: true}}}};
		mocks.instantGlobals = {wgAdDriverKruxCountries: ['XX']};
		adContext = getModule();
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();
	});
});
