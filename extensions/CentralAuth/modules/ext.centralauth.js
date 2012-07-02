( function ( mw, $, undefined ) {
	var cursorPosition, $methodHint;

	cursorPosition = {
		x : 0,
		y : 0
	};

	$(document).on( 'mousemove', function updateCursorPosition( e ) {
		cursorPosition.x = 
			e.clientX
			+ ( document.documentElement.scrollLeft || document.body.scrollLeft )
			- document.documentElement.clientLeft;

		cursorPosition.y =
			e.clientY
			+ ( document.documentElement.scrollTop || document.body.scrollTop )
			- document.documentElement.clientTop;
	} );

	function showMethodHint( methodName ) {
		var content, hintHtml;

		if ( !$methodHint ) {
			$methodHint = $( '<div>' )
				.addClass( 'merge-method-help-div' )
				.hide()
				.click( function () {
					$(this).fadeOut();
				} );

			content = document.getElementById( 'content' ) || document.getElementById( 'mw_content' ) || document.body;
			$(content).append( $methodHint );
		}
	
		hintHtml = mw.html.element( 'p', {
			'class': 'merge-method-help-name'
		}, mw.msg( 'centralauth-merge-method-' + methodName ) ) + mw.message( 'centralauth-merge-method-' + methodName + '-desc' ).escaped();
	
		$methodHint
			.html( hintHtml )
			.css({
				left: cursorPosition.x + 'px',
				top: cursorPosition.y + 'px'
			});

		$methodHint.fadeIn();
	}

	$( document ).ready( function () {
		// Bind an event listener to the common parent of all (?) elements
		$( '.mw-centralauth-wikislist' ).on( 'click', '.merge-method-help', function () {
			showMethodHint( $(this).data( 'centralauth-mergemethod' ) );
		} );
	} );

}( mediaWiki, jQuery ) );
