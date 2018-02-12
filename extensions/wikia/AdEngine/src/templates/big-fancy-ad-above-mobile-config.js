import { context, slotTweaker } from '@wikia/ad-engine';
import { universalAdPackage } from '@wikia/ad-products';

const {
	CSS_TIMING_EASE_IN_CUBIC,
	SLIDE_OUT_TIME
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
			this.onReady(iframe);
		});

		if (this.adsModule.hideSmartBanner) {
			this.adsModule.hideSmartBanner();
		}
	},

	onBeforeUnstickBfaaCallback() {
		Object.assign(this.navbarElement.style, {
			transition: `top ${SLIDE_OUT_TIME}ms ${CSS_TIMING_EASE_IN_CUBIC}`,
			top: '0'
		});
	},

	onAfterUnstickBfaaCallback() {
		Object.assign(this.navBarElement.style, {
			transition: '',
			top: ''
		});
	},

	moveNavbar(offset) {
		this.adsMobile.setSiteHeadOffset(offset || slotElement.clientHeight);
		this.navbarElement.style.top = offset ? `${offset}px` : '';
	}
});
