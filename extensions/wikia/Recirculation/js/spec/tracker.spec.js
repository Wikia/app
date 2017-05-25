/*global beforeEach, describe, it, modules, expect*/
describe('ext.wikia.recirculation.tracker', function () {
	'use strict';

	var mocks = {
			wikiaTracker: {
				ACTIONS: {
					CLICK: 'click',
					IMPRESSION: 'impression'
				},
				track: function() {}
			}
		};

	function getTracker() {
		return modules['ext.wikia.recirculation.tracker'](
			mocks.wikiaTracker
		);
	}

	beforeEach(function() {
		spyOn(mocks.wikiaTracker, 'track');
	});

	describe('trackImpression', function() {
		it('Calls the track method with the proper parameters', function() {
			getTracker().trackImpression('test-label');
			expect(mocks.wikiaTracker.track).toHaveBeenCalledWith({
				action: 'impression',
				category: 'recirculation',
				trackingMethod: 'analytics',
				label: 'test-label'
			});
		});
	});

	describe('trackClick', function() {
		it('Calls the track method with the proper parameters', function() {
			getTracker().trackClick('test-label');
			expect(mocks.wikiaTracker.track).toHaveBeenCalledWith({
				action: 'click',
				category: 'recirculation',
				trackingMethod: 'analytics',
				label: 'test-label'
			});
		});
	});
});
