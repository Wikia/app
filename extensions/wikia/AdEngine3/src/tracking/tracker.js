import {
	slotBiddersTrackingMiddleware,
	slotBillTheLizardStatusTrackingMiddleware,
	slotPropertiesTrackingMiddleware,
	slotTracker,
	slotTrackingMiddleware,

	viewabilityPropertiesTrackingMiddleware,
	viewabilityTracker,
	viewabilityTrackingMiddleware,
} from '@wikia/ad-engine';

export const track = (data) => {
	window.Wikia.Tracker.track(data);
};

export const registerSlotTracker = () => {
	slotTracker
		.addMiddleware(slotTrackingMiddleware)
		.addMiddleware(slotPropertiesTrackingMiddleware)
		.addMiddleware(slotBiddersTrackingMiddleware)
		.addMiddleware(slotBillTheLizardStatusTrackingMiddleware)
		.register((data) => track({
			...data,
			eventName: 'adengadinfo',
			trackingMethod: 'internal',
		}));
};

export const registerViewabilityTracker = () => {
	viewabilityTracker
		.addMiddleware(viewabilityTrackingMiddleware)
		.addMiddleware(viewabilityPropertiesTrackingMiddleware)
		.register((data) => track({
			...data,
			eventName: 'adengviewability',
			trackingMethod: 'internal',
		}));
};
