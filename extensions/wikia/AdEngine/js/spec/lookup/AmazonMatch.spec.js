/*global describe, it, modules, expect, spyOn*/
describe('Method ext.wikia.adEngine.lookup.amazonMatch', function () {
	'use strict';

	var mocks, testCases;

	function noop() {
		return;
	}

	function getFactory() {
		return modules['ext.wikia.adEngine.lookup.lookupFactory'](
			mocks.adContext,
			mocks.adTracker,
			mocks.lazyQueue,
			mocks.log
		);
	}

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.amazonMatch'](
			mocks.adContext,
			getFactory(),
			mocks.document,
			mocks.log,
			mocks.window
		);
	}

	function init(amazonMatch, tokens) {
		spyOn(mocks.window.amznads, 'getTokens').and.returnValue(tokens);
		amazonMatch.call();
		expect(typeof mocks.window.amznads.renderAd).toBe('function');
	}

	mocks = {
		targeting: noop,
		adContext: {
			getContext: function () {
				return {
					opts: noop,
					slots: noop,
					targeting: mocks.targeting
				};
			}
		},
		adTracker: {
			measureTime: function () {
				return {
					measureDiff: function () {
						return {
							track: noop
						};
					},
					track: noop
				};
			},
			track: noop
		},
		document: {
			createElement: function () {
				return {
					addEventListener: function (eventName, callback) {
						callback();
					}
				};
			},
			getElementsByTagName: function () {
				return [
					{
						parentNode: {
							insertBefore: noop
						}
					}
				];
			}
		},
		lazyQueue: {
			makeQueue: function (queue, callback) {
				queue.push = function () {
					callback();
				};
				queue.start = noop;
			}
		},
		log: noop,
		window: {
			amznads: {
				getAdsCallback: function (id, callback) {
					callback();
				},
				renderAd: noop,
				getTokens: noop
			}
		}
	};

	testCases = [
		// Empty
		{
			skin: 'oasis', input: [], expected: {}
		},
		{
			skin: 'oasis', input: ['invalid-input'], expected: {}
		},

		// Single values
		{
			skin: 'oasis', input: ['a1x6p14'],
			expected: {skyscraper: ['a1x6p14'], incontentBoxad: ['a1x6p14']}
		},
		{
			skin: 'mercury', input: ['a3x2p14'],
			expected: {mobileprefooter: ['a3x2p14'], mobileincontent: ['a3x2p14']}
		},
		{
			skin: 'mercury', input: ['a3x5p14'],
			expected: {mobileleaderboard: ['a3x5p14']}
		},
		{
			skin: 'oasis', input: ['a3x6p14'],
			expected: {medrec: ['a3x6p14'], skyscraper: ['a3x6p14'], incontentBoxad: ['a3x6p14']}},
		{
			skin: 'oasis', input: ['a7x9p14'],
			expected: {leaderboard: ['a7x9p14']}
		},

		// Pick the lowest price point (single size)
		{
			skin: 'oasis', input: ['a1x6p14', 'a1x6p5', 'a1x6p12'],
			expected: {skyscraper: ['a1x6p5'], incontentBoxad: ['a1x6p5']}},
		{
			skin: 'mercury', input: ['a3x2p12', 'a3x2p10'],
			expected: {mobileprefooter: ['a3x2p10'], mobileincontent: ['a3x2p10']}
		},

		// Medrec should get both 3x2 and 3x6 sizes
		{
			skin: 'oasis',
			input: ['a3x2p12', 'a3x2p13', 'a3x6p5', 'a7x9p5'],
			expected: {
				medrec: ['a3x2p12', 'a3x6p5'],
				leaderboard: ['a7x9p5'],
				skyscraper: ['a3x2p12', 'a3x6p5'],
				incontentBoxad: ['a3x2p12', 'a3x6p5']
			}
		},

		// More complete example
		{
			skin: 'oasis',
			input: [
				'a1x6p14',
				'a1x6p3',
				'a7x9p12',
				'a7x9p4',
				'a7x9p14',
				'a3x2p5',
				'a3x2p8',
				'a3x2p6',
				'a3x5p14',
				'a3x6p10',
				'a3x6p8',
				'a3x6p12',
				'xxx'
			],
			expected: {
				leaderboard: ['a7x9p4'],
				skyscraper: ['a1x6p3', 'a3x2p5', 'a3x6p8'],
				medrec: ['a3x2p5', 'a3x6p8'],
				incontentBoxad: ['a3x2p5', 'a1x6p3', 'a3x6p8']
			}
		}
	];

	Object.keys(testCases).forEach(function (k) {
		it('filters out correct amazon slots #' + k, function () {
			var amazonMatch = getModule(),
				testCase = testCases[k];

			mocks.targeting.skin = testCase.skin;

			init(amazonMatch, testCase.input);

			expect(amazonMatch.getSlotParams('TOP_LEADERBOARD').amznslots).toEqual(testCase.expected.leaderboard);
			expect(amazonMatch.getSlotParams('HOME_TOP_LEADERBOARD').amznslots).toEqual(testCase.expected.leaderboard);
			expect(amazonMatch.getSlotParams('HUB_TOP_LEADERBOARD').amznslots).toEqual(testCase.expected.leaderboard);
			expect(amazonMatch.getSlotParams('TOP_RIGHT_BOXAD').amznslots).toEqual(testCase.expected.medrec);
			expect(amazonMatch.getSlotParams('HOME_TOP_RIGHT_BOXAD').amznslots).toEqual(testCase.expected.medrec);
			expect(amazonMatch.getSlotParams('HUB_TOP_RIGHT_BOXAD').amznslots).toEqual(testCase.expected.medrec);
			expect(amazonMatch.getSlotParams('LEFT_SKYSCRAPER_2').amznslots).toEqual(testCase.expected.skyscraper);
			expect(amazonMatch.getSlotParams('LEFT_SKYSCRAPER_3').amznslots).toEqual(testCase.expected.skyscraper);
			expect(amazonMatch.getSlotParams('INVISIBLE_SKIN').amznslots).toEqual(undefined);
			expect(amazonMatch.getSlotParams('INCONTENT_1').amznslots).toEqual(undefined);
			expect(amazonMatch.getSlotParams('MOBILE_TOP_LEADERBOARD').amznslots)
				.toEqual(testCase.expected.mobileleaderboard);
			expect(amazonMatch.getSlotParams('MOBILE_IN_CONTENT').amznslots).toEqual(testCase.expected.mobileincontent);
			expect(amazonMatch.getSlotParams('MOBILE_PREFOOTER').amznslots).toEqual(testCase.expected.mobileprefooter);

			expect(amazonMatch.getSlotParams('INCONTENT_BOXAD_1').amznslots).toEqual(testCase.expected.incontentBoxad);
		});
	});

	it('returns empty amznslots when already rendered', function () {
		var amazonMatch = getModule();

		mocks.targeting.skin = 'mercury';
		init(amazonMatch, ['a3x5p14']);

		expect(amazonMatch.getSlotParams('MOBILE_TOP_LEADERBOARD').amznslots).toEqual(['a3x5p14']);
		mocks.window.amznads.renderAd(mocks.document);
		expect(amazonMatch.getSlotParams('MOBILE_TOP_LEADERBOARD').amznslots).toEqual(undefined);
	});

	it('switch the flag when response from Amazon recieved', function () {
		var amazonMatch = getModule();
		mocks.targeting.skin = 'oasis';
		init(amazonMatch, ['a3x5p14']);
		expect(amazonMatch.hasResponse()).toEqual(true);
	});
});
