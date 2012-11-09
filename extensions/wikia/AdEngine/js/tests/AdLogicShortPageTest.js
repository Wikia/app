/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdLogicShortPage.js
 */

module('AdLogicShortPage');

test('isPageTooShortForSlot', function() {
	var adLogicShortPage1000 = AdLogicShortPage({documentElement: {offsetHeight: 1000}}),
		adLogicShortPage3000 = AdLogicShortPage({documentElement: {offsetHeight: 3000}}),
		adLogicShortPage5000 = AdLogicShortPage({documentElement: {offsetHeight: 5000}});

	equal(adLogicShortPage1000.isPageTooShortForSlot(['foo']), false, 'height=1000 slot=foo -> ADS');
	equal(adLogicShortPage1000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_2']), true, 'height=1000 slot=LEFT_SKYSCRAPER_2 -> NO ADS');
	equal(adLogicShortPage1000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_3']), true, 'height=1000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
	equal(adLogicShortPage1000.isPageTooShortForSlot(['PREFOOTER_LEFT_BOXAD']), true, 'height=1000 slot=PREFOOTER_LEFT_BOXAD -> NO ADS');
	equal(adLogicShortPage1000.isPageTooShortForSlot(['PREFOOTER_RIGHT_BOXAD']), true, 'height=1000 slot=PREFOOTER_RIGHT_BOXAD -> NO ADS');

	equal(adLogicShortPage3000.isPageTooShortForSlot(['foo']), false, 'height=3000 slot=foo -> ADS');
	equal(adLogicShortPage3000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_2']), false, 'height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
	equal(adLogicShortPage3000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_3']), true, 'height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
	equal(adLogicShortPage3000.isPageTooShortForSlot(['PREFOOTER_LEFT_BOXAD']), false, 'height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
	equal(adLogicShortPage3000.isPageTooShortForSlot(['PREFOOTER_RIGHT_BOXAD']), false, 'height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

	equal(adLogicShortPage5000.isPageTooShortForSlot(['foo']), false, 'height=5000 slot=foo -> ADS');
	equal(adLogicShortPage5000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_2']), false, 'height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
	equal(adLogicShortPage5000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_3']), false, 'height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
	equal(adLogicShortPage5000.isPageTooShortForSlot(['PREFOOTER_LEFT_BOXAD']), false, 'height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
	equal(adLogicShortPage5000.isPageTooShortForSlot(['PREFOOTER_RIGHT_BOXAD']), false, 'height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

});
