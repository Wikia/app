describe('AdLogicShortPage', function(){
	it('checks if page is too short for a slot', function() {

		function isPageTooShortForSlot(slotName, pageLength) {
			var slot = [slotName],
				windowMock = {addEventListener: function() {}, styleMedia: {matchMedium: function() {return true;}}},
				logMock = function() {},
				documentMock = {documentElement: {scrollHeight: pageLength, scrollWidth: 1280}},
				adLogicShortPage = AdLogicShortPage(windowMock, documentMock, logMock),
				fillInSlotCalled = false,
				providerMock = {fillInSlot: function() { fillInSlotCalled = true; }};

			if (!adLogicShortPage.isApplicable(slot)) {
				// The proxy would not be used, so ad would be always shown
				return false;
			}

			adLogicShortPage.getProxy(providerMock).fillInSlot(slot);

			if (fillInSlotCalled) {
				// The ad would be shown, so page is not too short for this ad
				return false;
			}

			// The ad is delayed, so the page is too short
			return true;
		}

		expect(isPageTooShortForSlot('foo', 1000)).toBeFalsy('height=1000 slot=foo -> ADS');
		expect(isPageTooShortForSlot('LEFT_SKYSCRAPER_2', 1000)).toBeTruthy('height=1000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(isPageTooShortForSlot('LEFT_SKYSCRAPER_3', 1000)).toBeTruthy('height=1000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(isPageTooShortForSlot('PREFOOTER_LEFT_BOXAD', 1000)).toBeTruthy('height=1000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(isPageTooShortForSlot('PREFOOTER_RIGHT_BOXAD', 1000)).toBeTruthy('height=1000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(isPageTooShortForSlot('foo', 3000)).toBeFalsy('height=3000 slot=foo -> ADS');
		expect(isPageTooShortForSlot('LEFT_SKYSCRAPER_2', 3000)).toBeFalsy('height=3000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(isPageTooShortForSlot('LEFT_SKYSCRAPER_3', 3000)).toBeTruthy('height=3000 slot=LEFT_SKYSCRAPER_3 -> NO ADS');
		expect(isPageTooShortForSlot('PREFOOTER_LEFT_BOXAD', 3000)).toBeFalsy('height=3000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(isPageTooShortForSlot('PREFOOTER_RIGHT_BOXAD', 3000)).toBeFalsy('height=3000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');

		expect(isPageTooShortForSlot('foo', 5000)).toBeFalsy('height=5000 slot=foo -> ADS');
		expect(isPageTooShortForSlot('LEFT_SKYSCRAPER_2', 5000)).toBeFalsy('height=5000 slot=LEFT_SKYSCRAPER_2 -> ADS');
		expect(isPageTooShortForSlot('LEFT_SKYSCRAPER_3', 5000)).toBeFalsy('height=5000 slot=LEFT_SKYSCRAPER_3 -> ADS');
		expect(isPageTooShortForSlot('PREFOOTER_LEFT_BOXAD', 5000)).toBeFalsy('height=5000 slot=PREFOOTER_LEFT_BOXAD -> ADS');
		expect(isPageTooShortForSlot('PREFOOTER_RIGHT_BOXAD', 5000)).toBeFalsy('height=5000 slot=PREFOOTER_RIGHT_BOXAD -> ADS');
	});
});

