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
				numberOfVideosSeenInLastPageViews: noop
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
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			opts: {
				outstreamVideoFrequencyCapping: ['5/30pv']
			}
		});

		expect(getModule().videoCanBeLaunched()).toBeTruthy();
		expect(mocks.store.numberOfVideosSeenInLastPageViews.calls.first().args[0]).toEqual(30);
	});

	it('Should ask for correct number of PV and return negative result', function () {
		spyOn(mocks.store, 'numberOfVideosSeenInLastPageViews').and.returnValue(5);
		spyOn(mocks.adContext, 'getContext').and.returnValue({
			opts: {
				outstreamVideoFrequencyCapping: ['5/10pv']
			}
		});

		expect(getModule().videoCanBeLaunched()).toBeFalsy();
		expect(mocks.store.numberOfVideosSeenInLastPageViews.calls.first().args[0]).toEqual(10);
	});

	// it('Should decide about launch video based on real pv limiter', function () {
	// });
	//
	// it('Should decide about launch video based on few pv limiters', function () {
	// });
	//
	// it('Should decide about launch video based on time limiter', function () {
	// });
	//
	// it('Should decide about launch video based on few time limiters', function () {
	// });
	//
	// it('Should decide about launch video based on time limiters and pv', function () {
	// });
});

