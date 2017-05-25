/*global beforeEach, describe, it, expect, modules, spyOn, jasmine*/
describe('ext.wikia.adEngine.slot.service.stateMonitor', function () {
	'use strict';

	var mocks = {
		events: [],
		window: {
			addEventListener: function (name, callback) {
				mocks.events.forEach(function (event) {
					callback(event);
				});
			}
		}
	};

	beforeEach(function () {
		mocks.events = [];
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.stateMonitor'](mocks.window);
	}

	function createEvent(slotName, status) {
		return {
			detail: {
				slot: {
					name: slotName
				},
				status: status
			}
		};
	}

	it('Filter all hops', function () {
		var slotStateMonitor = getModule();

		mocks.events.push(createEvent('TOP_LEADERBOARD', 'hop'));
		mocks.events.push(createEvent('TOP_LEADERBOARD', 'hop'));
		mocks.events.push(createEvent('TOP_LEADERBOARD', 'hop'));
		mocks.events.push(createEvent('TOP_LEADERBOARD', 'success'));

		slotStateMonitor.run();

		expect(slotStateMonitor.getSlotStatuses('TOP_LEADERBOARD', 'hop').length).toEqual(3);
		expect(slotStateMonitor.getSlotStatuses('TOP_LEADERBOARD', 'success').length).toEqual(1);
		expect(slotStateMonitor.getSlotStatuses('TOP_LEADERBOARD').length).toEqual(4);
	});
});
