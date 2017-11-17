export default {
	adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{slotName}',
	custom: {
		adLayout: 'asd', // TODO: add dynamically
		device: 'desktop', // TODO: add dynamically
		dfpId: '5441',

	},
	events: {},
	slots: {
		'BOTTOM_LEADERBOARD': {
			disabled: true,
			slotName: 'BOTTOM_LEADERBOARD',
			lowerSlotName: 'bottom_leaderboard',
			slotGroup: 'PF',
			sizes: [
				{
					viewportSize: [728, 0],
					sizes: [[728, 90]]
				}
			],
			defaultSizes: [[2, 2]],
			targeting: {
				src: 'test', // TODO
				pos: 'BOTTOM_LEADERBOARD', // TODO
				loc: 'footer',
				uap: '356383452' // TODO
			}
		}
	},
	vast: {
		adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{slotName}',
		megaAdUnitId: '/{custom.dfpId}/{src}.{slotConfig.slotGroup}/{slotConfig.lowerSlotName}/{custom.device}/{targeting.skin}-{targeting.s2}/{targeting.s1}-{targeting.s0}'
	},
	targeting: {
		outstream: 'none',
		s1: '',
		uap: 'none',
		skin: 'oasis' // TODO: add dynamically
	},
	state: {
		adStack: window.adsQueue || [],
		isMobile: false
	},
	options: {
		customAdLoader: {
			globalMethodName: 'loadCustomAd'
		}
	}
};
