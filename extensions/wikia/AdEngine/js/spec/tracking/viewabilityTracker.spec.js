/*global beforeEach, describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.tracking.viewabilityTracker', function () {
	'use strict';

	var mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: mocks.opts
					};
				}
			},
			adTracker: {
				trackDW: function () {}
			},
			log: function () {},
			opts: {
				isOptedIn: true,
				kikimoraViewabilityTracking: true
			},
			trackingOptIn: {
				isOptedIn: function () {
					return mocks.opts.isOptedIn
				}
			},
			win: {
				pvUID: 'fooBarID'
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.tracking.viewabilityTracker'](
			mocks.adContext,
			mocks.adTracker,
			mocks.log,
			mocks.trackingOptIn,
			mocks.win
		);
	}

	function getSlot() {
		return {
			container: {
				firstChild: {
					dataset: {
						gptSlotParams: '{"wsi":"foo1","rv":"2"}',
						gptLineItemId: '567',
						gptCreativeId: '123'
					}
				}
			}
		};
	}

	beforeEach(function () {
		mocks.opts.isOptedIn = true;
		mocks.opts.kikimoraViewabilityTracking = true;
		mocks.log.levels = {};
	});

	it('Do not track if it is disabled in context', function () {
		spyOn(mocks.adTracker, 'trackDW');
		mocks.opts.kikimoraViewabilityTracking = false;

		getModule().track({});

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Do not track if user opts out', function () {
		spyOn(mocks.adTracker, 'trackDW');
		mocks.opts.isOptedIn = false;

		getModule().track({});

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Track basic information on view', function () {
		spyOn(mocks.adTracker, 'trackDW');

		getModule().track(getSlot());

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.pv_unique_id).toBe('fooBarID');
		expect(trackedData.wsi).toBe('foo1');
		expect(trackedData.line_item_id).toBe('567');
		expect(trackedData.creative_id).toBe('123');
		expect(trackedData.rv).toBe('2');
	});
});
