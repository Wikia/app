/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.template.modal', function () {
	'use strict';

	function noop() {
		return;
	}

	var adsModule = {
			createLightbox: noop,
			showLightbox: noop
		},
		mocks = {
			adHelper: {
				throttle: noop
			},
			adDetect: {},
			modalHandlerFactory: {
				create: function () {
					return {
						create: noop,
						show: noop,
						getExpansionModel: function () {
							return {
								availableHeightRatio: 1,
								availableWidthRatio: 1,
								heightSubtract: 80,
								minWidth: 100,
								minHeight: 100,
								maximumRatio: 3
							};
						}
					};
				}
			},
			log: noop,
			iframeWriter: {
				getIframe: noop
			},
			win: {
				addEventListener: noop,
				Mercury: {
					Modules: {
						Ads: {
							getInstance: function () {
								return adsModule;
							}
						}
					}
				}
			},
			doc: {
				createElement: function () {
					return {
						appendChild: noop,
						style: {}
					};
				}
			},
			params: {
				width: 100,
				height: 100,
				scalable: true
			}
		};

	beforeEach(function () {
		mocks.win.innerWidth = 0;
		mocks.win.innerHeight = 0;
	});

	function getModule() {
		return modules['ext.wikia.adEngine.template.modal'](
			mocks.adHelper,
			mocks.adDetect,
			mocks.modalHandlerFactory,
			mocks.doc,
			mocks.log,
			mocks.iframeWriter,
			mocks.win
		);
	}

	it('Ad should be scaled by height', function () {
		var myIframe = { style: {} };
		spyOn(mocks.iframeWriter, 'getIframe').and.returnValue(myIframe);

		mocks.win.innerWidth = 300;
		mocks.win.innerHeight = 280;
		getModule().show(mocks.params);
		expect(myIframe.style.transform).toBe('scale(2)');
	});

	it('Ad should be scaled by width', function () {
		var myIframe = { style: {} };
		spyOn(mocks.iframeWriter, 'getIframe').and.returnValue(myIframe);

		mocks.win.innerWidth = 300;
		mocks.win.innerHeight = 600;
		getModule().show(mocks.params);
		expect(myIframe.style.transform).toBe('scale(3)');
	});

});
