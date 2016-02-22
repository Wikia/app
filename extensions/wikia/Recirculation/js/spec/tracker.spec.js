/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.recirculation.tracker', function () {
	'use strict';
	function noop() {}

	var experimentName = 'RECIRCULATION',
		defaults = {
			category: 'recirculation',
			trackingMethod: 'analytics'
		},
		mocks = {
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
			var tracker = getTracker(),
				label = 'Link',
				expectedLabel = experimentName + '=' + mocks.abTest.getGroup() + '=' + label;

			var expectedParams = {
				action: mocks.wikiaTracker.ACTIONS.CLICK,
				category: defaults.category,
				trackingMethod: defaults.trackingMethod,
				label: expectedLabel
			};

			tracker.trackVerboseClick(experimentName, label);
			expect(mocks.wikiaTracker.track).toHaveBeenCalledWith(expectedParams);
		});
	});

	describe('trackVerboseImpression', function() {
		it('Calls the track method with the proper parameters', function() {
			var tracker = getTracker(),
				label = 'Link',
				expectedLabel = experimentName + '=' + mocks.abTest.getGroup() + '=' + label;

			var expectedParams = {
				action: mocks.wikiaTracker.ACTIONS.IMPRESSION,
				category: defaults.category,
				trackingMethod: defaults.trackingMethod,
				label: expectedLabel
			};

			tracker.trackVerboseImpression(experimentName, label);
			expect(mocks.wikiaTracker.track).toHaveBeenCalledWith(expectedParams);
		});
	});
});
