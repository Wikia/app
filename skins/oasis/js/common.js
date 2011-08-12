/**
 * "Safely" hide all ads
 *
 * @author macbre
 * @author Hyun Lim
 * @author wlee
 */
jQuery.hideAds = function() {
	var slots = { 'CORP_TOP_LEADERBOARD': 1, 'CORP_TOP_RIGHT_BOXAD': 1, 'HOME_TOP_LEADERBOARD': 1, 'HOME_TOP_RIGHT_BOXAD': 1, 'HOME_TOP_RIGHT_BUTTON': 1, 'TEST_HOME_TOP_RIGHT_BOXAD': 1, 'TEST_TOP_RIGHT_BOXAD': 1, 'TOP_BUTTON': 1, 'TOP_LEADERBOARD': 1, 'TOP_RIGHT_BOXAD': 1, 'TOP_RIGHT_BUTTON': 1 }
	var tags = { 'div': 1, 'iframe': 1, 'img': 1 }
	var styleContent = '';
	for (var i in slots) {
		for (var j in tags) {
			styleContent += ' #' + i + ' ' + j + ',';
		}
	}
	styleContent = styleContent.substr(0, styleContent.length-1); // remove trailing ','

	$('<style type="text/css" class="wikia-ad-hidden">' + styleContent + ' { margin-left:-9999px; } </style>').appendTo('head');
}

/**
 * Show hidden ads
 *
 * @author macbre
 * @author Hyun Lim
 * @author wlee
 */
jQuery.showAds = function() {
	$('head .wikia-ad-hidden').remove();
}
