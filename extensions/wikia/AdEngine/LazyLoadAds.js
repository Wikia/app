$(function() {
	LazyLoadAds.init();
});

var LazyLoadAds = {

	log: function(msg) {
		$().log(msg, 'LazyLoadAds');
	},

	settings : {
		threshhold : 200
	},

	lazyLoadAdTops : null,

	init : function() {

		LazyLoadAds.log("init");

		$(function() {

			LazyLoadAds.log("real init");

			LazyLoadAds.update();
			$(window).scroll(LazyLoadAds.update);
		});
	},

	calculateSlotsOffsets: function() {

		LazyLoadAds.log("calculateSlotsOffsets");

		LazyLoadAds.lazyLoadAdTops = {};

		$(".LazyLoadAd").each(function() {
			LazyLoadAds.lazyLoadAdTops[$(this).attr("id")] = $(this).offset().top;
		});
	},

	update : function() {

		//LazyLoadAds.log("update");

		if(LazyLoadAds.lazyLoadAdTops == null) {
			LazyLoadAds.calculateSlotsOffsets();
		}

		var fold = $(window).height() + $(window).scrollTop();

		$.each(LazyLoadAds.lazyLoadAdTops, function(elemId, topVal) {

			if(!$("#"+elemId).hasClass('AdLazyLoaded')) {
				if(topVal > 0 && topVal < (fold + LazyLoadAds.settings.threshhold)) {

					LazyLoadAds.log("About to fill: " + elemId);

					var adslot = elemId;

					if($('#'+elemId).get(0).nodeName == 'IFRAME') {
						window["fillIframe_" + adslot.replace("_iframe", "")]();
					} else {
						window["fillElem_" + adslot]();
					}

					$("#"+elemId).addClass('AdLazyLoaded');
				}
			}

		});
	}
};
