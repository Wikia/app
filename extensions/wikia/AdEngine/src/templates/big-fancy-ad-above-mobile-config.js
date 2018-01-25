import { context, slotTweaker } from '@wikia/ad-engine';

let adsModule;

function adjustPadding(iframe, aspectRatio) {
	var viewPortWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
		height = aspectRatio ? viewPortWidth / aspectRatio : iframe.contentWindow.document.body.offsetHeight;

	adsModule.setSiteHeadOffset(height);
}

function runOnReady(iframe, params, mercuryListener) {
	const onResize = (aspectRatio) => {
			adjustPadding(iframe, aspectRatio);
		},
		page = document.getElementsByClassName('application-wrapper')[0];

	adsModule = window.Mercury.Modules.Ads.getInstance();
	page.classList.add('bfaa-template');
	adjustPadding(iframe, params.aspectRatio);
	window.addEventListener('resize', onResize.bind(null, params.aspectRatio));

	if (mercuryListener) {
		mercuryListener.onPageChange(() => {
			page.classList.remove('bfaa-template');
			document.body.classList.remove('vuap-loaded');
			document.body.classList.remove('has-bfaa');
			document.body.style.paddingTop = '';
			adsModule.setSiteHeadOffset(0);
			window.removeEventListener('resize', onResize);
		});
	}
}

export function getConfig(mercuryListener) {
	let slotElement = null;
	let navbarElement = null;

	return {
		slotsToEnable: [
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER',
			'MOBILE_BOTTOM_LEADERBOARD'
		],
		onInit(adSlot, params) {
			context.set(`slots.${adSlot.getSlotName()}.options.isVideoMegaEnabled`, params.isVideoMegaEnabled);

			slotTweaker.onReady(adSlot).then((iframe) => runOnReady(iframe, params, mercuryListener));

			const wrapper = document.getElementsByClassName('mobile-top-leaderboard')[0];

			slotElement = adSlot.getElement();
			navbarElement = document.querySelector('.site-head-container .site-head');

			wrapper.style.opacity = '0';
			slotTweaker.onReady(adSlot).then((iframe) => {
				wrapper.style.opacity = '';
				runOnReady(iframe, params, mercuryListener);
			});
		},
		moveNavbar(offset) {
			const adsMobile = window.Mercury.Modules.Ads.getInstance();

			adsMobile.setSiteHeadOffset(offset || slotElement.clientHeight);
			navbarElement.style.top = offset ? `${offset}px` : '';
		}
	};
}
