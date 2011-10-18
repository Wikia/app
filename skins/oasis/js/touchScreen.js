$(document).ready(function() {
	touchImprovements.init();
});

touchImprovements = {
	
	init: function() {
		
		//onload scroll to main content
		var wikiaMainContent = $( '#WikiaMainContent' ).offset();
		window.scrollTo( 0, wikiaMainContent.top ),
		wikiUls = $('#WikiHeader nav > ul > li > ul'),
		globalUls = $('#GlobalNavigation li > ul');

		//global nav fix: first click opens nav,  second redirects to a hub
		$( '#GlobalNavigation' ).delegate( 'li > a', 'click', function( event ) {
			var next = $( this ).next();
			if ( next.hasClass( 'subnav' ) && !next.hasClass('open') ) {
				event.preventDefault();
				globalUls.removeClass('open');
				next.addClass('open');
			};
		});

		//wiki nav fix: first click opens nav, second redirects to a desired page
		$( '#WikiHeader' ).delegate( 'nav > ul > li > a', 'click', function() {
			var subnav = $( this ).next( 'ul' );
			if ( subnav.length && !subnav.hasClass('open')) {
				event.preventDefault();
				wikiUls.removeClass('open');
				subnav.addClass('open');
			};
		});
		
		//user menu fix:
		$( '#AccountNavigation' ).delegate( 'a', 'click', function( event ) {
			var next = $( this ).next();
			if ( next.hasClass( 'subnav' ) && !next.hasClass('open') ) {
				event.preventDefault();
				$('#GlobalNavigation li > ul').removeClass('open');
				next.addClass('open');
			};
		});
	}
};
