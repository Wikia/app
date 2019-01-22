export default {
  adUnitId: '/{custom.dfpId}/wka1b.{slotConfig.group}/{slotConfig.adProduct}{slotConfig.slotNameSuffix}/'
  + '{state.deviceType}/{targeting.skin}-{targeting.s2}/{custom.wikiIdentifier}-{targeting.s0}',
  bidders: {
    enabled: false,
    timeout: 2000,
    a9: {
      dealsEnabled: false,
      enabled: false,
      videoEnabled: false,
      amazonId: '3115',
      slots: {
        BOTTOM_LEADERBOARD: {
          sizes: [
            [728, 90],
            [970, 250]
          ]
        },
        INCONTENT_BOXAD_1: {
          sizes: [
            [300, 250],
            [300, 600]
          ]
        },
        TOP_LEADERBOARD: {
          sizes: [
            [728, 90],
            [970, 250]
          ]
        },
        TOP_RIGHT_BOXAD: {
          sizes: [
            [300, 250],
            [300, 600]
          ]
        },
        FEATURED: {
          type: 'video'
        }
      }
    },
    prebid: {
      enabled: false,
      lazyLoadingEnabled: false,
      bidsRefreshing: {
        enabled: false,
        slots: []
      },
      aol: {
        enabled: false,
        network: '9435.1',
        slots: {
          TOP_LEADERBOARD: {
            sizes: [
              [728, 90]
            ],
            placement: '4431497',
            alias: '4431497',
            sizeId: '225'
          },
          TOP_RIGHT_BOXAD: {
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
          TOP_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            position: 'atf'
          },
          TOP_RIGHT_BOXAD: {
            sizes: [
              [300, 250],
              [300, 600]
            ],
            position: 'atf'
          },
          BOTTOM_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            position: 'btf'
          },
          INCONTENT_BOXAD_1: {
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
          FEATURED: {
            placementId: '13684967'
          },
          INCONTENT_PLAYER: {
            placementId: '11543172'
          }
        }
      },
      audienceNetwork: {
        enabled: false,
        slots: {}
      },
      beachfront: {
        enabled: false,
        debugAppId: '2e55f7ad-3558-49eb-a3e1-056ccd0e74e2',
        slots: {
          INCONTENT_PLAYER: {
            appId: 'd239e601-dd57-4163-fe5d-35012d77395f'
          }
        }
      },
      indexExchange: {
        enabled: false,
        slots: {
          TOP_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            siteId: '183423'
          },
          TOP_RIGHT_BOXAD: {
            sizes: [
              [300, 250],
              [300, 600]
            ],
            siteId: '183567'
          },
          INCONTENT_BOXAD_1: {
            sizes: [
              [160, 600],
              [300, 600],
              [300, 250]
            ],
            siteId: '185049'
          },
          BOTTOM_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            siteId: '209250'
          }
        },
        recPlacements: {
          TOP_LEADERBOARD: '215807',
          TOP_RIGHT_BOXAD: '215808',
          INCONTENT_BOXAD_1: '215809',
          BOTTOM_LEADERBOARD: '215810'
        }
      },
      kargo: {
        enabled: false,
        slots: {}
      },
      onemobile: {
        enabled: false,
        slots: {}
      },
      openx: {
        enabled: false,
        delDomain: 'wikia-d.openx.net',
        slots: {
          TOP_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            unit: 538735690
          },
          TOP_RIGHT_BOXAD: {
            sizes: [
              [300, 250],
              [300, 600]
            ],
            unit: 538735691
          },
          INCONTENT_BOXAD_1: {
            sizes: [
              [300, 250],
              [300, 600],
              [160, 600]
            ],
            unit: 538735697
          },
          BOTTOM_LEADERBOARD: {
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
          FEATURED: {
            sizes: [
              [0, 0]
            ],
            ids: [
              '1636185@0x0'
            ]
          },
          TOP_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            ids: [
              '/5441/TOP_LEADERBOARD_728x90@728x90',
              '/5441/TOP_LEADERBOARD_970x250@970x250'
            ]
          },
          TOP_RIGHT_BOXAD: {
            sizes: [
              [300, 250],
              [300, 600]
            ],
            ids: [
              '/5441/TOP_RIGHT_BOXAD_300x250@300x250',
              '/5441/TOP_RIGHT_BOXAD_300x600@300x600'
            ]
          },
          BOTTOM_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            ids: [
              '/5441/BOTTOM_LEADERBOARD_728x90@728x90',
              '/5441/BOTTOM_LEADERBOARD_970x250@970x250'
            ]
          },
          INCONTENT_BOXAD_1: {
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
          FEATURED: {
            siteId: '147980',
            sizeId: '201',
            zoneId: '699374',
            position: 'btf'
          },
          INCONTENT_PLAYER: {
            siteId: '55412',
            sizeId: '203',
            zoneId: '260296',
            position: 'btf'
          }
        }
      },
      rubiconDisplay: {
        enabled: false,
        accountId: 7450,
        slots: {
          TOP_LEADERBOARD: {
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
          TOP_RIGHT_BOXAD: {
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
          INCONTENT_BOXAD_1: {
            sizes: [
              [160, 600],
              [300, 600],
              [300, 250]
            ],
            targeting: {
              loc: ['hivi']
            },
            position: 'btf',
            siteId: '148804',
            zoneId: '704676'
          },
          BOTTOM_LEADERBOARD: {
            sizes: [
              [728, 90],
              [970, 250]
            ],
            targeting: {
              loc: ['footer']
            },
            position: 'btf',
            siteId: '148804',
            zoneId: '704674'
          }
        }
      },
      wikia: {
        enabled: false,
        slots: {
          TOP_LEADERBOARD: {
            sizes: [
              [728, 90]
            ]
          },
          TOP_RIGHT_BOXAD: {
            sizes: [
              [300, 250]
            ]
          },
          INCONTENT_BOXAD_1: {
            sizes: [
              [300, 250]
            ]
          },
          BOTTOM_LEADERBOARD: {
            sizes: [
              [728, 90]
            ]
          }
        }
      },
      wikiaVideo: {
        enabled: false,
        slots: {
          FEATURED: {
            videoAdUnitId: '/5441/wka.life/_project43//article/test/outstream',
            customParams: 's1=_project43&artid=402&src=test&pos=outstream&passback=wikiaVideo'
          },
          INCONTENT_PLAYER: {
            videoAdUnitId: '/5441/wka.life/_project43//article/test/outstream',
            customParams: 's1=_project43&artid=402&src=test&pos=outstream&passback=wikiaVideo'
          }
        }
      }
    }
  },
  custom: {
    dfpId: '5441',
    wikiIdentifier: '_not_a_top1k_wiki',
    appnexusDfp: true,
    rubiconDfp: true,
    pubmaticDfp: false,
  },
  events: {
    pushOnScroll: {
      ids: [],
      threshold: 100,
    },
  },
  listeners: {
    porvata: [],
    slot: [],
  },
  slots: {},
  vast: {
    adUnitId: '/{custom.dfpId}/wka1b.{slotConfig.group}/{slotConfig.adProduct}{slotConfig.slotNameSuffix}/'
   + '{state.deviceType}/{targeting.skin}-{targeting.s2}/{custom.wikiIdentifier}-{targeting.s0}',
  },
  targeting: {
    ae3: '1',
    outstream: 'none',
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
    krux: {
      enabled: false,
      id: 'JU3_GW1b',
    },
    moatYi: {
      enabled: false,
      partnerCode: 'wikiaprebidheader490634422386',
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
    isMobile: true,
  },
  options: {
    customAdLoader: {
      globalMethodName: 'loadCustomAd',
    },
    video: {
      moatTracking: {
        articleVideosPartnerCode: 'wikiaimajsint377461931603',
        enabled: false,
        jwplayerPluginUrl: 'https://z.moatads.com/jwplayerplugin0938452/moatplugin.js',
        partnerCode: 'wikiajwint101173217941',
        sampling: 0,
      },
    },
  },
};
