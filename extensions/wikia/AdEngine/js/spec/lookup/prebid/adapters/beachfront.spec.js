/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.beachfront', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		context: {},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		log: function () {
		},
		instartLogic: {
			isBlocking: function () {
				return false;
			}
		},
		loc: {
			href: '//bar'
		}
	};

	mocks.log.levels = {};

	function getBeachfront() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.beachfront'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.instartLogic,
			mocks.loc,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.context = {
			bidders: {
				beachfront: true
			}
		};
	});

	it('Is disabled when context is disabled', function () {
		mocks.context.bidders.beachfront = false;
		var beachfront = getBeachfront();

		expect(beachfront.isEnabled()).toBeFalsy();
	});

	it('Is enabled when context is enabled', function () {
		var beachfront = getBeachfront();

		expect(beachfront.isEnabled()).toBeTruthy();
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var beachfront = getBeachfront();
		expect(beachfront.prepareAdUnit('INCONTENT_PLAYER', {
			appId: 'ww-11-kk-11-44'
		})).toEqual({
			code: 'INCONTENT_PLAYER',
			sizes: [640, 480],
			mediaType: 'video',
			bids: [
				{
					bidder: 'beachfront',
					params: {
						bidfloor: 0.01,
						appId: 'ww-11-kk-11-44'
					}
				}
			]
		});
	});
});
