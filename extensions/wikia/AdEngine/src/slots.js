import { context, utils } from '@wikia/ad-engine';
import { getAdProductInfo } from '@wikia/ad-engine/dist/ad-products';

export default {
	getContext() {
		return {
			TOP_LEADERBOARD: {
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
			TOP_BOXAD: {
				disabled: false,
				slotName: 'TOP_BOXAD',
				bidderAlias: 'TOP_RIGHT_BOXAD',
				sizes: [
					{
						viewportSize: [728, 0],
						sizes: [[300, 250], [300, 600], [300, 1050]]
					}
				],
				options: {},
				defaultSizes: [[300, 250]],
				targeting: {
					pos: ['TOP_BOXAD', 'TOP_RIGHT_BOXAD'],
					loc: 'top'
				}
			},
			BOTTOM_LEADERBOARD: {
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
				viewportConflicts: ['TOP_BOXAD']
			},
			INCONTENT_PLAYER: {
				disabled: false,
				slotName: 'INCONTENT_PLAYER',
				options: {},
				defaultSizes: [[1, 1]],
				targeting: {
					pos: 'INCONTENT_PLAYER',
					loc: 'middle',
				},
			},
		};
	},

	setupSlotVideoAdUnit(adSlot, params) {
		if (params.isVideoMegaEnabled) {
			const adProductInfo = getAdProductInfo(adSlot.getSlotName(), params.type, params.adProduct);
			const adUnit = utils.stringBuilder.build(
				context.get('vast.megaAdUnitId'),
				{
					slotConfig: {
						group: adProductInfo.adGroup,
						adProduct: adProductInfo.adProduct,
					},
				},
			);

			context.set(`slots.${adSlot.getSlotName()}.videoAdUnit`, adUnit);
		}
	},
}
