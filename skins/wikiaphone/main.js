//mixpanel
var mpq=[];

var MobileSkin = {
	GA: {
		accountID: "UA-2871474-1",
		samplingRate: '10',
		userName: (wgUserName == null) ? 'anon' : 'user'
	},
	userType: (wgIsLogin == true) ? 'logged in' : 'anon',
	ct: {},
	c: null,
	h: null,
	b: null,
	
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
	
	track: function(category, action, label, intVal) {
		//GA
		var paramsArray = ['_trackEvent', category, action];
		
		//mixpanel
		var paramsObject = {'category': category};
		
		//optional parameters
		if(label){
			paramsArray.push(label);
			paramsObject.label = label;
		}
		
		if(intVal){
			paramsArray.push(intVal);
			paramsObject.number = intVal;
		}
		
		//GA
		_gaq.push(paramsArray);
		
		//mixpanel
		if (mpq.track && category != 'pageview') mpq.track(action, paramsObject);
	},
	
	init: function(){
		//analytics
		//GA
		_gaq.push(
			['_setSampleRate', MobileSkin.GA.samplingRate],
			['_setAccount', MobileSkin.GA.accountID],
			//custom vars, max 5 allowed
			['_setCustomVar', 1, 'user type', MobileSkin.userType, 2],
			['_setCustomVar', 2, 'skin', skin, 3],
			['_setCustomVar', 3, 'hub', cityShort, 3],
			['_setCustomVar', 4, 'wiki', wgDBname, 3],
			['_setCustomVar', 5, 'visiting mainpage', wgIsMainpage.toString(), 3],
			['_trackPageview', '/1_mobile/' + MobileSkin.GA.userName + '/view']
		);
		
		//GA
		if(wgPrivateTracker) {
			_gaq.push(['_trackPageview', '/1_mobile/' + wgDB + '/' + MobileSkin.GA.userName + '/view']);
		}
		
		//mixpanel
		if(mpq.name_tag && wgUserName && wgUserName != null){ 
 			mpq.name_tag(wgUserName); 
 		}
 		
 		//mixpanel
 		if(mpq.register){
 			mpq.register({
	 			'user type': MobileSkin.userType,
	 			'user language': wgUserLanguage,
	 			'hub': cityShort,
	 			'wiki': wgDBname,
	 			'visiting mainpage': wgIsMainpage,
	 			'skin': skin,
	 			'user agent': navigator.userAgent
	 		});
 		}
 		
		MobileSkin.track('pageview', 'view', wgPageName);
		
		//skin elements
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
		
		//event handling
		MobileSkin.b.click(MobileSkin.toggle);
		
		$('#mobile-search-btn').bind('click', function(event){
			MobileSkin.track('button', 'click', 'search');
		});
		
		$('a').bind('click', function(event){
			var elm = $(this);
			var href = $(this).attr('href');
			
			if(elm.hasClass('showbutton')) { 
				if(elm.data("s")) {
					MobileSkin.track('button', 'click', 'section show'); 
				} else {
					MobileSkin.track('button', 'click', 'section hide'); 
				}
			} else if(elm.hasClass('more')) { 
				MobileSkin.track('link', 'click', 'related pages');
			} else if(elm.hasClass('fullsite')){
				event.preventDefault();
				MobileSkin.track('link', 'click', 'full site');
				document.cookie = 'mobilefullsite=true';
				location.reload();
			} else if(elm.attr('data-id') === 'randompage') MobileSkin.track('button', 'click', 'random page');
			else if(href && href.indexOf(CategoryNamespaceMessage) !== -1) MobileSkin.track('link', 'click', 'category');
			else if(href && href.indexOf(SpecialNamespaceMessage) === -1) MobileSkin.track('link', 'click', 'article');
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

$(document).ready(MobileSkin.init);