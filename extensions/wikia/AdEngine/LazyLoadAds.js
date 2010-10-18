$(function() {
	LazyLoadAds.init();
});

var LazyLoadAds = {

	log: function(msg) {
		$().log(msg, 'LazyLoadAds');
	},

	settings : {
		threshhold : 300
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
						var fillFunction = "fillIframe_" + adslot.replace("_iframe", "");
					} else {
						var fillFunction = "fillElem_" + adslot;
					}

					if (typeof(window[fillFunction]) !== 'undefined') {
						window[fillFunction]();
					}
					else {
						LazyLoadAds.log("Warning! " + fillFunction + " does not exist.");
					}

					$("#"+elemId).addClass('AdLazyLoaded');
				}
			}

		});
	}
};
