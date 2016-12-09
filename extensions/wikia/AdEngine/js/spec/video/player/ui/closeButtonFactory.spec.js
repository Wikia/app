/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.player.ui.closeButtonFactory', function () {
	'use strict';

	function noop () {}

	var mocks = {
			doc: {
				createElement: function () {
					return {
						addEventListener: function (name, callback) {
							this.callback = callback;
						},
						appendChild: noop,
						classList: {
							add: noop
						},
						click: function () {
							this.callback();
						},
						style: {}
					};
				}
			},
			log: noop,
			ima: {
				adsManager: {
					stop: noop
				}
			}
		},
		closeButton;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.closeButtonFactory'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		var closeButtonFactory = getModule();

		closeButton = closeButtonFactory.create(mocks.ima);
		mocks.log.levels = {};
	});

	it('Click on closeButton triggers video stop method', function () {
		spyOn(mocks.ima.adsManager, 'stop');

		closeButton.click();

		expect(mocks.ima.adsManager.stop).toHaveBeenCalled();
	});
});
