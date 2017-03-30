/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.video.videoSettings', function () {
	'use strict';

	var mocks = {
		resolvedState: {
			isResolvedState: function () { return false; }
		},
		googleIma: {
			vpaidMode: {
				ENABLED: 1
			}
		}
	};

	function getSettings(params) {
		params = params || {};
		return modules['ext.wikia.adEngine.video.videoSettings'](
			mocks.resolvedState,
			mocks.googleIma
		).create(params);
	}

	it('Should be not auto play without autoplay parameter', function () {
		var videoSettings = getSettings();

		expect(videoSettings.isAutoPlay()).toBeFalsy();
	});

	it('Should be auto play for default state with parameter', function () {
		var videoSettings = getSettings({
			autoPlay: true
		});

		expect(videoSettings.isAutoPlay()).toBeTruthy();
	});

	it('Should not be auto play for default state with incorrect parameter', function () {
		var videoSettings = getSettings({
			autoPlay: false
		});

		expect(videoSettings.isAutoPlay()).toBeFalsy();
	});

	it('Should be auto play for resolved state with autoplay parameter', function () {
		spyOn(mocks.resolvedState, 'isResolvedState');
		mocks.resolvedState.isResolvedState.and.returnValue(true);

		var videoSettings = getSettings({
			autoPlay: false,
			resolvedStateAutoPlay: true
		});

		expect(videoSettings.isAutoPlay()).toBeTruthy();
	});

	it('Should not be auto play for resolved state without autoplay parameter', function () {
		spyOn(mocks.resolvedState, 'isResolvedState');
		mocks.resolvedState.isResolvedState.and.returnValue(true);

		var videoSettings = getSettings({
			autoPlay: false,
			resolvedAutoPlay: false
		});

		expect(videoSettings.isAutoPlay()).toBeFalsy();
	});

	it('Should be split layout for correct parameter', function () {
		var videoSettings = getSettings({
			splitLayoutVideoPosition: 'right'
		});

		expect(videoSettings.isSplitLayout()).toBeTruthy();
	});

	it('Should be split layout for incorrect parameter', function () {
		var videoSettings = getSettings({
			splitLayoutVideoPosition: ''
		});

		expect(videoSettings.isSplitLayout()).toBeFalsy();
	});

	it('Should enable vpaid ads by default', function () {
		var videoSettings = getSettings({});

		expect(videoSettings.getVpaidMode()).toEqual(1);
	});

	it('Should control vpaid ads if it is configured in params', function () {
		var videoSettings = getSettings({
			vpaidMode: 0
		});

		expect(videoSettings.getVpaidMode()).toEqual(0);
	});

	it('Should not show ui controls by default', function () {
		var videoSettings = getSettings({});

		expect(videoSettings.hasUiControls()).toBeFalsy();
	});

	it('Should not ui controls when configured in params', function () {
		var videoSettings = getSettings({
			hasUiControls: true
		});

		expect(videoSettings.hasUiControls()).toBeTruthy();
	});
});

