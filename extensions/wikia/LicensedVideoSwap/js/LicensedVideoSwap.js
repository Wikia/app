require( ['wikia.querystring', 'wikia.localStorage', 'wikia.videoBootstrap'], function( QueryString, LocalStorage, VideoBootstrap) {

"use strict";

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
		this.initUndo();
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
		var that = this,
			$loading = $('<div class="loading-bg"></div>' ),
			$parent,
			$overlay,
			$row,
			$button,
			isSwap,
			currTitle,
			newTitle,
			title;

		function doRequest(){
			// Add loading graphic
			$loading.appendTo( that.$container );
			$overlay.addClass( 'loading' ).show();

			var data = {
				videoTitle: currTitle,
				sort: 'recent', // TODO: make this dynamic
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
						// update page html (this also gets rid of loading overlay)
						that.$container.html( data.html );
					}
				}
			});
		}

		function confirmModal() {
			var currTitleText =  currTitle.replace(/_/g, ' ' ),
				newTitleText,
				msg;

			if ( isSwap ) {
				newTitleText = newTitle.replace(/_/g, ' ' );
				title = $.msg( 'lvs-confirm-swap-title' );
				msg = $.msg( 'lvs-confirm-swap-message', currTitleText, newTitleText );
			} else {
				title = $.msg( 'lvs-confirm-keep-title' );
				msg = $.msg( 'lvs-confirm-keep-message', currTitleText );
			}

			$.confirm({
				title: title,
				content: msg,
				onOk: function() {
					doRequest();
				},
				width: 700
			});
		}

		// Event listener for interacting with buttons
		this.$container.on( 'mouseover mouseout click', '.swap-button, .keep-button', function( e ) {
			$button = $( this );

			$parent = $button.parent();
			$overlay = $parent.siblings( '.swap-arrow' );
			$row = $button.closest( '.row' );
			isSwap = $button.is( '.swap-button' );

			if ( isSwap ) {
				// swap button hovered
				if ( e.type == 'mouseover' ) {
					$overlay.fadeIn( 100 );
				} else if ( e.type == 'mouseout' ) {
					$overlay.fadeOut( 100 );
				// swap button clicked
				} else if ( e.type == 'click' ) {
					// Get both titles - current/non-premium video and video to swap it out with
					newTitle = decodeURIComponent( $button.attr( 'data-video-swap' ) );
					currTitle = decodeURIComponent( $row.find( '.keep-button' ).attr( 'data-video-keep' ) );
					confirmModal();
				}
			// Keep button clicked
			} else if ( e.type == 'click' ) {
				currTitle = decodeURIComponent( $row.find( '.keep-button' ).attr( 'data-video-keep' ) );
				// no new title b/c we're keeping the current video
				newTitle = '';
				confirmModal();
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
	},
	initUndo: function() {
		var that = this,
			videoTitle,
			newTitle,
			qs,
			sort,
			wasSwap;

		function doRequest() {
			$.nirvana.sendRequest({
				controller: 'LicensedVideoSwapSpecialController',
				method: 'restoreVideo',
				data: {
					videoTitle: videoTitle,
					newTitle: newTitle,
					sort: sort
				},
				callback: function( data ) {
					if( data.result == 'error' ) {
						window.GlobalNotification.show( data.msg, 'error' );
					} else {
						window.GlobalNotification.show( data.msg, 'confirm' );
						that.$container.html( data.html );
					}
				}
			});
		}

		$( 'body' ).on( 'click', '.global-notification .undo', function( e ) {
			e.preventDefault();

			var $this = $( this );

			videoTitle = $this.attr( 'data-video-title' );
			newTitle = $this.attr( 'data-new-title' ) || '';
			qs = new QueryString();
			sort = qs.getVal ( 'sort', 'recent' );
			wasSwap = !!newTitle;

			if ( wasSwap ) {
				$.confirm({
					title: $.msg( 'lvs-confirm-undow-swap-title' ),
					content: $.msg( 'lvs-confirm-undo-swap-message' ),
					onOk: function() {
						doRequest();
					},
					width: 700
				});
			} else {
				doRequest();
			}

		});
	}
};

$(function() {
	LVS.init.call( LVS );
});

});
