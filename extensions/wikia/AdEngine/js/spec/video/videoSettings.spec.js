/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.video.videoSettings', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function () {
				return true;
			}
		},
		resolvedState: {
			isResolvedState: function () { return false; }
		},
		sampler: {
			sample: function () {
				return true;
			}
		},
		win: {
			google: {
				ima: {
					ImaSdkSettings: {
						VpaidMode: {
							ENABLED: 1
						}
					}
				}
			}
		}
	};

	function getSettings(params) {
		params = params || {};
		return modules['ext.wikia.adEngine.video.videoSettings'](
			mocks.adContext,
			mocks.resolvedState,
			mocks.sampler,
			mocks.win
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

	it('Should enable tracking when param is boolean (true)', function () {
		spyOn(mocks.sampler, 'sample').and.returnValue(true);

		var videoSettings = getSettings({
			moatTracking: true
		});

		expect(videoSettings.isMoatTrackingEnabled()).toBeTruthy();
		expect(mocks.sampler.sample).not.toHaveBeenCalled();
	});

	it('Should disable tracking when param is boolean (false)', function () {
		spyOn(mocks.sampler, 'sample').and.returnValue(true);

		var videoSettings = getSettings({
			moatTracking: false
		});

		expect(videoSettings.isMoatTrackingEnabled()).toBeFalsy();
		expect(mocks.sampler.sample).not.toHaveBeenCalled();
	});

	it('Should enable tracking when param is integer (100)', function () {
		spyOn(mocks.sampler, 'sample').and.returnValue(true);

		var videoSettings = getSettings({
			moatTracking: 100
		});

		expect(videoSettings.isMoatTrackingEnabled()).toBeTruthy();
		expect(mocks.sampler.sample).not.toHaveBeenCalled();
	});

	it('Should enable tracking when param.bid is integer (100)', function () {
		spyOn(mocks.sampler, 'sample').and.returnValue(true);

		var videoSettings = getSettings({
			bid: {
				moatTracking: 100
			},
			moatTracking: 1
		});

		expect(videoSettings.isMoatTrackingEnabled()).toBeTruthy();
		expect(mocks.sampler.sample).not.toHaveBeenCalled();
	});

	it('Should use sampling when param is integer lower than 100', function () {
		spyOn(mocks.sampler, 'sample').and.returnValue(true);

		getSettings({
			moatTracking: 50
		});

		expect(mocks.sampler.sample).toHaveBeenCalled();
	});

	it('Should be able to disable moat tracking on runtime', function () {
		spyOn(mocks.sampler, 'sample').and.returnValue(true);

		var videoSettings = getSettings({
			moatTracking: 100
		});
		videoSettings.setMoatTracking(false);

		expect(videoSettings.isMoatTrackingEnabled()).toBeFalsy();
	});
});

