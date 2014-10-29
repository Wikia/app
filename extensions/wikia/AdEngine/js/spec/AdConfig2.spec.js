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

	function mockRtp(called, tier) {
		return {
			wasCalled: function () {
				return called;
			},
			trackState: function () {
				return;
			},
			getTier: function () {
				return tier;
			}
		};
	}

	// Mocks:
	var adDecoratorPageDimensionsMock = {isApplicable: function () { return false; }},
		adProviderLaterMock = {name: 'LaterMock'},
		adProviderGptMock = {name: 'GptMock'},
		logMock = function () { return; },
		gptSlotConfigMock = {
			extendSlotParams: function () {
				return;
			}
		},
		rtpMock = mockRtp(),
		rtpMockWithTier = mockRtp(true, 5),
		rtpMockWithoutTier = mockRtp(true),

	// Fixtures:
		highValueSlot = 'TOP_LEADERBOARD',
		lowValueSlot = 'foo';

	it('getProviderList returns [GPT, Later] for high value slots', function () {

		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([highValueSlot])).toEqual([adProviderGptMock, adProviderLaterMock], 'adProviderLaterMock');
	});

	it('getProviderList returns [Later] for low value slots', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([lowValueSlot])).toEqual([adProviderLaterMock], 'adProviderLaterMock');
	});

	it('getProviderList returns [Later] for NZ for both high and low value slots (if evolve slot config accepts)', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([lowValueSlot])).toEqual([adProviderLaterMock], 'adProviderLaterMock NZ');
		expect(adConfig.getProviderList([highValueSlot])).toEqual([adProviderLaterMock], 'adProviderLaterMock NZ');
	});

	it('getProviderList to return [GPT, Later] for NZ (if evolve slot config does not accept)', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			mockAdContext(true),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([highValueSlot])).toEqual([adProviderGptMock, adProviderLaterMock], 'adProviderGptMock');
	});

	it('getProviderList to return [Later] when adContext.providers.sevenOneMedia = true in HVC', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo(),
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([highValueSlot])).toEqual([adProviderLaterMock], 'adProviderLaterMock');
	});

	it('getProviderList to return [Later] when wgAdProviderSevenOneMedia = true in PL', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('PL'),
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(false),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([highValueSlot])).toEqual([adProviderLaterMock], 'adProviderLaterMock');
	});

	it('getProviderList to return [Later] when wgAdProviderSevenOneMedia = true in NZ', function () {
		var adConfig = modules['ext.wikia.adEngine.adConfig'](
			logMock,
			mockGeo('NZ'),
			mockAdContext(true, {sevenOneMedia: true}),
			adDecoratorPageDimensionsMock,
			mockEvolveSlotConfig(true),
			gptSlotConfigMock,
			rtpMock,

			// AdProviders
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(adConfig.getProviderList([highValueSlot])).toEqual([adProviderLaterMock], 'adProviderLaterMock');
	});

	it('getProviderList to return [] when wgShowAds = false', function () {
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
				adProviderGptMock,
				adProviderLaterMock
			);

		// First check if NullProvider wins over GPT
		expect(adConfig.getProviderList([highValueSlot])).toEqual([], 'adProviderNullMock wgShowAds false');

		// Second check if NullProvider wins over Later
		geoMock.getCountryCode = function () { return; };
		expect(adConfig.getProviderList([lowValueSlot])).toEqual([], 'adProviderNullMock wgShowAds false');
		expect(adConfig.getProviderList([highValueSlot])).toEqual([], 'adProviderNullMock wgShowAds false');

		// Third check if NullProvider wins over Evolve
		geoMock.getCountryCode = function () { return 'NZ'; };
		expect(adConfig.getProviderList([highValueSlot])).toEqual([], 'adProviderNullMock wgShowAds false');
	});

	it('getProviderList RTP integration -- RTP not called', function () {
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
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(gptSlotConfigMock.extendSlotParams.calls.length).toBe(0);
	});

	it('getProviderList RTP integration -- RTP called without tier info', function () {
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
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(gptSlotConfigMock.extendSlotParams.calls.length).toBe(0);
		expect(rtpMockWithoutTier.trackState).toHaveBeenCalled();
	});

	it('getProviderList RTP integration -- RTP called with tier info', function () {
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
			adProviderGptMock,
			adProviderLaterMock
		);

		expect(gptSlotConfigMock.extendSlotParams)
			.toHaveBeenCalledWith('gpt', 'HOME_TOP_RIGHT_BOXAD', { 'rp_tier': 5 });
		expect(rtpMockWithTier.trackState).toHaveBeenCalled();
	});
});
