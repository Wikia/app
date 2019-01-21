/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.provider.directGpt', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				getContext: function () {
					return mocks.context;
				}
			},
			context: {
				opts: {

				}
			},
			factory: {
				createProvider: noop
			},
			megaAdUnitBuilder: {name: 'megaAdUnit'},
			slotTweaker: {}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.directGpt'](
			mocks.adContext,
			mocks.factory,
			mocks.megaAdUnitBuilder,
			mocks.slotTweaker
		);
	}

	it('Return mega adUnit builder when enabled in context', function () {
		spyOn(mocks.factory, 'createProvider');
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts:{megaAdUnitBuilderEnabled: true}});

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].getAdUnitBuilder())
			.toEqual(mocks.megaAdUnitBuilder);
	});
});
