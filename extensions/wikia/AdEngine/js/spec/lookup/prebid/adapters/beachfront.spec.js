/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.beachfront', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function() {},
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
		babDetection: {
			isBlocking: function () {
				return false;
			}
		},
		log: function () {
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
			mocks.babDetection,
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
		spyOn(mocks.adContext, 'get').and.returnValue(false);

		expect(getBeachfront().isEnabled()).toBeFalsy();
	});

	it('Is enabled when context is enabled', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);

		expect(getBeachfront().isEnabled()).toBeTruthy();
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var beachfront = getBeachfront();
		expect(beachfront.prepareAdUnit('INCONTENT_PLAYER', {
			appId: 'ww-11-kk-11-44'
		})).toEqual({
			code: 'INCONTENT_PLAYER',
			mediaTypes: {
				video: {
					playerSize: [640, 480]
				}
			},
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
