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
	
	track: function(category, action, label, intVal) {
		var paramsArray = ['_trackEvent', category, action];
		
		//optional parameters
		if(label)
			paramsArray.push(label);
		
		if(intVal)
			paramsArray.push(intVal);
		
		_gaq.push(paramsArray);
	},
	
	init: function(){
		//analytics
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
		
		if(wgPrivateTracker) {
			_gaq.push(['_trackPageview', '/1_mobile/' + wgDB + '/' + MobileSkin.GA.userName + '/view']);
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

$(document).ready(MobileSkin.init);