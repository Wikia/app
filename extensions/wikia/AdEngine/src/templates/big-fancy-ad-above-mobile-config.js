import SlotTweaker from 'ad-engine/src/services/slot-tweaker';

let adsModule;

function adjustPadding(iframe, aspectRatio) {
	var viewPortWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
		height = aspectRatio ? viewPortWidth / aspectRatio : iframe.contentWindow.document.body.offsetHeight;

	adsModule.setSiteHeadOffset(height);
}

function runOnReady(iframe, params) {
	const onResize = (aspectRatio) => {
		adjustPadding(iframe, aspectRatio);
	};

	adsModule = window.Mercury.Modules.Ads.getInstance();
	document.body.classList.add('bfaa-template');
	adjustPadding(iframe, params.aspectRatio);
	window.addEventListener('resize', onResize.bind(null, params.aspectRatio));

	//if (mercuryListener) {
	//	mercuryListener.onPageChange(function () {
	//		page.classList.remove('bfaa-template');
	//		page.style.paddingTop = '';
	//		adsModule.setSiteHeadOffset(0);
	//		win.removeEventListener('resize', onResize);
	//	});
	//}//
}

export function getConfig() {
	return {
		slotsToEnable: [
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER',
			'MOBILE_BOTTOM_LEADERBOARD'
		],
		onInit(adSlot, params) {
			SlotTweaker.onReady(adSlot).then((iframe) => runOnReady(iframe, params));
		}
	}
}