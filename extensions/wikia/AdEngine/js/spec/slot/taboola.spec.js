/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.slot.taboola', function () {
	'use strict';

	function noop() {}

	var mocks = {
			adContext: {
				getContext: function () {
					return mocks.context;
				}
			},
			abTest: {
				getGroup: function () {
					return mocks.abTestGroup;
				}
			},
			doc: {
				getElementById: function () {
					return {};
				}
			},
			log: noop,
			recoveryHelper: {
				addOnBlockingCallback: function (callback) {
					callback();
				}
			},
			win: {}
		};

	beforeEach(function () {
		mocks.context = {
			providers: {
				taboola: true
			}
		};
		mocks.abTestGroup = 'GROUP_3';
		mocks.win.adslots2 = [];
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.taboola'](
			mocks.adContext,
			mocks.doc,
			mocks.log,
			mocks.win,
			mocks.abTest
		);
	}

	it('Do nothing when taboola provider is disabled', function () {
		mocks.context.providers.taboola = false;
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(0);
	});

	it('Do nothing when AbGroup is GROUP_0', function () {
		mocks.abTestGroup = 'GROUP_0';
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(0);
	});

	it('Add only right rail module when AbGroup is GROUP_1', function () {
		mocks.abTestGroup = 'GROUP_1';
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(1);
		expect(mocks.win.adslots2[0]).toEqual('NATIVE_TABOOLA_RAIL');
	});

	it('Add only below article module when AbGroup is GROUP_2', function () {
		mocks.abTestGroup = 'GROUP_2';
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(1);
		expect(mocks.win.adslots2[0]).toEqual('NATIVE_TABOOLA_ARTICLE');
	});

	it('Add all taboola slots when provider is enabled and AbGroup is GROUP_3', function () {
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(2);
	});
});
