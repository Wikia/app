/*global describe,it,expect,modules,spyOn*/
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

	function mockRtp(config, called, tier) {
		return {
			wasCalled: function () {
				return called;
			},
			trackState: function () {
				return;
			},
			getTier: function () {
				return tier;
			},
			getConfig: function () {
				return config;
			}
		};
	}

	// Mocks:
	var adDecoratorPageDimensionsMock = {isApplicable: function () { return false; }},
		adProviderNullMock = {name: 'NullMock'},
		adProviderLaterMock = {name: 'LaterMock'},
		logMock = function () { return; },
		gptSlotConfigMock = {
			extendSlotParams: function () {
				return;
			}
		},
		rtpMock = mockRtp({ slotname: [ 'HOME_TOP_RIGHT_BOXAD' ] }),
		rtpMockWithTier = mockRtp({ slotname: [ 'HOME_TOP_RIGHT_BOXAD' ] }, true, 5),
		rtpMockWithoutTier = mockRtp({ slotname: [ 'HOME_TOP_RIGHT_BOXAD' ] }, true),

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
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			mockGptProvider(false),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(adConfig.getProvider([lowValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderLaterMock, 'adProviderLaterMock');
	});

	it('getProvider use GPT for high value slots', function () {
		var adProviderGptMock = mockGptProvider(true),
			adConfig = modules['ext.wikia.adEngine.adConfig'](
				logMock,
				mockGeo(),
				mockAdContext(true),
				adDecoratorPageDimensionsMock,
				mockEvolveSlotConfig(false),
				mockGptProvider(true),
				rtpMock,

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
			gptSlotConfigMock,
			rtpMock,

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
			gptSlotConfigMock,
			rtpMock,

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
			gptSlotConfigMock,
			rtpMock,

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
			gptSlotConfigMock,
			rtpMock,

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
			gptSlotConfigMock,
			rtpMock,

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
			gptSlotConfigMock,
			rtpMock,

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
				mockGeo(),
				mockAdContext(false),
				adDecoratorPageDimensionsMock,
				mockEvolveSlotConfig(true),
				gptSlotConfigMock,
				rtpMock,

				// AdProviders
				mockGptProvider(true),
				adProviderLaterMock,
				adProviderNullMock
			);

		// First check if NullProvider wins over GPT
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Second check if NullProvider wins over Later
		geoMock.getCountryCode = function () { return; };
		expect(adConfig.getProvider([lowValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');

		// Third check if NullProvider wins over Evolve
		geoMock.getCountryCode = function () { return 'NZ'; };
		expect(adConfig.getProvider([highValueSlot])).toBe(adProviderNullMock, 'adProviderNullMock wgShowAds false');
	});

	it('getProvider RTP integration -- RTP not called', function () {
		spyOn(gptSlotConfigMock, 'extendSlotParams');

		modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(false),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),
			gptSlotConfigMock,
			mockRtp(),

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(gptSlotConfigMock.extendSlotParams.calls.length).toBe(0);
	});

	it('getProvider RTP integration -- RTP called without tier info', function () {
		spyOn(gptSlotConfigMock, 'extendSlotParams');
		spyOn(rtpMockWithoutTier, 'trackState');

		modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(false),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),
			gptSlotConfigMock,
			rtpMockWithoutTier,

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(gptSlotConfigMock.extendSlotParams.calls.length).toBe(0);
		expect(rtpMockWithoutTier.trackState).toHaveBeenCalled();
	});

	it('getProvider RTP integration -- RTP called with tier info', function () {
		spyOn(gptSlotConfigMock, 'extendSlotParams');
		spyOn(rtpMockWithTier, 'trackState');

		modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(false),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),
			gptSlotConfigMock,
			rtpMockWithTier,

			// AdProviders
			mockGptProvider(true),
			adProviderLaterMock,
			adProviderNullMock
		);

		expect(gptSlotConfigMock.extendSlotParams)
			.toHaveBeenCalledWith('gpt', 'HOME_TOP_RIGHT_BOXAD', { 'rp_tier': 5 });
		expect(rtpMockWithTier.trackState).toHaveBeenCalled();
	});
});
