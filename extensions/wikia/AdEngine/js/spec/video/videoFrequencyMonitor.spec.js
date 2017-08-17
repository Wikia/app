/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.video.videoFrequencyMonitor', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			store: {
				save: noop,
				numberOfVideosSeenInLastPageViews: noop,
				numberOfVideosSeenInTime: noop
			},
			window: {
				pvNumber: 1
			},
			settings: {
				get: function () {
					return {
						pv: [],
						time: []
					};
				}
			}
		};

	beforeEach(function () {
		jasmine.clock().install();
	});

	afterEach(function () {
		jasmine.clock().uninstall();
	});

	function mockVideosOnPageViews(data) {
		spyOn(mocks.store, 'numberOfVideosSeenInLastPageViews');

		mocks.store.numberOfVideosSeenInLastPageViews.and.callFake(function (i) {
			return data[i];
		});
	}

	function mockVideosInTime(data) {
		if (!mocks.store.numberOfVideosSeenInTime.and) {
			spyOn(mocks.store, 'numberOfVideosSeenInTime');
		}

		mocks.store.numberOfVideosSeenInTime.and.callFake(function (value, unit) {
			return data[value + unit];
		});
	}

	function getModule() {
		return modules['ext.wikia.adEngine.video.videoFrequencyMonitor'](
			mocks.settings,
			mocks.store,
			mocks.window
		);
	}

	it('Should send to store current pv and date', function () {
		var callArguments,
			currentDate = new Date();

		spyOn(mocks.store, 'save');
		mocks.window.pvNumber = 10;
		jasmine.clock().mockDate(currentDate);

		getModule().registerLaunchedVideo();

		callArguments = mocks.store.save.calls.all()[0].args[0];

		expect(callArguments.date).toEqual(currentDate.getTime());
		expect(callArguments.pv).toEqual(10);
	});

	it('Should enable video for no previous videos play registered', function () {
		expect(getModule().videoCanBeLaunched()).toBeTruthy();
	});

	it('Should ask for correct number of PV and return positive result', function () {
		spyOn(mocks.store, 'numberOfVideosSeenInLastPageViews').and.returnValue(4);
		spyOn(mocks.settings, 'get').and.returnValue({pv: [{frequency: 5, limit: 30}], time:[]});

		expect(getModule().videoCanBeLaunched()).toBeTruthy();
		expect(mocks.store.numberOfVideosSeenInLastPageViews.calls.first().args[0]).toEqual(30);
	});

	it('Should ask for correct number of PV and return negative result', function () {
		spyOn(mocks.store, 'numberOfVideosSeenInLastPageViews').and.returnValue(5);
		spyOn(mocks.settings, 'get').and.returnValue({pv: [{frequency: 5, limit: 10}], time:[]});

		expect(getModule().videoCanBeLaunched()).toBeFalsy();
		expect(mocks.store.numberOfVideosSeenInLastPageViews.calls.first().args[0]).toEqual(10);
	});

	[
		{
			videosSeenInPV: {
				10: 3,
				100: 10
			},
			videosSeenInTime: {},
			settings: {
				pv: [{
					frequency: 5,
					limit: 10
				}, {
					frequency: 10,
					limit: 100
				}], time: []
			},
			result: false
		},
		{
			videosSeenInPV: {
				10: 3,
				100: 9
			},
			videosSeenInTime: {},
			settings: {
				pv: [{
					frequency: 5,
					limit: 10
				}, {
					frequency: 10,
					limit: 100
				}], time: []
			},
			result: true
		},
		{
			videosSeenInPV: {
				10: 5,
				100: 10
			},
			videosSeenInTime: {},
			settings: {
				pv: [{
					frequency: 5,
					limit: 10
				}, {
					frequency: 10,
					limit: 100
				}], time: []
			},
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'5min': 2
			},
			settings: {
				pv: [], time: [{
					frequency: 2,
					limit: 5,
					unit: 'min'
				}]
			},
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'15min': 4
			},
			settings: {
				pv: [], time: [{
					frequency: 5,
					limit: 15,
					unit: 'min'
				}]
			},
			result: true
		},
		{
			videosSeenInPV: {
				100: 3
			},
			videosSeenInTime: {
				'15min': 4
			},
			settings: {
				pv: [{
					frequency: 3,
					limit: 100
				}], time: [{
					frequency: 5,
					limit: 15,
					unit: 'min'
				}]
			},
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 1
			},
			settings: {
				pv: [], time: [{
					frequency: 5,
					limit: 1,
					unit: 'h'
				}]
			},
			result: true
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 5
			},
			settings: {
				pv: [{}], time: [{
					frequency: 5,
					limit: 1,
					unit: 'h'
				}]
			},
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 2,
				'1/10minutes': 1
			},
			settings: {
				pv: [{}], time: [{
					frequency: 5,
					limit: 1,
					unit: 'h'
				}, {
					frequency: 1,
					limit: 10,
					unit: 'minutes'
				}]
			},
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 2,
				'3/10minutes': 2
			},
			settings: {
				pv: [{}], time: [{
					frequency: 5,
					limit: 1,
					unit: 'h'
				}, {
					frequency: 3,
					limit: 10,
					unit: 'min'
				}]
			},
			result: false
		}
	].forEach(function (testCase) {
		var resultTxt = testCase.result ? 'allow' : 'dont\'t allow';
		it('Should ' + resultTxt + ' to launch video based on pv (' + JSON.stringify(testCase.videosSeenInPV) + ') and time (' + JSON.stringify(testCase.videosSeenInTime) + ') limits', function () {
			mockVideosOnPageViews(testCase.videosSeenInPV);
			mockVideosInTime(testCase.videosSeenInTime);
			spyOn(mocks.settings, 'get').and.returnValue(testCase.settings);

			expect(getModule().videoCanBeLaunched()).toEqual(testCase.result);
		});
	});
});

