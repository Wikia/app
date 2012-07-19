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
	require(['media', 'querystring', 'topbar', 'toc', 'events', 'hideURLBar', 'tables', 'sections', 'share', 'popover', 'cookies', 'ads', 'lazyload'],
		function(media, qs, topbar, toc, events, hideURLBar, tables, sections, share, popover, cookies, ads, lazyLoad){
			var d = document,
				clickEvent = events.click;

			hideURLBar();

			sections.init();//NEEDS to run before table wrapping!!!
			tables.init();
			media.init();
			toc.init();

			//init ad (removing it if empty and closing in on close button)
			ads && ads.init();

			//add class for styling to be applied only if JS is enabled
			//(e.g. collapse sections)
			//must be done AFTER detecting size of elements on the page
			d.body.className += ' js';

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
				url.setVal('useskin', this.getAttribute('data-skin'));
				url.addCb();
				url.goTo();
			});

			//add chevrons to elements that need it
			var addChevs = d.getElementsByClassName('addChev'),
				l = addChevs.length,
				i = 0;

			for(; i < l; i++){
				addChevs[i].insertAdjacentHTML('beforeend', '<span class=chev></span>');
			}

			//add curtain
			d.body.insertAdjacentHTML('beforeend', '<div id=wkCurtain></div>');

			//close toc and topbar when 'curtain' is clicked
			d.getElementById('wkCurtain').addEventListener(clickEvent, function(ev){
				toc.close();
				topbar.closeDropDown();
			});

			var wkShrPag = d.getElementById('wkShrPag');

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

			var processedSections = {};

			//Image lazy loading
			$(window).on('load', function () {
				lazyLoad(
					document.getElementsByClassName('lazy'),
					'imgPlcHld',
					'fit'
				);

				sections.addEventListener('open', function () {
					var self = this,
						id = self.getAttribute('data-index');

					if (id !== null && id !== undefined && !processedSections[id]) {
						lazyLoad(
							self.getElementsByClassName('lazy'),
							'imgPlcHld',
							'fit'
						);

						processedSections[id] = true;
					}
				});
			});
		});
});