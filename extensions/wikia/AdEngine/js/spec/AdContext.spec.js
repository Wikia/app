/*global describe, it, modules, expect, spyOn, beforeEach*/
/*jshint maxlen:200*/
describe('AdContext', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
			browserDetect: {
				isEdge: function() {
					return false;
				},
				isChrome: function() {
					return false;
				},
				getBrowserVersion: function() {
					return 100;
				},
				isSteam: function() {
					return false;
				}
			},
			bridge: {
				geo: {
					mapSamplingResults: function() {
						return [];
					}
				}
			},
			instantGlobals: {},
			win: {},
			Querystring: function () {
				return mocks.querystring;
			},
			querystring: {
				getVal: noop
			},
			wikiaCookies: {},
			sampler: {
				sample: function () {
					return false;
				}
			},
			callback: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.adContext'](
			mocks.browserDetect,
			mocks.wikiaCookies,
			mocks.instantGlobals,
			mocks.bridge,
			mocks.sampler,
			mocks.win,
			mocks.Querystring
		);
	}

	function fakeIsProperGeo(geos) {
		geos = geos || [];
		return geos.indexOf('CURRENT_COUNTRY') !== -1;
	}

	beforeEach(function () {
		var geoAPI = [
			'isProperGeo', 'getCountryCode', 'getRegionCode', 'getContinentCode', 'isProperGeo',
			'getSamplingResults', 'mapSamplingResults'
		];
		mocks.bridge.geo = jasmine.createSpyObj('geo', geoAPI);
		mocks.wikiaCookies = jasmine.createSpyObj('cookies', ['get']);

		mocks.bridge.geo.isProperGeo.and.callFake(fakeIsProperGeo);
		mocks.bridge.geo.getSamplingResults.and.returnValue(['wgAdDriverRubiconDfpCountries_A_50']);
		mocks.bridge.geo.mapSamplingResults.and.returnValue('rub-dfp-test');
		mocks.instantGlobals = {};
	});

	it(
		'fills getContext() with context, targeting, providers ' +
		'even for empty (or missing) ads.context',
		function () {
			var adContext = getModule();

			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});

			mocks.win = {ads: {context: {}}};
			adContext = getModule();
			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
		}
	);

	it('copies ads.context into the returned context', function () {
		var adContext;

		mocks.win = {
			ads: {
				context: {
					opts: {
						showAds: true,
						xxx: true
					},
					targeting: {
						yyy: true
					},
					providers: {
						someProvider: true,
						someProviderProperty: 7
					}
				}
			}
		};

		adContext = getModule();
		expect(adContext.getContext().opts.showAds).toBe(true);
		expect(adContext.getContext().opts.xxx).toBe(true);
		expect(adContext.getContext().targeting.yyy).toBe(true);
		expect(adContext.getContext().providers.someProvider).toBe(true);
		expect(adContext.getContext().providers.someProviderProperty).toBe(7);
	});

	it('makes targeting.pageCategories filled with categories properly', function () {
		var adContext;

		mocks.win = {
			ads: {context: {}}
		};
		adContext = getModule();
		expect(
			adContext.getContext().targeting.pageCategories &&
			adContext.getContext().targeting.pageCategories.length
		).toBeFalsy();

		mocks.win = {
			ads: {
				context: {
					targeting: {
						mercuryPageCategories: [
							{title: 'Category1', url: '/wiki/Category:Category1'},
							{title: 'Category2', url: '/wiki/Category:Category2'}
						]
					}
				}
			},
			wgCategories: ['Category1', 'Category2']
		};
		adContext = getModule();
		expect(
			adContext.getContext().targeting.pageCategories &&
			adContext.getContext().targeting.pageCategories.length
		).toBeFalsy();

		mocks.win = {
			ads: {context: {targeting: {enablePageCategories: true}}}
		};
		adContext = getModule();
		expect(
			adContext.getContext().targeting.pageCategories &&
			adContext.getContext().targeting.pageCategories.length
		).toBeFalsy();

		mocks.win = {
			ads: {context: {targeting: {enablePageCategories: true}}},
			wgCategories: ['Category1', 'Category2']
		};
		adContext = getModule();
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);

		mocks.win = {
			ads: {
				context: {
					targeting: {
						enablePageCategories: true,
						mercuryPageCategories: [
							{title: 'Category1', url: '/wiki/Category:Category1'},
							{title: 'Category2', url: '/wiki/Category:Category2'}
						]
					}
				}
			}
		};
		adContext = getModule();
		expect(adContext.getContext().targeting.pageCategories).toEqual(['Category1', 'Category2']);

		mocks.win = {
			ads: {
				context: {
					targeting: {
						enablePageCategories: true,
						mercuryPageCategories: []
					}
				}
			}
		};
		adContext = getModule();
		expect(adContext.getContext().targeting.pageCategories).toEqual([]);
	});

	it('makes targeting.enableKruxTargeting false when disaster rec instant global variable is set to true',
		function () {
			var adContext;
			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};

			mocks.instantGlobals = {wgAdDriverKruxCountries: ['CURRENT_COUNTRY']};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['CURRENT_COUNTRY', 'ZZ'],
				wgSitewideDisableKrux: false
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['CURRENT_COUNTRY', 'ZZ'],
				wgSitewideDisableKrux: true
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['CURRENT_COUNTRY', 'ZZ', 'YY'],
				wgSitewideDisableKrux: 0
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

			mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
			mocks.instantGlobals = {
				wgAdDriverKruxCountries: ['CURRENT_COUNTRY', 'ZZ'],
				wgSitewideDisableKrux: 1
			};
			adContext = getModule();
			expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();
		}
	);

	it('calls whoever registered with addCallback each time setContext is called', function () {
		var adContext;

		spyOn(mocks, 'callback');

		mocks.win = {};
		mocks.instantGlobals = {};
		adContext = getModule();
		adContext.addCallback(mocks.callback);
		adContext.setContext({});
		expect(mocks.callback).toHaveBeenCalled();
	});

	it('enables high impact slot when country in instantGlobals.wgAdDriverHighImpactSlotCountries', function () {
		var adContext;

		mocks.win = {ads: {context: {slots: {invisibleHighImpact: true}}}};
		mocks.instantGlobals = {wgAdDriverHighImpactSlotCountries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().slots.invisibleHighImpact).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverHighImpactSlotCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().slots.invisibleHighImpact).toBeFalsy();
	});

	it('enables high impact slot when url param highimpactslot is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'highimpactslot' ?  '1' : '0';
		});

		expect(getModule().getContext().slots.invisibleHighImpact).toBeTruthy();
	});

	it('enables krux when country in instantGlobals.wgAdDriverKruxCountries', function () {
		var adContext;
		mocks.win = {ads: {context: {targeting: {enableKruxTargeting: true}}}};
		mocks.instantGlobals = {wgAdDriverKruxCountries: ['AA', 'CURRENT_COUNTRY', 'BB']};
		adContext = getModule();
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverKruxCountries: ['AA', 'BB', 'CC']};
		adContext = getModule();
		expect(adContext.getContext().targeting.enableKruxTargeting).toBeFalsy();
	});

	it('enable BlockAdBlock detection for current country on whitelist on oasis', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return true;
		});
		mocks.instantGlobals = {wgAdDriverBabDetectionDesktopCountries: ['CURRENT_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.babDetectionDesktop).toBeTruthy();
	});

	it('disable BlockAdBlock detection when current country is not on whitelist on oasis', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return true;
		});
		mocks.instantGlobals = {wgAdDriverBabDetectionDesktopCountries: ['OTHER_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.babDetectionDesktop).toBeFalsy();
	});

	it('enable BlockAdBlock detection for current country on whitelist on mobile-wiki', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return true;
		});
		mocks.instantGlobals = {wgAdDriverBabDetectionMobileCountries: ['CURRENT_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.babDetectionMobile).toBeTruthy();
	});

	it('disable BlockAdBlock detection when current country is not on whitelist on mobile-wiki', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return true;
		});
		mocks.instantGlobals = {wgAdDriverBabDetectionMobileCountries: ['OTHER_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.babDetectionMobile).toBeFalsy();
	});

	it('showcase is enabled if the cookie is set', function () {
		mocks.wikiaCookies.get.and.returnValue('NlfdjR5xC0');
		expect(getModule().getContext().opts.showcase).toBeTruthy();
	});

	it('showcase is disabled if cookie is not set', function () {
		mocks.win.ads.context = {};
		mocks.wikiaCookies.get.and.returnValue(false);
		expect(getModule().getContext().opts.showcase).toBeFalsy();
	});

	it('enables FAN provider when provider is enabled by wg var', function () {
		var adContext;
		mocks.win = {
			ads: {
				context: {
					providers: {
						audienceNetwork: true
					}
				}
			}
		};

		adContext = getModule();
		expect(adContext.getContext().providers.audienceNetwork).toBeTruthy();
	});

	[
		{
			wgCountry: ['CURRENT_COUNTRY'],
			sampler: true,
			expectedResult: true
		},
		{
			wgCountry: ['CURRENT_COUNTRY'],
			sampler: false,
			expectedResult: false
		},
		{
			wgCountry: ['OTHER_COUNTRY'],
			sampler: true,
			expectedResult: false
		},
		{
			wgCountry: ['OTHER_COUNTRY'],
			sampler: false,
			expectedResult: false
		}
	].forEach(function (testCase) {
		var description = 'MOAT for featured video should be ' + (testCase.expectedResult ? 'enabled' : 'disabled') +
			' for countries: '  + JSON.stringify(testCase.wgCountry) + ' and sampling: ' + testCase.sampler;

		it(description, function () {
			mocks.instantGlobals = {wgAdDriverMoatTrackingForFeaturedVideoAdCountries: testCase.wgCountry};
			spyOn(mocks.sampler, 'sample').and.returnValue(testCase.sampler);

			expect(getModule().getContext().opts.isMoatTrackingForFeaturedVideoEnabled).toEqual(testCase.expectedResult);
		});
	});

	it('Should set by default sampling for MOAT FV on 1% of traffic', function () {
		mocks.instantGlobals = {wgAdDriverMoatTrackingForFeaturedVideoAdCountries: ['CURRENT_COUNTRY']};
		spyOn(mocks.sampler, 'sample');

		getModule().getContext();

		var moatSamplerArgs = mocks.sampler.sample.calls.allArgs()[0];

		expect(moatSamplerArgs[0]).toEqual('moatTrackingForFeaturedVideo');
		expect(moatSamplerArgs[1]).toEqual(1);
	});

	it('Should set sampling for MOAT FV based on wgVar', function () {
		mocks.instantGlobals = {
			wgAdDriverMoatTrackingForFeaturedVideoAdCountries: ['CURRENT_COUNTRY'],
			wgAdDriverMoatTrackingForFeaturedVideoAdSampling: 25
		};
		spyOn(mocks.sampler, 'sample');

		getModule().getContext();

		var moatSamplerArgs = mocks.sampler.sample.calls.allArgs()[0];

		expect(moatSamplerArgs[0]).toEqual('moatTrackingForFeaturedVideo');
		expect(moatSamplerArgs[1]).toEqual(25);
	});

	[
		{
			instantGlobals: {
				wgAdDriverRubiconPrebidCountries: ['ZZ']
			},
			testedBidder: 'rubicon',
			expectedResult: false
		},
		{
			instantGlobals: {
				wgAdDriverRubiconPrebidCountries: ['CURRENT_COUNTRY']
			},
			testedBidder: 'rubicon',
			expectedResult: true
		},
		{
			hasFeaturedVideo: true,
			instantGlobals: {
				wgAdDriverBeachfrontBidderCountries: ['CURRENT_COUNTRY']
			},
			testedBidder: 'beachfront',
			expectedResult: false
		},
		{
			hasFeaturedVideo: false,
			instantGlobals: {
				wgAdDriverBeachfrontBidderCountries: ['ZZ']
			},
			testedBidder: 'beachfront',
			expectedResult: false
		},
		{
			hasFeaturedVideo: false,
			instantGlobals: {
				wgAdDriverBeachfrontBidderCountries: ['CURRENT_COUNTRY']
			},
			testedBidder: 'beachfront',
			expectedResult: true
		},
		{
			hasFeaturedVideo: true,
			instantGlobals: {
				wgAdDriverAppNexusAstBidderCountries: ['CURRENT_COUNTRY']
			},
			testedBidder: 'appnexusAst',
			expectedResult: true
		},
		{
			hasFeaturedVideo: false,
			instantGlobals: {
				wgAdDriverAppNexusAstBidderCountries: ['ZZ']
			},
			testedBidder: 'appnexusAst',
			expectedResult: false
		},
		{
			hasFeaturedVideo: false,
			instantGlobals: {
				wgAdDriverAppNexusAstBidderCountries: ['CURRENT_COUNTRY']
			},
			testedBidder: 'appnexusAst',
			expectedResult: true
		}
	].forEach(function (testCase) {
		it('Test bidder configuration', function () {
			getModule().setContext({
				targeting: {
					hasFeaturedVideo: testCase.hasFeaturedVideo
				}
			});
			mocks.instantGlobals = testCase.instantGlobals;

			expect(getModule().getContext().bidders[testCase.testedBidder]).toEqual(testCase.expectedResult);
		});
	});

	it('return value by string', function () {

		mocks.win = {
			ads: {
				context: {
					opts: {
						showAds: 'A',
						xxx: 'B',
						countries: ['PL', 'US', 'CA'],
						negativeValue: false
					},
					targeting: {
						yyy: 'C'
					},
					test: {
						q: 'W',
						w: 'E'
					}
				}
			}
		};

		expect(getModule().get('opts.showAds')).toEqual('A');
		expect(getModule().get('opts.xxx')).toEqual('B');
		expect(getModule().get('test')).toEqual(mocks.win.ads.context.test);
		expect(getModule().get('opts.countries')).toEqual(mocks.win.ads.context.opts.countries);
		expect(getModule().get()).toEqual(getModule().getContext());
		expect(getModule().get().test).toEqual(mocks.win.ads.context.test);
		expect(getModule().get('opts.negativeValue')).toEqual(false);
	});

	it('return undefined if value cant be found', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						showAds: 'A',
						xxx: 'B',
						countries: ['PL', 'US', 'CA']
					},
					targeting: {
						yyy: 'C'
					},
					test: {
						q: 'W',
						w: 'E'
					}
				}
			}
		};

		expect(getModule().get('not.existing.path')).toBeUndefined();
		expect(getModule().get('opts.partially_existing_path')).toBeUndefined();
		expect(getModule().get('opts..partially_existing_path')).toBeUndefined();
		expect(getModule().get('..')).toBeUndefined();
		expect(getModule().get('..')).toBeUndefined();
		expect(getModule().get('opts..showAds')).toBeUndefined();
	});

	it('checks which lABrador keyvals should be sent to DFP', function () {
		mocks.instantGlobals = {
			wgAdDriverRubiconDfpCountries: ['XX/50'],
			wgAdDriverLABradorDfpKeyvals: ['wgAdDriverRubiconDfpCountries_A_50:rub-dfp-test']
		};

		getModule();

		expect(getModule().get('opts.labradorDfp')).toEqual('rub-dfp-test');
	});
});
