/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.template.modal', function () {
	'use strict';

	function noop() {
		return;
	}

	var adsModule = {
			openLightbox: noop
		},
		mocks = {
			log: noop,
			adContext: {
				getContext: function () {
					return {
						targeting: {
							skin: 'mercury'
						}
					};
				}
			},
			adHelper: {
				throttle: noop
			},
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
			mocks.adContext,
			mocks.adHelper,
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
