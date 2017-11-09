export default {
	adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{slotName}',
	custom: {
		dfpId: '5441',
	},
	events: {},
	slots: {
		'bottom-leaderboard': {
			disabled: true,
			slotName: 'BOTTOM_LEADERBOARD',
			sizes: [
				{
					viewportSize: [728, 0],
					sizes: [[728, 90]]
				}
			],
			defaultSizes: [[2, 2]],
			targeting: {
				loc: 'footer'
			}
		}
	},
	vast: {
		adUnitId: '/{custom.dfpId}/wka.{targeting.s0}/{targeting.s1}//{targeting.s2}/{src}/{pos}',
	},
	targeting: {
		outstream: 'none',
		s1: '',
		uap: 'none'
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
