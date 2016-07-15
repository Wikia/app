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
			callback: noop
		},
		queryParams = [
			'evolve2',
			'liftium',
			'turtle'
		];

	function getModule() {
		return modules['ext.wikia.adEngine.adContext'](
			mocks.abTesting,
			mocks.wikiaCookies,
			mocks.doc,
			mocks.geo,
			mocks.instantGlobals,
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

	it(
		'fills getContext() with context, targeting, providers and forcedProvider ' +
		'even for empty (or missing) ads.context',
		function () {
			var adContext = getModule();

			expect(adContext.getContext().opts.enableScrollHandler).toBeFalsy();
			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
			expect(adContext.getContext().providers).toEqual({revcontent: false});
			expect(adContext.getContext().forcedProvider).toEqual(null);

			mocks.win = {ads: {context: {}}};
			adContext = getModule();
			expect(adContext.getContext().opts.enableScrollHandler).toBeFalsy();
			expect(adContext.getContext().targeting).toEqual({enableKruxTargeting: false});
			expect(adContext.getContext().providers).toEqual({revcontent: false});
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

	it('enables high impact 2 slot when country in instantGlobals.wgAdDriverHighImpact2SlotCountries', function () {
		var adContext;

		mocks.instantGlobals = {wgAdDriverHighImpact2SlotCountries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().slots.invisibleHighImpact2).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverHighImpact2SlotCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().slots.invisibleHighImpact2).toBeFalsy();
	});

	it('enables high impact slot when url param highimpactslot is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'highimpactslot' ?  '1' : '0';
		});

		expect(getModule().getContext().slots.invisibleHighImpact).toBeTruthy();
	});

	it('enables scroll handler when country in instantGlobals.wgAdDriverScrollHandlerCountries', function () {
		var adContext;

		mocks.instantGlobals = {wgAdDriverScrollHandlerCountries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().opts.enableScrollHandler).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverScrollHandlerCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().opts.enableScrollHandler).toBeFalsy();
	});

	it('enables scroll handler when url param scrollhandler is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'scrollhandler' ?  '1' : '0';
		});

		expect(getModule().getContext().opts.enableScrollHandler).toBeTruthy();
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

	it('enables detection when url param sourcepointdetection is set', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar'
					}
				}
			}
		};
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'sourcepointdetection' ?  '1' : '0';
		});

		expect(getModule().getContext().opts.sourcePointDetection).toBeTruthy();
		expect(getModule().getContext().opts.sourcePointDetectionMobile).toBeTruthy();
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

	it('enables incontent_player slot when country in instatnGlobals.wgAdDriverIncontentPlayerSlotCountries', function () {
		var adContext;

		mocks.instantGlobals = {wgAdDriverIncontentPlayerSlotCountries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().slots.incontentPlayer).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverIncontentPlayerSlotCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().slots.incontentPlayer).toBeFalsy();
	});

	it('enables incontent_leaderboard slot when ' +
	'country in instatnGlobals.wgAdDriverIncontentLeaderboardSlotCountries', function () {
		var adContext;

		mocks.instantGlobals = {wgAdDriverIncontentLeaderboardSlotCountries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().slots.incontentLeaderboard).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverIncontentLeaderboardSlotCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().slots.incontentLeaderboard).toBeFalsy();
	});

	it('enables incontent_leaderboard as out-of-page', function () {
		var adContext;

		mocks.instantGlobals = {wgAdDriverIncontentLeaderboardOutOfPageSlotCountries: ['HH', 'CURRENT_COUNTRY', 'ZZ']};
		adContext = getModule();
		expect(adContext.getContext().slots.incontentLeaderboardAsOutOfPage).toBeTruthy();

		mocks.instantGlobals = {wgAdDriverIncontentLeaderboardOutOfPageSlotCountries: ['YY']};
		adContext = getModule();
		expect(adContext.getContext().slots.incontentLeaderboardAsOutOfPage).toBeFalsy();
	});

	it('enables incontent_player slot when url param incontentplayer is set', function () {
		spyOn(mocks.querystring, 'getVal').and.callFake(function (param) {
			return param === 'incontentplayer' ?  '1' : '0';
		});

		expect(getModule().getContext().slots.incontentPlayer).toBeTruthy();
	});

	it('context.opts.scrollHandlerConfig equals instatnGlobals.wgAdDriverScrollHandlerConfig', function () {
		var config = {
			foo: 'bar'
		};

		mocks.instantGlobals = { wgAdDriverScrollHandlerConfig: config };

		expect(getModule().getContext().opts.scrollHandlerConfig).toBe(config);
	});

	it('enables recoveredAdsMessage when country in instant var and detection is on', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: true
					},
					targeting: {
						pageType: 'article',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY', 'ZZ']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeTruthy();
	});

	it('enables recoveredAdsMessage when region in instant var and detection is on', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: true
					},
					targeting: {
						pageType: 'article',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY-CURRENT_REGION']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeTruthy();
	});

	it('enables recoveredAdsMessage when country and region in instant var (country overwrites region)', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: true
					},
					targeting: {
						pageType: 'article',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY-EE', 'CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeTruthy();
	});

	it('disabled recoveredAdsMessage on non article page type', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: true
					},
					targeting: {
						pageType: 'home',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY-EE', 'CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeFalsy();
	});

	it('disables recoveredAdsMessage when country and region in instant var and both are invalid', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar'
					},
					targeting: {
						pageType: 'article',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY-EE', 'YY']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeFalsy();
	});

	it('disables recoveredAdsMessage when detection is off', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar'
					},
					targeting: {
						pageType: 'article',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['YY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeFalsy();
	});

	it('disables recoveredAdsMessage when showAds is false', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: false
					},
					targeting: {
						pageType: 'article',
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverAdsRecoveryMessageCountries: ['CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.recoveredAdsMessage).toBeFalsy();
	});

	it('enables google consumer surveys when country in instant var and abtest group is GROUP_5', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: true
					},
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverGoogleConsumerSurveysCountries: ['CURRENT_COUNTRY']
		};
		spyOn(mocks.abTesting, 'getGroup').and.returnValue('GROUP_5');

		expect(getModule().getContext().opts.googleConsumerSurveys).toBeTruthy();
	});

	it('disables google consumer surveys when abtest group is not GROUP_5', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: true
					},
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverGoogleConsumerSurveysCountries: ['YY']
		};

		expect(getModule().getContext().opts.googleConsumerSurveys).toBeFalsy();
	});

	it('disables google consumer surveys when country not in instant var', function () {
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
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverGoogleConsumerSurveysCountries: ['CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.googleConsumerSurveys).toBeFalsy();
	});

	it('disables google consumer surveys when detection is off', function () {
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
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['YY'],
			wgAdDriverGoogleConsumerSurveysCountries: ['CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.googleConsumerSurveys).toBeFalsy();
	});

	it('disables recoveredAdsMessage when showAds is false', function () {
		mocks.win = {
			ads: {
				context: {
					opts: {
						sourcePointDetectionUrl: '//foo.bar',
						showAds: false
					},
					targeting: {
						skin: 'oasis'
					}
				}
			}
		};
		mocks.instantGlobals = {
			wgAdDriverSourcePointDetectionCountries: ['CURRENT_COUNTRY'],
			wgAdDriverGoogleConsumerSurveysCountries: ['CURRENT_COUNTRY']
		};

		expect(getModule().getContext().opts.googleConsumerSurveys).toBeFalsy();
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
});
