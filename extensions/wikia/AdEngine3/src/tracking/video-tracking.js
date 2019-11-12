import { eventService, porvataTracker, playerEvents } from '@wikia/ad-engine';
import { track } from './tracker';

function trackEvent(eventData) {
	track(Object.assign(
		{
			eventName: 'adengplayerinfo',
			trackingMethod: 'internal',
		},
		eventData,
	));
}

function trackVideoXClick(adSlot) {
	track({
		action: 'click',
		category: 'force_close',
		label: adSlot.getSlotName(),
		trackingMethod: 'analytics',
	});
}


export default {
	register: () => {
		eventService.on(playerEvents.VIDEO_PLAYER_TRACKING_EVENT, trackEvent);
		eventService.on(playerEvents.PLAYER_X_CLICK, trackVideoXClick);

		porvataTracker.register();
	},
};
