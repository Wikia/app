var AdSS = {
	sponsormsg: null,
	siteAds: [],

	init: function() {
		AdSS.sponsormsg = $("div.sponsormsg > ul");
		// if div exists
		if(AdSS.sponsormsg.length) {
			// display page ads
			if(typeof(wgAdSS_pageAds) !== 'undefined') {
				$.each( wgAdSS_pageAds, function(i,v) { AdSS.sponsormsg.append(v); } );
			}

			// display a self ads
			if(typeof(wgAdSS_selfAd) !== 'undefined') {
				$(wgAdSS_selfAd).appendTo(AdSS.sponsormsg)
					.find("a").bind( "click", { adId: 0 }, AdSS.onClick );
				$.tracker.byStr( "adss/publisher/view/0" );
			}

			// fetch site ads
			$.getJSON( wgScript, {'action':'ajax', 'rs':'AdSS_Publisher::getSiteAdsAjax', 'cb':'3.1'}, AdSS.onGetSiteAds );
		}
	},

	onGetSiteAds: function(response) {
		// create a flat array for prev/next navigation
		var i;
		for (i=0; i<response.length; i++) {
			// only add real ads
			if (response[i].id > 0) {
				// ignore weight
				if (AdSS.siteAds.length == 0 
				 || AdSS.siteAds[AdSS.siteAds.length-1].id != response[i].id) {
					AdSS.siteAds.push(response[i]);
				}
				// add a back reference
				response[i].idx = AdSS.siteAds.length-1;
			}
		}

		var slot;
		var showedAds = [];
		for (slot=1; slot < response.length/50 + 1; slot++) {
			var rand_no = Math.random() * response.length;
			rand_no = Math.floor(rand_no+1);
			var rand_ad = response[rand_no-1];

			if (rand_ad.id > 0 // only real ads
			   && $.inArray(rand_ad.hash, showedAds) == -1) { // and only these that were not showed yet
				showedAds.push(rand_ad.hash);
				AdSS.replaceAd(
					$("<li></li>").insertBefore( AdSS.sponsormsg.find("li").last() ),
					rand_ad.idx
				);
			}
		}
	},

	replaceAd: function(oldAd, adIdx) {
		var adId = AdSS.siteAds[adIdx].id;
		var ad = $(AdSS.siteAds[adIdx].html);

		ad.find("a").bind( "click", {adId: adId}, AdSS.onClick ).before(AdSS.getPrevNext(adIdx));
		ad.css({"position": "relative"});
		
		oldAd.replaceWith(ad);
		
		$.tracker.byStr( "adss/publisher/view/"+adId );
	},

	getPrevNext: function(idx) {
		var prevIdx = idx-1;
		var nextIdx = idx+1;
		if(prevIdx<0)
			prevIdx = AdSS.siteAds.length-1;
		if(nextIdx==AdSS.siteAds.length)
			nextIdx = 0;

		var prevnext = $('<div class="prevnext"><a href="#" class="prev" rel="'+prevIdx+'">&lt;</a>&nbsp;<a href="#" class="next" rel="'+nextIdx+'">&gt;</a></div>');
		prevnext.css({"float":"right", "font-size":"80%"});
		prevnext.find("a").css({"border":"1px solid", "padding":"1px"}).click( function(e) {
			e.preventDefault();
			AdSS.replaceAd( $(this).closest("li"), parseInt($(this).attr("rel")) );
		} );

		return prevnext;
	},

	onClick: function(event) {
		$.tracker.byStr( "adss/publisher/click/"+event.data.adId );
	}
}

$(AdSS.init);
