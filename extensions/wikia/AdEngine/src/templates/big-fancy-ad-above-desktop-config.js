import { universalAdPackage } from '@wikia/ad-engine/dist/ad-products';
import { context, scrollListener, slotTweaker, utils } from '@wikia/ad-engine';
import { pinNavbar, navBarElement, isElementInViewport } from './navbar-updater';

const {
	CSS_CLASSNAME_STICKY_BFAA,
	CSS_TIMING_EASE_IN_CUBIC,
	SLIDE_OUT_TIME
} = universalAdPackage;

export const getConfig = () => ({
	autoPlayAllowed: true,
	defaultStateAllowed: true,
	fullscreenAllowed: true,
	stickinessAllowed: true,
	adSlot: null,
	slotParams: null,
	updateNavbarOnScroll: null,
	slotsToDisable: [
		'INVISIBLE_HIGH_IMPACT_2',
	],
	slotsToEnable: [
		'BOTTOM_LEADERBOARD',
		'INCONTENT_BOXAD_1',
		'TOP_BOXAD'
	],

	onInit(adSlot, params) {
		this.adSlot = adSlot;
		this.slotParams = params;
		context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);
		context.set('slots.BOTTOM_LEADERBOARD.viewportConflicts', []);

		const spotlightFooter = document.getElementById('SPOTLIGHT_FOOTER');
		const wrapper = document.getElementById('WikiaTopAds');

		wrapper.style.opacity = '0';
		slotTweaker.onReady(adSlot).then(() => {
			wrapper.style.opacity = '';
			this.updateNavbar();
		});

		this.updateNavbarOnScroll = scrollListener.addCallback(() => this.updateNavbar());

		if (!window.ads.runtime.disableCommunitySkinOverride) {
			document.body.classList.add('uap-skin');
		}

		if (spotlightFooter) {
			spotlightFooter.parentNode.style.display = 'none';
		}
	},

	onAfterStickBfaaCallback() {
		pinNavbar(false);
	},

	onBeforeUnstickBfaaCallback() {
		scrollListener.removeCallback(this.updateNavbarOnScroll);
		this.updateNavbarOnScroll = null;
		Object.assign(navBarElement.style, {
			transition: `top ${SLIDE_OUT_TIME}ms ${CSS_TIMING_EASE_IN_CUBIC}`,
			top: '0'
		});
	},

	onAfterUnstickBfaaCallback() {
		Object.assign(navBarElement.style, {
			transition: '',
			top: ''
		});

		this.updateNavbar();
		this.updateNavbarOnScroll = scrollListener.addCallback(() => this.updateNavbar());
	},

	updateNavbar() {
		const container = this.adSlot.getElement();
		const isSticky = container.classList.contains(CSS_CLASSNAME_STICKY_BFAA);
		const isInViewport = isElementInViewport(this.adSlot, this.slotParams);

		pinNavbar(isInViewport && !isSticky);
		this.moveNavbar(isSticky ? container.offsetHeight : 0);
	},

	moveNavbar(offset) {
		if (navBarElement) {
			navBarElement.style.top = offset ? `${offset}px` : '';
		}
	}
});
