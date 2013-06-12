require( ['wikia.querystring', 'wikia.localStorage', 'wikia.videoBootstrap'], function( QueryString, LocalStorage, VideoBootstrap) {

var LVS = {
	init: function() {
		this.$container = $( '#LVSGrid' );
		this.videoWidth = this.$container.find( '.grid-3' ).first().width();

		this.initEllipses();
		this.initDropDown();
		this.initCallout();
		this.initMoreSuggestions();
		this.initSwapOrKeep();
		this.initPlay();
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
				var sort = $target.data( 'sort' ),
					qs = new QueryString();
				qs.setVal( 'sort', sort ).goTo();
			}
		});
	},
	/*
	 * This function controlls the callout box at the top of the page.
	 * When the "x" is clicked, a local storage entry is set so the
	 * callout won't show again.
	 */
	initCallout: function() {

		var $callout = $( '#WikiaArticle' ).find( '.lvs-callout' ),
			$closeBtn = $callout.find( '.close' );

		if ( !LocalStorage.lvsCalloutClosed ) {
			$callout.show();

			$closeBtn.on( 'click', function( e ) {
				e.preventDefault();
				$callout.slideUp();
				LocalStorage.lvsCalloutClosed = true;
			});
		}
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
	initSwapOrKeep: function() {
		function doRequest( isSwap, currTitle,  newTitle, $row ){
			var data = {
				videoTitle: currTitle,
				selectedSort: 'latest', // TODO: make this dynamic
				currentPage: 1 // TODO: make this dynamic
			};

			if ( isSwap ) {
				data.newTitle = newTitle;
			}

			$.nirvana.sendRequest({
				controller: 'LicensedVideoSwapSpecialController',
				method: isSwap ? 'swapVideo' : 'keepVideo',
				data: data,
				callback: function( data ) {
					if( data.result == 'error' ) {
						window.GlobalNotification.show( data.msg, 'error' );
					} else {
						window.GlobalNotification.show( data.msg, 'confirm' );

						$row.slideUp( function() {
							$row.remove();
						});
					}
				}
			});
		}

		function confirmModal( isSwap, currTitle, newTitle, $row ) {
			var currTitleText =  currTitle.replace(/_/g, ' ' ),
				newTitleText,
				msg;

			if ( isSwap ) {
				newTitleText = newTitle.replace(/_/g, ' ' );
				msg = $.msg( 'lvs-confirm-swap-message', currTitleText, newTitleText );
			} else {
				msg = $.msg( 'lvs-confirm-keep-message', currTitleText );
			}

			$.confirm({
				content: msg,
				onOk: function() {
					doRequest( isSwap, newTitle, currTitle, $row );
				},
				width: 700
			});
		}

		// Event listener for interacting with buttons
		this.$container.on( 'mouseover mouseout click', '.swap-button, .keep-button', function( e ) {
			var $this = $( this ),
				$parent = $this.parent(),
				$arrow = $parent.siblings( '.swap-arrow' ),
				$row = $this.closest( '.row' ),
				isSwap = $this.is( '.swap-button' ),
				newTitle,
				currTitle;

			if ( isSwap ) {
				// swap button hovered
				if ( e.type == 'mouseover' ) {
					$arrow.fadeIn( 100 );
				} else if ( e.type == 'mouseout' ) {
					$arrow.fadeOut( 100 );
				// swap button clicked
				} else if ( e.type == 'click' ) {
					// Get both titles - current/non-premium video and video to swap it out with
					newTitle = $this.attr( 'data-video-swap' );
					currTitle = $row.find( '.keep-button' ).attr( 'data-video-keep' );
					confirmModal( true, decodeURIComponent( currTitle ), decodeURIComponent( newTitle ), $row );
				}
			// Keep button clicked
			} else if ( e.type == 'click' ) {
				currTitle = $row.find( '.keep-button' ).attr( 'data-video-keep' );
				confirmModal( false, decodeURIComponent( currTitle ), null, $row );
			}
		});
	},
	initPlay: function() {
		var that = this;

		this.$container.on('click', '.video', function(e) {
			e.preventDefault();

			var $this = $( this ),
				fileTitle = decodeURIComponent( $this.children( 'img' ).attr( 'data-video-key' )),
				videoInstance,
				$element,
				$thumbList,
				$row = $this.closest( '.row' );

			$row.find( '.swap-button' ).attr( 'data-video-swap', fileTitle );

			if ( $this.hasClass( 'thumb' ) ) {
				// one of the thumbnails was clicked
				$element = $this.closest( '.row' ).find( '.premium .video-wrapper' );
				$thumbList = $this.closest( 'ul' );

				// put outline around the thumbnail that was clicked
				$thumbList.find( '.selected' ).removeClass( 'selected' );
				$this.addClass( 'selected' );
			} else {
				// Large image was clicked
				$element = $this.parent();
			}

			$.nirvana.sendRequest({
				controller: 'VideoHandler',
				method: 'getEmbedCode',
				data: {
					fileTitle: fileTitle,
					width: that.videoWidth,
					autoplay: 1
				},
				callback: function( data ) {
					videoInstance = new VideoBootstrap( $element[0], data.embedCode, 'licensedVideoSwap' );

					// Update swap button so it contains the dbkey of the video to swap
					$row.find( '.swap-button' ).attr( 'data-video-swap', fileTitle );
				}
			});
		});
	}
};

$(function() {
	LVS.init.call( LVS );
});

});
