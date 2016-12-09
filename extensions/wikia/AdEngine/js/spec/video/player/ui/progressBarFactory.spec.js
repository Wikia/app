/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.video.player.ui.progressBarFactory', function () {
	'use strict';

	function noop () {}

	var mocks = {
			doc: {
				createElement: function () {
					return {
						appendChild: noop,
						classList: {
							add: noop
						},
						style: {}
					};
				}
			},
			log: noop,
			video: {
				getRemainingTime: function () {
					return 5;
				}
			},
			videoBroken: {
				getRemainingTime: noop
			}
		},
		progressBar;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.progressBarFactory'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		var progressBarFactory = getModule();

		progressBar = progressBarFactory.create();
		mocks.log.levels = {};
	});

	it('Creates progressBar object with correct interface', function () {
		expect(typeof progressBar.update).toBe('function');
		expect(typeof progressBar.pause).toBe('function');
	});

	it('Updates currentTime element with transitionDuration and width when video returns proper time', function () {
		progressBar.update(mocks.video);

		expect(progressBar.currentTime.style.transitionDuration).toBe('5s');
		expect(progressBar.currentTime.style.width).toBe('100%');
	});

	it('Updates currentTime element with width when video has broken time time', function () {
		progressBar.update(mocks.videoBroken);

		expect(progressBar.currentTime.style.transitionDuration).toBe(undefined);
		expect(progressBar.currentTime.style.width).toBe('0');
	});

	it('Pauses currentTime by setting current width', function () {
		progressBar.currentTime.offsetWidth = 150;
		progressBar.container.offsetWidth = 200;

		progressBar.pause();

		expect(progressBar.currentTime.style.width).toBe('75%');
	});
});
