/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.video.player.uiTemplate', function () {
	'use strict';

	var UI = {
			CLOSE_BUTTON: 'closeButton',
			REPLAY_OVERLAY: 'replayOverlay'
		},
		noop = function () {},
		mocks = {
			log: noop,
			videoSettings: {
				isAutoPlay: noop,
				isSplitLayout: noop
			}
		};

	mocks.log.levels = { debug: 1 };

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.uiTemplate'](mocks.log);
	}

	beforeEach(function () {
		spyOn(mocks.videoSettings, 'isAutoPlay');
		mocks.videoSettings.isAutoPlay.and.returnValue(true);

		spyOn(mocks.videoSettings, 'isSplitLayout');
		mocks.videoSettings.isSplitLayout.and.returnValue(false);
	});

	it('Should show close button element if there is no autoplay and there is no split screen', function () {
		var UITemplate = getModule(),
			videoSettings = mocks.videoSettings,
			result;

		mocks.videoSettings.isAutoPlay.and.returnValue(false);
		mocks.videoSettings.isSplitLayout.and.returnValue(false);

		result = UITemplate.selectTemplate(videoSettings);
		expect(result).toContain(UI.CLOSE_BUTTON);
		expect(result).not.toContain(UI.REPLAY_OVERLAY);
	});

	it('Should hide close button element if there is autoplay for not split ad', function () {
		var UITemplate = getModule(),
			videoSettings = mocks.videoSettings,
			result;

		mocks.videoSettings.isAutoPlay.and.returnValue(true);
		mocks.videoSettings.isSplitLayout.and.returnValue(false);

		result = UITemplate.selectTemplate(videoSettings);
		expect(result).not.toContain(UI.CLOSE_BUTTON);
		expect(result).not.toContain(UI.REPLAY_OVERLAY);
	});

	it('Should hide close button element if there is auto play for split ad', function () {
		var UITemplate = getModule(),
			videoSettings = mocks.videoSettings,
			result;

		mocks.videoSettings.isAutoPlay.and.returnValue(true);
		mocks.videoSettings.isSplitLayout.and.returnValue(true);

		result = UITemplate.selectTemplate(videoSettings);
		expect(result).not.toContain(UI.CLOSE_BUTTON);
		expect(result).toContain(UI.REPLAY_OVERLAY);
	});

	it('Should show replay button and close for click to play and split', function () {
		var UITemplate = getModule(),
			videoSettings = mocks.videoSettings,
			result;

		mocks.videoSettings.isAutoPlay.and.returnValue(false);
		mocks.videoSettings.isSplitLayout.and.returnValue(true);

		result = UITemplate.selectTemplate(videoSettings);
		expect(result).toContain(UI.CLOSE_BUTTON);
		expect(result).toContain(UI.REPLAY_OVERLAY);
	});
});

