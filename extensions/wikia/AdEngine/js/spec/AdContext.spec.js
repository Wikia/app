/*global describe, it, modules, expect, spyOn, beforeEach*/
/*jshint maxlen:200*/
describe('AdContext', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
			abTesting: {
				getGroup: function () {
					return 'group';
				}
			},
			geo: {
				getCountryCode: function () {
					return 'CURRENT_COUNTRY';
				},
				getRegionCode: function () {
					return 'CURRENT_REGION';
				},
				getContinentCode: function () {
					return 'CURRENT_CONTINENT';
				},
				isProperGeo: function (countryList) {
					if (!countryList) {
						return false;
					}
					if (countryList.indexOf('CURRENT_COUNTRY') > -1) {
						return true;
					}
					if (countryList.indexOf('CURRENT_COUNTRY-CURRENT_REGION') > -1) {
						return true;
					}
					if (countryList.indexOf('XX-CURRENT_CONTINENT') > -1) {
						return true;
					}
					if (countryList.indexOf('XX') > -1) { //global
						return true;
					}
					return false;
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
			wikiaCookies: {
				get: noop
			},
			sampler: {
				sample: function () {
					return false;
				}
			},
			callback: noop
		},
		queryParams = [
			'evolve2',
			'turtle'
		];

	function getModule() {
		return modules['ext.wikia.adEngine.adContext'](
			mocks.abTesting,
			mocks.wikiaCookies,
			mocks.doc,
			mocks.geo,
			mocks.instantGlobals,
			mocks.sampler,
			mocks.win,
			mocks.Querystring
		);
	}

	beforeEach(function () {
		mocks.instantGlobals = {};
		getModule().getContext().opts = {};
		if (mocks.doc && mocks.doc.hasOwnProperty('referrer')) {
			mocks.doc.referrer = '';
		}
	});

	function enableSourcePointMMS(context) {
		context.opts = context.opts || {};
		context.opts.sourcePointMMS = true;
	}

	function enableTaboola(context) {
		mocks.instantGlobals = mocks.instantGlobals || {};
		mocks.instantGlobals.wgAdDriverTaboolaConfig = {
			SLOT: {
				recovery: ['CURRENT_COUNTRY']
			}
		};

		context.opts = context.opts || {};
		context.opts.useTaboola = true;
	}

	function enablePageFairDetection() {
		mocks.instantGlobals.wgAdDriverPageFairDetectionCountries = ['CURRENT_COUNTRY'];
		spyOn(mocks.sampler, 'sample').and.returnValue(true);
	}

	function enablePageFairRecovery(context) {
		mocks.instantGlobals = mocks.instantGlobals || {};
		mocks.instantGlobals.wgAdDriverPageFairRecoveryCountries = ['CURRENT_COUNTRY'];

		context.opts = context.opts || {};
		context.opts.pageFairRecovery = true;
	}

	function enableSourcePointDetection(context) {
		context.opts = context.opts || {};
		context.targeting = context.targeting || {};

		context.opts.sourcePointDetectionUrl = 'url';
		context.targeting.skin = 'oasis';

		mocks.instantGlobals.wgAdDriverSourcePointDetectionCountries = ['CURRENT_COUNTRY'];
	}

	function enableSourcePointRecovery(context) {
		context.opts = context.opts || {};
		context.opts.sourcePointRecovery = true;

		mocks.instantGlobals = mocks.instantGlobals || {};
		mocks.instantGlobals.wgAdDriverSourcePointRecoveryCountries = ['CURRENT_COUNTRY'];
	}

	function enableGCS(context) {
		enableSourcePointDetection(context);
		context.opts = context.opts || {};
		context.opts.sourcePointDetection = true;
		context.opts.showAds = true;

		spyOn(mocks.abTesting, 'getGroup').and.returnValue('GROUP_5');

		mocks.instantGlobals = mocks.instantGlobals || {};
		mocks.instantGlobals.wgAdDriverGoogleConsumerSurveysCountries = ['CURRENT_COUNTRY'];
	}

	it(
		'fills getContext() with context, targeting, providers and forcedProvider ' +
		'even for empty (or missing) ads.context',
		function () {
			var adContext = getModule();

			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
			expect(adContext.getContext().forcedProvider).toEqual(null);

			mocks.win = {ads: {context: {}}};
			adContext = getModule();
			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
			expect(adContext.getContext().forcedProvider).toEqual(null);
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

	it('makes opts.showAds false for sony tvs', function () {
		var adContext;

		mocks.win = {
			ads: {
				context: {
					opts: {
						showAds: true
					}
				}
			}
		};

		mocks.doc = {
			referrer: 'info.tvsideview.sony.net'
		};

		adContext = getModule();
		expect(adContext.getContext().opts.showAds).toBeFalsy();
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

	it('makes targeting.enableKruxTargeting false when disaster recovery instant global variable is set to true',
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

	it('makes providers.turtle true when country in instantGlobals.wgAdDriverTurtleCountries', function () {
		var adContext;

		mocks.win = {};
		mocks.instantGlobals = {wgAdDriverTurtleCountries: ['CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().providers.turtle).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverTurtleCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().providers.turtle).toBeFalsy();
	});

	it('makes providers.rubiconFastlane true when country in wgCountries', function () {
		var adContext;

		mocks.win = {
			ads: {
				context: {
					providers: {
						rubiconFastlane: true
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverRubiconFastlaneCountries: ['CURRENT_COUNTRY', 'ZZ'],
			wgAdDriverRubiconFastlaneProviderCountries: ['CURRENT_COUNTRY', 'ZZ']
		};
		adContext = getModule();
		expect(adContext.getContext().providers.rubiconFastlane).toBeTruthy();

		mocks.instantGlobals = {
			wgAdDriverRubiconFastlaneCountries: ['YY'],
			wgAdDriverRubiconFastlaneProviderCountries: ['CURRENT_COUNTRY', 'ZZ']
		};
		adContext = getModule();
		expect(adContext.getContext().providers.rubiconFastlane).toBeFalsy();

		mocks.instantGlobals = {
			wgAdDriverRubiconFastlaneCountries: ['CURRENT_COUNTRY', 'ZZ'],
			wgAdDriverRubiconFastlaneProviderCountries: ['YY']
		};
		adContext = getModule();
		expect(adContext.getContext().providers.rubiconFastlane).toBeFalsy();
	});

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

	it('query param is being passed to the adContext properly', function () {
		spyOn(mocks.querystring, 'getVal');

		Object.keys(queryParams).forEach(function (k) {
			var adContext;

			mocks.win = {};
			mocks.instantGlobals = {};
			mocks.querystring.getVal.and.returnValue(queryParams[k]);

			adContext = getModule();
			expect(mocks.querystring.getVal).toHaveBeenCalled();

			adContext = adContext.getContext();
			expect(adContext.forcedProvider).toEqual(queryParams[k]);
		});
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

	it('disables detection when url is not set', function () {
		mocks.instantGlobals = {wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY', 'ZZ']};

		expect(getModule().getContext().opts.sourcePointDetection).toBe(undefined);
		expect(getModule().getContext().opts.sourcePointDetectionMobile).toBe(undefined);
	});

	it('enables detection when instantGlobals.wgAdDriverSourcePointDetectionCountries', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar'
					},
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY', 'ZZ']};

		expect(getModule().getContext().opts.sourcePointDetection).toBeTruthy();
	});

	it('disables detection when url param noexternals=1 is set', function () {
		mocks.win = {ads: {context: {opts: {sourcePointDetectionUrl: '//foo.bar'}}}};
		mocks.instantGlobals = {wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY', 'ZZ']};
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'noexternals' ?  '1' : '0';
		});

		expect(getModule().getContext().opts.sourcePointDetection).toBeFalsy();
	});

	it('disables Source Point detection when Source Point recovery is enabled', function () {
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: [
				'CURRENT_COUNTRY',
				'ZZ'
			]
		};
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//blah.blah',
						sourcePointRecovery: true
					}
				}
			}
		};

		expect(getModule().getContext().opts.sourcePointDetection).toBeFalsy();
	});

	it('Should allow to enable PageFair recovery with detection', function () {
		var context = {};

		enablePageFairRecovery(context);
		enablePageFairDetection();
		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
		expect(context.opts.pageFairDetection).toBeTruthy();
	});

	it('Should allow to enable SourcePoint recovery with detection', function () {
		var context = {};

		enableSourcePointRecovery(context);
		enableSourcePointDetection(context);
		getModule().setContext(context);

		expect(context.opts.sourcePointRecovery).toBeTruthy();
		expect(context.opts.sourcePointDetection).toBeTruthy();
	});

	it('Should disable PageFair recovery if there is no correct geo', function () {
		var context = {
			opt: {
				pageFairRecovery: true
			}
		};

		mocks.instantGlobals = {
			wgAdDriverPageFairRecoveryCountries: ['AA', 'BB']
		};

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeFalsy();
	});

	it('Should enable PageFair recovery if there is proper geo', function () {
		var context = {
			opts: {
				pageFairRecovery: true
			}
		};

		mocks.instantGlobals = {
			wgAdDriverPageFairRecoveryCountries: ['AA', 'CURRENT_COUNTRY']
		};

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
	});

	it('Should disable PageFair recovery if there is proper geo but is disabled by backend (wgVariable)', function () {
		var context = {
			opts: {
				pageFairRecovery: false
			}
		};

		mocks.instantGlobals = {
			wgAdDriverPageFairRecoveryCountries: ['AA', 'CURRENT_COUNTRY']
		};

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeFalsy();
	});

	it('Should disable PageFair recovery if there is no proper geo but its enabled by backend (wgVariable)', function () {
		var context = {
			opts: {
				pageFairRecovery: true
			}
		};

		mocks.instantGlobals = {
			wgAdDriverPageFairRecoveryCountries: ['AA', 'BB']
		};

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeFalsy();
	});

	it('enables detection when url param pagefairdetection is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'pagefairdetection' ?  '1' : '0';
		});

		expect(getModule().getContext().opts.pageFairDetection).toBeTruthy();
	});

	it('disable detection when noExtenals is set and pagefairdetection is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			var result = ['noexternals', 'pagefairdetection'].indexOf(param) !== -1;
			return result ? '1' : '0';
		});

		expect(getModule().getContext().opts.pageFairDetection).toBeFalsy();
	});

	it('disable PageFair detection for current country on whitelist and not allowed by sampler', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return false;
		});

		mocks.instantGlobals = {wgAdDriverPageFairDetectionCountries: ['CURRENT_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.pageFairDetection).toBeFalsy();
	});

	it('enable PageFair detection for current country on whitelist and allowed by sampler', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return true;
		});
		mocks.instantGlobals = {wgAdDriverPageFairDetectionCountries: ['CURRENT_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.pageFairDetection).toBeTruthy();
	});

	it('disable PageFair detection when current country is not on whitelist and allowed by sampler', function () {
		spyOn(mocks.sampler, 'sample').and.callFake(function () {
			return true;
		});
		mocks.instantGlobals = {wgAdDriverPageFairDetectionCountries: ['OTHER_COUNTRY', 'ZZ']};
		expect(getModule().getContext().opts.pageFairDetection).toBeFalsy();
	});

	it('enables PageFair detection when url param pagefairdetection is set and current country is on whitelist', function () {
		mocks.instantGlobals = {wgAdDriverPageFairDetectionCountries: ['CURRENT_COUNTRY', 'ZZ']};
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			var result = ['pagefairdetection'].indexOf(param) !== -1;
			return result ? '1' : '0';
		});

		expect(getModule().getContext().opts.pageFairDetection).toBeTruthy();
	});

	it('enables detection when instantGlobals.wgAdDriverSourcePointDetectionMobileCountries', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar'
					},
					targeting: {
						skin: 'mercury'
					}
				}
			}
		};
		mocks.instantGlobals = {wgAdDriverSourcePointDetectionMobileCountries: ['CURRENT_COUNTRY', 'ZZ']};

		expect(getModule().getContext().opts.sourcePointDetectionMobile).toBeTruthy();
	});

	it('enables detection when ' +
	'instantGlobals.wgAdDriverSourcePointDetectionCountries is enabled for continent', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar'
					},
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {wgAdDriverSourcePointDetectionCountries: ['XX-CURRENT_CONTINENT']};
		expect(getModule().getContext().opts.sourcePointDetection).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverSourcePointDetectionCountries: ['XX-NOT_PROPER_CONTINENT']};
		expect(getModule().getContext().opts.sourcePointDetection).toBeFalsy();

		mocks.instantGlobals = {wgAdDriverSourcePointDetectionCountries: ['XX']};
		expect(getModule().getContext().opts.sourcePointDetection).toBeTruthy();
	});

	it('Should enable PageFair Recovery', function () {
		var context = {};

		enablePageFairRecovery(context);
		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
	});

	it('Should enable SourcePoint Recovery', function () {
		var context = {};

		enableSourcePointRecovery(context);
		getModule().setContext(context);

		expect(context.opts.sourcePointRecovery).toBeTruthy();
	});

	it('Should enable SourcePoint MMS', function () {
		var context = {};

		enableSourcePointMMS(context);
		getModule().setContext(context);

		expect(context.opts.sourcePointMMS).toBeTruthy();
	});

	it('Should enable Taboola', function () {
		var context = {};

		enableTaboola(context);
		getModule().setContext(context);

		expect(context.opts.loadTaboolaLibrary).toBeTruthy();
	});

	it('Should disable Taboola if useTaboola is false', function () {
		var context = {};

		enableTaboola(context);
		context.opts = {
			useTaboola: false,
			disableTaboola: true
		};

		getModule().setContext(context);

		expect(context.opts.loadTaboolaLibrary).toBeFalsy();
	});

	it('Should enable Taboola if there is no useTaboola variable (cache issue)', function () {
		var context = {};

		mocks.instantGlobals = mocks.instantGlobals || {};
		mocks.instantGlobals.wgAdDriverTaboolaConfig = {
			SLOT: {
				recovery: ['CURRENT_COUNTRY']
			}
		};

		getModule().setContext(context);

		expect(context.opts.loadTaboolaLibrary).toBeTruthy();
	});

	it('Should enable GCS', function () {
		var context = {};

		enableGCS(context);
		getModule().setContext(context);

		expect(context.opts.googleConsumerSurveys).toBeTruthy();
	});

	it('Should disable SourcePoint Recovery when PageFair recovery is enabled', function () {
		var context = {};

		enableSourcePointRecovery(context);
		enablePageFairRecovery(context);
		getModule().setContext(context);

		expect(context.opts.sourcePointRecovery).toBeFalsy();
		expect(context.opts.pageFairRecovery).toBeTruthy();
	});

	it('Should disable SourcePoint MMS when SourcePoint Recovery is enabled', function () {
		var context = {};

		enableSourcePointMMS(context);
		enableSourcePointRecovery(context);
		getModule().setContext(context);

		expect(context.opts.sourcePointRecovery).toBeTruthy();
		expect(context.opts.sourcePointMMS).toBeFalsy();
	});

	it('Should disable SourcePoint MMS when PageFair Recovery is enabled', function () {
		var context = {};

		enableSourcePointMMS(context);
		enablePageFairRecovery(context);
		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
		expect(context.opts.sourcePointMMS).toBeFalsy();
	});

	it('Should disable Taboola if SourcePoint Recovery is enabled', function () {
		var context = {};

		enableSourcePointMMS(context);
		enableTaboola(context);
		getModule().setContext(context);

		expect(context.opts.sourcePointMMS).toBeTruthy();
		expect(context.opts.loadTaboolaLibrary).toBeFalsy();
	});

	it('Should disable Taboola if PageFair Recovery is enabled', function () {
		var context = {};

		enablePageFairRecovery(context);
		enableTaboola(context);
		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
		expect(context.opts.loadTaboolaLibrary).toBeFalsy();
	});

	it('Should disable GCS if Taboola is enabled', function () {
		var context = {};

		enableTaboola(context);
		enableGCS(context);
		getModule().setContext(context);

		expect(context.opts.loadTaboolaLibrary).toBeTruthy();
		expect(context.opts.googleConsumerSurveys).toBeFalsy();
	});

	it('Should disable GCS if PageFair is enabled', function () {
		var context = {};

		enablePageFairRecovery(context);
		enableGCS(context);
		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
		expect(context.opts.googleConsumerSurveys).toBeFalsy();
	});

	it('showcase is enabled if the cookie is set', function () {
		mocks.wikiaCookies = {
			get: function () {
				return 'NlfdjR5xC0';
			}
		};

		expect(getModule().getContext().opts.showcase).toBeTruthy();
	});

	it('showcase is disabled if cookie is not set', function () {
		mocks.wikiaCookies = {
			get: function () {
				return false;
			}
		};

		expect(getModule().getContext().opts.showcase).toBeFalsy();
	});

	it('enables evolve2 provider when country in instantGlobals.wgAdDriverEvolve2Countries', function () {
		var adContext;
		mocks.win = {
			ads: {
				context: {
					providers: {
						evolve2: true
					}
				}
			}
		};

		mocks.instantGlobals = {wgAdDriverEvolve2Countries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().providers.evolve2).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverEvolve2Countries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().providers.evolve2).toBeFalsy();
	});

	it('disables evolve2 provider when provider is disabled by wg var', function () {
		var adContext;
		mocks.win = {
			ads: {
				context: {
					providers: {
						evolve2: false
					}
				}
			}
		};

		mocks.instantGlobals = {wgAdDriverEvolve2Countries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().providers.evolve2).toBeFalsy();
	});

	it('disable overriding prefooters sizes for mercury', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['CURRENT_COUNTRY']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'mercury',
						pageType: 'article'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridePrefootersSizes).toBeFalsy();
	});

	it('disable overriding prefooters sizes for home page', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['CURRENT_COUNTRY']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'oasis',
						pageType: 'home'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridePrefootersSizes).toBeFalsy();
	});

	it('disable overriding prefooters sizes by country', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['ZZ']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'oasis',
						pageType: 'article'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridePrefootersSizes).toBeFalsy();
	});

	it('enable overriding prefooters sizes', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['CURRENT_COUNTRY']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'oasis',
						pageType: 'article'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridePrefootersSizes).toBeTruthy();
	});

	it('disable overriding leaderboard sizes for mercury', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['JP']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'mercury'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridyLeaderboardSizes).toBeFalsy();
	});

	it('disable overriding leaderboard sizes by country', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['ZZ']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridyLeaderboardSizes).toBeFalsy();
	});

	it('enable overriding leaderboard sizes', function () {
		mocks.instantGlobals = {wgAdDriverOverridePrefootersCountries: ['JP']};
		mocks.win = {
			ads: {
				context: {
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};

		expect(getModule().getContext().opts.overridyLeaderboardSizes).toBeFalsy();
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
});
