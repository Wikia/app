import {context, scrollListener, slotTweaker, universalAdPackage, utils} from '@wikia/ad-engine';
import {navBarElement, navbarManager} from './navbar-updater';
import slots from '../slots';

const {
	CSS_CLASSNAME_STICKY_BFAA,
	CSS_TIMING_EASE_IN_CUBIC,
	SLIDE_OUT_TIME,
	CSS_CLASSNAME_THEME_RESOLVED
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
		'incontent_player',
		'invisible_high_impact_2',
		'floor_adhesion',
	],
	slotsToEnable: [
		'bottom_leaderboard',
		'incontent_boxad_1',
		'top_boxad',
	],

	onInit(adSlot, params) {
		this.adSlot = adSlot;
		this.slotParams = params;
		context.set('slots.bottom_leaderboard.viewportConflicts', []);
		context.set('slots.bottom_leaderboard.sizes', []);
		context.set('slots.bottom_leaderboard.defaultSizes', [[3, 3]]);
		slots.setupSlotVideoAdUnit(adSlot, params);

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
		navbarManager.setPinned(false);
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

	onResolvedStateSetCallback() {
		this.updateNavbar(); // when scrolling prevents jumping UAP
		requestAnimationFrame(() => this.updateNavbar()); // when idle, moves navbar to resolved UAP
	},

	updateNavbar() {
		const container = this.adSlot.getElement();
		const isSticky = container.classList.contains(CSS_CLASSNAME_STICKY_BFAA);
		const isInViewport = utils.isInViewport(container, { areaThreshold: 1 });
        const isResolved = container.classList.contains(CSS_CLASSNAME_THEME_RESOLVED);

		navbarManager.setPinned((isInViewport && !isSticky) || !isResolved);
		this.moveNavbar((isSticky && isResolved) ? container.offsetHeight : 0);
	},

	moveNavbar(offset) {
		if (navBarElement) {
			navBarElement.style.top = offset ? `${offset}px` : '';
		}
	}
});
