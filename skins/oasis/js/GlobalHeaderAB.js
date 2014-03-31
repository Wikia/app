// TODO move it somewhere
$(function() {
	$( '#GlobalNavigation' ).addClass( 'vertical-colors' );

	function addSearch() {
		var li = $('<li>' ),
			form = $('<form>' )
				.addClass( 'search-form' )
				.attr( 'method', 'get' )
				.attr( 'action', window.wgGlobalSearchUrl );

		$('<input>')
			.addClass( 'search-box' )
			.attr( 'type', 'text' )
			.attr( 'accesskey', 'f' )
			.attr( 'autocomplete', 'off' )
			.attr( 'name', 'search' )
			//TODO i18n
			.attr( 'placeholder', 'Search for topics brand and content' )
			.appendTo( form );
		$('<input>' )
			.attr( 'type', 'hidden' )
			.attr( 'name', 'resultsLang')
			.val( window.wgUserLanguage)
			.appendTo( form );
		$('<input>')
			.addClass( 'search-button' )
			.attr( 'type', 'submit' )
			// TODO i18n
			.val( 'Search all Wikia' )
			.appendTo( form );

		li.append( form );
		$( '#WikiaHeader' ).find( '.start-a-wiki' ).after( li );
	}

	// TODO prepare methods
	addSearch();
	$( '#WikiaHeader' ).find( '.search-form' ).addClass( 'search-collapsed' );
	$( '#WikiaHeader' ).find( '.search-button' ).addClass( 'search-icon' );
	$( '#search-v2-form' ).find( '.SearchInput' ).remove();
});
