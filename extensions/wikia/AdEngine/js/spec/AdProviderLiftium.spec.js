/*global describe, it, modules, expect*/
describe('AdProviderLiftium', function () {
	'use strict';
	it('canHandleSlot', function () {
		var scriptWriterMock = {},
			logMock = function () { return; },
			windowMock = {},
			documentMock = {},
			slotTweakerMock = {},
			adProviderLiftium;

		adProviderLiftium = modules['ext.wikia.adEngine.provider.liftium'](
			documentMock,
			logMock,
			scriptWriterMock,
			windowMock,
			slotTweakerMock
		);

		expect(adProviderLiftium.canHandleSlot(['foo'])).toBeFalsy('foo');
		expect(adProviderLiftium.canHandleSlot(['TOP_BUTTON_WIDE'])).toBeTruthy('TOP_BUTTON_WIDE');
		expect(adProviderLiftium.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderLiftium.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
	});
});
