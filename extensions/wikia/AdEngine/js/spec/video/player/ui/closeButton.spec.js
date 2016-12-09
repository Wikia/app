/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.player.ui.closeButton', function () {
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
							var event = {
								preventDefault: noop
							};
							this.callback(event);
						},
						style: {}
					};
				}
			},
			log: noop,
			video: {
				container: {
					appendChild: function (element) {
						mocks.video.closeButton = element;
					}
				},
				stop: noop
			}
		},
		closeButton;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.closeButton'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.log.levels = {};
		mocks.video.closeButton = null;

		closeButton = getModule();
	});

	it('Click on closeButton triggers video stop method', function () {
		spyOn(mocks.video, 'stop');
		closeButton.add(mocks.video);

		mocks.video.closeButton.click();

		expect(mocks.video.stop).toHaveBeenCalled();
	});
});
