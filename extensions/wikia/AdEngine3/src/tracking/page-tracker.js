import { context } from '@wikia/ad-engine';
import { track } from './tracker';

/**
 * Wrapper for page info warehouse tracking
 */
export default {
	/**
	 * Checks whether tracker is enabled via instant global
	 * @returns {boolean}
	 */
	isEnabled() {
		return context.get('options.tracking.kikimora.slot');
	},

	/**
	 * Track page info prop values
	 * @param {String} name
	 * @param {String} value
	 * @returns {void}
	 */
	trackProp(name, value) {
		if (!this.isEnabled()) {
			return;
		}

		const now = new Date();
		track({
			eventName: 'adengpageinfo_props',
			trackingMethod: 'internal',
			prop_name: name,
			prop_value: value,
			timestamp: now.getTime(),
			tz_offset: now.getTimezoneOffset(),
		});
	},
};
