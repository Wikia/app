/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.video.videoSettings', function () {
	'use strict';

	var mocks = {
		resolvedState: {
			isResolvedState: function () { return false; }
		}
	};

	function getSettings(params) {
		params = params || {};
		return modules['ext.wikia.adEngine.video.videoSettings'](
			mocks.resolvedState
		).create(params);
	}

	it('Should be not auto play without autoplay parameter', function () {
		var videoSettings = getSettings();
		expect(false).toMatch(videoSettings.isAutoPlay());
	});

	it('Should be auto play for default state with parameter', function () {
		var videoSettings = getSettings({
			autoPlay: true
		});
		expect(true).toMatch(videoSettings.isAutoPlay());
	});

	it('Should not be auto play for default state with incorrect parameter', function () {
		var videoSettings = getSettings({
			autoPlay: false
		});
		expect(false).toMatch(videoSettings.isAutoPlay());
	});

	it('Should be auto play for resolved state with autoplay parameter', function () {
		spyOn(mocks.resolvedState, 'isResolvedState');
		mocks.resolvedState.isResolvedState.and.returnValue(true);

		var videoSettings = getSettings({
			autoPlay: false,
			resolvedAutoPlay: true
		});
		expect(true).toMatch(videoSettings.isAutoPlay());
	});

	it('Should not be auto play for resolved state without autoplay parameter', function () {
		spyOn(mocks.resolvedState, 'isResolvedState');
		mocks.resolvedState.isResolvedState.and.returnValue(true);

		var videoSettings = getSettings({
			autoPlay: false,
			resolvedAutoPlay: false
		});
		expect(false).toMatch(videoSettings.isAutoPlay());
	});
});

