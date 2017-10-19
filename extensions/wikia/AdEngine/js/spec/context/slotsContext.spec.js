
/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.context.slotsContext', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		context: {
			targeting: {
				skin: 'oasis'
			},
			opts: {}
		},
		adContext: {
			addCallback: noop,
			getContext: function () {
				return mocks.context;
			}
		},
		videoFrequencyMonitor: {
			canLaunchVideo: true,
			videoCanBeLaunched: function () {
				return mocks.videoFrequencyMonitor.canLaunchVideo;
			}
		},
		doc: {
			querySelectorAll: function() {
				return [
					undefined,
					{
						offsetWidth: 30,
						parentNode: {
							offsetWidth: 30
						}
					}
				];
			}
		},
		geo: {
			isProperGeo: function (countries) {
				return countries && countries.indexOf('XX') !== -1;
			}
		},
		instantGlobals: {},
		log: noop
	};

	mocks.log.levels = {};

	function getContext() {
		return modules['ext.wikia.adEngine.context.slotsContext'](
			mocks.adContext,
			mocks.videoFrequencyMonitor,
			mocks.doc,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.context.opts = {};
		mocks.context.targeting.pageType = 'article';
		mocks.instantGlobals = {};
	});

	it('on article page mark home slots as disabled', function () {
		var context = getContext();

		expect(context.isApplicable('TOP_LEADERBOARD')).toBeTruthy();
		expect(context.isApplicable('TOP_RIGHT_BOXAD')).toBeTruthy();
		expect(context.isApplicable('PREFOOTER_MIDDLE_BOXAD')).toBeFalsy();
		expect(context.isApplicable('INCONTENT_PLAYER')).toBeTruthy();
	});

	it('on home page mark article slots and one home specific slot as enabled', function () {
		mocks.context.targeting.pageType = 'home';
		var context = getContext();

		expect(context.isApplicable('TOP_LEADERBOARD')).toBeTruthy();
		expect(context.isApplicable('TOP_RIGHT_BOXAD')).toBeTruthy();
		expect(context.isApplicable('PREFOOTER_MIDDLE_BOXAD')).toBeTruthy();
		expect(context.isApplicable('INCONTENT_PLAYER')).toBeFalsy();
	});

	it('geo restricted slots are disabled by default', function () {
		var context = getContext();

		expect(context.isApplicable('INVISIBLE_HIGH_IMPACT_2')).toBeFalsy();
	});

	it('geo based slots', function () {
		var dataProvider = [
			{
				countriesVariable: 'wgAdDriverHighImpact2SlotCountries',
				slotName: 'INVISIBLE_HIGH_IMPACT_2'
			}
		];

		dataProvider.forEach(function (testCase) {
			mocks.instantGlobals[testCase.countriesVariable] = ['XX'];
			var context = getContext();

			expect(context.isApplicable(testCase.slotName)).toBeTruthy();
		});

		dataProvider.forEach(function (testCase) {
			mocks.instantGlobals[testCase.countriesVariable] = ['DE'];
			var context = getContext();

			expect(context.isApplicable(testCase.slotName)).toBeFalsy();
		});
	});

	it('enable prefooter based context opt', function () {
		mocks.context.opts.overridePrefootersSizes = false;
		var context = getContext();

		expect(context.isApplicable('PREFOOTER_RIGHT_BOXAD')).toBeTruthy();
	});

	it('disable prefooter based context opt', function () {
		mocks.context.opts.overridePrefootersSizes = true;
		var context = getContext();

		expect(context.isApplicable('PREFOOTER_RIGHT_BOXAD')).toBeFalsy();
	});

	it('disable INCONTENT_PLAYER by vide frequency capping', function () {
		mocks.videoFrequencyMonitor.canLaunchVideo = false;
		var context = getContext();

		expect(context.isApplicable('INCONTENT_PLAYER')).toBeFalsy();
	});

	it('filter slot map based on status (article page type)', function () {
		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				PREFOOTER_LEFT_BOXAD: 3,
				PREFOOTER_MIDDLE_BOXAD: 4
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			PREFOOTER_LEFT_BOXAD: 3
		});
	});

	it('filter slot map based on status (home page type)', function () {
		mocks.context.targeting.pageType = 'home';
		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				PREFOOTER_LEFT_BOXAD: 3,
				PREFOOTER_MIDDLE_BOXAD: 4
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			PREFOOTER_LEFT_BOXAD: 3,
			PREFOOTER_MIDDLE_BOXAD: 4
		});
	});

	it('filter slot map that is undefined - no slot maps for given skin', function () {
		var context = getContext();

		expect(context.filterSlotMap()).toEqual({});
	});

	it('filter slot map for premium ad layout (article page)', function () {
		mocks.context.opts.premiumAdLayoutEnabled = true;
		mocks.instantGlobals['wgAdDriverHighImpact2SlotCountries'] = ['XX'];

		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				PREFOOTER_LEFT_BOXAD: 3,
				PREFOOTER_MIDDLE_BOXAD: 4,
				PREFOOTER_RIGHT_BOXAD: 5,
				LEFT_SKYSCRAPER_2: 6,
				LEFT_SKYSCRAPER_3: 7,
				INVISIBLE_HIGH_IMPACT_2: 8,
				BOTTOM_LEADERBOARD: 9
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			INVISIBLE_HIGH_IMPACT_2: 8,
			BOTTOM_LEADERBOARD: 9
		});
	});

	it('filter slot map for premium ad layout (featured video page)', function () {
		mocks.context.opts.premiumAdLayoutEnabled = true;
		mocks.context.targeting.hasFeaturedVideo = true;
		mocks.instantGlobals['wgAdDriverHighImpact2SlotCountries'] = ['XX'];

		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				PREFOOTER_LEFT_BOXAD: 3,
				PREFOOTER_MIDDLE_BOXAD: 4,
				PREFOOTER_RIGHT_BOXAD: 5,
				LEFT_SKYSCRAPER_2: 6,
				LEFT_SKYSCRAPER_3: 7,
				INVISIBLE_HIGH_IMPACT_2: 8,
				BOTTOM_LEADERBOARD: 9
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			BOTTOM_LEADERBOARD: 9
		});
	});
});
