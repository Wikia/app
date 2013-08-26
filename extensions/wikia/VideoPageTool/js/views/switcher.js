/**
 * jQuery plugin Switcher:
 *
 * Move elements up and down by clicking up and down buttons inside each element.
 * The top and bottom elements will have the top and bottom buttons disabled respectively.
 *
 * Options:
 *  up: jQuery selector string to identify up buttons
 *  down: jQuery selector string to identify down buttons
 *  boxes: jQuery selector string to identify elements to be moved up and down
 *  onChange: function to be called after elements are moved up or down
 *
 * @author Liz Lee <liz@wikia-inc.com>
 */

$(function( $, window) {
	$.fn.switcher = function( options ) {
		var $this = $( this ),
			$boxes,
			count,
			upArrows,
			downArrows,
			defaults = {
				up: '.nav-up',
				down: '.nav-down',
				boxes: '.form-box',
				onChange: false
			};

		options = $.extend(defaults, options);

		// runs once at the begining
		function initBoxes() {
			setBoxes();

			count = $boxes.length;
			upArrows = $boxes.find( options.up );
			downArrows = $boxes.find( options.down );

			updateDisabled();
		}

		// Get jQuery array of boxes
		function setBoxes() {
			$boxes = $this.find( options.boxes );
		}

		// Disable up button for first box and down button for last box
		function updateDisabled() {
			setBoxes();

			upArrows.attr('disabled', false);
			downArrows.attr('disabled', false);

			$boxes.eq( 0 ).find( options.up ).attr( 'disabled', true );
			$boxes.eq( count - 1 ).find( options.down ).attr( 'disabled', true );
		}

		return this.each( function() {
			initBoxes();

			upArrows.on( 'click', function( e ) {
				e.preventDefault();

				var $box = $( this ).parent(),
					$prev = $box.prev();
				$box.insertBefore( $prev );

				updateDisabled();

				options.onChange && options.onChange( $box, $prev );
			});

			downArrows.on( 'click', function( e ) {
				e.preventDefault();

				var $box = $( this ).parent(),
					$next = $box.next();
				$box.insertAfter( $next );

				updateDisabled();

				options.onChange && options.onChange( $box, $next );
			});
		});
	};
});
