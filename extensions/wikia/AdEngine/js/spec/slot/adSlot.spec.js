/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.adSlot', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.slot.adSlot']();
	}

	it('getShortSlotName - should return last part of slotPath', function () {
		expect(getModule().getShortSlotName('long/slot/name/slotName')).toBe('slotName', 'Last part of slot name');
	});

	it('getShortSlotName - should keep slotName untouched if passed slotName is not a path', function () {
		expect(getModule().getShortSlotName('TOP_LEADERBOARD')).toBe('TOP_LEADERBOARD');
	});

});
