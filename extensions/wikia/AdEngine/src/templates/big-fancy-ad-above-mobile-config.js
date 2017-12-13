import SlotTweaker from 'ad-engine/src/services/slot-tweaker';

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
	return {
		slotsToEnable: [
			'MOBILE_IN_CONTENT',
			'MOBILE_PREFOOTER',
			'MOBILE_BOTTOM_LEADERBOARD'
		],
		onInit(adSlot, params) {
			SlotTweaker.onReady(adSlot).then((iframe) => runOnReady(iframe, params, mercuryListener));
		}
	};
}
