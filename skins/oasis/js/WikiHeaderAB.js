$(function() {
	'use strict';
	var navigation;
	navigation = $( '#WikiHeader' ).detach();
	navigation.find( '.buttons' ).hide();
	navigation.find( '.WikiHeaderSearch' ).hide();
	navigation.removeClass( 'WikiHeader' ).addClass( 'WikiHeaderV2' );
	navigation.find( '.WikiNav' ).removeClass( 'WikiNav' ).addClass( 'WikiNavV2' );
	navigation.find( '.accent' ).removeClass( 'accent' );
	navigation.find( '.marked' ).removeClass( 'marked' );
	navigation.find( '.chevron' ).remove();

	navigation.find( '> nav' ).unbind();

	navigation.find( '.nav-item' ).each(function() {
		var elem = $( this ),
			seeAll = elem.find( '> a' ).clone().wrap('<section class="see-all"></section>').parent(),
			elem2 = elem.find( '.subnav-2' );
			elem2.wrap('<section class="submenu" data-elements="' + elem2.size() + '"></section>');
			// TODO i18n
			elem2.append( seeAll.text( 'See all in ' + seeAll.text() ) );
	});

	navigation.children().wrapAll('<section class="local-navigation-container"></section>');

	navigation.insertAfter( '#WikiaHeader' );

	$('.nav-item').click(function(e){
		e.preventDefault();

		$(this).toggleClass('active');
	});
});
