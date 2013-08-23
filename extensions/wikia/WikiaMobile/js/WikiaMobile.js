//init
window.addEventListener('DOMContentLoaded', function () {
	'use strict';
	require(['wikia.querystring', require.optional('topbar'), require.optional('toc'), require.optional('share'), require.optional('popover'), require.optional('wikia.cookies'), 'track', 'layout', 'wikia.videoBootstrap', 'wikia.window'],
		function (qs, topbar, toc, share, popover, cookies, track, layout, VideoBootstrap, window) {
			var d = document,
				clickEvent = 'click',
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

					if(t.tagName === 'A') {
						track.event('read-more', track.IMAGE_LINK, {
							href: t.href
						},
						ev);
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

					var skin = this.getAttribute('data-skin');

					//This is being deprecated remove when Varnish will be updated to use useskin
					cookies.set('mobilefullsite', 'true');

					cookies.set('useskin', skin, {
						domain: window.wgCookieDomain,
						path: window.wgCookiePath
					});
					qs().setVal('useskin', skin).addCb().goTo();
				});
			}

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
						},
						ev);
					}
				});
			}

			if (topBar) {
				if (wordmark = topBar.children[0]) {
					wordmark.addEventListener(clickEvent, function (ev) {
						track.event('wordmark', track.CLICK, {
							href: this.href
						},
						ev);
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
						},
						ev);
					}
				});
			}

			// Play video on file pages
			var filePageContainer = document.getElementById('file');
			if(filePageContainer && window.playerParams) {
				new VideoBootstrap(filePageContainer, window.playerParams, 'filePage');
			}
		}
	);
});
