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

( function( $ ) {

	'use strict';

	var Switcher = function( $element, options ) {
		var defaults = {
			up: '.nav-up',
			down: '.nav-down',
			boxes: '.form-box',
			onChange: false
		};

		this.$elem = $element;
		this.options = $.extend(defaults, options);
		this.init();
	};

	Switcher.prototype = {
		init: function() {
			this.setBoxes();

			this.count = this.$boxes.length;
			this.upArrows = this.$boxes.find( this.options.up );
			this.downArrows = this.$boxes.find( this.options.down );

			this.updateDisabled();
			this.bindEvents();

		},
		bindEvents: function() {
			var that = this;

			this.upArrows.on( 'click', this.handleUpClick );
			this.downArrows.on( 'click', this.handleDownClick );

			this.$elem.on( 'switched.switcher', function( e, data ) {
				that.updateDisabled();
				// Call extension's onChange callback
				that.options.onChange && that.options.onChange( data.box, data.elem );
			});
		},
		handleUpClick: function( e ) {
			e.preventDefault();

			var $box = $( this ).parent(),
				$prev = $box.prev();
			$box.insertBefore( $prev );

			$box.parent().trigger( 'switched.switcher', { box: $box, elem: $prev } );
		},
		handleDownClick: function( e ) {
			e.preventDefault();

			var $box = $( this ).parent(),
				$next = $box.next();
			$box.insertAfter( $next );

			$box.parent().trigger( 'switched.switcher', { box: $box, elem: $next } );
		},
		// Disable up button for first box and down button for last box
		updateDisabled: function() {
			this.setBoxes();

			this.upArrows.attr('disabled', false);
			this.downArrows.attr('disabled', false);

			this.$boxes.eq( 0 ).find( this.options.up ).attr( 'disabled', true );
			this.$boxes.eq( this.count - 1 ).find( this.options.down ).attr( 'disabled', true );
		},
		// Get jQuery array of boxes
		setBoxes: function () {
			this.$boxes = this.$elem.find( this.options.boxes );
		}

	};

	$.fn.switcher = function( options ) {
		return this.each( function() {
			var $this = $( this );
			$this.data('switcher', new Switcher( $this, options ))
		});
	};

})( jQuery );
