export default {
	adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{slotName}',
	custom: {
		dfpId: '5441',
	},
	events: {},
	listeners: {
		porvata: [],
		slot: []
	},
	slots: {},
	vast: {
		adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{targeting.src}/{slotName}',
		megaAdUnitId: '/{custom.dfpId}/wka1a.{adGroup}/{adProduct}/{custom.device}/{targeting.skin}-{targeting.s2}/{targeting.s1}-{targeting.s0}'
	},
	targeting: {
		outstream: 'none',
		uap: 'none',
	},
	slotGroups: {
		LB: ['TOP_LEADERBOARD', 'MOBILE_TOP_LEADERBOARD'],
		MR: ['TOP_RIGHT_BOXAD'],
		PF: ['MOBILE_PREFOOTER', 'BOTTOM_LEADERBOARD', 'MOBILE_BOTTOM_LEADERBOARD'],
		PX: ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT', 'INVISIBLE_HIGH_IMPACT_2'],
		HiVi: ['INCONTENT_BOXAD_1', 'MOBILE_IN_CONTENT'],
		VIDEO: ['FEATURED', 'OUTSTREAM', 'UAP_BFAA', 'UAP_BFAB', 'ABCD', 'OOYALA', 'VIDEO']
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
		}
	}
};
