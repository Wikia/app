import { AdSlot, context, events, eventService, scrollListener, slotService, utils, universalAdPackage } from '@wikia/ad-engine';
import { getNavbarHeight } from '../templates/navbar-updater';
import { babDetection } from '../wad/bab-detection';
import { btLoader } from '../wad/bt-loader';
import { recRunner } from '../wad/rec-runner';

const fmrPrefix = 'incontent_boxad_';
const refreshInfo = {
	delayDisabled: false,
	recSlotViewed: 2000,
	refreshDelay: 10000,
	refreshLimit: 20,
	startPosition: 0,
};

let btRec = false;
let recSelector = null;
let currentRecNode = null;

let currentAdSlot = null;
let nextSlotName = null;
let rotatorListener = null;
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
 * Checks if slot can be refreshed or limit is reached
 *
 * @returns {boolean}
 */
function isRefreshLimitAvailable() {
	return btRec || (currentAdSlot && (currentAdSlot.getConfigProperty('repeat.index') < refreshInfo.refreshLimit));
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
 * Checks if user reached certain scroll position to enable FMR logic
 *
 * @returns {boolean}
 */
function isStartPositionReached() {
	return refreshInfo.startPosition <= window.scrollY;
}

/**
 * Execute some callback now or pin it to scroll and run once condition is met
 *
 * @param {function} condition
 * @param {function} callback
 * @returns {void}
 */
function runNowOrOnScroll(condition, callback) {
	if (condition()) {
		removeScrollListener();
		callback();
	} else if (!rotatorListener) {
		rotatorListener = scrollListener.addCallback(() => runNowOrOnScroll(condition, callback));
	}
}

/**
 * Shows or hides recirculation element
 *
 * @param {boolean} visible
 * @returns {void}
 */
function swapRecirculation(visible) {
	recirculationElement.style.display = visible ? 'block' : 'none';
}

/*********************************
 * Watchers or exported functions
 *********************************/

/**
 * Hides currently loaded slot and shows recirculation
 *
 * @returns {void}
 */
function hideSlot() {
	if (btRec) {
		removeRecNode();
	} else {
		currentAdSlot.hide();
	}

	swapRecirculation(true);
	scheduleNextSlotPush();
}

/**
 * Push next floating medrec to ads queue or applying rec
 *
 * @returns {void}
 */
function pushNextSlot() {
	context.push('state.adStack', { id: nextSlotName });

	applyRec(() => {
		slotStatusChanged(AdSlot.STATUS_SUCCESS);
		setTimeout(() => {
			hideSlot();
		}, refreshInfo.recSlotViewed + refreshInfo.refreshDelay);
	});
}

/**
 * If exists: remove current scroll listener
 *
 * @returns {void}
 */
function removeScrollListener() {
	if (rotatorListener) {
		scrollListener.removeCallback(rotatorListener);
		rotatorListener = null;
	}
}

/**
 * Wait some time and inject next floating medrec
 *
 * @returns {void}
 */
function scheduleNextSlotPush() {
	if (isRefreshLimitAvailable()) {
		setTimeout(() => {
			tryPushNextSlot();
		}, refreshInfo.refreshDelay);
	}
}

/**
 * Callback executed on ad slot or BT rec placement load
 *
 * @param {string} slotStatus
 * @returns {void}
 */
function slotStatusChanged(slotStatus) {
	if (universalAdPackage.isFanTakeoverLoaded()) {
		swapRecirculation(false);

		return;
	}

	if (!btRec) {
		currentAdSlot = slotService.get(nextSlotName);
		nextSlotName = fmrPrefix + (currentAdSlot.getConfigProperty('repeat.index') + 1);
	}

	if (slotStatus === AdSlot.STATUS_SUCCESS) {
		swapRecirculation(false);
	}
}

/**
 * Wait for conditions and inject first floating medrec
 *
 * @returns {void}
 */
function startFirstRotation() {
	runNowOrOnScroll(() => isInViewport() && isStartPositionReached(), pushNextSlot);
}

/**
 * Postpone slot push until recirculation will be in viewport
 *
 * @returns {void}
 */
function tryPushNextSlot() {
	runNowOrOnScroll(isInViewport, pushNextSlot);
}

/**
 * Enable floating medrec rotating logic
 *
 * @param {string} slotName
 * @returns {void}
 */
export function rotateIncontentBoxad(slotName) {
	nextSlotName = slotName;
	recirculationElement = document.getElementById('recirculation-rail');
	refreshInfo.startPosition = utils.getTopOffset(recirculationElement) - getNavbarHeight();
	refreshInfo.refreshDelay = context.get('custom.fmrRotatorDelay') || refreshInfo.refreshDelay;
	refreshInfo.delayDisabled = context.get('custom.fmrDelayDisabled');
	btRec = babDetection.isBlocking() && recRunner.isEnabled('bt');

	eventService.on(events.AD_SLOT_CREATED, (slot) => {
		if (slot.getSlotName().substring(0, 16) === fmrPrefix) {
			slot.once(AdSlot.STATUS_SUCCESS, () => {
				slotStatusChanged(AdSlot.STATUS_SUCCESS);

				slot.once(AdSlot.SLOT_VIEWED_EVENT, () => {
					if (refreshInfo.delayDisabled) {
						rotatorListener = scrollListener.addCallback(() => {
							removeScrollListener();
							hideSlot();
						});

						return;
					}

					setTimeout(() => {
						hideSlot();
					}, refreshInfo.refreshDelay);
				});
			});

			slot.once(AdSlot.STATUS_COLLAPSE, () => {
				slotStatusChanged(AdSlot.STATUS_COLLAPSE);
				scheduleNextSlotPush();
			});
		}
	});

	setTimeout(() => {
		startFirstRotation();
	}, refreshInfo.refreshDelay);
}
