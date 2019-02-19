import { context, slotService, utils } from '@wikia/ad-engine';
import { getAdProductInfo } from '@wikia/ad-engine/dist/ad-products';
import { throttle } from 'lodash';
import { babDetection } from './wad/bab-detection';
import { recRunner } from './wad/rec-runner';
import { btLoader } from './wad/bt-loader';

const PAGE_TYPES = {
	article: 'a',
	home: 'h',
};

function isIncontentBoxadApplicable() {
	const isSupportedPageType = ['article', 'search'].indexOf(context.get('wiki.targeting.pageType')) !== -1;

	return isSupportedPageType &&
		window.wgIsContentNamespace &&
		context.get('wiki.opts.adsInContent') &&
		!context.get('wiki.targeting.wikiIsCorporate');
}

function isHighImpactApplicable() {
	return !context.get('custom.hasFeaturedVideo');
}

function isIncontentPlayerApplicable() {
	const header = document.querySelectorAll('#mw-content-text > h2')[1];

	return !context.get('custom.hasFeaturedVideo') &&
		header && header.offsetWidth >= header.parentNode.offsetWidth;
}

/**
 * Enables top_boxad on screen with width >= 1024px.
 *
 * @returns {boolean}
 */
function isTopBoxadApplicable() {
	return utils.getViewportWidth() >= 1024;
}

export const hasLowerSlotNames = !document.getElementById('TOP_LEADERBOARD');

