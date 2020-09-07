import {
	AdSlot,
	btRec,
	context,
	distroScale,
	events,
	eventService,
	FmrRotator,
	scrollListener,
	slotInjector,
	slotDataParamsUpdater,
	slotService,
	utils,
	getAdProductInfo
} from '@wikia/ad-engine';
import { throttle } from 'lodash';
import { take } from 'rxjs/operators';
import { communicationService } from "./communication/communication-service";
import { ofType } from "./communication/of-type";

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
	return !context.get('custom.hasFeaturedVideo') && context.get('slots.floor_adhesion.disabled');
}

function isFloorAdhesionApplicable() {
	return !context.get('custom.hasFeaturedVideo') && !context.get('slots.floor_adhesion.disabled');
}

function isAffiliateSlotApplicable() {
	return isRightRailApplicable() && context.get('wiki.opts.enableAffiliateSlot') && !context.get('custom.hasFeaturedVideo');
}

function registerFloorAdhesionCodePriority() {
	let porvataClosedActive = false;

	slotService.on('floor_adhesion', AdSlot.STATUS_SUCCESS, () => {
		porvataClosedActive = true;

		eventService.on(events.VIDEO_AD_IMPRESSION, () => {
			if (porvataClosedActive) {
				porvataClosedActive = false;
				slotService.disable('floor_adhesion', 'closed-by-porvata');
			}
		});
	});

	slotService.on('floor_adhesion', AdSlot.HIDDEN_EVENT, () => {
		porvataClosedActive = false;
	});
}

/**
 * Enables top_boxad on screen with width >= 1024px.
 *
 * @returns {boolean}
 */
function isRightRailApplicable() {
	return utils.getViewportWidth() >= 1024;
}

