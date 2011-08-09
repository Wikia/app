//mixpanel
var mpq=[];

var MobileSkin = {
	uacct: "UA-2871474-1",
	username: (wgUserName == null) ? 'anon' : 'user',
	sampleSet: false,
	ct: {},
	c: null,
	h: null,
	b: null,
	
	track: function(str) {
		if(!MobileSkin.sampleSet) {
			_gaq.push(['_setSampleRate', '10']);
			MobileSkin.sampleSet = true;
		}
		_gaq.push(['_setAccount', MobileSkin.uacct]);
		_gaq.push(['_trackPageview', str]);
	},
	
	initTracking: function(){
		//mixpanel
		if(wgUserName && wgUserName != null){ 
 			mpq.name_tag(wgUserName); 
 		}
 		
 		//mixpanel
 		mpq.register({
 			'user type': (wgIsLogin == true) ? 'logged in' : 'anon',
 			'user language': wgUserLanguage,
 			'hub': cityShort,
 			'wiki': wgDBname,
 			'visiting mainpage': wgIsMainpage
 		});
 		
		MobileSkin.trackEvent(MobileSkin.username + '/view', true);
		
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
	
	initMixpanel: function(){
		if(!DevelEnvironment){
			mpq.push(["init","f64b56c48325a31a1a442e31b98cf2c1"]);
			var b,a,e,d,c;
			b = document.createElement("script");
			b.type = "text/javascript";
			b.async = true;
			b.src = (document.location.protocol === "https:" ? "https:" : "http:") + "//api.mixpanel.com/site_media/js/api/mixpanel.js";
			a = document.getElementsByTagName("script")[0];
			a.parentNode.insertBefore(b, a);
			e = function(f){
				return function(){
					mpq.push([f].concat(Array.prototype.slice.call(arguments,0)))
				}
			};
			
			d = ["track", "track_links", "track_forms", "register", "register_once", "identify", "name_tag", "set_config"];
			
			for(c = 0; c < d.length; c++){
				mpq[d[c]] = e(d[c]);
			}
		}
	},
	
	trackClick: function(eventName){
		MobileSkin.trackEvent(MobileSkin.username + '/click/' + eventName, true);
		
		//mixpanel
		mpq.track('click', {'source': eventName});
	},
	
	trackEvent: function(eventName, indirectCall) {
		indirectCall = indirectCall || false;
		
		MobileSkin.track('/1_mobile/' + eventName);
		
		if(wgPrivateTracker) {
			MobileSkin.track('/1_mobile/' + wgDB + '/' + eventName);
		}
		
		//mixpanel
		if(!indirectCall){
			mpg.track('event fired', {'name': eventName});
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
			MobileSkin.trackClick('fullsite');
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

//mixpanel
MobileSkin.initMixpanel();

$(document).ready(function(){
	MobileSkin.init();
	MobileSkin.initTracking();
});