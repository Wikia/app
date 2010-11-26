var AdSS = {
	sponsormsg: null,
	siteAds: [],

	init: function() {
		AdSS.sponsormsg = $("div.sponsormsg > ul");
		AdSS.sponsormsg.css( { "position": "relative" } );
		AdSS.sponsormsg.bind("mouseenter mouseleave", function(e) {
			if(e.type=="mouseenter") {
				$("div.prevnext").animate({opacity:1});
			} else {
				$("div.prevnext").animate({opacity:0});
			}
		});

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

		// fetch a site ad
		$.getJSON( wgScript, {'action':'ajax', 'rs':'AdSS_Publisher::getSiteAdsAjax'}, AdSS.onGetSiteAds );
	},

	onGetSiteAds: function(response) {
		var rand_no = Math.random() * response.length;
		rand_no = Math.floor(rand_no+1);
		if( response[rand_no-1].id > 0 ) {
			var adIdx;
			var i;
			for( i=0; i<response.length; i++ ) {
				if( response[i].id > 0 ) {
					if( AdSS.siteAds.length == 0 
							|| AdSS.siteAds[ AdSS.siteAds.length-1 ].id != response[i].id ) {
						if( response[i].id == response[rand_no-1].id ) {
							adIdx = AdSS.siteAds.length;
						}
						AdSS.siteAds.push( response[i] );
					}
				}
			}

			AdSS.sponsormsg.find("li").last().before("<li></li>");
			AdSS.showSiteAd( adIdx );
		}
	},

	showSiteAd: function(idx) {
		var adId = AdSS.siteAds[idx].id;
		var ad = $(AdSS.siteAds[idx].html);

		ad.find("a").bind( "click", {adId: adId}, AdSS.onClick );
		ad.append(AdSS.getPrevNext(idx));

		AdSS.sponsormsg.find("li").last().prev().replaceWith(ad);
		
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
		prevnext.css( { "position":"absolute", "right":"0px", "top":"0px", "opacity":"0" } );
		prevnext.find("a").css( { "border":"1px solid", "padding":"1px" } ).click( function(e) {
			e.preventDefault();
			AdSS.showSiteAd( parseInt( $(this).attr("rel") ) );
		} );

		return prevnext;
	},

	onClick: function(event) {
		$.tracker.byStr( "adss/publisher/click/"+event.data.adId );
	}
}

$(AdSS.init);
