import { events } from '@wikia/ad-engine';
import { porvataTracker } from '@wikia/ad-engine/dist/ad-products';
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
    events.on(events.VIDEO_PLAYER_TRACKING_EVENT, trackEvent);

    porvataTracker.register();
  },
};
