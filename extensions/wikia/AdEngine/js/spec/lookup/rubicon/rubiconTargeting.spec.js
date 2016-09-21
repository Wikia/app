/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.rubicon.rubiconTargeting', function () {
	'use strict';

	var mocks = {
			adContext: {
				getContext: function () {
					return {
						targeting: mocks.targeting
					};
				}
			},
			adLogicZoneParams: {
				getSite: function () {
					return 'life';
				},
				getName: function () {
					return '_dragonball';
				},
				getPageType: function () {
					return mocks.targeting.pageType;
				},
				getLanguage: function () {
					return 'pl';
				}
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.rubicon.rubiconTargeting'](
			mocks.adContext,
			mocks.adLogicZoneParams
		);
	}

	beforeEach(function () {
		mocks.targeting = {
			pageType: 'article'
		};
	});

	it('Returns targeting based on context and adLogicZoneParams', function () {
		var rubiconTargeting = getModule().getTargeting('TOP_LEADERBOARD', 'oasis', 'vulcan');

		expect(rubiconTargeting).toEqual({
			pos: 'TOP_LEADERBOARD',
			src: 'gpt',
			s0: 'life',
			s1: 'not a top1k wiki',
			s2: 'article',
			lang: 'pl',
			passback: 'vulcan'
		});
	});

	it('Returns targeting with specific dbname when wiki is from top1k', function () {
		mocks.targeting.wikiIsTop1000 = true;

		var rubiconTargeting = getModule().getTargeting('TOP_LEADERBOARD', 'oasis', 'vulcan');

		expect(rubiconTargeting.s1).toEqual('_dragonball');
	});

	it('Returns mobile src when skin is mercury', function () {
		var rubiconTargeting = getModule().getTargeting('TOP_LEADERBOARD', 'mercury', 'vulcan');

		expect(rubiconTargeting.src).toEqual('mobile');
	});

});
