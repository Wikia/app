/*global describe, it, modules, expect*/
describe('AdProviderLiftium', function () {
	'use strict';

	function noop() {
		return;
	}

	it('canHandleSlot', function () {
		var scriptWriterMock = {},
			logMock = function () { return; },
			adContextMock = {
				getContext: noop
			},
			windowMock = {},
			documentMock = {},
			slotTweakerMock = {},
			adProviderLiftium;

		adProviderLiftium = modules['ext.wikia.adEngine.provider.liftium'](
			adContextMock,
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
