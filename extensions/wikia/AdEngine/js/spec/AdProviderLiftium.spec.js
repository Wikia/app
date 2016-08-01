/*global describe, it, modules, expect*/
describe('AdProviderLiftium', function () {
	'use strict';

	function noop() {
		return;
	}

	it('canHandleSlot', function () {
		var scriptWriterMock = {},
			logMock = function () { return; },
			contextMock = {
				opts: noop
			},
			adContextMock = {
				getContext: function () {
					return contextMock;
				}
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
		expect(adProviderLiftium.canHandleSlot(['TOP_LEADERBOARD'])).toBeTruthy('TOP_LEADERBOARD');
		expect(adProviderLiftium.canHandleSlot(['TOP_RIGHT_BOXAD'])).toBeTruthy('TOP_RIGHT_BOXAD');
	});
});
