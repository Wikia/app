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
			uapContext: {},
			factory: {
				createProvider: noop
			},
			kiloAdUnitBuilder: {name: 'kiloAdUnit'},
			megaAdUnitBuilder: {name: 'megaAdUnit'},
			slotTweaker: {},
			pageFairRecovery: {},
			sourcePointRecovery: {}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.directGpt'](
			mocks.adContext,
			mocks.uapContext,
			mocks.factory,
			mocks.kiloAdUnitBuilder,
			mocks.megaAdUnitBuilder,
			mocks.slotTweaker,
			mocks.pageFairRecovery,
			mocks.sourcePointRecovery
		);
	}

	it('Return kilo adUnit if there is no param in context', function () {
		spyOn(mocks.factory, 'createProvider');

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].getAdUnitBuilder())
			.toEqual(mocks.kiloAdUnitBuilder);
	});

	it('Return mega adUnit builder when enabled in context', function () {
		spyOn(mocks.factory, 'createProvider');
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts:{megaAdUnitBuilderEnabled: true}});

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].getAdUnitBuilder())
			.toEqual(mocks.megaAdUnitBuilder);
	});

	it('Return kilo adUnit builder when Mega is turned off', function () {
		spyOn(mocks.factory, 'createProvider');
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts:{megaAdUnitBuilderEnabled: false}});

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].getAdUnitBuilder())
			.toEqual(mocks.kiloAdUnitBuilder);
	});
});
