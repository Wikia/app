require(['wikia.querystring', require.optional('wikia.cookies'), 'track', 'wikia.window', 'jquery'],
	function (qs, cookies, track, window, $) {
		'use strict';

		var d = window.document;

		//used to handle close tracking on Read More section
		$(d.getElementById('wkRelPag')).on('click', '.open', function(){
			if (this.children[0].className.indexOf('open') > -1) {
				track.event('read-more', track.CLICK, {label: 'close'});
			}
		}).on('click', 'a', function(ev){
			track.event('read-more', track.IMAGE_LINK, {
					href: this.href
			},ev);
		});

		$(d.getElementById('wkFllSite')).on('click', function(event){
			var skin = this.getAttribute('data-skin') || 'oasis';

			event.preventDefault();
			event.stopPropagation();
			cookies.set('mobilefullsite', 'true');

			cookies.set('useskin', skin, {
				domain: window.wgCookieDomain,
				path: window.wgCookiePath
			});
			qs().setVal('useskin', skin).addCb().goTo();
		});

		$(d.getElementById('wkFtr')).on('click' , 'a', function(event){
			track.event('footer', track.TEXT_LINK, {
				label: 'link',
				href: this.href
			},event);
		});

		$(d.getElementById('wkTopBar')).find('a:first-child').on('click', function(event){
			track.event('wordmark', track.CLICK, {
				href: this.href
			},event);
		});

		$(d.getElementById('catlinks')).on('click', 'a', function(event){
			track.event('category', track.TEXT_LINK, {
				label: 'article',
				href: this.href
			},event);
		});
	}
);
