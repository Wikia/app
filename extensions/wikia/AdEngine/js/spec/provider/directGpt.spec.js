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
			defaultAdUnitBuilder: {name: 'defaultAdUnit'},
			kiloAdUnitBuilder: {name: 'kiloAdUnit'}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.directGptMobile'](
			mocks.adContext,
			mocks.defaultAdUnitBuilder,
			mocks.kiloAdUnitBuilder,
			mocks.factory
		);
	}

	it('Return default adUnit if there is no param in context', function () {
		spyOn(mocks.factory, 'createProvider');

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].adUnitBuilder)
			.toEqual(mocks.defaultAdUnitBuilder);
	});

	it('Return KILO adUnit if there is param in context', function () {
		spyOn(mocks.factory, 'createProvider');
		spyOn(mocks.adContext, 'getContext').and.returnValue({opts: {enableKILOAdUnit: true}});

		getModule();

		expect(mocks.factory.createProvider.calls.argsFor(0)[4].adUnitBuilder)
			.toEqual(mocks.kiloAdUnitBuilder);
	});
});
