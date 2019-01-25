export default {
	adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{custom.wikiIdentifier}//{targeting.s2}/{src}/{slotName}',
	custom: {
		dfpId: '5441',
		dbNameElement: '_not_a_top1k_wiki',
		wikiIdentifier: '_not_a_top1k_wiki'
	},
	events: {},
	listeners: {
		porvata: [],
		slot: []
	},
	slots: {},
	bidders: {},
	vast: {
		adUnitId: '/{custom.dfpId}/wka1b.{adGroup}/{adProduct}{audioSegment}/{custom.device}/{targeting.skin}-{targeting.s2}/{custom.wikiIdentifier}-{targeting.s0}'
	},
	targeting: {
		outstream: 'none',
		uap: 'none',
	},
	slotGroups: {
		LB: ['TOP_LEADERBOARD', 'MOBILE_TOP_LEADERBOARD'],
		MR: ['TOP_BOXAD'],
		PF: ['MOBILE_PREFOOTER', 'BOTTOM_LEADERBOARD'],
		PX: ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT', 'INVISIBLE_HIGH_IMPACT_2'],
		HiVi: ['INCONTENT_BOXAD_1', 'MOBILE_IN_CONTENT'],
		VIDEO: ['FEATURED', 'OUTSTREAM', 'UAP_BFAA', 'UAP_BFAB', 'ABCD', 'VIDEO']
	},
	state: {
		adStack: window.adsQueue || [],
		isMobile: false
	},
	options: {
		customAdLoader: {
			globalMethodName: 'loadCustomAd'
		},
		video: {
			moatTracking: {
				enabled: false,
				partnerCode: 'wikiaimajsint377461931603',
				sampling: 0
			}
		},
		porvata: {
			audio: {
				exposeToSlot: true,
				segment: '-audio',
				key: 'audio'
			}
		}
	}
};
