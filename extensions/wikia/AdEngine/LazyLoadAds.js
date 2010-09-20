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
				var elemId = $(this).attr("id");
				LazyLoadAds.lazyLoadAdTops[elemId] = $(this).offset().top;
			});
		}

		$.each(LazyLoadAds.lazyLoadAdTops, function(elemId, topVal) {
			if (!$("#"+elemId).hasClass('AdLazyLoaded')) { 
				if (topVal > 0 && topVal < (fold + LazyLoadAds.settings.threshhold)) {
					adslot = elemId;
					if (document.getElementById(elemId).nodeName.toLowerCase() == 'iframe') {
						//remove trailing "_iframe"
						var iframeLastIndex = elemId.lastIndexOf("_iframe", elemId.length-7);
						if (iframeLastIndex == elemId.length-7) {
							adslot = elemId.substr(0, iframeLastIndex);
						}
						window["fillIframe_" + adslot]();
					}
					else {
						window["fillElem_" + adslot]();
					}
					$("#"+elemId).addClass('AdLazyLoaded');
				}
			}
		});
	}
};
