/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.config.desktop', function () {
	'use strict';

	function noop() {
		return;
	}

	function returnEmpty() {
		return {};
	}

	function logMock() {

	}

	logMock.levels = {};

	var mocks = {
			adDecoratorPageDimensions: noop,
			getAdContextOpts: function () {
				return mocks.opts;
			},
			getAdContextTargeting: returnEmpty,
			getAdContextProviders: returnEmpty,
			getAdContextForcedProvider: returnEmpty,
			getInstantGlobals: returnEmpty,
			getUserAgent: noop,
			geo: {
				getCountryCode: noop
			},
			trackingOptIn: {
				isOptedIn: noop
			},
			adsContext: {
				getContext: function () {
					return {
						opts: mocks.getAdContextOpts(),
						targeting: mocks.getAdContextTargeting(),
						providers: mocks.getAdContextProviders(),
						forcedProvider: mocks.getAdContextForcedProvider()
					};
				}
			},
			log: logMock,
			opts: {
				showAds: true,
				premiumOnly: false
			},
			providers: {
				directGpt: {
					name: 'direct'
				},
				remnantGpt: {
					name: 'remnant'
				},
				turtle: {
					name: 'turtle',
					canHandleSlot: noop
				}
			}
		},
		forcedProvidersMap = {
			'turtle': mocks.providers.turtle.name
		};

	function getModule() {
		return modules['ext.wikia.adEngine.config.desktop'](
			mocks.log,
			{navigator: {userAgent: mocks.getUserAgent()}},
			mocks.getInstantGlobals(),
			mocks.geo,
			mocks.trackingOptIn,
			mocks.adsContext,
			mocks.adDecoratorPageDimensions,
			mocks.providers.directGpt,
			mocks.providers.remnantGpt,
			mocks.providers.turtle
		);
	}

	function getProviders(slotName) {
		var providers = getModule().getProviderList(slotName),
			providerNames = providers.map(function (item) {
				return item.name;
			});

		return providerNames.join(',');
	}

	beforeEach(function () {
		mocks.opts = {
			showAds: true,
			premiumOnly: false
		};
	});

	it('default setup: Direct, Remnant', function () {
		expect(getProviders('foo')).toEqual('direct,remnant');
	});

	it('only direct on premium-only page', function () {
		mocks.opts.premiumOnly = true;
		expect(getProviders('foo')).toEqual('direct');
	});

	it('Turtle: Turtle, Remnant', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks.trackingOptIn, 'isOptedIn').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('turtle,remnant');
	});

	it('Turtle cannot handle slot: Direct, Remnant', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(false);
		spyOn(mocks.trackingOptIn, 'isOptedIn').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('direct,remnant');
	});

	it('Turtle opted out: Direct, Remnant', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks.trackingOptIn, 'isOptedIn').and.returnValue(false);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('direct,remnant');
	});

	it('Turtle country, wgSitewideDisableGpt on: Turtle', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks.trackingOptIn, 'isOptedIn').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('turtle');
	});

	it('returns correct providers depending on forcedProvider', function () {
		spyOn(mocks, 'getAdContextForcedProvider');

		Object.keys(forcedProvidersMap).forEach(function (k) {
			mocks.getAdContextForcedProvider.and.returnValue(k);
			expect(getProviders('foo')).toEqual(forcedProvidersMap[k]);
		});
	});
});
