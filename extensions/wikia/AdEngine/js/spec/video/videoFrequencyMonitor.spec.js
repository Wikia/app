/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.video.videoFrequencyMonitor', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: {}
					};
				}
			},
			store: {
				save: noop,
				numberOfVideosSeenInLastPageViews: noop,
				numberOfVideosSeenInLast: noop
			},
			adLogicPageViewCounter: {
				get: function () {
					return 1;
				}
			}
		};

	beforeEach(function () {
		jasmine.clock().install();
	});

	afterEach(function () {
		jasmine.clock().uninstall();
	});

	function mockContext(data) {
		spyOn(mocks.adContext, 'getContext').and.returnValue(data);
	}

	function mockWgVar(wgVar) {
		mockContext({
			opts: {
				outstreamVideoFrequencyCapping: wgVar
			}
		});
	}

	function mockVideosOnPageViews(data) {
		if (!mocks.store.numberOfVideosSeenInLastPageViews.and) {
			spyOn(mocks.store, 'numberOfVideosSeenInLastPageViews');
		}

		mocks.store.numberOfVideosSeenInLastPageViews.and.callFake(function (i) {
			return data[i];
		});
	}

	function mockVideosInTime(data) {
		if (!mocks.store.numberOfVideosSeenInLast.and) {
			spyOn(mocks.store, 'numberOfVideosSeenInLast');
		}

		mocks.store.numberOfVideosSeenInLast.and.callFake(function (value, unit) {
			return data[value + unit];
		});
	}

	function getModule() {
		return modules['ext.wikia.adEngine.video.videoFrequencyMonitor'](
			mocks.adContext,
			mocks.adLogicPageViewCounter,
			mocks.store
		);
	}

	it('Should send to store current pv and date', function () {
		var callArguments,
			currentDate = new Date();

		spyOn(mocks.store, 'save');
		spyOn(mocks.adLogicPageViewCounter, 'get').and.returnValue(10);
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
		mockWgVar(['5/30pv']);

		expect(getModule().videoCanBeLaunched()).toBeTruthy();
		expect(mocks.store.numberOfVideosSeenInLastPageViews.calls.first().args[0]).toEqual(30);
	});

	it('Should ask for correct number of PV and return negative result', function () {
		spyOn(mocks.store, 'numberOfVideosSeenInLastPageViews').and.returnValue(5);
		mockWgVar(['5/10pv']);

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
			wgVar: ['5/10pv', '10/100pv'],
			result: false
		},
		{
			videosSeenInPV: {
				10: 3,
				100: 9
			},
			videosSeenInTime: {},
			wgVar: ['5/10pv', '10/100pv'],
			result: true
		},
		{
			videosSeenInPV: {
				10: 5,
				100: 10
			},
			videosSeenInTime: {},
			wgVar: ['5/10pv', '10/100pv'],
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'5min': 2
			},
			wgVar: ['2/5min'],
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'15min': 4
			},
			wgVar: ['5/15min'],
			result: true
		},
		{
			videosSeenInPV: {
				100: 3
			},
			videosSeenInTime: {
				'15min': 4
			},
			wgVar: ['5/15min', '3/100pv'],
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 1
			},
			wgVar: ['5/1h'],
			result: true
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 5
			},
			wgVar: ['5/1h'],
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 2,
				'1/10minutes': 1
			},
			wgVar: ['5/1h', '1/10minutes'],
			result: false
		},
		{
			videosSeenInPV: {},
			videosSeenInTime: {
				'1h': 2,
				'3/10minutes': 2
			},
			wgVar: ['5/1h', '3/10minutes'],
			result: false
		}
	].forEach(function (testCase) {
		var resultTxt = testCase.result ? 'allow' : 'dont\'t allow';
		it('Should ' + resultTxt + ' to launch video based on pv (' + JSON.stringify(testCase.videosSeenInPV) + ') and time (' + JSON.stringify(testCase.videosSeenInTime) + ') limits', function () {
			mockVideosOnPageViews(testCase.videosSeenInPV);
			mockVideosInTime(testCase.videosSeenInTime);
			mockWgVar(testCase.wgVar);

			expect(getModule().videoCanBeLaunched()).toEqual(testCase.result);
		});
	});

	//
	// it('Should decide about launch video based on time limiters and pv', function () {
	// });
});

