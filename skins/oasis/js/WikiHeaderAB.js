$(function () {
	'use strict';
	var navigation;
	navigation = $('#WikiHeader').detach();
	navigation.find('.buttons').hide();
	navigation.find('.WikiHeaderSearch').hide();
	navigation.removeClass('WikiHeader').addClass('WikiHeaderV2');
	navigation.find('.WikiNav').removeClass('WikiNav').addClass('WikiNavV2');
	navigation.find('.accent').removeClass('accent');
	navigation.find('.marked').removeClass('marked');
	navigation.find('.chevron').remove();

	navigation.find('> nav').unbind();

	navigation.find('.nav-item').each(function () {
		var elem = $(this),
			seeAll = elem.find('> a').clone(),
			elem2 = elem.find('.subnav-2'),
			length = elem.find('.subnav-2 > li').length,
			sizeClass = '';

		if (length === 3) {
			sizeClass = 'submenu-wide';
		} else if (length > 3) {
			sizeClass = 'submenu-full';
		} else {
			sizeClass = '';
		}
		elem2.wrap('<section class="submenu ' + sizeClass + '"></section>');
		elem2.append($('<div class="clearfix"></div>'));
		// TODO i18n
		elem2.append(seeAll.text('See all in ' + seeAll.text()).wrap('<section class="see-all"></section>').parent());
	});

	navigation.children().wrapAll('<section class="local-navigation-container"></section>');

	navigation.insertAfter('#WikiaHeader');

	// temp
	$('.nav-item').click(function (e) {
		e.preventDefault();

		$(this).toggleClass('active');
	});
});
