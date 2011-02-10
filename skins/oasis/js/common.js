/**
 * Get all Oasis's ads as jQuery collection (and cache the results)
 *
 * @author macbre
 */
jQuery.getAds = function() {
	if (!jQuery.adsNodes) {
		jQuery.adsNodes = $("[id$='TOP_LEADERBOARD'], [id$='TOP_RIGHT_BOXAD'], .wikia-ad").children();
	}

	return jQuery.adsNodes;
};

/**
 * "Safely" hide all ads
 *
 * @author macbre
 * @author Hyun Lim
 */
jQuery.hideAds = function() {
	jQuery.getAds().css('margin-left', '-9999px');
}

/**
 * Show hidden ads
 *
 * @author macbre
 * @author Hyun Lim
 */
jQuery.showAds = function() {
	jQuery.getAds().css('margin-left', 'auto');
}