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
		progressBarFactory;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.progressBarFactory'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		progressBarFactory = getModule();

		mocks.log.levels = {};
	});

	it('Start progressBar object with correct interface', function () {
		var progressBar = progressBarFactory.create(mocks.video);

		expect(typeof progressBar.pause).toBe('function');
		expect(typeof progressBar.reset).toBe('function');
		expect(typeof progressBar.start).toBe('function');
	});

	it('Start currentTime element with transitionDuration and width when video returns proper time', function () {
		var progressBar = progressBarFactory.create(mocks.video);
		progressBar.start();

		expect(progressBar.currentTime.style.transitionDuration).toBe('5s');
		expect(progressBar.currentTime.style.width).toBe('100%');
	});

	it('Start currentTime element with width when video has broken time time', function () {
		var progressBar = progressBarFactory.create(mocks.videoBroken);
		progressBar.start();

		expect(progressBar.currentTime.style.transitionDuration).toBeFalsy();
		expect(progressBar.currentTime.style.width).toBe('0');
	});

	it('Pause currentTime by setting current width', function () {
		var progressBar = progressBarFactory.create(mocks.video);
		progressBar.currentTime.offsetWidth = 150;
		progressBar.container.offsetWidth = 200;

		progressBar.pause();

		expect(progressBar.currentTime.style.width).toBe('75%');
	});

	it('Reset currentTime by setting removing width and transitionDuration', function () {
		var progressBar = progressBarFactory.create(mocks.video);

		progressBar.start();
		progressBar.reset();

		expect(progressBar.currentTime.style.width).toBe('0');
		expect(progressBar.currentTime.style.transitionDuration).toBeFalsy();
	});
});
