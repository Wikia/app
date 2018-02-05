import { context, slotTweaker } from '@wikia/ad-engine';
import { universalAdPackage, animateUAPSlot } from '@wikia/ad-products';

const {
	CSS_CLASSNAME_FADE_IN_ANIMATION,
	CSS_CLASSNAME_SLIDE_OUT_ANIMATION,
	CSS_CLASSNAME_STICKY_BFAA,
	CSS_TIMING_EASE_IN_CUBIC
} = universalAdPackage;

export const getConfig = mercuryListener => ({
	adsModule: null,
	adSlot: null,
	slotParams: null,
	navbarElement: null,
	slotsToEnable: [
		'MOBILE_IN_CONTENT',
		'MOBILE_PREFOOTER',
		'MOBILE_BOTTOM_LEADERBOARD'
	],

	adjustPadding(iframe, { aspectRatio }) {
		const viewPortWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		const height = aspectRatio ? viewPortWidth / aspectRatio : iframe.contentWindow.document.body.offsetHeight;

		this.adsModule.setSiteHeadOffset(height);
	},

	onReady(iframe) {
		const onResize = () => {
			adjustPadding(iframe, this.params);
		};
		const page = document.querySelector('.application-wrapper');

		page.classList.add('bfaa-template');
		this.adjustPadding(iframe, this.slotParams);
		window.addEventListener('resize', onResize);

		if (this.mercuryListener) {
			this.mercuryListener.onPageChange(() => {
				page.classList.remove('bfaa-template');
				document.body.classList.remove('vuap-loaded');
				document.body.classList.remove('has-bfaa');
				document.body.style.paddingTop = '';
				this.adsModule.setSiteHeadOffset(0);
				window.removeEventListener('resize', onResize);
			});
		}
	},

	onInit(adSlot, params) {
		this.adSlot = adSlot;
		this.slotParams = slotParams;
		this.adsModule = window.Mercury.Modules.Ads.getInstance();
		this.navbarElement = document.querySelector('.site-head-container .site-head');

		const wrapper = document.querySelector('.mobile-top-leaderboard');

		context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);
		wrapper.style.opacity = '0';
		slotTweaker.onReady(adSlot).then((iframe) => {
			wrapper.style.opacity = '';
			this.runOnReady(iframe);
		});

		if (this.adsModule.hideSmartBanner) {
			this.adsModule.hideSmartBanner();
		}
	},

	onUnstickBfaaCallback(adSlot) {
		const slideOutDuration = 600;

		Object.assign(this.navbarElement.style, {
			transition: `top ${slideOutDuration}ms ${CSS_TIMING_EASE_IN_CUBIC}`,
			top: '0'
		});
		animateUAPSlot(adSlot, CSS_CLASSNAME_SLIDE_OUT_ANIMATION, slideOutDuration).then(() => {
			Object.assign(this.navbarElement.style, {
				transition: '',
				top: ''
			});
			adSlot.getElement().classList.remove(CSS_CLASSNAME_STICKY_BFAA);

			return animateUAPSlot(adSlot, CSS_CLASSNAME_FADE_IN_ANIMATION, 400);
		});
	},

	moveNavbar(offset) {
		this.adsMobile.setSiteHeadOffset(offset || slotElement.clientHeight);
		this.navbarElement.style.top = offset ? `${offset}px` : '';
	}
});
