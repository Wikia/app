if((typeof wgAdsInterstitialsEnabled != 'undefined') && wgAdsInterstitialsEnabled){
console.log("Int: The Interstitials Code is loded.");
	var COOKIE_NAME = 'IntPgCounter';
	var count = $.cookies.get(COOKIE_NAME);
	count = parseInt((!count)?1:count);
	
console.log("Int: count: " + count);
	count += 1;
console.log("Int: next: " + count);
	$.cookies.set(COOKIE_NAME, count + '', {
		path: wgCookiePath,
		domain: wgCookieDomain
	});
console.log("Int: now set to: " + $.cookies.get(COOKIE_NAME) + " (should be same as 'next')");

	if((wgAdsInterstitialsPagesBeforeFirstAd == count - 1) || ((count > wgAdsInterstitialsPagesBeforeFirstAd) && (((count - wgAdsInterstitialsPagesBeforeFirstAd) % (wgAdsInterstitialsPagesBetweenAds+1)) == 0))){
console.log("Int: Decided to display interstitial on next page.");

			// If it's about to be time for an interstitial, re-write all INTERNAL links to go through the Interstitial.
			$('a[href]').each(function(index, elem){
				if($(elem).attr('hostname') == location.hostname){
					var link = wgInterstitialPath + encodeURIComponent($(elem).attr('href'));
//console.log("LINK: " + link);
					$(elem).attr('href', link);
				}
			});
        } else {
console.log("Int: Decided NOT to display interstitial on next page.");
        }
console.log("Int: Settings...");
console.log("Int: wgAdsInterstitialsPagesBeforeFirstAd: " + wgAdsInterstitialsPagesBeforeFirstAd);
console.log("Int: wgAdsInterstitialsPagesBetweenAds:    " + wgAdsInterstitialsPagesBetweenAds);

}
