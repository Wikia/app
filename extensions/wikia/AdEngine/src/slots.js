export default {
	oasis: {
		'TOP_LEADERBOARD': {
			disabled: false,
			slotName: 'TOP_LEADERBOARD',
			lowerSlotName: 'top_leaderboard',
			slotGroup: 'LB',
			sizes: [
				{
					viewportSize: [728, 0],
					sizes: [[3, 3], [728, 90], [1030, 130], [1030, 65], [1030, 250], [970, 365], [970, 250], [970, 90],
						[970, 66], [970, 180], [980, 150], [1024, 416], [1440, 585]
					]
				}
			],
			defaultSizes: [[2, 2]],
			targeting: {
				pos: 'TOP_LEADERBOARD',
				loc: 'top'
			}
		},
		'BOTTOM_LEADERBOARD': {
			disabled: true,
			slotName: 'BOTTOM_LEADERBOARD',
			lowerSlotName: 'bottom_leaderboard',
			slotGroup: 'PF',
			sizes: [
				{
					viewportSize: [728, 0],
					sizes: [[728, 90], [970, 250]]
				}
			],
			defaultSizes: [[2, 2]],
			targeting: {
				pos: 'BOTTOM_LEADERBOARD',
				loc: 'footer'
			}
		}
	},
	mercury: {
		'MOBILE_BOTTOM_LEADERBOARD': {
			disabled: true,
			slotName: 'MOBILE_BOTTOM_LEADERBOARD',
			lowerSlotName: 'mobile_bottom_leaderboard',
			slotGroup: 'PF',
			sizes: [
				{
					viewportSize: [0, 0],
					sizes: [[320, 480]]
				}
			],
			defaultSizes: [[2, 2]],
			targeting: {
				pos: 'MOBILE_BOTTOM_LEADERBOARD',
				loc: 'footer'
			}
		},
		'MOBILE_TOP_LEADERBOARD': {
			disabled: false,
			slotName: 'MOBILE_TOP_LEADERBOARD',
			lowerSlotName: 'mobile_top_leaderboard',
			slotGroup: 'TLB',
			sizes: [
				{
					viewportSize: [0, 0],
					sizes: [[320, 480]]
				}
			],
			defaultSizes: [[2, 2]],
			targeting: {
				pos: 'MOBILE_TOP_LEADERBOARD',
				loc: 'top'
			}
		}
	}
};
