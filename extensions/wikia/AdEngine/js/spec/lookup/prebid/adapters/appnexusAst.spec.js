/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return {
					targeting: {
						hasFeaturedVideo: false
					}
				};
			}
		},
		instantGlobals: {
			wgAdDriverAppNexusAstBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
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
			mocks.geo,
			mocks.instantGlobals,
			mocks.loc
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var appNexus = getAppNexus();
		appNexus.isEnabled();

		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var appNexus = getAppNexus();
		expect(appNexus.prepareAdUnit('TOP_LEADERBOARD', {
			placementId: 'foo'
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			sizes: [ 640, 480 ],
			mediaType: 'video-outstream',
			bids: [
				{
					bidder: 'appnexusAst',
					params: {
						placementId: 'foo',
						video: {
							skippable: false,
							playback_method: [ 'auto_play_sound_off' ]
						}
					}
				}
			]
		});
	});
});
