import { AdSlot, context, events, eventService, scrollListener, slotService, slotTweaker, utils, universalAdPackage } from '@wikia/ad-engine';
import { getNavbarHeight } from '../templates/navbar-updater';
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

let currentAdSlot = null;
let nextSlotName = null;
let rotatorListener = null;
let recirculationDisabled = false;
let recirculationElement = null;

/***********************
 * BT rec related logic
 ***********************/

/**
 * Duplicates ad slot and injects BT rec placement
 *
 * @param {function} [onSuccess]
 * @returns {void}
 */
function applyRec(onSuccess) {
	if (!btRec) {
		return;
	}

	if (recSelector === null) {
		recSelector = `div[id*="${btLoader.getPlacementId(nextSlotName)}"]`;
	}

	currentRecNode = btLoader.duplicateSlot(nextSlotName);

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
 * Checks if slot can be refreshed or limit is reached
 *
 * @returns {boolean}
 */
function isRefreshLimitAvailable() {
	return btRec || (currentAdSlot && (currentAdSlot.getConfigProperty('repeat.index') < 20));
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
function isInViewport() {
	const recirculationElementInViewport = utils.isInViewport(recirculationElement);
	const btRecNodeInViewport = btRec && currentRecNode && utils.isInViewport(currentRecNode);
	const adSlotInViewport = currentAdSlot && currentAdSlot.getElement() && utils.isInViewport(currentAdSlot.getElement());

	return recirculationElementInViewport || btRecNodeInViewport || adSlotInViewport;
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
function isStartPositionReached() {
	return refreshInfo.startPosition <= window.scrollY;
}

/**
 * Checks if user scrolled some distance before slot reload
 *
 * @returns {boolean}
 */
function isScrolledEnoughToRotate() {
	return Math.abs(window.scrollY - refreshInfo.refreshAdPosition) > refreshInfo.heightScrolledThreshold;
}

/*********************************
 * Watchers or exported functions
 *********************************/

/**
 * Rotates floating medrec based on given conditions
 *
 * @returns {void}
 */
function rotateSlots() {
	if (!isRefreshLimitAvailable()) {
		scrollListener.removeCallback(rotatorListener);
	} else if (enoughTimeSinceLastRefresh() && isScrolledEnoughToRotate() && isInViewport()) {
		if (refreshInfo.adVisible) {
			if (btRec) {
				removeRecNode();
			} else {
				slotTweaker.hide(currentAdSlot);
			}

			updateAdRefreshInformation();
			swapRecirculation(true);

			if (!recirculationDisabled) {
				return;
			}
		}

		scrollListener.removeCallback(rotatorListener);

		context.push('state.adStack', { id: nextSlotName });

		applyRec(slotStatusChanged);
	}
}

/**
 * Wait for conditions and inject first floating medrec
 *
 * @returns {void}
 */
function showSlotWhenPossible() {
	const isViewportAndNoRecirculation = recirculationDisabled && isInViewport();
	const isPositionAndTime = enoughTimeSinceLastRefresh() && isStartPositionReached();

	if (isViewportAndNoRecirculation || isPositionAndTime) {
		scrollListener.removeCallback(rotatorListener);

		context.push('state.adStack', { id: nextSlotName });

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
function slotStatusChanged(slotName = fmrPrefix, slotStatus = AdSlot.STATUS_SUCCESS) {
	if (slotName.substring(0, 16) === fmrPrefix) {
		if (universalAdPackage.isFanTakeoverLoaded()) {
			swapRecirculation(false);

			return;
		}
		if (!btRec) {
			currentAdSlot = slotService.get(nextSlotName);
			nextSlotName = fmrPrefix + (currentAdSlot.getConfigProperty('repeat.index') + 1);
		}

		updateAdRefreshInformation();

		if (slotStatus === AdSlot.STATUS_SUCCESS) {
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
	nextSlotName = slotName;
	recirculationDisabled = context.get('custom.isRecirculationDisabled');
	recirculationElement = document.getElementById('recirculation-rail');
	refreshInfo.startPosition = utils.getTopOffset(recirculationElement) - getNavbarHeight();
	btRec = babDetection.isBlocking() && recRunner.isEnabled('bt');

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
		slot.once(AdSlot.STATUS_SUCCESS, () => {
			slotStatusChanged(slot.getSlotName(), AdSlot.STATUS_SUCCESS);
		});
	});

	rotatorListener = scrollListener.addCallback(() => showSlotWhenPossible());
}
