/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.config.desktop', function () {
	'use strict';

	function noop() {
		return;
	}

	function returnEmpty() {
		return {};
	}

	var uaIE8 = [
			'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0;',
			'GTB7.4; InfoPath.2; SV1; .NET CLR 3.3.69573; WOW64; en-US)'
		].join(''),
		mocks = {
			adDecoratorPageDimensions: noop,
			getAdContextOpts: function () {
				return {
					showAds: true
				};
			},
			getAdContextTargeting: returnEmpty,
			getAdContextProviders: returnEmpty,
			getAdContextForceProviders: returnEmpty,
			getInstantGlobals: returnEmpty,
			getUserAgent: noop,
			geo: {
				getCountryCode: noop
			},
			log: noop,
			providers: {
				directGpt: {
					name: 'direct'
				},
				evolve: {
					name: 'evolve',
					canHandleSlot: noop
				},
				liftium: {
					name: 'liftium'
				},
				openX: {
					name: 'openX',
					canHandleSlot: noop
				},
				remnantGpt: {
					name: 'remnant'
				},
				sevenOneMedia: {
					name: 'sevenOneMedia'
				},
				taboola: {
					name: 'taboola',
					canHandleSlot: noop
				},
				turtle: {
					name: 'turtle'
				}
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.config.desktop'](
			mocks.log,
			{navigator: {userAgent: mocks.getUserAgent()}},
			mocks.getInstantGlobals(),
			mocks.geo,
			{
				getContext: function () {
					return {
						opts: mocks.getAdContextOpts(),
						targeting: mocks.getAdContextTargeting(),
						providers: mocks.getAdContextProviders(),
						forceProviders: mocks.getAdContextForceProviders()
					};
				}
			},
			mocks.adDecoratorPageDimensions,
			mocks.providers.evolve,
			mocks.providers.liftium,
			mocks.providers.directGpt,
			mocks.providers.openX,
			mocks.providers.remnantGpt,
			mocks.providers.sevenOneMedia,
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

	it('NZ, Evolve slot: Evolve, Remnant, Liftium', function () {
		spyOn(mocks.geo, 'getCountryCode').and.returnValue('NZ');
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		expect(getProviders('foo')).toEqual('evolve,remnant,liftium');
	});

	it('NZ, not Evolve slot: Direct, Remnant, Liftium', function () {
		spyOn(mocks.geo, 'getCountryCode').and.returnValue('NZ');
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('Turtle: Turtle, Remnant, Liftium', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		expect(getProviders('foo')).toEqual('turtle,remnant,liftium');
	});

	it('non-Evolve country, SevenOne Media on: SevenOneMedia', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({sevenOneMedia: true});
		expect(getProviders('foo')).toEqual('sevenOneMedia');
	});

	it('non-Evolve country, Evolve-slot, SevenOne Media on: SevenOneMedia', function () {
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({sevenOneMedia: true});
		expect(getProviders('foo')).toEqual('sevenOneMedia');
	});

	it('NZ, Evolve-slot, SevenOne Media on: SevenOneMedia', function () {
		spyOn(mocks.geo, 'getCountryCode').and.returnValue('NZ');
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({sevenOneMedia: true});
		expect(getProviders('foo')).toEqual('sevenOneMedia');
	});

	it('any country, SevenOne Media on, wgSitewideDisableSevenOneMedia on: None', function () {
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({sevenOneMedia: true});
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableSevenOneMedia: true});
		expect(getProviders('foo')).toEqual('');
	});

	it('any country, SevenOne Media off, wgSitewideDisableSevenOneMedia on: Direct, Remnant, Liftium', function () {
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableSevenOneMedia: true});
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});

	it('any country, SevenOne Media on, IE8: None', function () {
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getAdContextProviders').and.returnValue({sevenOneMedia: true});
		spyOn(mocks, 'getUserAgent').and.returnValue(uaIE8);
		expect(getProviders('foo')).toEqual('');
	});

	it('any country, SevenOne Media off, IE8: Direct, Remnant, Liftium', function () {
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getUserAgent').and.returnValue(uaIE8);
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
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
		spyOn(mocks.geo, 'getCountryCode').and.returnValue('NZ');
		spyOn(mocks.providers.evolve, 'canHandleSlot').and.returnValue(true);
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('evolve,liftium');
	});

	it('Turtle country, wgSitewideDisableGpt on: Turtle, Liftium', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({turtle: true});
		spyOn(mocks, 'getInstantGlobals').and.returnValue({wgSitewideDisableGpt: true});
		expect(getProviders('foo')).toEqual('turtle,liftium');
	});

	it('any country, OpenX on and can handle slot: Direct, Remnant, OpenX', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({openX: true});
		spyOn(mocks.providers.openX, 'canHandleSlot').and.returnValue(true);
		expect(getProviders('foo')).toEqual('direct,remnant,openX');
	});

	it('any country, OpenX on but cannot handle slot: Direct, Remnant, Liftium', function () {
		spyOn(mocks, 'getAdContextProviders').and.returnValue({openX: true});
		expect(getProviders('foo')).toEqual('direct,remnant,liftium');
	});
});
