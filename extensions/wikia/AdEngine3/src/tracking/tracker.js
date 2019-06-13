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
