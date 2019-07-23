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

export default {
	register: () => {
		eventService.on(playerEvents.VIDEO_PLAYER_TRACKING_EVENT, trackEvent);

		porvataTracker.register();
	},
};
