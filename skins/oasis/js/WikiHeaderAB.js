jQuery(function () {
	'use strict';
	var navigation = jQuery('#WikiHeader'),
		svgChevron = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg"' +
			' x="0px" y="0px" width="5px" height="9px" viewBox="0 0 5 9" ' +
			' enable-background="new 0 0 5 9" xml:space="preserve">' +
			' <polygon points="0.725,0 0,0.763 3.553,4.501 0,8.237 0.725,9 5,4.505 4.994,4.501 5,4.495"/> ' +
			' </svg>';

	// COLORS
	(function(){
		/*jshint multistr: true */
		var headerLinkColor = jQuery('.WikiHeader .nav-item:not(.marked) > a').css('color') || '#fff',
      headerBackgroundColor = jQuery('.WikiaPage .WikiaPageBackground').css('background-color') || '#000',
      linkColor = jQuery('.WikiHeader > nav li.marked > a').css('color') || '#fff',
			backgroundColor = jQuery('.WikiHeader > nav li.marked').css('background-color') || '#000',
			css = '.WikiHeaderV2 { \
		background: $header-color-global; \
	} \
		.WikiHeaderV2 .wordmark.text a { \
		color: $header-color-link-primary; \
	} \
 \
	.WikiNavV2 .nav-item > a { \
		background: transparent; \
		color: $header-color-link-primary; \
	} \
	.WikiNavV2 .nav-item > a:hover, .WikiNavV2 .nav-item > a:active { \
		background: $header-color-background; \
		color: $header-color-link; \
	} \
	.WikiNavV2 .nav-item:hover > a, .WikiNavV2 .nav-item:active > a, .WikiNavV2 .nav-item.active > a { \
		background: $header-color-background; \
		color: $header-color-link; \
	} \
	.WikiNavV2 .nav-item .submenu { \
		background: $header-color-background; \
		color: $header-color-link; \
	} \
	.WikiNavV2 .nav-item .submenu .subnav-2a { \
		border-bottom: 1px solid $header-color-link; \
	} \
	.WikiNavV2 .nav-item .submenu .subnav-2a svg polygon { \
		fill: $header-color-link; \
	} \
	.WikiNavV2 .nav-item .submenu .see-all { \
		border-top: 1px solid $header-color-link; \
	} \
	.WikiNavV2 .nav-item .submenu .see-all svg polygon { \
		fill: $header-color-link; \
	} \
	'.replace(/\$header-color-global/g, headerBackgroundColor)
    .replace(/\$header-color-link-primary/g, headerLinkColor)
    .replace(/\$header-color-link/g, linkColor)
    .replace(/\$header-color-background/g, backgroundColor),
			head = document.head || document.getElementsByTagName('head')[0],
			style = document.createElement('style');

		style.type = 'text/css';
		if (style.styleSheet){
			style.styleSheet.cssText = css;
		} else {
			style.appendChild(document.createTextNode(css));
		}

		head.appendChild(style);
	})();
  
  // NAVIGATIOn

	jQuery('.WikiaPageHeader').addClass('WikiaPageHeaderV2');
  navigation.detach();
	navigation.find('.buttons').hide();
	navigation.find('.WikiHeaderSearch').hide();
	navigation.removeClass('WikiHeader').addClass('WikiHeaderV2');
	navigation.find('.WikiNav').removeClass('WikiNav').addClass('WikiNavV2');
	navigation.find('.accent').removeClass('accent');
	navigation.find('.marked').removeClass('marked');
	navigation.find('.chevron').remove();
	navigation.find('> nav').unbind();

	navigation.find('.nav-item').each(function () {
		var $this = jQuery(this),
			$seeAll = $this.find('> a').clone(),
			$subNav = $this.find('.subnav-2'),
			$items = $subNav.children(),
			noOfItems = $items.length,
			submenuClasses = 'submenu',
			seeAllText = (noOfItems > 1) ? ('See all in ' + $seeAll.text()) : 'See all',
			$columns = jQuery(),
			$columnUl,
			columnsCount = 0,
			i = 0;

		$items.find('.subnav-2a').append(svgChevron);
		if (noOfItems === 3) {
			submenuClasses += ' submenu-wide';
		} else if (noOfItems > 3) {
			submenuClasses += ' submenu-full';
		} else {
      submenuClasses += ' submenu-width-' + noOfItems;
			$this.addClass('nav-item-narrow');
		}

		$subNav.wrap('<section class="' + submenuClasses + '"></section>')
			.parent().append($('<div class="clearfix"></div>'));

		if ($seeAll.attr('href') !== '#') {
			$subNav.parent().append($seeAll.html(seeAllText + svgChevron)
				.wrap('<section class="see-all"></section>').parent());
		} else {
			$this.addClass('no-see-all');
		}

		columnsCount = Math.min(4, $items.length);
		for (i = 0; i < columnsCount; i++) {
			$columnUl = $('<ul class="subnav-2-column">');
			$columnUl.append($items.get(i));
			$columnUl.append($items.get(i + 4));

			$columns = $columns.add(jQuery('<li class="subnav-2-column-wrapper">').append($columnUl));
		}
		$subNav.append($columns);
	});

	navigation.children().wrapAll('<section class="local-navigation-container"></section>');
	navigation.insertAfter('#WikiaHeader');
  
  // touch devices
  if ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch) {
  jQuery('.nav-item > a').on('click', function(e){
                         e.preventDefault();
                         //jQuery('.nav-item').removeClass('active');
                         //jQuery(this).addClass('active');
   });
  }
  
  // tracking
  window['optimizely'] = window['optimizely'] || [];
  jQuery('.nav-item').on('mouseenter', function (e) {
      window.optimizely.push(['trackEvent', 'nav-item_hover']);
  });
  
  jQuery('#WikiHeader').on('mousedown', 'a', function(e) {
    
		var label,
			el = $(e.target);

		// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

		if (el.closest('.wordmark').length > 0) {
			label = 'wordmark';
		} else if (el.closest('.WikiNavV2').length > 0) {
			var canonical = el.data('canonical');
			if (canonical !== undefined) {
				switch(canonical) {
					case 'wikiactivity':
						label = 'on-the-wiki-activity';
						break;
					case 'random':
						label = 'on-the-wiki-random';
						break;
					case 'newfiles':
						label = 'on-the-wiki-new-photos';
						break;
					case 'chat':
						label = 'on-the-wiki-chat';
						break;
					case 'forum':
						label = 'on-the-wiki-forum';
						break;
					case 'videos':
						label = 'on-the-wiki-videos';
						break;
				}
			} else if (el.parent().hasClass('nav-item')) {
				label = 'custom-level-1';
			} else if (el.parent().hasClass('see-all')) {
				label = 'custom-level-1';
			} else if (el.hasClass('subnav-2a')) {
				label = 'custom-level-2';
			} else if (el.hasClass('subnav-3a')) {
				label = 'custom-level-3';
			}
		}

		if (label !== undefined) {
     window.optimizely.push(['trackEvent', label + '_clicks']);
			Wikia.Tracker.track({
				action: Wikia.Tracker.ACTIONS.CLICK,
				trackingMethod: 'ga',
				browserEvent: e,
				category: 'wiki-nav',
				label: label
			});
		}
	});
});
