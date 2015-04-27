/*global describe, it, modules, expect, spyOn*/
/*jshint maxlen:200*/
describe('AdContext', function () {
	'use strict';

	var geoMock = {
		getCountryCode: function () { return 'XX'; }
	};

	it('fills getContext() with context, targeting, providers and forceProviders even for empty (or missing) ads.context', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({}, {}, geoMock, {});
		expect(adContext.getContext().opts).toEqual({});
		expect(adContext.getContext().targeting).toEqual({});
		expect(adContext.getContext().providers).toEqual({});
		expect(adContext.getContext().forceProviders).toEqual({});

		adContext = modules['ext.wikia.adEngine.adContext']({ads: {context: {}}}, {}, geoMock, {});
		expect(adContext.getContext().opts).toEqual({});
		expect(adContext.getContext().targeting).toEqual({});
		expect(adContext.getContext().providers).toEqual({});
		expect(adContext.getContext().forceProviders).toEqual({});
	});

	it('copies ads.context into the returned context', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
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
		}, {}, geoMock, {});
		expect(adContext.getContext().opts.showAds).toBe(true);
		expect(adContext.getContext().opts.xxx).toBe(true);
		expect(adContext.getContext().targeting.yyy).toBe(true);
		expect(adContext.getContext().providers.someProvider).toBe(true);
		expect(adContext.getContext().providers.someProviderProperty).toBe(7);
	});

	it('makes opts.showAds false for sony tvs', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {
				context: {
					opts: {
						showAds: true
					}
				}
			}
		}, {
			referrer: 'info.tvsideview.sony.net'
		}, geoMock, {});
		expect(adContext.getContext().opts.showAds).toBeFalsy();
	});

	it('makes opts.usePostScribe true when wgAdDriverUseSevenOneMedia = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {
				context: {
					providers: {
						sevenOneMedia: true
					}
				}
			}
		}, {}, geoMock, {});
		expect(adContext.getContext().opts.usePostScribe).toBeTruthy();
	});

	it('makes targeting.pageCategories filled with categories properly', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {}}
		}, {}, geoMock, {});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {}},
			wgCategories: ['Category1', 'Category2'],
			Wikia: {article: {article: {categories: [{title: 'Category1', url: '/wiki/Category:Category1'}, {title: 'Category2', url: '/wiki/Category:Category2'}]}}}
		}, {}, geoMock, {});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {targeting: {enablePageCategories: true}}}
		}, {}, geoMock, {});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {targeting: {enablePageCategories: true}}},
			wgCategories: ['Category1', 'Category2']
		}, {}, geoMock, {});
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {targeting: {enablePageCategories: true}}},
			Wikia: {article: {article: {categories: [{title: 'Category1', url: '/wiki/Category:Category1'}, {title: 'Category2', url: '/wiki/Category:Category2'}]}}}
		}, {}, geoMock, {});
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);
	});

	it('makes targeting.enableKruxTargeting false when disaster recovery instant global variable is set to true', function () {
		var adContext,
			getWindowMock = function() {
				return {ads: {
					context: {
						targeting: {
							enableKruxTargeting: true
						}
					}
				}};
			};

		adContext = modules['ext.wikia.adEngine.adContext'](getWindowMock(), {}, geoMock, {});
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext'](getWindowMock(), {}, geoMock, {
			wgSitewideDisableKrux: false
		});
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext'](getWindowMock(),  {}, geoMock, {
			wgSitewideDisableKrux: true
		});
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext'](getWindowMock(), {}, geoMock, {
			wgSitewideDisableKrux: 0
		});
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext'](getWindowMock(),  {}, geoMock, {
			wgSitewideDisableKrux: 1
		});
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();
	});

	it('makes providers.turtle true when country in instantGlobals.wgAdDriverTurtleCountries', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({}, {}, geoMock, {
			wgAdDriverTurtleCountries: ['XX', 'ZZ']
		});
		expect(adContext.getContext().providers.turtle).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext']({},  {}, geoMock, {
			wgAdDriverTurtleCountries: ['YY']
		});
		expect(adContext.getContext().providers.turtle).toBeFalsy();
	});

	it('calls whoever registered with addCallback each time setContext is called', function () {
		var adContext,
			mocks = {
				callback: function () {
					return;
				}
			};

		spyOn(mocks, 'callback');

		adContext = modules['ext.wikia.adEngine.adContext']({}, {}, geoMock, {});
		adContext.addCallback(mocks.callback);
		adContext.setContext({});
		expect(mocks.callback).toHaveBeenCalled();
	});

	it('enables high impact slot when country in instantGlobals.wgAdDriverHighImpactSlotCountries', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({}, {}, geoMock, {
			wgAdDriverHighImpactSlotCountries: ['XX', 'ZZ']
		});
		expect(adContext.getContext().opts.enableInvisibleHighImpactSlot).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext']({},  {}, geoMock, {
			wgAdDriverHighImpactSlotCountries: ['YY']
		});
		expect(adContext.getContext().opts.enableInvisibleHighImpactSlot).toBeFalsy();
	});
});
