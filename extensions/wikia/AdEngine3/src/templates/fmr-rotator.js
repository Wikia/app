import { context, scrollListener, slotService, utils } from '@wikia/ad-engine';

const refreshInfo = {
	adVisible: false,
	heightScrolledThreshold: 10,
	lastRefreshTime: new Date(),
	refreshAdPosition: 0,
	refreshDelay: 1000, //ToDo: 10000
	refreshNumber: 0,
	startPosition: 0
};

let currentSlotName = null;
let currentAdSlot = null;
let rotatorListener = null;
let recirculationElement = null;


function getNavbarHeight() {
	const navbar = document.getElementById('globalNavigation');

	return navbar ? navbar.offsetHeight : 0;
}

/*
 * Decision methods: decide whether FMR rotate conditions are met
 */
function enoughTimeSinceLastRefresh() {
	return ((new Date()) - refreshInfo.lastRefreshTime) > refreshInfo.refreshDelay;
}

function refreshLimitAvailable() {
	return refreshInfo.refreshNumber <= 20; //ToDo: context get
}

function userReachedStartPosition() {
	return refreshInfo.startPosition <= window.scrollY;
}

function userScrolledEnoughDistance() {
	return Math.abs(window.scrollY - refreshInfo.refreshAdPosition) > refreshInfo.heightScrolledThreshold;
}

function fanTakeoverLoaded() {
	return false;
	//var isAdVisible = refreshInfo.adVisible && refreshInfo.refreshNumber !== 0;
	//return adEngineBridge.universalAdPackage.isFanTakeoverLoaded() && isAdVisible;
}

function updateAdRefreshInformation() {
	refreshInfo.adVisible = !refreshInfo.adVisible;
	refreshInfo.lastRefreshTime = new Date();
	refreshInfo.refreshAdPosition = window.scrollY;
	refreshInfo.refreshNumber++;
}


function enableSlotRotation() {
	rotatorListener = scrollListener.addCallback(() => rotateSlots());
}

function rotateSlots() {
	if (
		enoughTimeSinceLastRefresh() &&
		refreshLimitAvailable() &&
		userScrolledEnoughDistance()
	) {
		if (refreshInfo.adVisible) {
			swapRecirculation(true);
		} else {
			swapRecirculation(false);
		}

		updateAdRefreshInformation();
	}
}

function showSlotWhenPossible() {
	console.log(refreshInfo, window.scrollY);

	if (enoughTimeSinceLastRefresh() && userReachedStartPosition()) {
		// ToDo remove
		console.log('load!!!');
		context.push('state.adStack', { id: currentSlotName });

		updateAdRefreshInformation();

		scrollListener.removeCallback(rotatorListener);
		rotatorListener = null;

		setTimeout(() => {
			if (!fanTakeoverLoaded()) {
				enableSlotRotation();
			}
		}, refreshInfo.refreshDelay);
	}






/*
fanTakeoverNotLoaded() &&
refreshLimitAvailable() &&
userScrolledEnoughDistance()
 */






	/*const slot = document.getElementById(slotName);

	console.log(utils.getTopOffset(slot), window.scrollY);

	if (utils.isInViewport(slot) && utils.getTopOffset(slot) <= 0) {
		setTimeout(() => {
			context.push('events.pushOnScroll.ids', slotName);
		}, 1000);
	}*/
}

function swapRecirculation(visible) {
	recirculationElement.style.display = visible ? 'block' : 'none';
}

export function rotateIncontentBoxad(slotName) {
	console.log('rotateIncontentBoxad');
	currentSlotName = slotName;
	currentAdSlot = document.getElementById(slotName);
	recirculationElement = document.getElementById('recirculation-rail');
	refreshInfo.startPosition = utils.getTopOffset(recirculationElement) - getNavbarHeight();
console.log(utils.getTopOffset(recirculationElement), getNavbarHeight());

	rotatorListener = scrollListener.addCallback(() => showSlotWhenPossible());


	/*
	currentAdSlot = slotService.get(slotName);
		scrollListener.removeCallback(rotatorListener);
		rotatorListener = null;
	 */





















	/*context.push('listeners.slot', {
		onStatusChanged: (slot) => {
			if (slot.getSlotName() === slotName && slot.getStatus() === 'success') {
				swapRecirculation(false);
			}
		}
	});*/
}
