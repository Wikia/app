/*global describe, it, expect, modules*/
describe('AdConfig2Late', function () {
	'use strict';

	var uaIE8 = [
		'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0;',
		'GTB7.4; InfoPath.2; SV1; .NET CLR 3.3.69573; WOW64; en-US)'
	].join('');


	it('getProvider returns Liftium if it can handle it', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns Null if Liftium cannot handle it', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return false;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return false;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderNullMock');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia) Poland', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: true},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderSevenOneMedia, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia) Australia', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: true},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'AU'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderSevenOneMedia, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Null for 71M disaster recovery with wgAdDriverUseSevenOneMedia', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: true},
			instantGlobalsMock = { wgSitewideDisableSevenOneMedia: true },
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Liftium for 71M disaster recovery without wgAdDriverUseSevenOneMedia', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: false},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Null for IE8 with wgAdDriverUseSevenOneMedia', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: true, navigator: {userAgent: uaIE8}},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);
		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Liftium for IE8 without wgAdDriverUseSevenOneMedia', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: false, navigator: {userAgent: uaIE8}},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);
		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns Liftium without AbTest', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseSevenOneMedia: false},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () { return 'PL'; } },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns DirectGpt for wgAdDriverUseDartForSlotsBelowTheFold for given slots', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseDartForSlotsBelowTheFold: true},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () {return 'US';} },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['MODAL_INTERSTITIAL'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['LEFT_SKYSCRAPER_3'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
	});

	it('getProvider returns DirectGpt for truthy wgAdDriverUseDartForSlotsBelowTheFold within Entertainment amd Gaming verticals for given slots', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseDartForSlotsBelowTheFold: 'any truthy value', cscoreCat: "Entertainment"},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () {return 'US';} },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['MODAL_INTERSTITIAL'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['LEFT_SKYSCRAPER_3'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');

		windowMock = {wgAdDriverUseDartForSlotsBelowTheFold: 'any truthy value', cscoreCat: "Gaming"};

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['MODAL_INTERSTITIAL'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['LEFT_SKYSCRAPER_3'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD'])).toBe(adProviderDirectGpt, 'adProviderDirectGpt');

	});

	it('getProvider returns Liftium for truthy wgAdDriverUseDartForSlotsBelowTheFold within other verticals for given slots', function () {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderEvolveMock = {name: 'EvolveMock', canHandleSlot: function () {return true;}},
			adProviderDirectGpt = {name: 'DirectGpt', canHandleSlot: function () {return true;}},
			adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function () {return false;}},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function () {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function () {return true;}},
			logMock = function () {},
			windowMock = {wgAdDriverUseDartForSlotsBelowTheFold: 'any truthy value', cscoreCat: "Lifestyle"},
			instantGlobalsMock = {},
			geoMock = { getCountryCode: function () {return 'US';} },
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			instantGlobalsMock,
			geoMock,
			adProviderEvolveMock,
			adProviderLiftiumMock,
			adProviderDirectGpt,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['MODAL_INTERSTITIAL'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['LEFT_SKYSCRAPER_3'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_LEFT_BOXAD'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');
		expect(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD'])).not.toBe(adProviderDirectGpt, 'adProviderDirectGpt');

	});


});