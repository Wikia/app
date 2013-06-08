$(function() {

var LVS = {
	init: function() {
		this.$container = $( '#LVSGrid' );

		this.initEllipses();
		this.initDropDown();
		this.initCallout();
		this.initMoreSuggestions();
		this.initSwap();
		this.initKeep();
	},
	/*
	 * The design calls for all of the "posted in" titles to be on one line.
	 * This function calculates whether or not we need to truncate that list
	 * and show a "more" link based on the width of that line.
	 */
	initEllipses: function() {
		var wrapperWidth,
			ellipsesWidth,
			truncatedWidth,
			undef;

		function initPopover( elem ) {
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
		}

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
				initPopover( $ellipses );
			}
		});
	},
	/**
	 * Set up the style guide dropdown to toggle sorting of videos
	 */
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
	/**
	 * Clicking on the more suggestions link will slide down a row of
	 * thumbnails that are additional possible matches for the non-premium
	 * video
	 */
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
	initSwap: function() {
		var that = this;

		function doRequest( newTitle, currTitle ){
			$.nirvana.sendRequest({
				controller: 'LicensedVideoSwapSpecialController',
				method: 'swapVideo',
				data: {
					videoTitle: currTitle,
					newTitle: newTitle
				},
				callback: function(data) {
					if( data.result == 'error' ) {
						window.GlobalNotification.show(data.msg, 'error');
					} else {
						window.GlobalNotification.show(data.msg, 'confirm');
					}
				}
			});
		}

		function confirmSwap( isSwap, currTitle, newTitle ) {
			var msg;

			currTitleText =  currTitle.replace(/_/g, ' ');

			newTitleText = newTitle.replace(/_/g, ' ');
			msg = $.msg( 'lvs-confirm-swap-message', currTitleText, newTitleText )

			$.confirm({
				content: msg,
				onOk: function() {
					doRequest( isSwap, newTitle, currTitle );
				},
				width: 700
			});
		}

		this.$container.on( 'mouseover mouseout click', '.swap-button', function( e ) {
			var $this = $( this ),
				$parent = $this.parent(),
				$arrow = $parent.siblings( '.swap-arrow' ),
				newTitle,
				currTitle;

			// swap button hovered
			if ( e.type == 'mouseover' ) {
				$arrow.fadeIn( 100 );
			} else if ( e.type == 'mouseout' ) {
				$arrow.fadeOut( 100 );
			// swap button clicked
			} else if ( e.type == 'click' ) {
				// Get both titles - current/non-premium video and video to swap it out with
				newTitle = $this.attr( 'data-video-swap' );
				currTitle = that.$container.find( '.keep-button' ).attr( 'data-video-keep' );
				confirmSwap( true, decodeURIComponent( currTitle ), decodeURIComponent( newTitle ) );
			}
		});
	},
	initKeep: function() {
		function doRequest( currTitle, $wrapper ) {
			$.nirvana.sendRequest({
				controller: 'LicensedVideoSwapSpecialController',
				method: 'skipVideo',
				data: {
					videoTitle: currTitle,
				},
				callback: function(data) {
					if( data.result == 'error' ) {
						window.GlobalNotification.show(data.msg, 'error');
					} else {
						window.GlobalNotification.show(data.msg, 'confirm');

						$wrapper.slideUp( function() {
							$wrapper.remove();
						})
					}
				}
			});
		}

		function confirmKeep( currTitle, $wrapper ) {
			var currTitleText =  currTitle.replace(/_/g, ' ');

			$.confirm({
				content: $.msg( 'lvs-confirm-keep-message', currTitleText ),
				onOk: function() {
					doRequest( currTitle, $wrapper );
				},
				width: 700
			});
		}

		this.$container.on( 'click', '.keep-button', function() {
			var $this = $( this ),
				$wrapper = $this.closest( '.row' );
				currTitle = $this.attr( 'data-video-keep' );

			confirmKeep( decodeURIComponent( currTitle ), $wrapper );
		});
	}
};

LVS.init();

});