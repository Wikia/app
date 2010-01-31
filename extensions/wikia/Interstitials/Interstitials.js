if((typeof wgAdsInterstitialsEnabled != 'undefined') && wgAdsInterstitialsEnabled){
	var COOKIE_NAME = 'IntPgCounter';
	var count = $.cookies.get(COOKIE_NAME);
	count = parseInt((!count)?1:count);

	$.cookies.set(COOKIE_NAME, (count + 1), {
		path: wgCookiePath,
		domain: wgCookieDomain
	});

	if((wgAdsInterstitialsPagesBeforeFirstAd == count) || ((count > wgAdsInterstitialsPagesBeforeFirstAd) && ((count % wgAdsInterstitialsPagesBetweenAds) == 0))){
		$('#interstitial_fg').css('border-color', $('#wikia_page').css('border-left-color'));
		$('#interstitial_fg').css('background-color', $('#wikia_page').css('background-color'));
		$('#interstitial_bg').css('height', $('html').css('height')); // make bg 100% of page, not just viewport.

		var adMillis = 1000 * wgAdsInterstitialsDurationInSeconds;
		$('#interstitial_fg').show();
		$('#interstitial_bg').show();
		setTimeout(function(){
			$('#interstitial_fg').hide();
			$('#interstitial_bg').hide();
		}, adMillis);
	}
}
