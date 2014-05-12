$(function () {
	'use strict';
	var navigation = $('#WikiHeader').detach(),
		svgChevron = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg"' +
			' x="0px" y="0px" width="5px" height="9px" viewBox="0 0 5 9" ' +
			' enable-background="new 0 0 5 9" xml:space="preserve">' +
			' <polygon points="0.725,0 0,0.763 3.553,4.501 0,8.237 0.725,9 5,4.505 4.994,4.501 5,4.495"/> ' +
			' </svg>';

	$('.WikiaPageHeader').addClass('WikiaPageHeaderV2');
	navigation.find('.buttons').hide();
	navigation.find('.WikiHeaderSearch').hide();
	navigation.removeClass('WikiHeader').addClass('WikiHeaderV2');
	navigation.find('.WikiNav').removeClass('WikiNav').addClass('WikiNavV2');
	navigation.find('.accent').removeClass('accent');
	navigation.find('.marked').removeClass('marked');
	navigation.find('.chevron').remove();
	navigation.find('> nav').unbind();

	navigation.find('.nav-item').each(function () {
		var $this = $(this),
			$seeAll = $this.find('> a').clone(),
			$subNav = $this.find('.subnav-2'),
			$items = $subNav.children(),
			noOfItems = $items.length,
			sizeClass = '',
			$columns = $(),
			$columnUl,
			i = 0;

		$items.find('.subnav-2a').append(svgChevron);
		if (noOfItems === 3) {
			sizeClass = 'submenu-wide';
		} else if (noOfItems > 3) {
			sizeClass = 'submenu-full';
		} else {
			$this.addClass('nav-item-narrow');
		}
		$subNav.wrap('<section class="submenu ' + sizeClass + '"></section>')
			.parent().append($('<div class="clearfix"></div>') )
			// TODO i18n
			.append($seeAll.html('See all in ' + $seeAll.text() + svgChevron)
			.wrap('<section class="see-all"></section>').parent());

		for ( i = 0; i < 4; i++ ) {
			if ( $items.length > i ) {
				$columnUl = $( '<ul>' );
				$columnUl.append( $items.get( i ) );
				$columnUl.append( $items.get( i + 4 ) );

				$columns = $columns.add( $( '<li>' ).append( $columnUl ) );
			}
		}
		$subNav.append($columns);
	});

	navigation.children().wrapAll('<section class="local-navigation-container"></section>');
	navigation.insertAfter('#WikiaHeader');
});
