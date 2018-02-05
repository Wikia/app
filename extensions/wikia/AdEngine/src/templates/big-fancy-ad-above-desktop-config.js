import { universalAdPackage, animateUAPSlot } from '@wikia/ad-products';
import { context, scrollListener, slotTweaker } from '@wikia/ad-engine';
import autobind from 'core-decorators/es/autobind';
import { pinNavbar, navBarElement, navBarStickClass, isElementInViewport } from './navbar-updater';

const {
	CSS_CLASSNAME_FADE_IN_ANIMATION,
	CSS_CLASSNAME_SLIDE_OUT_ANIMATION,
	CSS_CLASSNAME_STICKY_BFAA,
	CSS_TIMING_EASE_IN_CUBIC
} = universalAdPackage;

export const getConfig = () => ({
	adSlot: null,
	slotParams: null,
	updateNavbarOnScroll: null,

	slotsToEnable: [
		'BOTTOM_LEADERBOARD',
		'INCONTENT_BOXAD_1'
	],

	onInit(adSlot, params) {
		this.adSlot = adSlot;
		this.slotParams = params;
		context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);

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

	onStickBfaaCallback(adSlot) {
		adSlot.getElement().classList.add(CSS_CLASSNAME_STICKY_BFAA);
		pinNavbar(false);
	},

	onUnstickBfaaCallback(adSlot) {
		const slideOutDuration = 600;

		scrollListener.removeCallback(this.updateNavbarOnScroll);
		this.updateNavbarOnScroll = null;
		Object.assign(navBarElement.style, {
			transition: `top ${slideOutDuration}ms ${CSS_TIMING_EASE_IN_CUBIC}`,
			top: '0'
		});
		animateUAPSlot(adSlot, CSS_CLASSNAME_SLIDE_OUT_ANIMATION, slideOutDuration).then(() => {
			Object.assign(navBarElement.style, {
				transition: '',
				top: ''
			});
			adSlot.getElement().classList.remove(CSS_CLASSNAME_STICKY_BFAA);
			this.updateNavbar();

			return animateUAPSlot(adSlot, CSS_CLASSNAME_FADE_IN_ANIMATION, 400);
		}).then(() => {
			this.updateNavbarOnScroll = scrollListener.addCallback(() => this.updateNavbar());
		});
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
