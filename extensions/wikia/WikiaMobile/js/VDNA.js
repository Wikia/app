/**
 * This module is intended to live throughout december
 * If this is meant to run longer, please refactor
 */

$(function () {
	'use strict';

	/**
	 * VDNA promotion enabled only on vdna.wikia.com (1066105)
	 */
	if (['1066105'].indexOf(window.wgCityId) !== -1) {
		// Code from VDNA
		setTimeout(
			function(){
				var e = function (e) {
					var t = '; ' + document.cookie;
					var n = t.split('; '+e+'=');
					if (n.length == 2)
						return n.pop().split(';').shift();
				};
				var t = document.createElement('script');
				var n = document.getElementsByTagName('script')[0];
				t.src = document.location.protocol + '//embedded.visualdna.com/wikia-marvel/scripts/youni.js?' + Math.floor((new Date).getTime()/36e5);
				t.async = true;
				t.type = 'text/javascript';
				n.parentNode.insertBefore(t,n);
				if (e('MarvelWikiaCampaign') !== '1') {
					var r = new Date;
					r.setTime(r.getTime()+30*24*60*60*1e3);
					var i = 'expires='+r.toUTCString();
					document.cookie = 'MarvelWikiaCampaign=1; ' + i;
					t.onload = function () {
						window.VDNATalk.talk('marvel-wiki_new')
					}
				}
			},
			1
		);

		var $marvelVDNAImage = $(
			'<div style="text-align: center"><a href="#"><img src="' +
			window.wgExtensionsPath +
			'/wikia/WikiaMobile/images/MarvelMobileAsset.png" alt="Marvel VDNA"></a></div>'
		).on('click', function() {
			window.VDNATalk.launch('marvel-wiki');
		});

		$('#wkMainCnt').prepend($marvelVDNAImage);
	}
});
