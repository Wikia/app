/*global describe, it, modules, expect*/
describe('AdContext', function () {
	'use strict';

	it('makes opts.showAds true when wgShowAds = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: true
		});
		expect(adContext.opts.showAds).toBeTruthy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: false
		});
		expect(adContext.opts.showAds).toBeFalsy();
	});

	it('makes opts.showAds false for sony tvs', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgShowAds: true
		}, {
			referrer: 'info.tvsideview.sony.net'
		});
		expect(adContext.opts.showAds).toBeFalsy();
	});

	it('makes opts.usePostScribe true when wgUsePostScribe = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgUsePostScribe: false
		});
		expect(adContext.opts.usePostScribe).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgUsePostScribe: true
		});
		expect(adContext.opts.usePostScribe).toBeTruthy();
	});

	it('makes opts.usePostScribe true when wgAdDriverUseSevenOneMedia = true', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgAdDriverUseSevenOneMedia: true
		});
		expect(adContext.opts.usePostScribe).toBeTruthy();
	});

	it('makes targeting.pageCategories filled with categories properly', function () {
		var adContext;

		adContext = modules['ext.wikia.adEngine.adContext']({});
		expect(adContext.targeting.pageCategories && adContext.targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgCategories: ['category1', 'category2']
		});
		expect(adContext.targeting.pageCategories && adContext.targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgAdDriverUseCatParam: true
		});
		expect(adContext.targeting.pageCategories && adContext.targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgCategories: ['category1', 'category2'],
			wgAdDriverUseCatParam: true
		});
		expect(adContext.targeting.pageCategories).toEqual(['category1', 'category2']);
	});
});
