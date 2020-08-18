import fallbackInstantConfig from './fallback-config.json';

export default {
	adUnitId: '/{custom.dfpId}/{custom.serverPrefix}.{slotConfig.group}/{slotConfig.adProduct}{slotConfig.slotNameSuffix}/{state.deviceType}/{targeting.skin}-{targeting.s2}/{custom.wikiIdentifier}-{targeting.s0}',
	bidders: {
		enabled: false,
		timeout: 2000,
		a9: {
			dealsEnabled: false,
			enabled: false,
			videoEnabled: false,
			amazonId: '3115',
			slots: {
				bottom_leaderboard: {
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				incontent_boxad_1: {
					sizes: [
						[300, 250],
						[300, 600]
					]
				},
				top_leaderboard: {
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				top_boxad: {
					sizes: [
						[300, 250],
						[300, 600]
					]
				},
				featured: {
					type: 'video'
				}
			}
		},
		prebid: {
			enabled: false,
			lazyLoadingEnabled: false,
			bidsRefreshing: {
				enabled: false,
				slots: ['incontent_boxad_1']
			},
			aol: {
				enabled: false,
				network: '9435.1',
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90]
						],
						placement: '4431497',
						alias: '4431497',
						sizeId: '225'
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						placement: '4431473',
						alias: '4431473',
						sizeId: '170'
					}
				}
			},
			appnexus: {
				enabled: false,
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						position: 'atf'
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						position: 'atf'
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						position: 'btf'
					},
					incontent_boxad_1: {
						sizes: [
							[160, 600],
							[300, 600],
							[300, 250]
						],
						position: 'hivi'
					}
				},
				placements: {
					atf: '11977073',
					btf: '11977096',
					hivi: '11977016',
					other: '11969927'
				},
				recPlacements: {
					atf: '11823778',
					btf: '11823724',
					hivi: '11823799',
					other: '11969927'
				}
			},
			appnexusAst: {
				enabled: false,
				debugPlacementId: '5768085',
				slots: {
					featured: {
						placementId: '13684967'
					},
					incontent_player: {
						placementId: '11543172'
					}
				}
			},
			beachfront: {
				enabled: false,
				debugAppId: '2e55f7ad-3558-49eb-a3e1-056ccd0e74e2',
				slots: {
					incontent_player: {
						appId: 'd239e601-dd57-4163-fe5d-35012d77395f'
					}
				}
			},
			indexExchange: {
				enabled: false,
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						siteId: '183423'
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						siteId: '183567'
					},
					incontent_boxad_1: {
						sizes: [
							[160, 600],
							[300, 600],
							[300, 250]
						],
						siteId: '185049'
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						siteId: '209250'
					},
					featured: {
						siteId: '437502'
					}
				},
				recPlacements: {
					top_leaderboard: '215807',
					top_boxad: '215808',
					incontent_boxad_1: '215809',
					bottom_leaderboard: '215810'
				}
			},
			kargo: {
				enabled: false,
				slots: {}
			},
			nobid: {
				enabled: false,
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						siteId: 21872987104
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						siteId: 21872987104
					},
					incontent_boxad_1: {
						sizes: [
							[300, 250],
							[300, 600],
							[160, 600]
						],
						siteId: 21872987104
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						siteId: 21872987104
					}
				}
			},
			onemobile: {
				enabled: false,
				slots: {}
			},
			oneVideo: {
				enabled: false,
				slots: {
					featured: {
						pubId: 'FandomIS'
					},
					incontent_player: {
						pubId: 'FandomOS'
					}
				}
			},
			openx: {
				enabled: false,
				delDomain: 'wikia-d.openx.net',
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						unit: 538735690
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						unit: 538735691
					},
					incontent_boxad_1: {
						sizes: [
							[300, 250],
							[300, 600],
							[160, 600]
						],
						unit: 538735697
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						unit: 539119447
					}
				}
			},
			pubmatic: {
				enabled: false,
				publisherId: '156260',
				slots: {
					featured: {
						sizes: [
							[0, 0]
						],
						ids: [
							'1636185@0x0'
						]
					},
					incontent_player: {
						sizes: [
							[0, 0]
						],
						ids: [
							'1636186@0x0'
						]
					},
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						ids: [
							'/5441/TOP_LEADERBOARD_728x90@728x90',
							'/5441/TOP_LEADERBOARD_970x250@970x250'
						]
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						ids: [
							'/5441/TOP_RIGHT_BOXAD_300x250@300x250',
							'/5441/TOP_RIGHT_BOXAD_300x600@300x600'
						]
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						ids: [
							'/5441/BOTTOM_LEADERBOARD_728x90@728x90',
							'/5441/BOTTOM_LEADERBOARD_970x250@970x250'
						]
					},
					incontent_boxad_1: {
						sizes: [
							[160, 600],
							[300, 600],
							[300, 250]
						],
						ids: [
							'/5441/INCONTENT_BOXAD_1_160x600@160x600',
							'/5441/INCONTENT_BOXAD_1_300x250@300x250',
							'/5441/INCONTENT_BOXAD_1_300x600@300x600'
						]
					}
				}
			},
			rubicon: {
				enabled: false,
				accountId: 7450,
				slots: {
					featured: {
						siteId: '147980',
						sizeId: '201',
						zoneId: '699374',
					},
					incontent_player: {
						siteId: '55412',
						sizeId: '203',
						zoneId: '260296',
					}
				}
			},
			rubicon_display: {
				enabled: false,
				accountId: 7450,
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						targeting: {
							loc: ['top']
						},
						position: 'atf',
						siteId: '148804',
						zoneId: '704672'
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						targeting: {
							loc: ['top']
						},
						position: 'atf',
						siteId: '148804',
						zoneId: '704672'
					},
					incontent_boxad_1: {
						sizes: [
							[160, 600],
							[300, 600],
							[300, 250]
						],
						targeting: {
							loc: ['hivi']
						},
						siteId: '148804',
						zoneId: '704676'
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						targeting: {
							loc: ['footer']
						},
						siteId: '148804',
						zoneId: '704674'
					}
				}
			},
			telaria: {
				enabled: false,
				slots: {
					featured: {
						adCode: '2ciy2-doix6',
						supplyCode: '2ciy2-9kbup',
					}
				}
			},
			triplelift: {
				enabled: false,
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						inventoryCodes: [
							'Fandom_DT_LB_728x90_hdx_prebid',
							'Fandom_DT_LB_970x250_hdx_prebid'
						]
					},
					top_boxad: {
						sizes: [
							[300, 250],
							[300, 600]
						],
						inventoryCodes: [
							'Fandom_DT_MR_300x250_prebid',
							'Fandom_DT_MR_300x600_prebid'
						]
					},
					incontent_boxad_1: {
						sizes: [
							[160, 600],
							[300, 600],
							[300, 250]
						],
						inventoryCodes: [
							'Fandom_DT_FMR_160x600_hdx_prebid',
							'Fandom_DT_FMR_300x250_hdx_prebid',
							'Fandom_DT_FMR_300x600_hdx_prebid'
						]
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90],
							[970, 250]
						],
						inventoryCodes: [
							'Fandom_DT_BLB_728x90_hdx_prebid',
							'Fandom_DT_BLB_970x250_hdx_prebid'
						]
					}
				}
			},
			wikia: {
				enabled: false,
				slots: {
					top_leaderboard: {
						sizes: [
							[728, 90]
						]
					},
					top_boxad: {
						sizes: [
							[300, 250]
						]
					},
					incontent_boxad_1: {
						sizes: [
							[300, 250]
						]
					},
					bottom_leaderboard: {
						sizes: [
							[728, 90]
						]
					}
				}
			},
			wikiaVideo: {
				enabled: false,
				slots: {
					featured: {
						videoAdUnitId: '/5441/wka.life/_project43//article/test/outstream',
						customParams: 's1=_project43&artid=402&src=test&pos=outstream'
					},
					incontent_player: {
						videoAdUnitId: '/5441/wka.life/_project43//article/test/outstream',
						customParams: 's1=_project43&artid=402&src=test&pos=outstream'
					}
				}
			}
		}
	},
	custom: {
		appnexusDfp: true,
		beachfrontDfp: false,
		dbNameForAdUnit: '_not_a_top1k_wiki',
		dfpId: '5441',
		pubmaticDfp: false,
		rubiconDfp: true,
		serverPrefix: 'wka1b',
		wikiIdentifier: '_not_a_top1k_wiki',
	},
	events: {
		pushOnScroll: {
			ids: [],
			threshold: 100,
		},
	},
	slots: {},
	vast: {
		adUnitId: '/{custom.dfpId}/{custom.serverPrefix}.{slotConfig.group}/{slotConfig.adProduct}{slotConfig.slotNameSuffix}/{state.deviceType}/{targeting.skin}-{targeting.s2}/{custom.wikiIdentifier}-{targeting.s0}',
		adUnitIdWithDbName: '/{custom.dfpId}/{custom.serverPrefix}.{slotConfig.group}/{slotConfig.adProduct}{slotConfig.slotNameSuffix}/{state.deviceType}/{targeting.skin}-{targeting.s2}/{custom.dbNameForAdUnit}-{targeting.s0}',
	},
	targeting: {
		ae3: '1',
		skin: 'oasis',
		uap: 'none',
		uap_c: 'none'
	},
	services: {
		billTheLizard: {
			enabled: true,
			host: 'https://services.wikia.com',
			endpoint: 'bill-the-lizard/predict',
			projects: {},
			parameters: {},
			timeout: 2000,
		},
		confiant: {
			enabled: false,
			propertyId: 'd-aIf3ibf0cYxCLB1HTWfBQOFEA',
		},
		durationMedia: {
			enabled: false,
		},
		distroScale: {
			enabled: false,
			id: '22599',
		},
		externalLogger: {
			endpoint: '/wikia.php?controller=AdEngine&method=postLog',
		},
		iasPublisherOptimization: {
			pubId: '930616',
			slots: [
				'hivi_leaderboard',
				'top_leaderboard',
				'top_boxad',
				'incontent_boxad_1',
				'bottom_leaderboard',
			],
		},
		instantConfig: {
			endpoint: 'https://services.wikia.com/icbm/api/config?app=oasis',
			fallback: fallbackInstantConfig,
		},
		nielsen: {
			enabled: false,
			appId: 'P26086A07-C7FB-4124-A679-8AC404198BA7',
		},
	},
	slotGroups: {
		VIDEO: ['ABCD', 'FEATURED', 'OUTSTREAM', 'UAP_BFAA', 'UAP_BFAB', 'VIDEO'],
	},
	src: 'gpt',
	state: {
		adStack: [],
		isMobile: false,
	},
	options: {
		customAdLoader: {
			globalMethodName: 'loadCustomAd',
		},
		video: {
			moatTracking: {
				articleVideosPartnerCode: 'wikiajwint101173217941',
				enabled: false,
				jwplayerPluginUrl: 'https://z.moatads.com/jwplayerplugin0938452/moatplugin.js',
				partnerCode: 'wikiaimajsint377461931603',
				sampling: 0,
			},
			iasTracking: {
				enabled: false,
				config: {
					anId: '930616',
					campId: '640x480',
				},
			},
		},
		wad: {
			enabled: false,
			blocking: false,
			blockingSrc: 'rec',
			btRec: {
				enabled: false,
				placementsMap: {
					top_leaderboard: {
						uid: '5b33d3584c-188',
						style: {
							'margin': '10px 0',
							'z-index': '100'
						},
						size: {
							width: 728,
							height: 90
						},
						lazy: false
					},
					top_boxad: {
						uid: '5b2d1649b2-188',
						style: {
							'margin-bottom': '10px',
							'z-index': '100'
						},
						size: {
							width: 300,
							height: 250
						},
						lazy: false
					},
					incontent_boxad_1: {
						uid: '5bbe13967e-188',
						style: {
							'z-index': '100'
						},
						size: {
							width: 300,
							height: 250
						},
						lazy: true
					},
					bottom_leaderboard: {
						uid: '5b8f13805d-188',
						style: {
							'margin-bottom': '23px',
							'z-index': '100'
						},
						size: {
							width: 728,
							height: 90
						},
						lazy: true
					}
				}
			},
		},
	},
};
