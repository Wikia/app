(function() {
if(window.wgAdsInterstitialsEnabled) {
	var COOKIE_NAME = 'IntPgCounter';
	var count = $.cookies.get(COOKIE_NAME);
	count = parseInt((!count)?1:count);

	count += 1;
	$.cookies.set(COOKIE_NAME, count + '', {
		path: wgCookiePath,
		domain: wgCookieDomain
	});

	var numToSkip = 2; // skip the interstitial and the page it was blocking as candidates
	if((wgAdsInterstitialsPagesBeforeFirstAd == count - 1) || ((count > wgAdsInterstitialsPagesBeforeFirstAd) && (((count - wgAdsInterstitialsPagesBeforeFirstAd -1) % (wgAdsInterstitialsPagesBetweenAds + numToSkip)) == 0))){
		// If it's about to be time for an interstitial, re-write all INTERNAL links to go through the Interstitial.
		$('a[href]').each(function(index, elem){
			// Don't rewrite external links (or any other Exitstitials)
			if((!$(elem).hasClass('external')) && (!$(elem).hasClass('exitstitial'))){
				var link = wgInterstitialPath + encodeURIComponent($(elem).attr('href'));
				$(elem).attr('href', link);
			}
		});
	}
}
})();
