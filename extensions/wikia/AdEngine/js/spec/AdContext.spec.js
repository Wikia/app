/*global describe, it, modules, expect*/
/*jshint maxlen:200*/
describe('AdContext', function () {
	'use strict';

	var geoMock = {
		getCountryCode: function () { return 'XX'; }
	};

	it('makes opts.showAds true when wgShowAds = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: true
		}, {}, geoMock, {});
		expect(adContext.getContext().opts.showAds).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: false
		}, {}, geoMock, {});
		expect(adContext.getContext().opts.showAds).toBeFalsy();
	});

	it('makes opts.showAds false for sony tvs', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: true
		}, {
			referrer: 'info.tvsideview.sony.net'
		}, geoMock, {});
		expect(adContext.getContext().opts.showAds).toBeFalsy();
	});

	it('makes opts.usePostScribe true when wgUsePostScribe = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgUsePostScribe: false
		}, {}, geoMock, {});
		expect(adContext.getContext().opts.usePostScribe).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgUsePostScribe: true
		}, {}, geoMock, {});
		expect(adContext.getContext().opts.usePostScribe).toBeTruthy();
	});

	it('makes opts.usePostScribe true when wgAdDriverUseSevenOneMedia = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgAdDriverUseSevenOneMedia: true
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

	it('makes opts.alwaysCallDart true when country in instantGlobals.wgAdDriverAlwaysCallDartInCountries', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({}, {}, geoMock, {
			wgAdDriverAlwaysCallDartInCountries: ['XX']
		});
		expect(adContext.getContext().opts.alwaysCallDart).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext']({},  {}, geoMock, {
			wgAdDriverAlwaysCallDartInCountries: ['YY']
		});
		expect(adContext.getContext().opts.alwaysCallDart).toBeFalsy();
	});
});
