/**
 * @test-require-asset extensions/wikia/AdEngine/js/AdLogicShortPage.js
 */

describe('AdLogicShortPage', function(){
	it('checks if page is too short for a slot', function() {
		var adLogicShortPage1000 = AdLogicShortPage({documentElement: {offsetHeight: 1000}}),
			adLogicShortPage3000 = AdLogicShortPage({documentElement: {offsetHeight: 3000}}),
			adLogicShortPage5000 = AdLogicShortPage({documentElement: {offsetHeight: 5000}});

		expect(adLogicShortPage1000.isPageTooShortForSlot(['foo'])).toBeFalsy('height=1000 slot=foo -> ADS');
		expect(adLogicShortPage1000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_2'])).toBeTruthy('height=1000 slot=LEFT_SKYSCRAPER_2 -> NO ADS');
		expect(adLogicShortPage1000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_3'])).toBeTruthy('height=1000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(adLogicShortPage1000.isPageTooShortForSlot(['PREFOOTER_LEFT_BOXAD'])).toBeTruthy('height=1000 slot=PREFOOTER_LEFT_BOXAD -> NO ADS');
		expect(adLogicShortPage1000.isPageTooShortForSlot(['PREFOOTER_RIGHT_BOXAD'])).toBeTruthy('height=1000 slot=PREFOOTER_RIGHT_BOXAD -> NO ADS');

		expect(adLogicShortPage3000.isPageTooShortForSlot(['foo'])).toBeFalsy('height=3000 slot=foo -> ADS');
		expect(adLogicShortPage3000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_2'])).toBeFalsy('height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adLogicShortPage3000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_3'])).toBeTruthy('height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(adLogicShortPage3000.isPageTooShortForSlot(['PREFOOTER_LEFT_BOXAD'])).toBeFalsy('height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adLogicShortPage3000.isPageTooShortForSlot(['PREFOOTER_RIGHT_BOXAD'])).toBeFalsy('height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(adLogicShortPage5000.isPageTooShortForSlot(['foo'])).toBeFalsy('height=5000 slot=foo -> ADS');
		expect(adLogicShortPage5000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_2'])).toBeFalsy('height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(adLogicShortPage5000.isPageTooShortForSlot(['LEFT_SKYSCRAPER_3'])).toBeFalsy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(adLogicShortPage5000.isPageTooShortForSlot(['PREFOOTER_LEFT_BOXAD'])).toBeFalsy('height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(adLogicShortPage5000.isPageTooShortForSlot(['PREFOOTER_RIGHT_BOXAD'])).toBeFalsy('height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});
});