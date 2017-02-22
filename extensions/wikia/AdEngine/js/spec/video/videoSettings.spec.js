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

		expect(videoSettings.isAutoPlay()).toBeFalsy()
	});

	it('Should be auto play for default state with parameter', function () {
		var videoSettings = getSettings({
			autoPlay: true
		});

		expect(videoSettings.isAutoPlay()).toBeTruthy()
	});

	it('Should not be auto play for default state with incorrect parameter', function () {
		var videoSettings = getSettings({
			autoPlay: false
		});

		expect(videoSettings.isAutoPlay()).toBeFalsy()
	});

	it('Should be auto play for resolved state with autoplay parameter', function () {
		spyOn(mocks.resolvedState, 'isResolvedState');
		mocks.resolvedState.isResolvedState.and.returnValue(true);

		var videoSettings = getSettings({
			autoPlay: false,
			resolvedStateAutoPlay: true
		});

		expect(videoSettings.isAutoPlay()).toBeTruthy()
	});

	it('Should not be auto play for resolved state without autoplay parameter', function () {
		spyOn(mocks.resolvedState, 'isResolvedState');
		mocks.resolvedState.isResolvedState.and.returnValue(true);

		var videoSettings = getSettings({
			autoPlay: false,
			resolvedAutoPlay: false
		});

		expect(videoSettings.isAutoPlay()).toBeFalsy()
	});
});

