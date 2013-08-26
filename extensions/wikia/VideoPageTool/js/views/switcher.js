$(function( $, window) {
	$.fn.switcher = function( options ) {
		var $this = $( this ),
			$boxes,
			count,
			defaults = {};

		options = $.extend(defaults, options);

		$boxes = $this.find( options.boxes );
		count = $boxes.length;

		// Assign up and down arrows to each box
		$boxes.each( function() {
			var $box = $( this ),
				upArrow = $box.find( options.up ),
				downArrow = $box.find( options.down );
			$box.data( 'up-arrow', upArrow ).data( 'down-arrow', downArrow );
		});

		$boxes.eq( 0 ).data( 'up-arrow' ).attr( 'disabled', true );
		$boxes.eq( count - 1 ).data( 'down-arrow' ).attr( 'disabled', true );

		/*function isFirst( $elem ) {
			return ( $elem.index() == 0 );
		}

		function isLast( $elem ) {
			return ( $elem.index() == count );
		}*/

		return this.each( function() {
			/*var $this = $( this ),
				upArrow = $this.data( 'up-arrow' ),
				downArrow = $this.data( 'down-arrow' );

			upArrow.on( 'click', function( e ) {
				e.preventDefault();
				alert('up clicked');
			});
			downArrow.on( 'click', function( e ) {
				e.preventDefault();
				alert('down clicked');
			});*/

		});
	};
});
