/*global define*/
define('ext.wikia.adEngine.tracking.pageInfoTracker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.tracking.pageInfoTracker';

	function track(event, data) {
		log(['logPageInfo', data], log.levels.debug, logGroup);
		adTracker.trackDW(data, event);
	}

	function trackProp(name, value) {
		if (!adContext.get('opts.enableAdInfoLog')) {
			return;
		}

		track('adengpageinfo_props', {
			'pv_unique_id': win.pvUID,
			'prop_name': name,
			'prop_value': value,
			'timestamp': (new Date()).getTime(),
			'tzOffset': (new Date().getTimezoneOffset())
		});
	}

	return {
		trackProp: trackProp
	};
});
