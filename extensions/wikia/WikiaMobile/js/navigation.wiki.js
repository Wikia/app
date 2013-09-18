define('navigation.wiki', ['wikia.window', 'wikia.nirvana', 'track'],
	function(window, nirvana, track){
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

		$wkNavMenu.removeClass().addClass('cur1');
	});

	function trackLevel(level) {
		track.event('wikinav', track.CLICK, {
			label: 'level-' + level
		});
	}

	function setup(navHtml, wkNav){
		if(navHtml && wkNav) {
			$wkNavMenu = wkNav.html(navHtml).find('#wkNavMenu');

			$wikiNavHeader = $wkNavMenu.find('header');
			$wikiNavH1 = $wikiNavHeader.find('h1').removeClass();
			$wikiNavLink = $(d.getElementById('wkNavLink'));

			//add chevrons to all elements that have child lists
			$wkNavMenu.find('ul ul').parent().addClass('cld');

			$wkNavMenu.on('click', '.cld', function(event){
				event.stopPropagation();

				var $this = $(this),
					$element = $this.children().first(),
					href = $element.attr('href');

				$this.find('ul').first().addClass('cur');

				handleHeaderLink(href);

				if($wkNavMenu.hasClass('cur1')){
					$wikiNavH1.text($element.text());
					lvl2Link = href;

					trackLevel(2);

					$wkNavMenu.removeClass().addClass('cur2');
					$wikiNavH1.removeClass().addClass('anim');
				} else {
					trackLevel(3);

					$wkNavMenu.removeClass().addClass('cur3');
					$wikiNavH1.removeClass().addClass('animNext');

					window.setTimeout(function(){
						$wikiNavH1.text($element.text());
					}, ANIMATION_TIME);
				}
			}).on('click', '#wkNavBack', function(){
				if($wkNavMenu.hasClass('cur2')) {
					trackLevel(1);

					$wkNavMenu.removeClass().addClass('cur1');
					$wikiNavH1.removeClass().addClass('animBack');

					window.setTimeout(function(){
						$wkNavMenu.find('.lvl2.cur').removeClass('cur');
					}, ANIMATION_TIME * 2);
				} else {
					$wikiNavH1.addClass('animBack');

					handleHeaderLink(lvl2Link);

					trackLevel(2);

					$wkNavMenu.removeClass().addClass('cur2');

					window.setTimeout(function(){
						$wikiNavH1.text($wkNavMenu.find('.lvl2.cur').prev().text());
					}, ANIMATION_TIME);

					window.setTimeout(function(){
						$wkNavMenu.find('.lvl3.cur').removeClass('cur');
						$wikiNavH1.removeClass();
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

	function init(navMenu){
		nirvana.sendRequest({
			type: 'GET',
			controller: 'WikiaMobileController',
			method: 'getNavigation',
			format: 'html'
		}).done(function(navHtml){
			setup(navHtml, navMenu);
		});
	}

	function handleHeaderLink(link){
		if(link) {
			$wikiNavLink.attr('href', link);
			$wikiNavLink.show();
		} else {
			$wikiNavLink.hide();
		}
	}

	return {
		init: init
	};
});