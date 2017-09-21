/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.video.player.ui.progressBar', function () {
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
			domElementTweaker: {
				forceRepaint: noop
			},
			log: noop,
			params: {},
			video: {
				container: {
					appendChild: function (element) {
						mocks.video.progressBar = element;
					}
				},
				addEventListener: noop,
				getRemainingTime: function () {
					return 5;
				}
			},
			videoBroken: {
				container: {
					appendChild: function (element) {
						mocks.video.progressBar = element;
					}
				},
				addEventListener: noop,
				getRemainingTime: noop
			}
		},
		progressBar;

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.ui.progressBar'](
			mocks.domElementTweaker,
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		progressBar = getModule();

		mocks.log.levels = {};
	});

	it('Start progressBar object with correct interface', function () {
		progressBar.add(mocks.video, mocks.params);

		expect(typeof mocks.video.progressBar.pause).toBe('function');
		expect(typeof mocks.video.progressBar.reset).toBe('function');
		expect(typeof mocks.video.progressBar.start).toBe('function');
	});

	it('Start currentTime element with transitionDuration and width when video returns proper time', function () {
		progressBar.add(mocks.video, mocks.params);
		mocks.video.progressBar.start();

		expect(mocks.video.progressBar.currentTime.style.transitionDuration).toBe('5s');
		expect(mocks.video.progressBar.currentTime.style.width).toBe('100%');
	});

	it('Start currentTime element with width when video has broken time time', function () {
		progressBar.add(mocks.videoBroken, mocks.params);
		mocks.video.progressBar.start();

		expect(mocks.video.progressBar.currentTime.style.transitionDuration).toBeFalsy();
		expect(mocks.video.progressBar.currentTime.style.width).toBe('0');
	});

	it('Pause currentTime by setting current width', function () {
		progressBar.add(mocks.video, mocks.params);
		mocks.video.progressBar.currentTime.offsetWidth = 150;
		mocks.video.progressBar.offsetWidth = 200;

		mocks.video.progressBar.pause();

		expect(mocks.video.progressBar.currentTime.style.width).toBe('75%');
	});

	it('Reset currentTime by setting removing width and transitionDuration', function () {
		progressBar.add(mocks.video, mocks.params);

		mocks.video.progressBar.start();
		mocks.video.progressBar.reset();

		expect(mocks.video.progressBar.currentTime.style.width).toBe('0');
		expect(mocks.video.progressBar.currentTime.style.transitionDuration).toBeFalsy();
	});
});
