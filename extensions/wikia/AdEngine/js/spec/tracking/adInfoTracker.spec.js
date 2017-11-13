/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.tracking.adInfoTracker', function () {
	'use strict';
	function noop() {}

	var mocks = {
		adTracker: {
			trackDW: function () {
				return {};
			}
		},
		slotRegistry: {
			getScrollY: noop
		},
		browserDetect: {
			getOS: function () {
				return 'BarOS';
			},
			getBrowser: function () {
				return 'Foo 50';
			}
		},
		pageLayout: {
			getSerializedData: function () {
				return 'xyz=012';
			}
		},
		window: {
			document: {
				body: {
					scrollHeight: 500
				}
			},
			pvUID: 'foo-xxx-bar'
		},
		log: noop
	};

	function getModule() {
		return modules['ext.wikia.adEngine.tracking.adInfoTracker'](
			mocks.adTracker,
			mocks.slotRegistry,
			mocks.pageLayout,
			mocks.browserDetect,
			mocks.log,
			mocks.window
		);
	}

	mocks.log.levels = {};

	it('track data with page params', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO', {
			pv: '1',
			geo: 'PL',
			s0: 'life',
			s1: '_project43',
			s2: 'article',
			s0v: 'lifestyle',
			lang: 'pl',
			skin: 'oasis',
			esrb: 'teen',
			ref: 'foo',
			top: '1k'
		});

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.pv).toBe('1');
		expect(trackedData.pv_unique_id).toBe('foo-xxx-bar');
		expect(trackedData.country).toBe('PL');
		expect(trackedData.kv_s0).toBe('life');
		expect(trackedData.kv_s1).toBe('_project43');
		expect(trackedData.kv_s2).toBe('article');
		expect(trackedData.kv_s0v).toBe('lifestyle');
		expect(trackedData.kv_lang).toBe('pl');
		expect(trackedData.kv_skin).toBe('oasis');
		expect(trackedData.kv_esrb).toBe('teen');
		expect(trackedData.kv_ref).toBe('foo');
		expect(trackedData.kv_top).toBe('1k');
	});

	it('track data with slot params', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO', {}, {
			pos: 'FOO',
			rv: '2',
			wsi: 'ofa1',
			abi: '50_1'
		});

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.kv_pos).toBe('FOO');
		expect(trackedData.kv_rv).toBe('2');
		expect(trackedData.kv_wsi).toBe('ofa1');
		expect(trackedData.kv_abi).toBe('50_1');
	});

	it('track data with page layout', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO', {}, {});

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.page_layout).toBe('xyz=012');
	});

	it('track data with creative details', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO', {}, {}, {
			creativeId: '123',
			creativeSize: '[728,90]',
			lineItemId: '789',
			slotSize: [728, 90],
			status: 'success'
		});

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.creative_id).toBe('123');
		expect(trackedData.creative_size).toBe('728x90');
		expect(trackedData.product_lineitem_id).toBe('789');
		expect(trackedData.slot_size).toBe('728x90');
		expect(trackedData.ad_status).toBe('success');
	});

	it('prepareData correctly calculates bidder_won for no bidders', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO');

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.bidder_won).toBe('');
	});

	it('prepareData correctly calculates bidder_won for bidders - openx', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO', {}, {}, {}, {
			bidderWon: 'openx',
			realSlotPrices: {
				openx: '3.30',
				rubicon: '0.75'
			}
		});

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.bidder_won).toBe('openx');
		expect(trackedData.bidder_4).toBe('0.75');
		expect(trackedData.bidder_9).toBe('3.30');
	});

	it('include browser information data', function () {
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO');

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.browser).toBe('BarOS Foo 50');
	});

	it('include article height', function () {
		mocks.window.document.body.scrollHeight = 57;
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO');

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.kv_ah).toBe(57);
	});

	it('include default product_chosen', function () {
		mocks.window.document.body.scrollHeight = 57;
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO');

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.product_chosen).toBe('unknown');
	});

	it('include given product_chosen', function () {
		mocks.window.document.body.scrollHeight = 57;
		spyOn(mocks.adTracker, 'trackDW');
		getModule().track('FOO', {}, {}, {adProduct: 'chosen_product'});

		var trackedData = mocks.adTracker.trackDW.calls.mostRecent().args[0];

		expect(trackedData.product_chosen).toBe('chosen_product');
	});
});
