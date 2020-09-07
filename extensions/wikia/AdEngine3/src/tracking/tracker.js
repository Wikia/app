import {
	bidderTracker,
	bidderTrackingMiddleware,

	GAMOrigins,

	slotBiddersTrackingMiddleware,
	slotBillTheLizardStatusTrackingMiddleware,
	slotPropertiesTrackingMiddleware,
	slotTracker,
	slotTrackingMiddleware,

	viewabilityPropertiesTrackingMiddleware,
	viewabilityTracker,
	viewabilityTrackingMiddleware,

	PostmessageTracker,
	TrackingTarget,
	trackingPayloadValidationMiddleware,
} from '@wikia/ad-engine';

export const track = (data) => {
	window.Wikia.Tracker.track(data);
};

export const registerSlotTracker = () => {
	slotTracker.onChangeStatusToTrack.push('catlapsed');
	slotTracker
		.add(slotTrackingMiddleware)
		.add(slotPropertiesTrackingMiddleware)
		.add(slotBiddersTrackingMiddleware)
		.add(slotBillTheLizardStatusTrackingMiddleware)
		.register(({ data }) => track({
			...data,
			eventName: 'adengadinfo',
			trackingMethod: 'internal',
		}));
};

export const registerViewabilityTracker = () => {
	viewabilityTracker
		.add(viewabilityTrackingMiddleware)
		.add(viewabilityPropertiesTrackingMiddleware)
		.register(({ data }) => track({
			...data,
			eventName: 'adengviewability',
			trackingMethod: 'internal',
		}));
};

export const registerBidderTracker = () => {
	bidderTracker
		.add(bidderTrackingMiddleware)
		.register(({ data }) => track({
			...data,
			eventName: 'adengbidders',
			trackingMethod: 'internal',
		}));
};

export const registerPostmessageTrackingTracker = () => {
	const postmessageTracker = new PostmessageTracker(
		['payload', 'target'],
	);

	postmessageTracker
		.add(trackingPayloadValidationMiddleware)
		.register(
			(message) => {
				const { target, payload } = message;

				switch (target){
					case TrackingTarget.GoogleAnalytics: {
						const { category, action, label, value } = payload;

						window.guaTrackEvent(category, action, label, value || 0);
						break;
					}
					case TrackingTarget.DataWarehouse:
						track({
							...payload,
							eventName: 'trackingevent',
							trackingMethod: 'internal',
						});
						break;
					default:
						break;
				}
			},
			[window.origin, ...GAMOrigins],
		);
};
