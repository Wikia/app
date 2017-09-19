/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.slot.service.viewabilityHandler', function () {
	'use strict';

	function noop() {}

	var handler,
		mocks = {
			log: noop,
			googleTag: {
				destroySlots: noop,
				refresh: noop
			},
			slot: {
				isViewed: false,
				post: noop
			},
			slotRegistry: {
				get: function (slotName) {
					if (slotName === 'NOT_DEFINED') {
						return null;
					}

					if (slotName === 'ALREADY_VIEWED_FOO') {
						mocks.slot.isViewed = true;
					}

					return mocks.slot;
				}
			},
			win: {
				adslots2: [],
				setTimeout: function (callback) {
					callback();
				}
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.viewabilityHandler'](
			mocks.googleTag,
			mocks.slotRegistry,
			mocks.log,
			mocks.win
		);
	}

	beforeEach(function () {
		handler = getModule();
		mocks.log.levels = [];
		mocks.slot.isViewed = false;
		mocks.win.adslots2 = [];
	});

	it('Do not refresh if slot is not defined', function () {
		spyOn(mocks.slot, 'post');
		spyOn(mocks.googleTag, 'destroySlots');
		spyOn(mocks.win.adslots2, 'push');

		handler.refreshOnView('NOT_DEFINED');

		expect(mocks.slot.post).not.toHaveBeenCalled();
		expect(mocks.win.adslots2.push).not.toHaveBeenCalled();
	});

	it('Refresh slot immediately if it was already viewed', function () {
		spyOn(mocks.googleTag, 'destroySlots');
		spyOn(mocks.win.adslots2, 'push');

		handler.refreshOnView('ALREADY_VIEWED_FOO');

		expect(mocks.win.adslots2.push).toHaveBeenCalled();
		expect(mocks.googleTag.destroySlots).toHaveBeenCalled();
	});

	it('Add hook if slot was not viewed yet', function () {
		spyOn(mocks.slot, 'post');

		handler.refreshOnView('NOT_VIEWED_BAR');

		expect(mocks.slot.post).toHaveBeenCalled();
	});
});
