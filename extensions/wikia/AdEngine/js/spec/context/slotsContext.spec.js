/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.context.uapContext', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		context: {
			opts: {}
		},
		adContext: {
			addCallback: noop,
			getContext: function () {
				return mocks.context;
			}
		},
		adLogicZoneParams: {
			getPageType: function () {
				return mocks.context.pageType;
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

	function getContext() {
		return modules['ext.wikia.adEngine.context.slotsContext'](
			mocks.adContext,
			mocks.adLogicZoneParams,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.context.opts = {};
		mocks.context.pageType = 'article';
		mocks.instantGlobals = {};
	});

	it('on article page mark home slots as disabled', function () {
		var context = getContext();

		expect(context.isApplicable('TOP_LEADERBOARD')).toBeTruthy();
		expect(context.isApplicable('TOP_RIGHT_BOXAD')).toBeTruthy();

		expect(context.isApplicable('HOME_TOP_LEADERBOARD')).toBeFalsy();
		expect(context.isApplicable('HOME_TOP_RIGHT_BOXAD')).toBeFalsy();
		expect(context.isApplicable('PREFOOTER_MIDDLE_BOXAD')).toBeFalsy();
	});

	it('on home page mark article slots as disabled', function () {
		mocks.context.pageType = 'home';
		var context = getContext();

		expect(context.isApplicable('TOP_LEADERBOARD')).toBeFalsy();
		expect(context.isApplicable('TOP_RIGHT_BOXAD')).toBeFalsy();

		expect(context.isApplicable('HOME_TOP_LEADERBOARD')).toBeTruthy();
		expect(context.isApplicable('HOME_TOP_RIGHT_BOXAD')).toBeTruthy();
		expect(context.isApplicable('PREFOOTER_MIDDLE_BOXAD')).toBeTruthy();
	});

	it('geo restricted slots are disabled by default', function () {
		var context = getContext();

		expect(context.isApplicable('INVISIBLE_HIGH_IMPACT_2')).toBeFalsy();
		expect(context.isApplicable('INCONTENT_LEADERBOARD')).toBeFalsy();
		expect(context.isApplicable('INCONTENT_PLAYER')).toBeFalsy();
	});

	it('geo based slots', function () {
		var dataProvider = [
			{
				countriesVariable: 'wgAdDriverHighImpact2SlotCountries',
				slotName: 'INVISIBLE_HIGH_IMPACT_2'
			},
			{
				countriesVariable: 'wgAdDriverIncontentLeaderboardSlotCountries',
				slotName: 'INCONTENT_LEADERBOARD'
			},
			{
				countriesVariable: 'wgAdDriverIncontentPlayerSlotCountries',
				slotName: 'INCONTENT_PLAYER'
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

	it('filter slot map based on status (article page type)', function () {
		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				HOME_TOP_LEADERBOARD: 3,
				HOME_TOP_RIGHT_BOXAD: 4,
				PREFOOTER_LEFT_BOXAD: 5,
				PREFOOTER_MIDDLE_BOXAD: 6
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			PREFOOTER_LEFT_BOXAD: 5
		});
	});

	it('filter slot map based on status (home page type)', function () {
		mocks.context.pageType = 'home';
		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				HOME_TOP_LEADERBOARD: 3,
				HOME_TOP_RIGHT_BOXAD: 4,
				PREFOOTER_LEFT_BOXAD: 5,
				PREFOOTER_MIDDLE_BOXAD: 6
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			HOME_TOP_LEADERBOARD: 3,
			HOME_TOP_RIGHT_BOXAD: 4,
			PREFOOTER_LEFT_BOXAD: 5,
			PREFOOTER_MIDDLE_BOXAD: 6
		});
	});
});
