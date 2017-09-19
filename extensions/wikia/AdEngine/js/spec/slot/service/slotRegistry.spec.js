/*global beforeEach, describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.service.slotRegistry', function () {
	'use strict';

	var mocks = {
			adContext: {
				addCallback: function () {}
			}
		},
		registry;

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.slotRegistry'](
			mocks.adContext
		);
	}

	beforeEach(function () {
		registry = getModule();
	});

	it('Returns null when slot is not added', function () {
		expect(registry.get('TOP_LEADERBOARD')).toBe(null);
		expect(registry.get('TOP_LEADERBOARD', 'direct')).toBe(null);
	});

	it('Returns added slot', function () {
		var slot = {
			name: 'TOP_LEADERBOARD'
		};

		registry.add(slot, 'direct');

		expect(registry.get('TOP_LEADERBOARD')).toBe(slot);
	});

	it('Returns null when there is no slot for given provider', function () {
		var slot = {
			name: 'TOP_LEADERBOARD'
		};

		registry.add(slot, 'direct');

		expect(registry.get('TOP_LEADERBOARD', 'remnant')).toBe(null);
	});

	it('Returns recently added slot or specific for provider', function () {
		var directSlot = {
				id: 1,
				name: 'TOP_LEADERBOARD'
			},
			remnantSlot = {
				id: 2,
				name: 'TOP_LEADERBOARD'
			};

		registry.add(directSlot, 'direct');
		registry.add(remnantSlot, 'remnant');

		expect(registry.get('TOP_LEADERBOARD')).toBe(remnantSlot);
		expect(registry.get('TOP_LEADERBOARD', 'direct')).toBe(directSlot);
		expect(registry.get('TOP_LEADERBOARD', 'remnant')).toBe(remnantSlot);
	});

	it('Return null after reset', function () {
		var directSlot = {
				id: 1,
				name: 'TOP_LEADERBOARD'
			};

		registry.add(directSlot, 'direct');

		registry.reset('TOP_LEADERBOARD');

		expect(registry.get('TOP_LEADERBOARD')).toBe(null);
		expect(registry.get('TOP_LEADERBOARD', 'direct')).toBe(null);
	});

	it('Starting a slot queue increments refreshed view count', function () {
		var directSlot = {
				id: 1,
				name: 'TOP_LEADERBOARD'
			},
			remnantSlot = {
				id: 2,
				name: 'TOP_LEADERBOARD'
			};

		registry.add(directSlot, 'direct');
		registry.add(remnantSlot, 'remnant');
		expect(registry.getRefreshCount('TOP_LEADERBOARD')).toBe(1);

		registry.reset('TOP_LEADERBOARD');
		expect(registry.getRefreshCount('TOP_LEADERBOARD')).toBe(1);

		registry.add(directSlot, 'direct');
		expect(registry.getRefreshCount('TOP_LEADERBOARD')).toBe(2);
	});
});
