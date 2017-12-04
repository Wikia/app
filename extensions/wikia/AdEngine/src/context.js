export default {
	adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{slotName}',
	custom: {
		dfpId: '5441',
	},
	events: {},
	slots: {},
	vast: {
		adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{slotName}',
		megaAdUnitId: '/{custom.dfpId}/{src}.{slotConfig.slotGroup}/{slotConfig.lowerSlotName}/{custom.device}/{targeting.skin}-{targeting.s2}/{targeting.s1}-{targeting.s0}'
	},
	targeting: {
		outstream: 'none',
		uap: 'none',
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
