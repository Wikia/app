/*global define*/
define('ext.wikia.adEngine.lookup.prebid.priceParsingHelper', function () {
	'use strict';


	/**
	 * For given title, if contains string in form like:
	 * ve6749ic
	 * ve3150LB
	 * ve0321xx
	 * return its price in $ or null if invalid
	 *
	 * @param title
	 * @returns {number | null}
	 */
	function getPriceFromString(title) {
		var re = new RegExp('ve(\[0-9]{4})(xx|ic|lb)', 'i'),
			results = re.exec(title);

		return results && results[1] ? parseInt(results[1], 10) / 100 : null;
	}

	return {
		getPriceFromString: getPriceFromString
	};
});
