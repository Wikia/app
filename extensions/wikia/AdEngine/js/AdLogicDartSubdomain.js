var AdLogicDartSubdomain = function (Geo) {
	'use strict';

	function getSubdomain() {
		switch (Geo.getContinentCode()) {
		case 'AF':
		case 'EU':
			return 'ad-emea';
		case 'AS':
			switch (Geo.getCountryCode()) {
			// Middle East
			case 'AE':
			case 'CY':
			case 'BH':
			case 'IL':
			case 'IQ':
			case 'IR':
			case 'JO':
			case 'KW':
			case 'LB':
			case 'OM':
			case 'PS':
			case 'QA':
			case 'SA':
			case 'SY':
			case 'TR':
			case 'YE':
				return 'ad-emea';
			default:
				return 'ad-apac';
			}
		case 'OC':
			return 'ad-apac';
		default: // NA, SA
			return 'ad';
		}
	}

	return {
		getSubdomain: getSubdomain
	};
};

(function (context) {
	'use strict';
	if (context.define && context.define.amd) {
		context.define('ext.wikia.adengine.adlogic.subdomain', ['wikia.geo'], context.AdLogicDartSubdomain);
	}
}(this));
