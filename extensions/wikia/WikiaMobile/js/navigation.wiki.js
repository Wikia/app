define('navigation.wiki', ['wikia.window', 'wikia.nirvana', 'track'],
	function(window, nirvana, track){
	'use strict';

	var d = window.document,
		$wkNavMenu,
		$wikiNavHeader,
		$wikiNavH1,
		$wikiNavLink,
		lvl2Link,
		navSetUp = false;

	$(d).on('nav:open', function(){

		track.event('wikinav', track.CLICK, {
			label: 'level-1'
		});

		$wkNavMenu.removeClass().addClass('cur1');
	});

	function init(navMenu){
		$wkNavMenu = navMenu;

		nirvana
			.sendRequest({
				type: 'GET',
				controller: 'WikiaMobileController',
				method: 'getNavigation',
				format: 'html'
			}).done(function(nav){
				if(nav) {
					$wkNavMenu = navMenu.html(nav).find('#wkNavMenu');
					setupNav();
				}
			});
	}

	function setupNav(){
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

				track.event('wikinav', track.CLICK, {
					label: 'level-2'
				});

				$wkNavMenu.removeClass().addClass('cur2');
				$wikiNavH1.removeClass().addClass('anim');
			} else {
				track.event('wikinav', track.CLICK, {
					label: 'level-3'
				});

				$wkNavMenu.removeClass().addClass('cur3');
				$wikiNavH1.removeClass().addClass('animNext');

				setTimeout(function(){
					$wikiNavH1.text($element.text());
				}, 250);
			}
		});


		d.getElementById('wkNavBack').addEventListener('click', function() {
			if($wkNavMenu.hasClass('cur2')) {
				setTimeout(function(){
					$wkNavMenu.find('.lvl2.cur').removeClass().addClass('lvl2');
				}, 501);
				track.event('wikinav', track.CLICK, {
					label: 'level-1'
				});
				$wkNavMenu.removeClass().addClass('cur1');
				$wikiNavH1.removeClass().addClass('animBack');
			} else {
				setTimeout(function(){
					$wkNavMenu.find('.lvl3.cur').removeClass().addClass('lvl3');
					$wikiNavH1.removeClass();
				}, 501);

				$wikiNavH1.addClass('animBack');
				setTimeout(function(){
					$wikiNavH1.text($wkNavMenu.find('.lvl2.cur').prev().text());
				}, 250);

				handleHeaderLink(lvl2Link);

				track.event('wikinav', track.CLICK, {
					label: 'level-2'
				});

				$wkNavMenu.removeClass().addClass('cur2');
			}
		});

		$wikiNavLink.on('click', function(){
			track.event('wikinav', track.CLICK, {
				label: 'header-' + $wkNavMenu[0].className.slice(3)
			});
		});

		navSetUp = true;
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
		init: init,
		open: open,
		close: close
		//isOpen: isOpen
	};
});