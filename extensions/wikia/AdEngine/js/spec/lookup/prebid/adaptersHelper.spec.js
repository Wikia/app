/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adaptersHelper', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		context: {
			targeting: {
				wikiIsTop1000: true
			}
		},
		adLogicZoneParams: {
			getLanguage: function () {
				return 'en';
			},
			getName: function () {
				return 'test';
			},
			getPageType: function () {
				return 'article';
			},
			getSite: function () {
				return 'life';
			}
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersHelper'](
			mocks.adContext,
			mocks.adLogicZoneParams
		);
	}

	it('returns rubicon targeting for given parameters', function () {
		var module = getModule();
		expect(module.getTargeting('TOP_LEADERBOARD', 'oasis')).toEqual({
			pos: ['TOP_LEADERBOARD'],
			src: ['gpt'],
			s0: ['life'],
			s1: ['test'],
			s2: ['article'],
			lang: ['en']
		});
	});
});
