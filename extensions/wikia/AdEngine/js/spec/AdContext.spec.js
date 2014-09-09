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

		adContext = modules['ext.wikia.adEngine.adContext']({});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgCategories: ['category1', 'category2']
		});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgAdDriverUseCatParam: true
		});
		expect(adContext.getContext().targeting.pageCategories && adContext.getContext().targeting.pageCategories.length).toBeFalsy();

		adContext = modules['ext.wikia.adEngine.adContext']({
			wgCategories: ['category1', 'category2'],
			wgAdDriverUseCatParam: true
		});
		expect(adContext.getContext().targeting.pageCategories).toEqual(['category1', 'category2']);
	});
});
