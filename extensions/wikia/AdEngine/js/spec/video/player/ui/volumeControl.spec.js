/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.video.player.ui.volumeControl', function () {
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
							add: noop,
							remove: noop
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
				addEventListener: noop,
				ima: {
					dispatchEvent: noop
				},
				container: {
					appendChild: function (element) {
						mocks.video.volumeControl = element;
					},
					querySelector: noop
				},
				isMuted: function () {
					return this.muted;
				},
				volumeToggle: noop,
				muted: false,
				setVolume: function (volume) {
					this.muted = volume === 0;
				},
				stop: noop
			}
		},
		volumeControl;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.volumeControl'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.log.levels = {};
		mocks.video.pauseOverlay = null;

		volumeControl = getModule();
	});

	it('Click on volume control triggers video volume toggle action', function () {
		volumeControl.add(mocks.video, {});

		spyOn(mocks.video, 'volumeToggle');

		mocks.video.volumeControl.click();
		expect(mocks.video.volumeToggle).toHaveBeenCalled();
	});
});
