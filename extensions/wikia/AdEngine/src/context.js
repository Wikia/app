export default {
	adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{custom.wikiIdentifier}//{targeting.s2}/{src}/{slotName}',
	custom: {
		dfpId: '5441',
	},
	events: {},
	listeners: {
		porvata: []
	},
	slots: {},
	vast: {
		adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{custom.wikiIdentifier}//{targeting.s2}/{src}/{slotName}',
		megaAdUnitId: '/{custom.dfpId}/wka1a.{slotConfig.slotGroup}/{slotConfig.lowerSlotName}/{custom.device}/{targeting.skin}-{targeting.s2}/{custom.wikiIdentifier}-{targeting.s0}'
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
