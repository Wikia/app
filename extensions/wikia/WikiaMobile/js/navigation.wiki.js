require(['wikia.window', 'wikia.nirvana', 'track', 'wikia.cache'],
	function(window, nirvana, track, cache){
	'use strict';

	var d = window.document,
		$wkNavMenu,
		$wikiNavHeader,
		$wikiNavH1,
		$wikiNavLink,
		lvl2Link,
		ANIMATION_TIME = 250;

	$(d).on('nav:open', function(){
		trackLevel(1);
	}).on('nav:close', function(){
		if($wkNavMenu){
			$wkNavMenu.removeClass('cur2 cur3');
		}
	});

	function trackLevel(level) {
		track.event('wikinav', track.CLICK, {
			label: 'level-' + level
		});
	}

	function setup(navHtml){
		if(navHtml) {
			$wkNavMenu = $('#wkNav').html(navHtml).find('#wkNavMenu');

			$wikiNavHeader = $wkNavMenu.find('header');
			$wikiNavH1 = $wikiNavHeader.find('h1').removeClass();
			$wikiNavLink = $(d.getElementById('wkNavLink'));

			//add chevrons to all elements that have child lists
			$wkNavMenu.find('ul ul').parent().addClass('cld');

			$wkNavMenu.on('click', 'li', function(event){
				var $this = $(this),
					$element = $this.children().first(),
					hasChildren = $this.hasClass('cld'),
					href = $element.attr('href');

				event.stopPropagation();

				if(hasChildren) {
					$this.find('ul').first().addClass('cur');

					handleHeaderLink(href);

					if($wkNavMenu.hasClass('cur2')){
						trackLevel(3);

						$wkNavMenu.addClass('cur3');
						$wikiNavH1.addClass('animNext');

						window.setTimeout(function(){
							$wikiNavH1.text($element.text());
						}, ANIMATION_TIME);

					} else {
						trackLevel(2);

						$wikiNavH1.text($element.text());
						lvl2Link = href;

						$wkNavMenu.addClass('cur2');
						$wikiNavH1.removeClass().addClass('anim');
					}
				}
			}).on('click', '#wkNavBack', function(){
				if($wkNavMenu.hasClass('cur3')) {
					trackLevel(2);

					$wikiNavH1.removeClass().addClass('animBack');

					handleHeaderLink(lvl2Link);

					$wkNavMenu.removeClass('cur3');

					window.setTimeout(function(){
						$wikiNavH1.text($wkNavMenu.find('.lvl2.cur').prev().text());
					}, ANIMATION_TIME);

					window.setTimeout(function(){
						$wkNavMenu.find('.lvl3.cur').removeClass('cur');
						$wikiNavH1.removeClass();
					}, ANIMATION_TIME * 2);
				} else {
					trackLevel(1);

					$wkNavMenu.removeClass('cur2');
					$wikiNavH1.removeClass().addClass('animBack');

					window.setTimeout(function(){
						$wkNavMenu.find('.lvl2.cur').removeClass('cur');
					}, ANIMATION_TIME * 2);
				}
			});

			$wikiNavLink.on('click', function(){
				track.event('wikinav', track.CLICK, {
					label: 'header-' + $wkNavMenu[0].className.slice(3)
				});
			});
		}
	}

	function handleHeaderLink(link){
		if(link) {
			$wikiNavLink.attr('href', link).show();
		} else {
			$wikiNavLink.hide();
		}
	}

	$(function(){
		var CACHE_KEY = 'wkNavigation';

		setTimeout(function(){
			var navHtml = cache.getVersioned(CACHE_KEY);

			if(navHtml) {
				setup(navHtml);
			}else{
				nirvana.sendRequest({
					type: 'GET',
					controller: 'WikiaMobileController',
					method: 'getNavigation',
					format: 'html',
					data: {
						lang: window.wgUserLanguage
					}
				}).done(function(navHtml){
					cache.setVersioned(CACHE_KEY, navHtml, 10800);

					setup(navHtml);
				});
			}
		}, 200); //do this on load but give browser some time to finish
	});
});