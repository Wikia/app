$(function() {
	var sponsormsg = $("div.sponsormsg > ul");
	if(typeof(wgAdSS_pageAds) !== 'undefined') {
		$.each( wgAdSS_pageAds, function(i,v) {
			sponsormsg.append(v);
		});
	}
	if(typeof(wgAdSS_selfAd) !== 'undefined') {
		$(wgAdSS_selfAd).appendTo(sponsormsg).click(
			function() {
				$.tracker.byStr( "adss/publisher/click/0" );
			}
		);
	}
	$.getJSON(wgScript, {'action':'ajax', 'rs':'AdSS_Publisher::getSiteAdsAjax'},
		function(response) {
			var rand_no = Math.random() * Math.max(response.length, 4);
			rand_no = Math.floor(rand_no+1);
			if(response.length >= rand_no) {
				var adId = response[rand_no-1].id;
				$(response[rand_no-1].html).insertBefore( sponsormsg.find("li").last() ).bind( "click", {adId: adId},
					function(event) {
						$.tracker.byStr( "adss/publisher/click/"+event.data.adId );
					}
				);
				$.tracker.byStr( "adss/publisher/view/"+adId );
			}
		}
	);
});
