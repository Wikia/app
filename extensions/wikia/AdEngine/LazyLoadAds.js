$(function() {
	LazyLoadAds.init();
});

var LazyLoadAds = {
	settings : {
		threshhold : 200
	},

	lazyLoadAdTops : null,

	init : function() {
		$(function() {
			LazyLoadAds.update();
			$(window).scroll(LazyLoadAds.update);
		});
	},

	update : function() {
		var fold = $(window).height() + $(window).scrollTop();

		if (LazyLoadAds.lazyLoadAdTops==null) {
			LazyLoadAds.lazyLoadAdTops = {};
			$(".LazyLoadAd").each(function() {
				var iframeId = $(this).attr("id");
				LazyLoadAds.lazyLoadAdTops[iframeId] = $(this).offset().top;
			});
		}

		$.each(LazyLoadAds.lazyLoadAdTops, function(iframeId, topVal) {
			if (!$("#"+iframeId).attr("src")) {
				if (topVal > 0 && topVal < (fold + LazyLoadAds.settings.threshhold)) {
                                	//remove trailing "_iframe"
                                	var iframeLastIndex = iframeId.lastIndexOf("_iframe", iframeId.length-7);
                                	if (iframeLastIndex == iframeId.length-7) {
                                    		iframeId = iframeId.substr(0, iframeLastIndex);
                                	}
                                	window["fillIframe_" + iframeId]();
				}
			}
		});
	}
};
