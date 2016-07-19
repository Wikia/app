/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.recirculation.tracker', function () {
	'use strict';
	function noop() {}

	var mocks = {
			abTest: {
				getGroup: function() {
					return 'GROUP_1';
				}
			},
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
			mocks.wikiaTracker,
			mocks.abTest
		);
	}

	beforeEach(function() {
		spyOn(mocks.wikiaTracker, 'track');
	});

	describe('trackVerboseClick', function() {
		it('Calls the track method with the proper parameters', function() {
			getTracker().trackVerboseClick('RECIRCULATION', 'Link');
			expect(mocks.wikiaTracker.track).toHaveBeenCalledWith({
				action: 'click',
				category: 'recirculation',
				trackingMethod: 'analytics',
				label: 'RECIRCULATION=GROUP_1=Link'
			});
		});
	});

	describe('trackVerboseImpression', function() {
		it('Calls the track method with the proper parameters', function() {
			getTracker().trackVerboseImpression('RECIRCULATION', 'Link');
			expect(mocks.wikiaTracker.track).toHaveBeenCalledWith({
				action: 'impression',
				category: 'recirculation',
				trackingMethod: 'analytics',
				label: 'RECIRCULATION=GROUP_1=Link'
			});
		});
	});
});
