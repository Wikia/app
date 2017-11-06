export default {
	adUnitId: '/5441/wka.life/_project43//{custom.namespace}/gpt/{slotName}',
	custom: {
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
		adUnitId: '/5441/wka1a.{group}/{src}/desktop/oasis-fv-article/_project43-life'
	},
	targeting: {
		outstream: 'none',
		s1: '_project43',
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
