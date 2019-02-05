import { context, utils } from '@wikia/ad-engine';
import { recInjector } from './rec-injector';

const isDebug = utils.queryString.isUrlParamSet('bt-rec-debug');
const placementClass = 'bt-uid-tg';

let placementsMap = {};

/**
 * Duplicates slots before rec code execution
 * @param {string} slotName
 * @returns {Node|boolean}
 */
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

/**
 * Mark ad slots and injects BT rec code into DOM
 * @returns {void}
 */
function injectScript() {
	markAdSlots();

	if (!isDebug) {
		recInjector.inject('bt').then(() => {
			triggerScript();
		});
	}
}

/**
 * Mark ad slots as ready for rec operations
 * @returns {void}
 */
function markAdSlots() {
	Object
		.keys(placementsMap)
		.forEach((key) => {
			if (!placementsMap[key].lazy) {
				duplicateSlot(key);
			}
		});
}

/**
 * Force trigger of BT code
 * @returns {void}
 */
function triggerScript() {
	if (!isDebug && window && window.BT && window.BT.clearThrough) {
		window.BT.clearThrough();
	}
}

/**
 * Loads BT rec service
 */
export const btLoader = {
	duplicateSlot,

	/**
	 * Returns slot uid for given slot name
	 * @param {string} slotName
	 * @returns {string}
	 */
	getPlacementId(slotName) {
		return placementsMap[slotName].uid || '';
	},

	/**
	 * Adds BT rec service event listener on document
	 * @returns {void}
	 */
	init() {
		placementsMap = context.get('options.wad.btRec.placementsMap') || {};

		document.addEventListener('bab.blocking', injectScript);
	},

	triggerScript,
};