export default {
	getContext() {
		return {
			top_leaderboard: {
				aboveTheFold: true,
				bidderAlias: 'TOP_LEADERBOARD',
				firstCall: true,
				adProduct: 'top_leaderboard',
				slotNameSuffix: '',
				group: 'LB',
				options: {},
				slotShortcut: 'l',
				sizes: [
					{
						viewportSize: [1440, 0],
						sizes: [
							[728, 90],
							[970, 66],
							[970, 90],
							[970, 150],
							[970, 180],
							[970, 250],
							[970, 365],
							[1024, 416],
							[1030, 65],
							[1030, 130],
							[1030, 250],
							[1440, 585],
						],
					},
					{
						viewportSize: [1024, 0],
						sizes: [
							[728, 90],
							[970, 66],
							[970, 90],
							[970, 150],
							[970, 180],
							[970, 250],
							[970, 365],
							[1024, 416],
							[1030, 65],
							[1030, 130],
							[1030, 250]
						],
					},
				],
				defaultSizes: [[728, 90]],
				defaultTemplates: [],
				targeting: {
					loc: 'top',
					rv: 1,
					xna: 1,
				},
			},
			top_boxad: {
				adProduct: 'top_boxad',
				aboveTheFold: true,
				bidderAlias: 'TOP_RIGHT_BOXAD',
				slotNameSuffix: '',
				group: 'MR',
				options: {},
				slotShortcut: 'm',
				sizes: [
					{
						viewportSize: [1024, 1300],
						sizes: [
							[300, 250],
							[300, 600],
							[300, 1050]
						],
					},
				],
				defaultSizes: [[300, 250], [300, 600]],
				targeting: {
					loc: 'top',
					pos: ['TOP_BOXAD', 'TOP_RIGHT_BOXAD'],
					rv: 1,
				},
			},
			invisible_skin: {
				adProduct: 'invisible_skin',
				aboveTheFold: true,
				slotNameSuffix: '',
				group: 'PX',
				options: {},
				slotShortcut: 'x',
				sizes: [
					{
						viewportSize: [1240, 0],
						sizes: [
							[1, 1],
							[1000, 1000],
						],
					},
				],
				defaultSizes: [[1, 1]],
				targeting: {
					loc: 'top',
					rv: 1,
				},
			},
			incontent_boxad_1: {
				adProduct: 'incontent_boxad_1',
				bidderAlias: 'INCONTENT_BOXAD_1',
				slotNameSuffix: '',
				group: 'HiVi',
				options: {},
				slotShortcut: 'f',
				sizes: [],
				defaultSizes: [[300, 250]],
				targeting: {
					loc: 'hivi',
					rv: 1,
				},
			},
			bottom_leaderboard: {
				adProduct: 'bottom_leaderboard',
				bidderAlias: 'BOTTOM_LEADERBOARD',
				slotNameSuffix: '',
				group: 'PF',
				options: {},
				slotShortcut: 'b',
				sizes: [
					{
						viewportSize: [1024, 0],
						sizes: [
							[728, 90],
							[970, 250],
						],
					},
				],
				defaultSizes: [[728, 90]],
				targeting: {
					loc: 'footer',
					rv: 1,
					xna: 1,
				},
			},
			incontent_player: {
				adProduct: 'incontent_player',
				avoidConflictWith: '.ad-slot',
				autoplay: true,
				audio: false,
				bidderAlias: 'INCONTENT_PLAYER',
				insertBeforeSelector: '.article-content > h2',
				disabled: true,
				slotNameSuffix: '',
				group: 'HiVi',
				slotShortcut: 'i',
				defaultSizes: [[1, 1]],
				targeting: {
					loc: 'middle',
					pos: ['incontent_player'],
					rv: 1,
				},
			},
			invisible_high_impact_2: {
				adProduct: 'invisible_high_impact_2',
				slotNameSuffix: '',
				group: 'PX',
				options: {},
				outOfPage: true,
				targeting: {
					loc: 'hivi',
					rv: 1,
				},
			},
			featured: {
				adProduct: 'featured',
				bidderAlias: 'FEATURED',
				slotNameSuffix: '',
				nonUapSlot: true,
				group: 'VIDEO',
				lowerSlotName: 'featured',
				videoSizes: [[640, 480]],
				targeting: {
					rv: 1
				},
				trackEachStatus: true,
				trackingKey: 'featured-video',
			},
		};
	},

	addSlotSize(slotName, size) {
		const definedViewportSizes = context.get(`slots.${slotName}.sizes`);

		context.push(`slots.${slotName}.defaultSizes`, size);
		definedViewportSizes.forEach((sizeMap) => {
			sizeMap.sizes.push(size);
		})
	},

	setupSlotParameters(slot) {
		const audioSuffix = slot.config.audio === true ? '-audio' : '';
		const clickToPlaySuffix = slot.config.autoplay === true || slot.config.videoDepth > 1 ? '' : '-ctp';

		slot.setConfigProperty('slotNameSuffix', clickToPlaySuffix || audioSuffix || '');
		slot.setConfigProperty('targeting.audio', audioSuffix ? 'yes' : 'no');
		slot.setConfigProperty('targeting.ctp', clickToPlaySuffix ? 'yes' : 'no');
	},

	setupStates() {
		slotService.setState('top_leaderboard', true);
		slotService.setState('top_boxad', isTopBoxadApplicable());
		slotService.setState('incontent_boxad_1', true);
		slotService.setState('bottom_leaderboard', true);
		slotService.setState('incontent_player', isIncontentPlayerApplicable());
		slotService.setState('invisible_skin', true);
		slotService.setState('invisible_high_impact_2', isHighImpactApplicable());

		slotService.setState('featured', context.get('custom.hasFeaturedVideo'));
		slotService.setState('gpt_flush', false);

		// TODO: Remove those slots once AE3 is globally enabled
		slotService.setState('top_leaderboard_ab', false);
		slotService.setState('gpt_flush', false);

		// TODO: Remove me after 24h -- slots injected on backend
		if (!hasLowerSlotNames) {
			slotService.setState('TOP_LEADERBOARD', true);
			slotService.setState('TOP_BOXAD', isTopBoxadApplicable());
			slotService.setState('INVISIBLE_SKIN', true);
			slotService.setState('TOP_LEADERBOARD_AB', false);
			slotService.setState('GPT_FLUSH', false);
		}
	},

	setupIdentificators() {
		const pageTypeParam = PAGE_TYPES[context.get('wiki.targeting.pageType')] || 'x';
		const slotsDefinition = context.get('slots');

		// Wikia Page Identificator
		context.set('targeting.wsi', `ox${pageTypeParam}1`);
		Object.keys(slotsDefinition).forEach((key) => {
			const slotParam = slotsDefinition[key].slotShortcut || 'x';
			context.set(`slots.${key}.targeting.wsi`, `o${slotParam}${pageTypeParam}1`);
		});
	},

	setupSizesAvailability() {
		if (window.innerWidth >= 1024) {
			context.set('slots.top_leaderboard.targeting.xna', '0');
			context.set('slots.bottom_leaderboard.targeting.xna', '0');
		}
	},

	injectBottomLeaderboard() {
		const slotName = 'bottom_leaderboard';
		const pushSlotAfterComments = throttle(() => {
			if (window.ArticleComments && !window.ArticleComments.initCompleted) {
				return;
			}

			if (babDetection.isBlocking() && recRunner.isEnabled('bt') && btLoader.duplicateSlot(slotName)) {
				btLoader.triggerScript();
			}

			document.removeEventListener('scroll', pushSlotAfterComments);
			context.push('events.pushOnScroll.ids', slotName);
		}, 250);

		document.addEventListener('scroll', pushSlotAfterComments);
	},

	injectIncontentPlayer() {
		const header = document.querySelectorAll('#mw-content-text > h2')[1];

		if (!header || !isIncontentPlayerApplicable()) {
			return;
		}

		const slotName = 'incontent_player';
		const wrapper = document.createElement('div');

		wrapper.id = 'INCONTENT_WRAPPER';
		wrapper.innerHTML = '<div id="' + slotName + '" class="wikia-ad hide"></div>';
		header.parentNode.insertBefore(wrapper, header);

		context.push('state.adStack', { id: slotName });
	},

	// TODO: Extract floating medrec to separate module once we do refreshing
	injectIncontentBoxad() {
		const slotName = 'incontent_boxad_1';
		const isApplicable = isIncontentBoxadApplicable();
		const parentNode = document.getElementById('WikiaAdInContentPlaceHolder');

		if (!isApplicable || !parentNode) {
			slotService.setState(slotName, false);
			return;
		}

		const element = document.createElement('div');
		element.id = slotName;
		element.classList.add('wikia-ad');

		parentNode.appendChild(element);

		setTimeout(() => {
			// TODO: Add FMR recovery logic from AE2::floatingMedrec.js

			context.push('events.pushOnScroll.ids', slotName);
		}, 10000);
	},

	injectHighImpact() {
		context.push('state.adStack', { id: 'invisible_high_impact_2' });
	},
};
