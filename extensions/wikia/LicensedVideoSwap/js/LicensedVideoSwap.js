$(function() {

var LVS = {
	init: function() {
		this.$container = $( '#LVSGrid' );

		this.initEllipses();
		this.initDropDown();
		this.initCallout();
		this.initMoreSuggestions();
		this.initSwapArrow();
	},
	/*
	 * The design calls for all of the "posted in" titles to be on one line.
	 * This function calculates whether or not we need to truncate that list
	 * and show a "more" link based on the width of that line.
	 */
	initEllipses: function() {
		var that = this,
			wrapperWidth,
			ellipsesWidth,
			truncatedWidth,
			undef;

		this.$container.find('.posted-in').each(function() {
			var $this = $( this ),
				$msg = $this.children( 'div' ),
				msgWidth = $msg.width(),
				$ellipses = $this.find( '.ellipses' );

			// get constant DOM widths only once
			if ( ellipsesWidth === undef ) {
				ellipsesWidth = $ellipses.width();
				// get wrapper width
				wrapperWidth = $this.width();
				// calculate width to truncate to
				truncatedWidth = wrapperWidth - ellipsesWidth;
			}

			if ( msgWidth > wrapperWidth ) {
				$msg.addClass( 'processed' ).width( truncatedWidth );
				$ellipses.show();
				that.initPopover.call( that, $ellipses );
			}
		});
	},
	initDropDown: function() {
		$( '.WikiaDropdown' ).wikiaDropdown({
			onChange: function( e, $target ) {
				//TODO: add change event here
			}
		});
	},
	/*
	 * This function controlls the callout box at the top of the page.
	 * When the "x" is clicked, a local storage entry is set so the
	 * callout won't show again.
	 */
	initCallout: function() {
		require( ['wikia.localStorage'], function( ls ) {

			var $callout = $( '#WikiaArticle' ).find( '.lvs-callout' ),
				$closeBtn = $callout.find( '.close' );

			if ( !ls.lvsCalloutClosed ) {
				$callout.show();

				$closeBtn.on( 'click', function( e ) {
					e.preventDefault();
					$callout.slideUp();
					ls.lvsCalloutClosed = true;
				});
			}
		});
	},
	initMoreSuggestions: function() {
		this.$container.on( 'click', '.more-link', function( e ) {
			e.preventDefault();
			var $this = $( this ),
				$toggleDiv = $this.parent().next( '.more-videos' );

			if ( $this.hasClass( 'expanded' ) ) {
				$this.removeClass( 'expanded' );
				$toggleDiv.slideUp();
			} else {
				$this.addClass( 'expanded' );
				$toggleDiv.slideDown();
			}

		});
	},
	initSwapArrow: function() {
		var that = this;

		this.$container.on( 'mouseover mouseout click', '.swap-button', function( e ) {
			var $this = $( this ),
				$parent = $this.parent(),
				$arrow = $parent.siblings( '.swap-arrow' ),
				$wrapper = $parent.parent();

			if ( e.type == 'mouseover' ) {
				$arrow.fadeIn( 100 );
			} else if ( e.type == 'mouseout' ) {
				$arrow.fadeOut( 100 );
			} else if ( e.type == 'click' ) {
				that.handleSwap.call( that, $this, $arrow, $wrapper );
			}
		});
	},
	initPopover: function( elem ) {
		var popoverTimeout = 0;

		function setPopoverTimeout() {
			popoverTimeout = setTimeout( function() {
				elem.popover( 'hide' );
			}, 300 );
		}

		elem.popover({
			trigger: 'manual',
			placement: 'top',
			content: function() {
				var list = elem.next().find('ul').clone(),
					details = list.wrap( '<div class="details"></div>' );

				return details.parent();
			}
		}).on( 'mouseenter', function() {
			clearTimeout( popoverTimeout );
			$( '.popover' ).remove();
			elem.popover( 'show' );

		}).on('mouseleave', function() {
			setPopoverTimeout();
			$( '.popover' ).mouseenter( function() {
				clearTimeout( popoverTimeout );
			}).mouseleave( function() {
				setPopoverTimeout();
			});
		});

	},
	handleSwap: function( button, $arrow, $wrapper ) {
        $.confirm({
	        content: $.msg( 'lvs-confirm-swap-message' ),
	        onOk: function(){
		        // TODO: add ajax request here
	        },
	        width: 700
        });

		/*button.hide();
		$arrow.show();
		$wrapper.find( '.non-premium' ).fadeOut();*/
	}
};

LVS.init();

});