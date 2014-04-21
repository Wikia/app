/*global describe, it, expect, AdConfig2Late*/
describe('AdConfig2Late', function () {
	'use strict';

	var uaIE8 = [
		'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0;',
		'GTB7.4; InfoPath.2; SV1; .NET CLR 3.3.69573; WOW64; en-US)'
	].join('');

	var adProviderRemnantGpt = {name: 'RemnantGpt', canHandleSlot: function() {return false;}};


		it('getProvider returns Liftium if it can handle it', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {},
			abTestMock = {inGroup: function () {return false;}},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns Null if Liftium cannot handle it', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return false;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {},
			abTestMock = {inGroup: function () {return false;}},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderNullMock');
	});

	it('getProvider returns SevenOneMedia if it can handle it (for wgAdDriverUseSevenOneMedia)', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {wgAdDriverUseSevenOneMedia: true},
			abTestMock = {inGroup: function () {return false;}},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderSevenOneMedia, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Null for 71M disaster recovery with wgAdDriverUseSevenOneMedia', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {wgAdDriverUseSevenOneMedia: true},
			abTestMock = {
				inGroup: function (experiment, group) {
					return (experiment === 'SEVENONEMEDIA_DR' && group === 'DISABLED');
				}
			},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Liftium for 71M disaster recovery without wgAdDriverUseSevenOneMedia', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {wgAdDriverUseSevenOneMedia: false},
			abTestMock = {
				inGroup: function (experiment, group) {
					return (experiment === 'SEVENONEMEDIA_DR' && group === 'DISABLED');
				}
			},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Null for IE8 with wgAdDriverUseSevenOneMedia', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {wgAdDriverUseSevenOneMedia: true, navigator: {userAgent: uaIE8}},
			abTestMock = {inGroup: function () {}},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);
		expect(adConfig.getProvider(['foo'])).toBe(adProviderNullMock, 'adProviderSevenOneMediaMock');
	});

	it('getProvider returns Liftium for IE8 without wgAdDriverUseSevenOneMedia', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {wgAdDriverUseSevenOneMedia: false, navigator: {userAgent: uaIE8}},
			abTestMock = {inGroup: function () {}},
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);
		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});

	it('getProvider returns Liftium without AbTest', function() {
		var adProviderNullMock = {name: 'NullMock'},
			adProviderLiftiumMock = {name: 'LiftiumMock', canHandleSlot: function() {return true;}},
			adProviderSevenOneMedia = {name: 'SevenOneMediaMock', canHandleSlot: function() {return true;}},
			logMock = function() {},
			windowMock = {wgAdDriverUseSevenOneMedia: false},
			abTestMock,
			adConfig;

		adConfig = modules['ext.wikia.adEngine.adConfigLate'](
			logMock,
			windowMock,
			abTestMock,
			adProviderLiftiumMock,
			adProviderRemnantGpt,
			adProviderNullMock,
			adProviderSevenOneMedia
		);

		expect(adConfig.getProvider(['foo'])).toBe(adProviderLiftiumMock, 'adProviderLiftiumMock');
	});
});
