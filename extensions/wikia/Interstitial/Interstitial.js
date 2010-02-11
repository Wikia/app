if((typeof wgAdsInterstitialsEnabled != 'undefined') && wgAdsInterstitialsEnabled){
console.log("Int: The Interstitials Code is loded.");
	var COOKIE_NAME = 'IntPgCounter';
	var count = $.cookies.get(COOKIE_NAME);
	count = parseInt((!count)?1:count);

console.log("Int: count: " + count);
	// TODO: Don't increment this when we're on the actual interstitial page.
	count += 1;
console.log("Int: next: " + count);
	$.cookies.set(COOKIE_NAME, count, {
		path: wgCookiePath,
		domain: wgCookieDomain
	});

/*
	var html = "<div id='interstitial_fg' class='interstitial_fg'>" + 
	"			<div class='interstitial_fg_top color1'>" +
	"				<a href ='javascript:void(0)' class='wikia_button' onclick =\"" +
	"document.getElementById('interstitial_fg').style.display='none';document.getElementById('interstitial_bg').style.display='none'" +
	"\"><span>" + wgMsgInterstitialSkipAd + "</span></a>" +
	"			</div>" +
	"			<div class='interstitial_fg_body'>" +
	
// TODO: FIX THIS
	"				" + "TEST" + //wgAdsInterstitialsCampaignCode
	"			</div>" +
	"		</div>" +
	"			<div class='interstitial_bg_top color2'>" +
	"		<div id='interstitial_bg' class='interstitial_bg'>" +
	"				<div id='wikia_header'>" +
	"					<div class='monaco_shinkwrap'>" +
	"						<div id='wikiaBranding'>" +
	"							<div id='wikia_logo'>Wikia</div>" +
	"						</div>" +
	"					</div>" +
	"				</div>" +
	"			</div>" +
	"			<div id='background_strip' class='interstitial_bg_middle'>" +
	"				&nbsp;" +
	"			</div>" +
	"			<div class='color2 interstitial_bg_bottom'>" +
	"				&nbsp;" +
	"			</div>" +
	"		</div>";
*/
	if((wgAdsInterstitialsPagesBeforeFirstAd == count) || ((count > wgAdsInterstitialsPagesBeforeFirstAd) && ((count % (wgAdsInterstitialsPagesBetweenAds+1)) == 0))){
/*console.log("Int: Decided to display interstitial.");
console.log("Int: The campaign code looks like this:");
console.log(wgAdsInterstitialsCampaignCode);
		$('#interstitial_fg').css('border-color', $('#wikia_page').css('border-left-color'));
		$('#interstitial_fg').css('background-color', $('#wikia_page').css('background-color'));
		$('#interstitial_bg').css('height', $('html').css('height')); // make bg 100% of page, not just viewport.

		var adMillis = 1000 * wgAdsInterstitialsDurationInSeconds;
console.log("Int: Showing for " + adMillis + " milliseconds.");
		$('body').prepend(html);
		$('#interstitial_fg').show();
		$('#interstitial_bg').show();
		setTimeout(function(){
			$('#interstitial_fg').hide();
			$('#interstitial_bg').hide();
console.log("Int: Interstitial is done with its time... hiding.");
		}, adMillis);
*/

console.log("Int: Decided to display interstitial on next page.");
			// If it's about to be time for an interstitial, re-write all INTERNAL links to go through the Interstitial.
			$('a[href]').each(function(index, elem){
				if($(elem).attr('hostname') == location.hostname){
					var link = wgInterstitialPath + encodeURIComponent($(elem).attr('href'));
console.log("LINK: " + link);
					$(elem).attr('href', link);
				}
			});
        } else {
console.log("Int: Decided NOT to display interstitial on next page.");
        }
console.log("Int: Settings...");
console.log("Int: wgAdsInterstitialsPagesBeforeFirstAd: " + wgAdsInterstitialsPagesBeforeFirstAd);
console.log("Int: wgAdsInterstitialsPagesBetweenAds:    " + wgAdsInterstitialsPagesBetweenAds); 
console.log("Int: wgAdsInterstitialsDurationInSeconds: " + wgAdsInterstitialsDurationInSeconds);

}
