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
			video: {
				stop: noop
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

		closeButton = closeButtonFactory.create(mocks.video);
		mocks.log.levels = {};
	});

	it('Click on closeButton triggers video stop method', function () {
		spyOn(mocks.video, 'stop');

		closeButton.click();

		expect(mocks.video.stop).toHaveBeenCalled();
	});
});
