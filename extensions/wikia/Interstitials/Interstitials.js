if((typeof wgAdsInterstitialsEnabled != 'undefined') && wgAdsInterstitialsEnabled){
	const COOKIE_NAME = 'IntPgCounter';
	var count = $.cookies.get(COOKIE_NAME);
	count = parseInt((!count)?1:count);

	$.cookies.set(COOKIE_NAME, (count + 1), {
		path: wgCookiePath,
		domain: wgCookieDomain
	});

	if((wgAdsInterstitialsPagesBeforeFirstAd == count) || ((count > wgAdsInterstitialsPagesBeforeFirstAd) && ((count % wgAdsInterstitialsPagesBetweenAds) == 0))){
		var adMillis = 1000 * wgAdsInterstitialsDurationInSeconds;
		$('#interstitial_foreground').show();
		$('#interstitial_background').show();
		setTimeout(function(){
			$('#interstitial_foreground').hide();
			$('#interstitial_background').hide();
		}, adMillis);
	}
}
