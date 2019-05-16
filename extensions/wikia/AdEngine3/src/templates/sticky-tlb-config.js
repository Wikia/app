import { universalAdPackage } from '@wikia/ad-engine/dist/ad-products';
import { scrollListener, slotService, slotTweaker } from '@wikia/ad-engine';
import { pinNavbar, navBarElement, isElementInViewport } from './navbar-updater';

const {
	CSS_CLASSNAME_STICKY_BFAA,
	CSS_TIMING_EASE_IN_CUBIC,
	SLIDE_OUT_TIME
} = universalAdPackage;

export const getConfig = () => ({
	adSlot: null,
	slotParams: null,
	updateNavbarOnScroll: null,

	onInit(adSlot, params) {
		this.adSlot = adSlot;
		this.slotParams = params;

		const wrapper = document.getElementById('WikiaTopAds');

		this.adSlot.getElement().classList.add('gpt-ad');
		wrapper.style.opacity = '0';
		slotTweaker.onReady(adSlot).then(() => {
			debugger;
			wrapper.style.opacity = ''; // this does appear
			this.updateNavbar();
		});

		this.updateNavbarOnScroll = scrollListener.addCallback(() => this.updateNavbar());

		slotService.disable('incontent_player', 'hivi-collapse');
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
