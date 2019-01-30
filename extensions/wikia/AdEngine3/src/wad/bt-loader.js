import { utils } from '@wikia/ad-engine';

const wikiaApiController = 'AdEngine3ApiController';
const wikiaApiMethod = 'getRecCode';
const isDebug = utils.queryString.get('bt-rec-debug') === '1';
const placementClass = 'bt-uid-tg';
const placementsMap = {
		TOP_LEADERBOARD: {
			uid: '5b33d3584c-188',
			style: 'margin:10px 0; z-index:100;',
			size: {
				width: 728,
				height: 90
			},
			lazy: false
		},
		TOP_BOXAD: {
			uid: '5b2d1649b2-188',
			style: 'margin-bottom:10px; z-index:100;',
			size: {
				width: 300,
				height: 250
			},
			lazy: false
		},
		INCONTENT_BOXAD_1: {
			uid: '5bbe13967e-188',
			style: 'z-index:100;',
			size: {
				width: 300,
				height: 250
			},
			lazy: true
		},
		BOTTOM_LEADERBOARD: {
			uid: '5b8f13805d-188',
			style: 'margin-bottom:23px; z-index:100;',
			size: {
				width: 728,
				height: 90
			},
			lazy: true
		}
	};

function duplicateSlot(slotName) {
	const slot = document.getElementById(slotName);

	if (slot) {
		let node = document.createElement('span');

		node.classList.add(placementClass);
		node.dataset['uid'] = placementsMap[slotName].uid;
		node.dataset['style'] = placementsMap[slotName].style;

		if (isDebug) {
			node.style = placementsMap[slotName].style + ' width: ' + placementsMap[slotName].size.width + 'px; height: '
				+ placementsMap[slotName].size.height + 'px; background: #00D6D6; display: inline-block;';
		} else {
			node.style.display = 'none';
		}

		slot.parentNode.insertBefore(node, slot.previousSibling);

		return node;
	}

	return false;
}

function injectScript() {
	markAdSlots();

	const url = window.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod + '&type=bt';

	if (!isDebug) {
		utils.scriptLoader.loadScript(
			url,
			'text/javascript',
			false,
			document.head.lastChild,
		).then(() => {
			triggerScript();
		});
	}
}

function markAdSlots() {
	Object
		.keys(placementsMap)
		.forEach((key) => {
			if (!placementsMap[key].lazy) {
				duplicateSlot(key);
			}
		});
}

function triggerScript() {
	if (!isDebug && window && window.BT && window.BT.clearThrough) {
		window.BT.clearThrough();
	}
}

export const btLoader = {
	getPlacementId(slotName) {
		return placementsMap[slotName].uid || '';
	},

	init() {
		document.addEventListener('bab.blocking', injectScript);
	},
};
