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

	init : function() {
		LazyLoadAds.update();
		$(window).scroll(LazyLoadAds.update);
	},

	update : function() {

		if(!LazyLoadAds.allAds) {
			LazyLoadAds.w = $(window);
			LazyLoadAds.allAds = [];
			$(".LazyLoadAd").each(function(i, el) {
				LazyLoadAds.allAds.push($(el));
			});
			LazyLoadAds.num = LazyLoadAds.allAds.length;
		}

		var fold = LazyLoadAds.w.height() + LazyLoadAds.w.scrollTop();
		
		for(i = 0; i < LazyLoadAds.num; i++) {
			if(LazyLoadAds.allAds[i]) {
				var top = LazyLoadAds.allAds[i].offset().top;
				if(top > 0 && top < (fold + LazyLoadAds.settings.threshhold) ) {
					var elemId = LazyLoadAds.allAds[i].attr("id");
					var adslot = elemId;
	
					if($('#'+elemId).get(0).nodeName == 'IFRAME') {
						var fillFunction = "fillIframe_" + adslot.replace("_iframe", "");
					} else {
						var fillFunction = "fillElem_" + adslot;
					}
	
					if (typeof(window[fillFunction]) !== 'undefined') {
						window[fillFunction]();
						window[fillFunction] = null;
					}
					else {
						LazyLoadAds.log("Warning! " + fillFunction + " does not exist.");
					}
	
					LazyLoadAds.allAds[i] = false;
				}
			}
		}
	}
};
