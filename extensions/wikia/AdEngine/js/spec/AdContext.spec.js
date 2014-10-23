/*global describe, it, modules, expect*/
describe('AdContext', function () {
	'use strict';

	it('makes opts.showAds true when wgShowAds = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: true
		});
		expect(adContext.getContext().opts.showAds).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: false
		});
		expect(adContext.getContext().opts.showAds).toBeFalsy();
	});

	it('makes opts.showAds false for sony tvs', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: true
		}, {
			referrer: 'info.tvsideview.sony.net'
		});
		expect(adContext.getContext().opts.showAds).toBeFalsy();
	});

	it('makes opts.usePostScribe true when wgUsePostScribe = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgUsePostScribe: false
		});
		expect(adContext.getContext().opts.usePostScribe).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgUsePostScribe: true
		});
		expect(adContext.getContext().opts.usePostScribe).toBeTruthy();
	});

	it('makes opts.usePostScribe true when wgAdDriverUseSevenOneMedia = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgAdDriverUseSevenOneMedia: true
		});
		expect(adContext.getContext().opts.usePostScribe).toBeTruthy();
	});

	it('makes targeting.pageCategories filled with categories properly', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {}}
		});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {}},
			wgCategories: ['Category1', 'Category2'],
			Wikia: {article: {article: {categories: [{title: 'Category1', url: '/wiki/Category:Category1'}, {title: 'Category2', url: '/wiki/Category:Category2'}]}}}
		});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {targeting: {enablePageCategories: true}}}
		});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {targeting: {enablePageCategories: true}}},
			wgCategories: ['Category1', 'Category2'],
		});
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);

		adContext = modules['ext.wikia.adEngine.adContext']({
			ads: {context: {targeting: {enablePageCategories: true}}},
			Wikia: {article: {article: {categories: [{title: 'Category1', url: '/wiki/Category:Category1'}, {title: 'Category2', url: '/wiki/Category:Category2'}]}}}
		});
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);
	});
});
