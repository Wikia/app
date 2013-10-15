define( 'wikia.ui.modal', [ 'jquery' ], function( $ ) {
	"use strict";

	var BLACKOUT_CLASS = 'blackout',
		CLOSE_CLASS = 'close',
		$html = $('html');

	function Modal( id ) {
		var that = this;

		this.$element = $( '#' + id );
		this.$blackout = getBlackout();
		this.$close = this.$element.find( '.' + CLOSE_CLASS );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();
			this.hide();
		}, that ) );

		$(window).bind( 'resize', $.proxy( function () {
			this.calculateHeight();
		}, that ) );

		function getBlackout() {
			var blackoutId = BLACKOUT_CLASS + '_' + id,
				$blackout = $('#' + blackoutId );

			$blackout.click( $.proxy(function( event ) {
				event.preventDefault();

				if( this.isShown() ) {
					this.hide();
				}
			}, that) );

			return $blackout;
		}
	}

	Modal.prototype.show = function() {
		$html.addClass( 'modal-shown' );
		this.$element.addClass( 'shown' );
		this.$blackout.addClass( 'visible' );

		this.calculateHeight();
	};

	Modal.prototype.hide = function() {
		this.$element.removeClass( 'shown' );
		this.$blackout.removeClass( 'visible' );
		$html.removeClass( 'modal-shown' );
	};

	Modal.prototype.isShown = function() {
		return this.$element.hasClass( 'shown' );
	};

	Modal.prototype.close = function() {
		$(this).remove();
	};

	Modal.prototype.calculateHeight = function() {
		var $header = this.$element.find("header"),
			$section = this.$element.find("section"),
			$footer = this.$element.find("footer"),
			currentModalHeight = this.$element.outerHeight() || 0,
			currentHeaderHeight = $header.outerHeight() || 0,
			currentSectionHeight = $section.outerHeight() || 0,
			currentFooterHeight = $footer.outerHeight() || 0,
			// once the currentSectionHeight is higher than maxSection we're going to change positioning of footer
			// therefor, we need to multiply it here
			headerFooterHeightSum = currentHeaderHeight + ( 2 * currentFooterHeight ),
			maxSectionHeight = currentModalHeight - headerFooterHeightSum;

		if( currentSectionHeight > maxSectionHeight ) {
			$footer.css( "position", "relative" );
			$section.height( maxSectionHeight );
		}
	};

	/** Public API */
	return {
		init: function( id ) {
			return new Modal( id );
		}
	}
});
