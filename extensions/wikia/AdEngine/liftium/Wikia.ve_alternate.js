/*
 * Special callback function for hopping. Originally implemented for VideoEgg.
 * http://developer.videoegg.com/mediawiki/index.php/VideoEgg_Ad_Platform_Integration_Guide_-_Website#Step_6._.28Optional_But_Highly_Recommended.29_Specify_an_alternate_behavior_when_no_ad_is_available
 * Your function will be called when no ad is available with a single argument containing the DOM div object where the ad would normally appear. This allows you to collapse the div or fill it with alternate content. For example, you could collapse the ad unit div and dynamically fill another div at another location on your page: function myNoAdCallback(div) { div.style.display = "none"; insertMyAd(); } var ve_alternate = myNoAdCallback;
 */
window.ve_alternate = (function(Athena) {
	'use strict';
	return function(div) {
		div.style.display = "none";
		Athena.hop();
	};
}(window.Athena));
