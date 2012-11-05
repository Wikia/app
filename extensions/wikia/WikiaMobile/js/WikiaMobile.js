//image lazyloading
//needs to run ASAP (before onload actually happens)
//so it's processed separately from the rest
//to avoid delays

(function (w) {
	'use strict';
	var onload = function onload() {
		require(['lazyload', 'sections'], function (lazyLoad, sections) {
			var processedSections = {};

			lazyLoad(document.getElementsByClassName('noSect'));

			sections.addEventListener('open', function () {
				var id = this.getAttribute('data-index');

				if (id && !processedSections[id]) {
					lazyLoad(this.getElementsByClassName('lazy'));

					processedSections[id] = true;
				}
			});
		});
	};

	w.addEventListener ? w.addEventListener('load', onload) : w.attachEvent('onload', onload);
})(window);

//init
window.addEventListener('DOMContentLoaded', function () {
	'use strict';
	require(['layout', 'querystring', require.optional('topbar'), require.optional('toc'), 'events', require.optional('share'), require.optional('popover'), require.optional('cookies'), 'track'],
		function (layout, qs, topbar, toc, events, share, popover, cookies, track) {
			var d = document,
				clickEvent = events.click,
				//add chevrons to elements that need it
				addChevs = d.getElementsByClassName('addChev'),
				i = addChevs.length,
				//used to handle close tracking on Read More section
				relPage = d.getElementById('wkRelPag'),
				//used to add sharing menu to a page
				wkShrPag = d.getElementById('wkShrPag'),
				wkFtr = d.getElementById('wkFtr'),
				topBar = d.getElementById('wkTopBar'),
				fllSite = d.getElementById('wkFllSite'),
				categoryLinks = d.getElementById('catlinks'),
				wordmark;

			while (i--) {
				addChevs[i].insertAdjacentHTML('beforeend', '<span class=chev></span>');
			}

			toc && toc.init();

			if (relPage) {
				relPage.addEventListener(clickEvent, function (ev) {
					var t = ev.target;
					ev.preventDefault();

					if(t.tagName == 'A') {
						track.event('read-more', track.IMAGE_LINK, {
							href: t.href
						});
					} else {
						if (relPage.children[0].className.indexOf('open') > -1) {
							track.event('read-more', track.CLICK, {label: 'close'});
						}
					}
				});
			}

			if (fllSite) {
				fllSite.addEventListener(clickEvent, function(event){
					event.preventDefault();
					event.stopPropagation();
					cookies.set('mobilefullsite', 'true');

					(new qs()).setVal('useskin', this.getAttribute('data-skin')).addCb().goTo();
				});
			}

			//add curtain
			d.body.insertAdjacentHTML('beforeend', '<div id=wkCurtain></div>');

			//close toc and topbar when 'curtain' is clicked
			d.getElementById('wkCurtain').addEventListener(clickEvent, function(){
				toc.close();
				topbar.closeDropDown();
			});

			if (wkShrPag) {
				popover({
					on: wkShrPag,
					create: function(cnt){
						cnt.addEventListener(clickEvent, function(){
							track.event('share', track.CLICK, 'page');
						}, true);
						return share()(cnt);
					},
					open: function () {
						track.event('share', track.CLICK, {label: 'open'});
					},
					close: function (ev) {
						if(ev.target.tagName != 'A') {track.event('share', track.CLICK, {label: 'close'});}
					},
					style: 'right:0;'
				});
			}

			if (wkFtr) {
				wkFtr.addEventListener(clickEvent, function (ev) {
					var t = ev.target;
					if (t.tagName == 'A') {
						track.event('footer', track.TEXT_LINK, {
							label: 'link',
							href: t.href
						});
					}
				});
			}

			if (topBar) {
				if (wordmark = topBar.children[0]) {
					wordmark.addEventListener(clickEvent, function () {
						track.event('wordmark', track.CLICK, {
							href: this.href
						});
					});
				}
			}

			if (categoryLinks) {
				categoryLinks.addEventListener(clickEvent, function (ev) {
					var t = ev.target;
					if (t.tagName == 'A') {
						track.event('category', track.TEXT_LINK, {
							label: 'article',
							href: t.href
						});
					}
				});
			}
		}
	);
});