if((typeof wgAdsInterstitialsEnabled != 'undefined') && wgAdsInterstitialsEnabled){
	const COOKIE_NAME = 'IntPgCounter';
	var count = $.cookies.get(COOKIE_NAME);
	count = ((!count)?1:count);

	var nextCount = parseInt(count) + 1;

	// TODO: Use these globals.
	//wgAdsInterstitialsPagesBeforeFirstAd
	//wgAdsInterstitialsPagesBetweenAds
	//wgAdsInterstitialsDurationInSeconds
	//wgAdsInterstitialsCampaignCode

	$.cookies.set(COOKIE_NAME, nextCount, {
		path: wgCookiePath,
		domain: wgCookieDomain
	});

	if((count % 2) == 0){
		$('#interstitial_foreground').css('display', 'block');
		$('#interstitial_background').css('display', 'block');
	}
}
