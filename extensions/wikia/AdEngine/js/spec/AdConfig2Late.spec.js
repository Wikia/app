describe('AdConfig2Late', function(){
	it('getProvider returns Liftium2Dom if it can handle it', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return true;}}
			, logMock = function() {}
			, windowMock = {}
			, adConfig;

		adConfig = AdConfig2Late(
			logMock, windowMock

			, adProviderGameProMock
			, adProviderLiftium2DomMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftium2DomMock, 'adProviderLiftium2DomMock');
	});

	it('getProvider returns Null if Liftium cannot handle it', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
			, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return false;}}
			, logMock = function() {}
			, windowMock = {}
			, adConfig;

		adConfig = AdConfig2Late(
			logMock, windowMock

			, adProviderGameProMock
			, adProviderLiftium2DomMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderNullMock');
	});

	it('for German sites, getProvider returns GamePro if it can handle it and Null for three slots', function() {
		var adProviderNullMock = {name: 'NullMock'}
			, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
			, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return false;}}
			, logMock = function() {}
			, windowMock = {wgContentLanguage: 'de'}
			, adConfig;

		adConfig = AdConfig2Late(
			logMock, windowMock

			, adProviderGameProMock
			, adProviderLiftium2DomMock
			, adProviderNullMock
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderGameProMock, 'adProviderGameProMock');
		expect(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD'])).toBe(adProviderNullMock, 'adProviderNullMock');
		expect(adConfig.getProvider(['LEFT_SKYSCRAPER_3'])).toBe(adProviderNullMock, 'adProviderNullMock');
	});
});
