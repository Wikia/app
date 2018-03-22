/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.config.desktop', function () {
	'use strict';

	function noop() {
		return;
	}

	function returnEmpty() {
		return {};
	}

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
			log: noop,
			opts: {
				showAds: true,
				premiumOnly: false
			},
			providers: {
				directGpt: {
					name: 'direct'
				},
				evolve2: {
					name: 'evolve2',
					canHandleSlot: noop
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
			'evolve2': mocks.providers.evolve2.name,
			'turtle': mocks.providers.turtle.name
		};

	function getModule() {
		return modules['ext.wikia.adEngine.config.desktop'](
			mocks.log,
			{navigator: {userAgent: mocks.getUserAgent()}},
			mocks.getInstantGlobals(),
			mocks.geo,
			mocks.adsContext,
			mocks.adDecoratorPageDimensions,
			mocks.providers.directGpt,
			mocks.providers.evolve2,
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

	it('non-Evolve country, Evolve slot: Direct, Remnant', function () {
		expect(getProviders('foo')).toEqual('direct,remnant');
	});

	it('non-Evolve slot: Direct, Remnant', function () {
		spyOn(mocks.geo, 'getCountryCode').and.returnValue('NZ');
		expect(getProviders('foo')).toEqual('direct,remnant');
	});

	it('Turtle: Turtle, Remnant', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('turtle,remnant');
	});

	it('Turtle cannot handle slot: Direct, Remnant', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(false);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('direct,remnant');
	});

	it('Evolve country, Evolve-slot', function () {
		spyOn(mocks.providers.evolve2, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({evolve2: true});
		expect(getProviders('foo')).toEqual('evolve2,remnant');
	});

	it('Evolve country, wgSitewideDisableGpt on: Evolve', function () {
		spyOn(mocks.providers.evolve2, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({evolve2: true});
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('evolve2');
	});

	it('Turtle country, wgSitewideDisableGpt on: Turtle', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
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
