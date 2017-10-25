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
				kikimoraViewabilityTracking: true
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
		mocks.opts.kikimoraViewabilityTracking = true;
		mocks.log.levels = {};
	});

	it('Do not track if it is disabled in context', function () {
		spyOn(mocks.adTracker, 'trackDW');
		mocks.opts.kikimoraViewabilityTracking = false;

		getModule().track({});

		expect(mocks.adTracker.trackDW).not.toHaveBeenCalled();
	});

	it('Track basic information on view', function () {
		spyOn(mocks.adTracker, 'trackDW');

		getModule().track(getSlot());

		expect(mocks.adTracker.trackDW).toHaveBeenCalledWith({
			'pv_unique_id': 'fooBarID',
			'wsi': 'foo1',
			'line_item_id': '567',
			'creative_id': '123',
			'rv': '2'
		}, 'adengviewability');
	});
});
