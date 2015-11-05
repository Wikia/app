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
			context: {},
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
		mocks.win.adslots2 = [];
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.taboola'](
			mocks.adContext,
			mocks.doc,
			mocks.log,
			mocks.win
		);
	}

	it('Do nothing when taboola provider is disabled', function () {
		mocks.context.providers.taboola = false;
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(0);
	});

	it('Add all taboola slots when provider is enabled', function () {
		getModule().init();

		expect(mocks.win.adslots2.length).toEqual(2);
	});
});
