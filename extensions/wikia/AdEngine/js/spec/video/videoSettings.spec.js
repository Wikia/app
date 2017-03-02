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
			resolvedStateAutoPlay: true
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

	it('Should be split layout for correct parameter', function () {
		var videoSettings = getSettings({
			splitLayoutVideoPosition: 'right'
		});

		expect(true).toMatch(videoSettings.isSplitLayout());
	});

	it('Should be split layout for incorrect parameter', function () {
		var videoSettings = getSettings({
			splitLayoutVideoPosition: ''
		});

		expect(false).toMatch(videoSettings.isSplitLayout());
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
});

