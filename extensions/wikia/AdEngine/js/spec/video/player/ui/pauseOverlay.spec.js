/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.player.ui.pauseOverlay', function () {
	'use strict';

	function noop () {}

	var mocks = {
			doc: {
				createElement: function () {
					return {
						addEventListener: function (name, callback) {
							this.callback = callback;
						},
						classList: {
							add: noop
						},
						click: function () {
							var event = {
								preventDefault: noop
							};
							this.callback(event);
						}
					};
				}
			},
			log: noop,
			video: {
				container: {
					appendChild: function (element) {
						mocks.video.pauseOverlay = element;
					}
				},
				isPaused: function () {
					return this.paused;
				},
				paused: true,
				pause: function () {
					this.paused = true;
				},
				resume: function () {
					this.paused = false;
				},
				stop: noop
			}
		},
		pauseOverlay;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.pauseOverlay'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.log.levels = {};
		mocks.video.pauseOverlay = null;

		pauseOverlay = getModule();
	});

	it('Click on overlay triggers video resume/pause actions', function () {
		pauseOverlay.add(mocks.video);

		mocks.video.pauseOverlay.click();
		expect(mocks.video.paused).toBeFalsy();

		mocks.video.pauseOverlay.click();
		expect(mocks.video.paused).toBeTruthy();
	});
});
