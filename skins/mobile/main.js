$(document).ready(function(){
	MobileSkin.initTracking();
	MobileSkin.init();
});

var MobileSkin = {
	uacct: "UA-2871474-1",
	username: (wgUserName == null) ? 'anon' : 'user',
	ct: [],
	dataC: [],
	dataS: [],
	
	initTracking: function(){
		MobileSkin.trackEvent(MobileSkin.username + '/view');
		
		if(wgPrivateTracker) {
			MobileSkin.trackEvent(wgDB + '/' + MobileSkin.username + '/view');
		}
		
		$('#searchGoButton, #mw-searchButton').bind('click', function(event){
			MobileSkin.trackClick('search');
		});
		
		$('a').bind('click', function(event){
			var elm = $(this);
			var href = $(this).attr('href');
			
			if(href.indexOf(CategoryNamespaceMessage) !== -1) MobileSkin.trackClick('categorylink');
			else if(href.indexOf(SpecialNamespaceMessage) === -1) MobileSkin.trackClick('contentlink');
			else if(elm.attr('data-id') === 'randompage') MobileSkin.trackClick('randompage');
		});
	},
	
	trackClick: function(eventName){
		MobileSkin.trackEvent('anon/click/' + eventName);
	},
	
	trackEvent: function(eventName) {
		var eventToTrack = '/1_mobile/' + eventName;
		//TODO: implement ga.js or put back in place old urchintracker
		try{
			console.log('MobileSkin::trackEvent', eventToTrack);
		}catch(err){}
	},
	
	init: function(){
		MobileSkin.c = $("#bodyContent");
		MobileSkin.h = $("#bodyContent > h2");
		
		var results  = MobileSkin.h.get();
		MobileSkin.f = $(results[0]);
		MobileSkin.l = $(results[results.length - 1]);
		
		var counter = -1;
		
		MobileSkin.c.find('*').each(function(elm) {
			elm = $(elm);
			
			if (elm.is('h2')){
				elm.before('<div style="clear:both">');
				elm.append('<a class="showbutton">Show</a>');
				counter++;
				MobileSkin.ct["c" + counter] = [];
			} else if (elm.attr('id') !== 'catlinks' && counter > -1) {
				MobileSkin.ct["c" + counter].push(elm);
				elm.remove();
			}
		});
		
		MobileSkin.b = MobileSkin.h.find(".showbutton");
		counter = 0;
		
		MobileSkin.b.each(function(elm) {
			elm = $(elm);
			elm.attr('data-c', 'c' + counter);
			$(elm).bind('click', MobileSkin.toggle);
			counter++;
		});
	},
	
	toggle: function(event) {
		var elm = $(this);
		
		if(elm.attr('data-s')) {
			$(MobileSkin.ct[elm.attr('data-c')]).remove();
			elm.attr('data-s', false);
			elm.html("Show");
		} else {
			elm.closest("h2").after($(MobileSkin.ct[elm.attr('data-c')]));
			elm.attr('data-s', true);
			elm.html("Hide");
		}
		
		return false;
	}
};