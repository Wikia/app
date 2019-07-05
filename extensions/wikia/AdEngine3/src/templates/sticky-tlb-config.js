import {context, scrollListener, slotService, slotTweaker, universalAdPackage, utils} from '@wikia/ad-engine';
import {navbarElement, navbarManager} from './navbar-updater';

const {
	CSS_CLASSNAME_STICKY_BFAA,
	CSS_TIMING_EASE_IN_CUBIC,
	SLIDE_OUT_TIME
} = universalAdPackage;

function getStickinessConfig() {
	if (context.get('options.unstickHiViLeaderboardAfterTimeout')) {
		return {
			stickyDefaultTime: context.get('options.unstickHiViLeaderboardTimeout'),
			stickyAdditionalTime: 0,
			stickyUntilSlotViewed: false,
		};
	}

	return {};
}

export const getConfig = () => ({
	...getStickinessConfig(),

	adSlot: null,
	slotParams: null,
	updateNavbarOnScroll: null,

	onInit(adSlot, params) {
		this.adSlot = adSlot;
		this.slotParams = params;

		const wrapper = document.getElementById('WikiaTopAds');

		this.adSlot.getElement().classList.add('gpt-ad');
		wrapper.style.opacity = '0';

		this.updateNavbarOnScroll = scrollListener.addCallback(() => this.updateNavbar());

		slotService.disable('incontent_player', 'hivi-collapse');

		return slotTweaker.onReady(adSlot).then(() => {
			wrapper.style.opacity = '';
			this.updateNavbar();
		});
	},

	onAfterStickBfaaCallback() {
		navbarManager.setPinned(false);
	},

	onBeforeUnstickBfaaCallback() {
		scrollListener.removeCallback(this.updateNavbarOnScroll);
		this.updateNavbarOnScroll = null;
		Object.assign(navbarElement.style, {
			transition: `top ${SLIDE_OUT_TIME}ms ${CSS_TIMING_EASE_IN_CUBIC}`,
			top: '0'
		});
	},

	onAfterUnstickBfaaCallback() {
		Object.assign(navbarElement.style, {
			transition: '',
			top: ''
		});

		this.updateNavbar();
		this.updateNavbarOnScroll = scrollListener.addCallback(() => this.updateNavbar());
	},

	updateNavbar() {
		const container = this.adSlot.getElement();
		const isSticky = container.classList.contains(CSS_CLASSNAME_STICKY_BFAA);
		const isInViewport = utils.isInViewport(container, { areaThreshold: 1 });

		navbarManager.setPinned(isInViewport && !isSticky);
		this.moveNavbar(isSticky ? container.offsetHeight : 0);
	},

	moveNavbar(offset) {
		if (navbarElement) {
			navbarElement.style.top = offset ? `${offset}px` : '';
		}
	}
});
