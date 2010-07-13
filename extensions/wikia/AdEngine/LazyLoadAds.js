$(function() {
	LazyLoadAds.init();
});

var LazyLoadAds = {
	settings : {
		threshhold : 200
	},

	init : function() {
		$(function() {
			LazyLoadAds.update();
			$(window).scroll(LazyLoadAds.update);
		});
	},

	update : function() {
		var fold = $(window).height() + $(window).scrollTop();

		$(".LazyLoadAd").each(function() {
			if ($(this).offset().top < fold + LazyLoadAds.settings.threshhold && !$(this).attr("src")) {
				var iframeId = $(this).attr("id");
                                //remove trailing "_iframe"
                                var iframeLastIndex = iframeId.lastIndexOf("_iframe", iframeId.length-7);
                                if (iframeLastIndex == iframeId.length-7) {
                                    iframeId = iframeId.substr(0, iframeLastIndex);
                                }
                                window["fillIframe_" + iframeId]();
			}
		});
	}
};