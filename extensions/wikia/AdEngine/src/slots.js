export function getSlotsContext(legacyContext, skin) {
	const context = {
			oasis: {
				'TOP_LEADERBOARD': {
					disabled: false,
					slotName: 'TOP_LEADERBOARD',
					sizes: [
						{
							viewportSize: [728, 0],
							sizes: [[3, 3], [728, 90], [1030, 130], [1030, 65], [1030, 250], [970, 365], [970, 250], [970, 90],
								[970, 66], [970, 180], [980, 150], [1024, 416], [1440, 585]
							]
						}
					],
					options: {},
					defaultSizes: [[2, 2]],
					targeting: {
						pos: 'TOP_LEADERBOARD',
						loc: 'top'
					},
					defaultTemplates: []
				},
				'TOP_RIGHT_BOXAD': {
					disabled: false,
					slotName: 'TOP_RIGHT_BOXAD',
					sizes: [
						{
							viewportSize: [728, 0],
							sizes: [[300, 250], [300, 600], [300, 1050]]
						}
					],
					options: {},
					defaultSizes: [[300, 250]],
					targeting: {
						pos: 'TOP_RIGHT_BOXAD',
						loc: 'top'
					}
				},
				'BOTTOM_LEADERBOARD': {
					disabled: false,
					slotName: 'BOTTOM_LEADERBOARD',
					sizes: [
						{
							viewportSize: [728, 0],
							sizes: [[728, 90], [970, 250]]
						}
					],
					options: {},
					defaultSizes: [[2, 2]],
					targeting: {
						pos: 'BOTTOM_LEADERBOARD',
						loc: 'footer'
					},
					viewportConflicts: []
				}
			},
			mercury: {
				'BOTTOM_LEADERBOARD': {
					disabled: false,
					slotName: 'BOTTOM_LEADERBOARD',
					sizes: [
						{
							viewportSize: [0, 0],
							sizes: [[320, 50], [300, 250], [300, 50]]
						}
					],
					options: {},
					defaultSizes: [[2, 2]],
					targeting: {
						pos: ['BOTTOM_LEADERBOARD', 'MOBILE_PREFOOTER'],
						loc: 'footer'
					}
				},
				'MOBILE_TOP_LEADERBOARD': {
					disabled: false,
					slotName: 'MOBILE_TOP_LEADERBOARD',
					sizes: [
						{
							viewportSize: [0, 0],
							sizes: [[320, 480]]
						}
					],
					options: {},
					defaultSizes: [[2, 2]],
					targeting: {
						pos: 'MOBILE_TOP_LEADERBOARD',
						loc: 'top'
					}
				}
			}
		},
		slots = context[skin];

	if (skin === 'oasis' && legacyContext.get('opts.isBLBViewportEnabled')) {
		slots.BOTTOM_LEADERBOARD.viewportConflicts.push('TOP_RIGHT_BOXAD');
	}

	return slots;
}
