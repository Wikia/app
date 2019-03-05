import { context, scrollListener, slotService, slotTweaker, utils } from '@wikia/ad-engine';
import { universalAdPackage } from '@wikia/ad-engine/dist/ad-products';
import { babDetection } from '../wad/bab-detection';
import { btLoader } from '../wad/bt-loader';
import { recRunner } from '../wad/rec-runner';

const fmrPrefix = 'incontent_boxad_';
const refreshInfo = {
	adVisible: false,
	heightScrolledThreshold: 10,
	lastRefreshTime: new Date(),
	refreshAdPosition: 0,
	refreshDelay: 10000,
	startPosition: 0
};

let btRec = false;
let recSelector = null;
let currentRecNode = null;

let currentSlotName = null;
let currentAdSlot = null;
let rotatorListener = null;
let recirculationElement = null;

/***********************
 * BT rec related logic
 ***********************/

/**
 * Duplicates ad slot and injects BT rec placement
 *
 * @param {function} onSuccess
 * @returns {void}
 */
function applyRec(onSuccess) {
	if (!btRec) {
		return;
	}

	if (recSelector === null) {
		recSelector = 'div[id*="' + btLoader.getPlacementId(`${fmrPrefix}1`) + '"]';
	}

	currentRecNode = btLoader.duplicateSlot(`${fmrPrefix}1`);

	if (currentRecNode) {
		btLoader.triggerScript();
	}

	if (onSuccess) {
		onSuccess();
	}

	currentRecNode = document.querySelector(recSelector) || currentRecNode;
}

/**
 * Removes BT rec node from DOM
 *
 * @returns {void}
 */
function removeRecNode() {
	const recNode = document.querySelector(recSelector) || currentRecNode;

	if (recNode) {
		recNode.style.display = 'none';
		recNode.remove();
	}
}

/****************************************
 * Helpers and condition check functions
 ****************************************/

/**
 * Checks if minimum refresh time counter is over
 *
 * @returns {boolean}
 */
function enoughTimeSinceLastRefresh() {
	return ((new Date()) - refreshInfo.lastRefreshTime) > refreshInfo.refreshDelay;
}

/**
 * Checks UAP is loaded to disable FRM logic in this case
 *
 * @returns {boolean}
 */
function fanTakeoverLoaded() {
	return universalAdPackage.isFanTakeoverLoaded();
}

/**
 * Checks and returns page navigation bar height
 *
 * @returns {int}
 */
function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	return navbar ? navbar.offsetHeight : 0;
}

/**
 * Checks if slot can be refreshed or limit is reached
 *
 * @returns {boolean}
 */
function refreshLimitAvailable() {
	const limitAvailable = btRec || (currentAdSlot && (currentAdSlot.getConfigProperty('repeat.index') < 20));

	if (!limitAvailable) {
		scrollListener.removeCallback(rotatorListener);
	}

	return limitAvailable;
}

/**
 * Shows or hides recirculation element
 *
 * @param {boolean} visible
 * @returns {void}
 */
function swapRecirculation(visible) {
	recirculationElement.style.display = visible ? 'block' : 'none';
	refreshInfo.adVisible = !visible;
}

/**
 * Checks if user is in the right position to rotate FMR
 *
 * @returns {boolean}
 */
function userInRightPosition() {
	return utils.isInViewport(recirculationElement) || (btRec && currentRecNode && utils.isInViewport(currentRecNode))
		|| (currentAdSlot && currentAdSlot.getElement() && utils.isInViewport(currentAdSlot.getElement()));
}

/**
 * Update module refresh information after rotation
 *
 * @returns {void}
 */
function updateAdRefreshInformation() {
	refreshInfo.lastRefreshTime = new Date();
	refreshInfo.refreshAdPosition = window.scrollY;
}

/**
 * Checks if user reached certain scroll position to enable FMR logic
 *
 * @returns {boolean}
 */
function userReachedStartPosition() {
	return refreshInfo.startPosition <= window.scrollY;
}

/**
 * Checks if user scrolled some distance before slot reload
 *
 * @returns {boolean}
 */
function userScrolledEnoughDistance() {
	return Math.abs(window.scrollY - refreshInfo.refreshAdPosition) > refreshInfo.heightScrolledThreshold;
}

/**********************************
 * Watchers and exported functions
 **********************************/

/**
 * Rotates floating medrec based on given conditions
 *
 * @returns {void}
 */
function rotateSlots() {
	if (enoughTimeSinceLastRefresh() && refreshLimitAvailable() && userScrolledEnoughDistance() && userInRightPosition()) {
		if (refreshInfo.adVisible) {
			if (btRec) {
				removeRecNode();
			} else {
				slotTweaker.hide(currentAdSlot);
			}

			updateAdRefreshInformation();
			swapRecirculation(true);
		} else {
			scrollListener.removeCallback(rotatorListener);

			context.push('state.adStack', { id: currentSlotName });

			applyRec(slotStatusChanged);
		}
	}
}

/**
 * Wait for conditions and inject first floating medrec
 *
 * @returns {void}
 */
function showSlotWhenPossible() {
	if (enoughTimeSinceLastRefresh() && userReachedStartPosition()) {
		scrollListener.removeCallback(rotatorListener);

		context.push('state.adStack', { id: currentSlotName });

		applyRec(slotStatusChanged);
	}
}

/**
 * Callback executed on ad slot or BT rec placement load
 *
 * @param {string} slotName
 * @param {string} slotStatus
 * @returns {void}
 */
function slotStatusChanged(slotName = fmrPrefix, slotStatus = 'success') {
	if (!fanTakeoverLoaded() && slotName.substring(0, 16) === fmrPrefix) {
		if (!btRec) {
			currentAdSlot = slotService.get(currentSlotName);
			currentSlotName = fmrPrefix + (currentAdSlot.getConfigProperty('repeat.index') + 1);
		}

		updateAdRefreshInformation();

		if (slotStatus === 'success') {
			swapRecirculation(false);
		}

		rotatorListener = scrollListener.addCallback(() => rotateSlots());
	}
}

/**
 * Enable floating medrec rotating logic
 *
 * @param {string} slotName
 * @returns {void}
 */
export function rotateIncontentBoxad(slotName) {
	currentSlotName = slotName;
	recirculationElement = document.getElementById('recirculation-rail');
	refreshInfo.startPosition = utils.getTopOffset(recirculationElement) - getNavbarHeight();
	btRec = babDetection.isBlocking() && recRunner.isEnabled('bt');

	context.push('listeners.slot', {
		onStatusChanged: (slot) => {
			slotStatusChanged(slot.getSlotName(), slot.getStatus());
		}
	});

	rotatorListener = scrollListener.addCallback(() => showSlotWhenPossible());
}
