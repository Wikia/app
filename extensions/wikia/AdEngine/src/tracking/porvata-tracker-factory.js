import Context from 'ad-engine/src/services/context-service';

export function createTracker(legacyContext, geo, pageLevelParams, tracker) {
	return {
		isEnabled() {
			return legacyContext.get('opts.playerTracking');
		},

		onEvent(eventName, params, data) {
			const trackingData = Object.assign(data, {
				pv_unique_id: window.pvUID,
				pv_number: pageLevelParams.pv,
				country: geo.getCountryCode(),
				skin: pageLevelParams.skin,
				wsi: Context.get(`slots.${params.position}.targeting.wsi`) || '(none)'
			});

			tracker.trackDW(trackingData, 'adengplayerinfo');
		}
	};
}
