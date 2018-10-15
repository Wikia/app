/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function () {},
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
		loc: {
			href: '//bar'
		}
	};

	function getAppNexus() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.babDetection,
			mocks.loc
		);
	}

	beforeEach(function () {
		mocks.context = {
			bidders: {
				appnexusAst: true
			}
		};
	});

	it('enables bidder if flag is on and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
		expect(getAppNexus().isEnabled()).toBeTruthy();
	});

	it('disables bidder if flag is off and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		expect(getAppNexus().isEnabled()).toBeFalsy();
	});

	it('prepareAdUnit returns data in correct shape', function () {
		expect(getAppNexus().prepareAdUnit('TOP_LEADERBOARD', {
			placementId: 'foo'
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			mediaTypes: {
				video: {
					context: 'instream',
					playerSize: [640, 480]
				}
			},
			bids: [
				{
					bidder: 'appnexusAst',
					params: {
						placementId: 'foo',
						video: {
							skippable: false,
							playback_method: ['auto_play_sound_off']
						}
					}
				}
			]
		});
	});
});
