
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
			opts: {},
			slots: {
				invisibleHighImpact2: false
			}
		},
		adContext: {
			addCallback: noop,
			get: noop,
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
		instantGlobals: {},
		log: noop
	};

	mocks.log.levels = {};

	function getContext() {
		return modules['ext.wikia.adEngine.context.slotsContext'](
			mocks.adContext,
			mocks.videoFrequencyMonitor,
			mocks.doc,
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
		mocks.context.slots.invisibleHighImpact2 = true;
		var context = getContext();

		expect(context.isApplicable('TOP_LEADERBOARD')).toBeTruthy();
		expect(context.isApplicable('TOP_RIGHT_BOXAD')).toBeTruthy();
		expect(context.isApplicable('INCONTENT_PLAYER')).toBeTruthy();
	});

	it('on home page mark article slots and one home specific slot as enabled', function () {
		mocks.context.targeting.pageType = 'home';
		var context = getContext();

		expect(context.isApplicable('TOP_LEADERBOARD')).toBeTruthy();
		expect(context.isApplicable('TOP_RIGHT_BOXAD')).toBeTruthy();
		expect(context.isApplicable('INCONTENT_PLAYER')).toBeFalsy();
	});

	it('disables IHI2 by default', function () {
		mocks.context.slots.invisibleHighImpact2 =  undefined;

		expect(getContext().isApplicable('INVISIBLE_HIGH_IMPACT_2')).toBeFalsy();
	});

	it('turns on IHI2', function () {
		mocks.context.slots.invisibleHighImpact2 = true;

		expect(getContext().isApplicable('INVISIBLE_HIGH_IMPACT_2')).toBeTruthy();
	});

	it('turns off IHI2', function () {
		mocks.context.slots.invisibleHighImpact2 = false;

		expect(getContext().isApplicable('INVISIBLE_HIGH_IMPACT_2')).toBeFalsy();
	});

	it('disable INCONTENT_PLAYER by video frequency capping', function () {
		mocks.videoFrequencyMonitor.canLaunchVideo = false;

		expect(getContext().isApplicable('INCONTENT_PLAYER')).toBeFalsy();
	});

	it('filter slot map based on status (article page type)', function () {
		mocks.context.slots.invisibleHighImpact2 = false;
		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				BOTTOM_LEADERBOARD: 9
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			BOTTOM_LEADERBOARD: 9
		});
	});

	it('filter slot map based on status (home page type)', function () {
		mocks.context.targeting.pageType = 'home';
		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				BOTTOM_LEADERBOARD: 9
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			BOTTOM_LEADERBOARD: 9
		});
	});

	it('filter slot map that is undefined - no slot maps for given skin', function () {
		var context = getContext();

		expect(context.filterSlotMap()).toEqual({});
	});

	it('filter slot map fbased on status (featured video page)', function () {
		mocks.context.targeting.hasFeaturedVideo = true;
		mocks.instantGlobals['wgAdDriverHighImpact2SlotCountries'] = ['XX'];

		var context = getContext(),
			slotMap = {
				TOP_LEADERBOARD: 1,
				TOP_RIGHT_BOXAD: 2,
				INVISIBLE_HIGH_IMPACT_2: 8,
				BOTTOM_LEADERBOARD: 9
			};

		expect(context.filterSlotMap(slotMap)).toEqual({
			TOP_LEADERBOARD: 1,
			TOP_RIGHT_BOXAD: 2,
			BOTTOM_LEADERBOARD: 9
		});
	});

	it('should enable article video slot by default', function () {
		expect(getContext().isApplicable('FEATURED')).toBeTruthy();
	});
});
