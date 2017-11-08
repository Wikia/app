export default {
	adUnitId: '/5441/wka.life/_project43//{custom.namespace}/gpt/{slotName}',
	custom: {
		group: 'life',
		namespace: 'article'
	},
	events: {
		pushOnScroll: {
			ids: [
				'gpt-incontent-boxad',
				'gpt-bottom-leaderboard'
			],
			threshold: 100
		}
	},
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
		adUnitId: '5441/wka.{custom.group}/_project43//{custom.namespace}/{src}/{pos}'
	},
	targeting: {
		outstream: 'none',
		s1: '_project43',
		uap: '365341572'
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