export default {
	getContext() {
		return {
			hivi_leaderboard: {
				aboveTheFold: true,
				firstCall: true,
				adProduct: 'hivi_leaderboard',
				slotNameSuffix: '',
				group: 'LB',
				options: {},
				slotShortcut: 'v',
				sizes: [
					{
						viewportSize: [1024, 0],
						sizes: [
							[728, 90],
							[970, 250]
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
			top_leaderboard: {
				aboveTheFold: true,
				firstCall: true,
				adProduct: 'top_leaderboard',
				slotNameSuffix: '',
				group: 'LB',
				options: {},
				slotShortcut: 'l',
				sizes: [
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
				slotNameSuffix: '',
				group: 'MR',
				options: {},
				slotShortcut: 'm',
				defaultSizes: [[300, 250], [300, 600], [300, 1050]],
				targeting: {
					loc: 'top',
					rv: 1,
				},
			},
			affiliate_slot: {
				adProduct: 'affiliate_slot',
				aboveTheFold: true,
				slotNameSuffix: '',
				group: 'AU',
				options: {},
				slotShortcut: 'a',
				defaultSizes: [[280, 120]],
				insertBeforeSelector: '#top_boxad',
				targeting: {
					loc: 'top',
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
				bidderAlias: 'incontent_boxad_1',
				slotNameSuffix: '',
				group: 'HiVi',
				options: {},
				slotShortcut: 'f',
				sizes: [],
				defaultSizes: [[120, 600], [160, 600], [300, 250], [300, 600]],
				insertBeforeSelector: '#incontent_boxad_1',
				garfieldCat: true,
				repeat: {
					additionalClasses: 'hide',
					index: 1,
					limit: 20,
					slotNamePattern: 'incontent_boxad_{slotConfig.repeat.index}',
					updateProperties: {
						adProduct: '{slotConfig.slotName}',
						'targeting.rv': '{slotConfig.repeat.index}',
					},
					insertBelowScrollPosition: false,
					disablePushOnScroll: true,
				},
				targeting: {
					loc: 'hivi',
					rv: 1,
				},
			},
			bottom_leaderboard: {
				adProduct: 'bottom_leaderboard',
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
				avoidConflictWith: null,
				autoplay: true,
				audio: false,
				insertBeforeSelector: '#mw-content-text > h2',
				insertBelowFirstViewport: true,
				disabled: true,
				slotNameSuffix: '',
				group: 'HiVi',
				slotShortcut: 'i',
				defaultSizes: [[1, 1]],
				targeting: {
					loc: 'middle',
					pos: ['outstream'],
					rv: 1,
				},
				isVideo: true,
			},
			floor_adhesion: {
				adProduct: 'floor_adhesion',
				disabled: true,
				forceSafeFrame: true,
				slotNameSuffix: '',
				group: 'PF',
				options: {},
				targeting: {
					loc: 'footer',
					rv: 1,
				},
				defaultTemplates: [
					'floorAdhesion',
					'hideOnViewability',
				],
				defaultSizes: [[728, 90]],
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
				isVideo: true,
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
		slotService.setState('hivi_leaderboard', false);
		slotService.setState('top_leaderboard', true);
		slotService.setState('top_boxad', isRightRailApplicable());
		slotService.setState('affiliate_slot', isAffiliateSlotApplicable());
		slotService.setState('incontent_boxad_1', isRightRailApplicable());
		slotService.setState('bottom_leaderboard', true);
		slotService.setState('invisible_skin', true);
		slotService.setState('floor_adhesion', isFloorAdhesionApplicable());
		slotService.setState('invisible_high_impact_2', isHighImpactApplicable());

		slotService.setState('featured', context.get('custom.hasFeaturedVideo'));

		if (!context.get('services.distroScale.enabled')) {
			slotService.setState('incontent_player', context.get('custom.hasIncontentPlayer'));
		}
	},

	setupIncontentPlayerForDistroScale() {
		const slotName = 'incontent_player';

		slotService.setState(slotName, false, AdSlot.STATUS_COLLAPSE);
		slotService.on(slotName, AdSlot.STATUS_COLLAPSE, () => {
			slotDataParamsUpdater.updateOnCreate(slotService.get(slotName));
			distroScale.call();
		});

		context.push('state.adStack', { id: slotName });
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

	setupSlotVideoAdUnit(adSlot, params) {
		const adProductInfo = getAdProductInfo(adSlot.getSlotName(), params.type, params.adProduct);
		const adUnit = utils.stringBuilder.build(
			context.get(`slots.${adSlot.getSlotName()}.videoAdUnit`) || context.get('vast.adUnitId'),
			{
				slotConfig: {
					group: adProductInfo.adGroup,
					adProduct: adProductInfo.adProduct,
				},
			},
		);

		context.set(`slots.${adSlot.getSlotName()}.videoAdUnit`, adUnit);
	},

	setupSizesAvailability() {
		if (window.innerWidth >= 1024) {
			context.set('slots.hivi_leaderboard.targeting.xna', '0');
			context.set('slots.top_leaderboard.targeting.xna', '0');
			context.set('slots.bottom_leaderboard.targeting.xna', '0');
		}
		context.set(`slots.incontent_boxad_1.targeting.xna`, context.get('custom.hasFeaturedVideo') ? '1' : '0');
	},

	setupTopLeaderboard() {
		if (context.get('custom.hiviLeaderboard')) {
			slotService.setState('hivi_leaderboard', true);
			context.set('slots.top_leaderboard.firstCall', false);
			context.push('state.adStack', { id: 'hivi_leaderboard' });

			slotService.on('hivi_leaderboard', AdSlot.STATUS_SUCCESS, () => {
				slotService.setState('top_leaderboard', false);
				context.push('state.adStack', { id: 'top_leaderboard' });
			});

			slotService.on('hivi_leaderboard', AdSlot.STATUS_COLLAPSE, () => {
				const adSlot = slotService.get('hivi_leaderboard');

				if (!adSlot.isEmpty) {
					slotService.setState('top_leaderboard', false);
				}
				context.push('state.adStack', { id: 'top_leaderboard' });
			});
		} else {
			context.push('state.adStack', { id: 'top_leaderboard' });
		}
	},

	injectBottomLeaderboard() {
		const slotName = 'bottom_leaderboard';
		const pushSlotAfterComments = throttle(() => {
			if (window.ArticleComments && !window.ArticleComments.initCompleted) {
				return;
			}

			if (btRec.isEnabled() && btRec.duplicateSlot(slotName)) {
				btRec.triggerScript();
			}

			document.removeEventListener('scroll', pushSlotAfterComments);
			context.push('events.pushOnScroll.ids', slotName);
		}, 250);

		document.addEventListener('scroll', pushSlotAfterComments);
	},

	injectIncontentPlayer() {
		const isDistroScaleEnabled = context.get('services.distroScale.enabled');
		const isApplicable = !context.get('custom.hasFeaturedVideo');
		const isInjected = !!slotInjector.inject('incontent_player', isDistroScaleEnabled);

		if (isDistroScaleEnabled && isApplicable && isInjected) {
			this.setupIncontentPlayerForDistroScale();
		}

		return isApplicable && isInjected;
	},

	async injectIncontentBoxad() {
		await communicationService.action$.pipe(ofType('[Rail] Ready'), take(1)).toPromise();

		const slotName = 'incontent_boxad_1';
		const isApplicable = isIncontentBoxadApplicable();
		const parentNode = document.getElementById('WikiaAdInContentPlaceHolder');
		const rotator = new FmrRotator(slotName, 'incontent_boxad_', btRec);

		if (!isApplicable || !parentNode) {
			slotService.setState(slotName, false);
			return;
		}

		const element = document.createElement('div');
		element.id = slotName;
		element.classList.add('wikia-ad');

		parentNode.appendChild(element);

		rotator.rotateSlot(slotName);
	},

	injectHighImpact() {
		context.push('state.adStack', { id: 'invisible_high_impact_2' });
	},

	injectFloorAdhesion() {
		scrollListener.addSlot(
			'floor_adhesion',
			{ distanceFromTop: utils.getViewportHeight() },
		);

		registerFloorAdhesionCodePriority();
	},

	injectAffiliateSlot() {
		slotInjector.inject('affiliate_slot', true);

		context.push('state.adStack', { id: 'affiliate_slot' });
	},
};
