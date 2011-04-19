$(document).ready(function(){
	MobileSkin.init();
	MobileSkin.initTracking();
});

var MobileSkin = {
	uacct: "UA-19473076-1",//test related to FB#4768, original value was "UA-2871474-1"
	username: (wgUserName == null) ? 'anon' : 'user',
	ct: {},
	c: null,
	h: null,
	b: null,
	
	track: function(str) {
		if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
			_gaq.push(['_setAccount', MobileSkin.uacct]);
			_gaq.push(['_trackPageview', str]);
		} else if(typeof urchinTracker !== 'undefined') {
			_uff = 0;
			_uacct = MobileSkin.uacct;
			urchinTracker(str);
		}		
	},
	
	initTracking: function(){
		MobileSkin.trackEvent(MobileSkin.username + '/view');
		
		$('#mobile-search-btn').bind('click', function(event){
			MobileSkin.trackClick('search');
		});
		
		$('a').bind('click', function(event){
			var elm = $(this);
			var href = $(this).attr('href');
			
			if(href && href.indexOf(CategoryNamespaceMessage) !== -1) MobileSkin.trackClick('categorylink');
			else if(href && href.indexOf(SpecialNamespaceMessage) === -1) MobileSkin.trackClick('contentlink');
			else if(elm.attr('data-id') === 'randompage') MobileSkin.trackClick('randompage');
			else if(elm.hasClass('showbutton')) { 
				if(elm.data("s")) {
					MobileSkin.trackClick('show'); 
				} else {
					MobileSkin.trackClick('hide'); 
				}
			}
			else if(elm.hasClass('fullsite')) MobileSkin.trackClick('desktop');
		});
	},
	
	trackClick: function(eventName){
		MobileSkin.trackEvent(MobileSkin.username + '/click/' + eventName);
	},
	
	trackEvent: function(eventName) {
		MobileSkin.track('/1_mobile/' + eventName);
		if(wgPrivateTracker) {
			MobileSkin.track('/1_mobile/' + wgDB + '/' + eventName);
		}
	},
	
	init: function(){
		MobileSkin.c = $("#bodyContent");
		MobileSkin.h = MobileSkin.c.find(">h2");
		
		var cindex = -1;
		MobileSkin.c.contents().each(function(i, el) {
			if (this) {
				if (this.nodeName == 'H2') {
					$(this).append('<a class="showbutton">' + MobileSkinData["showtext"] + '</a>');
					cindex++;
					MobileSkin.ct["c"+cindex] = [];
				} else if (this.id != 'catlinks' && this.id != 'mw-data-after-content' && cindex > -1) {
					MobileSkin.ct["c"+cindex].push(this);
					$(this).remove();
				}
			}
		});
		
		MobileSkin.b = MobileSkin.h.find(".showbutton");
		
		MobileSkin.b.each(function(i, el) {
			$(el).data("c", "c" + i);
		});
		
		MobileSkin.b.click(MobileSkin.toggle);
		
		$("#fullsite .fullsite").click(function(e){
			e.preventDefault();
			document.cookie = 'mobilefullsite=true';
			location.reload();
		});
	},
	
	toggle: function(e) {
		e.preventDefault();
		
		if($(this).data("s")) {
			$(MobileSkin.ct[$(this).data("c")]).remove();
			$(this).data("s", false);
			$(this).text(MobileSkinData["showtext"]);
		} else {
			$(this).closest("h2").after($(MobileSkin.ct[$(this).data("c")]));
			$(this).data("s", true);
			$(this).text(MobileSkinData["hidetext"]);
		}
	}
};