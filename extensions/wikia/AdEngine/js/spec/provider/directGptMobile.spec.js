/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.provider.directGptMobile', function () {
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
			kiloAdUnitBuilder: {name: 'kiloAdUnit'},
			megaAdUnitBuilder: {name: 'megaAdUnit'}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.directGptMobile'](
			mocks.adContext,
			mocks.kiloAdUnitBuilder,
			mocks.megaAdUnitBuilder,
			mocks.factory
		);
	}

	it('Return kilo adUnit if there is no param in context', function () {
		spyOn(mocks.factory, 'createProvider');

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].getAdUnitBuilder())
			.toEqual(mocks.kiloAdUnitBuilder);
	});

	it('Return MEGA adUnit if there is correct param turned on', function () {
		spyOn(mocks.factory, 'createProvider');
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts:{megaAdUnitBuilderEnabled: true}});

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].getAdUnitBuilder())
			.toEqual(mocks.megaAdUnitBuilder);
	});
});
