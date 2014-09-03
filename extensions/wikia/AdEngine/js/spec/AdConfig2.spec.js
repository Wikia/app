/*global describe,it,expect,modules*/
describe('AdConfig2', function () {
	'use strict';

	// Mock factories:
	function mockGeo(country) {
		return {getCountryCode: function () { return country; }};
	}

	function mockEvolveSlotConfig(shouldHandle) {
		return {name: 'EvolveMock', canHandleSlot: function () { return shouldHandle; }};
	}

	function mockGptProvider(shouldHandle) {
		return {name: 'GptMock', canHandleSlot: function () { return shouldHandle; }};
	}

	function mockAdContext(showAds, providers) {
		return {
			getContext: function () {
				return {
					opts: {showAds: showAds},
					providers: providers || {},
					forceProviders: {}
				};
			}
		};
	}

	// Mocks:
	var adDecoratorPageDimensionsMock = {isApplicable: function () { return false; }},
		adProviderNullMock = {name: 'NullMock'},
		adProviderLaterMock = {name: 'LaterMock'},
		logMock = function () {},

	// Fixtures:
		highValueSlot = 'TOP_LEADERBOARD',
		lowValueSlot = 'foo';

	it('getProvider failsafe to Later', function () {

		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			mockGptProvider(false),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([lowValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider use GPT for high value slots', function () {
		var adProviderGptMock = mockGptProvider(true);

		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([lowValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderGptMock, 'adProviderDirectGptMock');
	});

	it('getProvider use Evolve for NZ (only if provider accepts)', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),

			// AdProviders
			mockGptProvider(false),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([lowValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock NZ');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock NZ');
	});

	it('getProvider do not use Evolve for PL', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('PL'),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([highValueSlot])).not.toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider do not use Evolve for NZ when it cannot handle the slot', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([highValueSlot])).not.toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider return SevenOneMedia when wgAdProviderSevenOneMedia = true in HVC', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider return SevenOneMedia when wgAdProviderSevenOneMedia = true in PL', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('PL'),
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider return SevenOneMedia when wgAdProviderSevenOneMedia = true in NZ', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider Null when wgShowAds = false', function () {
		var geoMock = mockGeo(),
			adConfig = modules['ext.wikia.adEngine.adConfig'](
				logMock,
				geoMock,
				mockAdContext(false),
				adDecoratorPageDimensionsMock,
				mockEvolveSlotConfig(true),

				// AdProviders
				mockGptProvider(true),
				adProviderLaterMock,
				adProviderNullMock
			);

		// First check if NullProvider wins over GPT
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Second check if NullProvider wins over Later
		geoMock.getCountryCode = function () {};
		expect(adConfig.getProvider([lowValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Third check if NullProvider wins over Evolve
		geoMock.getCountryCode = function () { return 'NZ'; };
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');
	});
});
