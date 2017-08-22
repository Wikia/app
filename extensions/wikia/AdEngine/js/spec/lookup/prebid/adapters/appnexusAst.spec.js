/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		context: {},
		instartLogic: {
			isBlocking: function() {}
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
			mocks.instartLogic,
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

	it('Is disabled when context is disabled', function () {
		mocks.context.bidders.appnexusAst = false;
		var appnexus = getAppNexus();

		expect(appnexus.isEnabled()).toBeFalsy();
	});

	it('Is enabled when context is enabled', function () {
		var appnexus = getAppNexus();

		expect(appnexus.isEnabled()).toBeTruthy();
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
