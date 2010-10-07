$(function() {
	var sponsormsg = $("div.sponsormsg > ul");
	if(typeof(wgAdSS_pageAds) !== 'undefined') {
		$.each( wgAdSS_pageAds, function(i,v) {
			sponsormsg.append(v);
		});
	}
	if(typeof(wgAdSS_selfAd) !== 'undefined') {
		sponsormsg.append(wgAdSS_selfAd);
	}
	$.getJSON(wgScript, {'action':'ajax', 'rs':'AdSS_Publisher::getSiteAdsAjax'},
		function(response) {
			var rand_no = Math.random() * Math.max(response.length, 4);
			rand_no = Math.floor(rand_no+1);
			if(response.length >= rand_no) {
				sponsormsg.find("li").last().before(response[rand_no-1]);
			}
		}
	);
});
