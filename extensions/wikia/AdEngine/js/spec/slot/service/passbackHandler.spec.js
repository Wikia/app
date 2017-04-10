/*global beforeEach, describe, it, expect, modules, spyOn, jasmine*/
describe('ext.wikia.adEngine.slot.service.passbackHandler', function () {
	'use strict';

	var mocks = {
		events: [],
		stateMonitor: {
			getSlotStatuses: function () {

			}
		}
	};

	beforeEach(function () {});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.passbackHandler'](mocks.stateMonitor);
	}

	it('Should return correct last hop adInfo', function () {
		spyOn(mocks.stateMonitor, 'getSlotStatuses').and.returnValue([
			{adInfo: {source: 'A' }},
			{adInfo: {source: 'B' }},
			{adInfo: {source: 'C' }}
		]);

		expect(getModule().get('SLOT_NAME')).toEqual('C');
	});

	it('Should return null for no hop', function () {
		spyOn(mocks.stateMonitor, 'getSlotStatuses').and.returnValue([]);

		expect(getModule().get('SLOT_NAME')).toEqual(null);
	});

	it('Should return "unknown" for missing adInfo', function () {
		spyOn(mocks.stateMonitor, 'getSlotStatuses').and.returnValue([
			{}
		]);

		expect(getModule().get('SLOT_NAME')).toEqual('unknown');
	});

	it('Should return "unknown" for empty adInfo', function () {
		spyOn(mocks.stateMonitor, 'getSlotStatuses').and.returnValue([
			{adInfo: {}}
		]);

		expect(getModule().get('SLOT_NAME')).toEqual('unknown');
	});

});
