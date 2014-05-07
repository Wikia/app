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
			newItem = elem.find( '> a' ).clone();

		elem.find( '.subnav-2' ).wrap('<section class="submenu"></div>' )
			// TODO i18n
			.parent().append( newItem.text( 'See all in ' + newItem.text() ) );
	});

	navigation.insertAfter( '#WikiaHeader' );
});
