/*global describe,it,expect,modules,spyOn*/
/*jshint maxlen: 200*/
describe('AdConfig2', function () {
	'use strict';

	// Mock factories:
	function mockGeo(country) {
		return {getCountryCode: function () { return country; }};
	}

	function mockEvolveSlotConfig(shouldHandle) {
		return {name: 'EvolveMock', canHandleSlot: function () { return shouldHandle; }};
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
		adProviderLaterMock = {name: 'LaterMock'},
		adProviderGptMock = {name: 'GptMock'},
		logMock = function () { return;},

	// Fixtures:
		highValueSlot = 'TOP_LEADERBOARD',
		lowValueSlot = 'foo';

	it('getProviderList returns [GPT, Later] for high value slots', function () {

		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			{},
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderGptMock, adProviderLaterMock]);
	});

	it('getProviderList returns [Later] for low value slots', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			{},
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(lowValueSlot)).toEqual([adProviderLaterMock]);
	});

	it('getProviderList returns [Later] for NZ for both high and low value slots (if evolve slot config accepts)', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			{},
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(lowValueSlot)).toEqual([adProviderLaterMock]);
		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderLaterMock]);
	});

	it('getProviderList returns [GPT, Later] for NZ (if evolve slot config does not accept)', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			{},
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderGptMock, adProviderLaterMock]);
	});

	it('getProviderList returns [Later] when adContext.providers.sevenOneMedia = true in HVC', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			{},
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderLaterMock]);
	});

	it('getProviderList returns [Later] when wgAdProviderSevenOneMedia = true in PL', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('PL'),
			{},
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderLaterMock]);
	});

	it('getProviderList returns [Later] when wgAdProviderSevenOneMedia = true in NZ', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			{},
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderLaterMock]);
	});

	it('getProviderList returns [] when wgShowAds = false', function () {
		var geoMock = mockGeo(),
			adConfig = modules['ext.wikia.adEngine.adConfig'](
				logMock,
				mockGeo(),
				{},
				mockAdContext(false),
				adDecoratorPageDimensionsMock,
				mockEvolveSlotConfig(true),

				// AdProviders
				adProviderGptMock,
				adProviderLaterMock
			);

		// First check if NullProvider wins over GPT
		expect(adConfig.getProviderList(highValueSlot)).toEqual([], 'adProviderNullMock wgShowAds false');

		// Second check if NullProvider wins over Later
		geoMock.getCountryCode = function () { return; };
		expect(adConfig.getProviderList(lowValueSlot)).toEqual([], 'adProviderNullMock wgShowAds false');
		expect(adConfig.getProviderList(highValueSlot)).toEqual([], 'adProviderNullMock wgShowAds false');

		// Third check if NullProvider wins over Evolve
		geoMock.getCountryCode = function () { return 'NZ'; };
		expect(adConfig.getProviderList(highValueSlot)).toEqual([], 'adProviderNullMock wgShowAds false');
	});

	it('getProviderList disaster recovery for DFP/GPT', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			{ wgSitewideDisableGpt: true },
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList(highValueSlot)).toEqual([adProviderLaterMock]);
	});
});
