//as fast as possible to avoid screen flickering
//document.documentElement.className += ' js';

//analytics
WikiaTracker.trackEvent(
	'trackingevent',
	{
 		ga_category: 'wikiamobile-view',
 		ga_action: WikiaTracker.ACTIONS.VIEW
 	},
 	'both'
 );

//init
$(function(){
	require(['media', 'querystring', 'topbar', 'toc', 'events', 'hideURLBar', 'tables', 'sections', 'share', 'popover', 'cookies'],
		function(media, qs, topbar, toc, events, hideURLBar, tables, sections, share, popover, cookies){
			var d = document,
				body = $(d.body),
				clickEvent = events.click;

			hideURLBar();

			sections.init();//NEEDS to run before table wrapping!!!
			tables.init();
			media.init();
			toc.init();

			//add class for styling to be applied only if JS is enabled
			//(e.g. collapse sections)
			//must be done AFTER detecting size of elements on the page
			d.body.className += ' js';

			d.body.addEventListener(clickEvent, function(ev){
				if(ev.target.className.indexOf('hidden') > -1){
					toc.close();
					topbar.closeDropDown();
				}
			});

			//TODO: optimize selectors caching for this file
			/*body.delegate('#wkMainCnt a', clickEvent, function(){
			 track('link/content');
			 });

			 $(d.getElementById('wkRelPag')).delegate('a', clickEvent, function(){
			 track('link/related-page');
			 });

			 $(d.getElementById('wkArtCat')).delegate('a', clickEvent, function(){
			 track('link/category');
			 });*/

			d.getElementById('wkFllSite').addEventListener(clickEvent, function(event){
				event.preventDefault();
				//track('link/fullsite');
				cookies.set('mobilefullsite', 'true');

				var url = new qs();
				url.setVal('useskin', 'oasis');
				url.addCb();
				url.goTo();
			});

			var wkShrPag = document.getElementById('wkShrPag');

			if(wkShrPag){
				popover({
					on: wkShrPag,
					create: share(),
					open: function(){
						//track('share/page/open');
					},
					close: function(){
						//track('share/page/close');
					},
					style: 'right:0;'
				});
			}
		});
});