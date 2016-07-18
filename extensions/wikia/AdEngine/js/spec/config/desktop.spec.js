/*global describe, it, expect, modules, spyOn*/
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
				return {
					showAds: true
				};
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
			providers: {
				directGpt: {
					name: 'direct'
				},
				evolve2: {
					name: 'evolve2',
					canHandleSlot: noop
				},
				liftium: {
					name: 'liftium'
				},
				monetizationService: {
					name: 'monetizationService',
					canHandleSlot: noop
				},
				remnantGpt: {
					name: 'remnant'
				},
				rubiconFastlane: {
					name: 'rpfl',
					canHandleSlot: noop
				},
				taboola: {
					name: 'taboola',
					canHandleSlot: noop
				},
				turtle: {
					name: 'turtle',
					canHandleSlot: noop
				}
			}
		},
		forcedProvidersMap = {
			'evolve2': mocks.providers.evolve2.name,
			'liftium': mocks.providers.liftium.name,
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
			mocks.providers.liftium,
			mocks.providers.monetizationService,
			mocks.providers.remnantGpt,
			mocks.providers.rubiconFastlane,
			mocks.providers.turtle,
			mocks.providers.taboola
		);
	}

	function getProviders(slotName) {
		var providers = getModule().getProviderList(slotName),
			providerNames = providers.map(function (item) {
				return item.name;
			});

		return providerNames.join(',');
	}

	it('default setup: Direct, Remnant, Liftium', function () {
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('non-Evolve country, Evolve slot: Direct, Remnant, Liftium', function () {
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('non-Evolve slot: Direct, Remnant, Liftium', function () {
		spyOn(mocks.geo, 'getCountryCode').and.returnValue('NZ');
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('Turtle: Turtle, Remnant, Liftium', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('turtle,remnant,liftium');
	});

	it('Turtle cannot handle slot: Direct, Remnant, Liftium', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(false);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('Evolve country, Evolve-slot', function () {
		spyOn(mocks.providers.evolve2, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({evolve2: true});
		expect(getProviders('foo')).toEqual('evolve2,remnant,liftium');
	});

	it('any country, Taboola on, Taboola slot: Taboola', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({taboola: true});
		spyOn(mocks.providers.taboola, 'canHandleSlot').and.returnValue(true);
		expect(getProviders('foo')).toEqual('taboola');
	});

	it('any country, Taboola on, non Taboola slot: not Taboola', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({taboola: true});
		expect(getProviders('foo')).not.toEqual('taboola');
	});

	it('default setup, wgSitewideDisableGpt on: just Liftium', function () {
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('liftium');
	});

	it('Evolve country, wgSitewideDisableGpt on: Evolve, Liftium', function () {
		spyOn(mocks.providers.evolve2, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({evolve2: true});
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('evolve2,liftium');
	});

	it('Turtle country, wgSitewideDisableGpt on: Turtle, Liftium', function () {
		spyOn(mocks.providers.turtle, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('turtle,liftium');
	});

	it('any country, Monetization Service on, Monetization Service slot', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({monetizationService: true});
		spyOn(mocks.providers.monetizationService, 'canHandleSlot').and.returnValue(true);
		expect(getProviders('foo')).toEqual('monetizationService');
	});

	it('any country, Monetization Service on, non Monetization Service slot', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({monetizationService: true});
		expect(getProviders('foo')).not.toEqual('monetizationService');
	});

	it('returns correct providers depending on forcedProvider', function () {
		spyOn(mocks, 'getAdContextForcedProvider');

		Object.keys(forcedProvidersMap).forEach(function (k) {
			mocks.getAdContextForcedProvider.and.returnValue(k);
			expect(getProviders('foo')).toEqual(forcedProvidersMap[k]);
		});
	});

	it('RubiconFastlane country but cannot handle slot: Direct, Remnant, Liftium', function () {
		spyOn(mocks.providers.rubiconFastlane, 'canHandleSlot').and.returnValue(false);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({rubiconFastlane: true});
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('RubiconFastlane country and can handle slot: Direct, Remnant, RubiconFastlane', function () {
		spyOn(mocks.providers.rubiconFastlane, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({rubiconFastlane: true});
		expect(getProviders('foo')).toEqual('direct,remnant,rpfl');
	});

	it('RubiconFastlane country and wgSitewideDisableGpt on: just RubiconFastlane', function () {
		spyOn(mocks.providers.rubiconFastlane, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		spyOn(mocks, 'getAdContextProviders').and.returnValue({rubiconFastlane: true});
		expect(getProviders('foo')).toEqual('rpfl');
	});
});
