(function ( window, $ ) {
	'use strict';

	var isTouchScreen = Wikia.isTouchScreen(),
		WikiHeader = {
			lastSubnavClicked: -1,
			isDisplayed: false,
			activeL1: null,

			editformSubmitAllowed: false,

			settings: {
				mouseoverDelay: isTouchScreen ? 0 : 200,
				mouseoutDelay: isTouchScreen ? 0 : 350
			},

			log: function ( msg ) {
				$().log( msg, 'WikiHeader' );
			},

			init: function ( isValidator ) {
				var suppressOnFocus = false;
				//Variables
				this.nav = $( '#WikiHeader > nav' );
				this.navLI = this.nav.find( '.nav-item' );
				this.subnav2 = this.nav.find( '.subnav-2' );
				this.subnav2LI = this.subnav2.find( '.subnav-2-item' );
				this.subnav3 = this.nav.find( '.subnav-3' );

				this.positionNav();

				//Events

				// Menu Main nodes
				this.nav
					// hover main menu nodes
					.on( 'mouseenter', '.nav-item', $.proxy( this.mouseoverL1, this ) )
					.on( 'mouseleave', '.nav-item', $.proxy( this.mouseoutL1, this ) )
					// click main menu nodes
					.on( 'click', '.nav-item', $.proxy( this.mouseclickL1, this ) )
					// focus main menu links
					.on( 'focus', '.nav-item > a', $.proxy( function ( event ) {
						this.showSubNavL2( $( event.target ).parent( 'li' ) );
					}, this ) );

				// Items in menu second level
				this.nav
					// hover second level menu items
					.on( 'mouseenter', '.subnav-2-item', $.proxy( this.mouseoverL2, this ) )
					.on( 'mouseleave', '.subnav-2-item', $.proxy( this.mouseoutL2, this ) )
					// click second level menu items
					.on( 'click', '.subnav-2-item', $.proxy( this.mouseclickL2, this ) )
					// focus second level menu links
					.on( 'focus', '.subnav-2-item > a', $.proxy( function ( event ) {
						this.hideNavL3();
						this.showSubNavL3( $( event.target ).parent( 'li' ) );
					}, this ) );

				//Accessibility Events
				//Show when any inner anchors are in focus
				// IE9 focus handling fix - see BugId:5914.
				// Assume keyboard-based navigation (IE9 focus handling fix).
				// Switch to browser's default onfocus behaviour when mouse-based navigation is detected  (IE9 focus handling fix).
				this.nav
					.on( 'mousedown', '.subnav-3 a', function () {
						suppressOnFocus = true;
					} )
					// Switch back to keyboard-based navigation mode  (IE9 focus handling fix).
					.on( 'mouseup', '.subnav-3 a', function () {
						suppressOnFocus = false;
					} )
					// The onfocus behaviour intended only for keyboard-based navigation (IE9 focus handling fix).
					.on( 'focus', '.subnav-3 a', $.proxy( function ( event ) {
						if ( !suppressOnFocus ) {
							this.hideNavL3();
							this.showSubNavL3( $( event.currentTarget ).closest( '.subnav' ).parent( 'li' ) );
						}
					}, this ) )
					//Hide when focus out of last anchor
					.on( 'focusout', '.subnav-3:last-child > li:last-child a', $.proxy( this.hideNavL3, this ) );

				// BugID: 64318 - hiding publish button on nav edit
				if ( (window.wgIsWikiNavMessage) && (window.wgAction === 'edit') ) {
					$( '#wpSave' ).hide();
					$( '#editform' ).submit( function ( ev ) {
						if ( !WikiHeader.editformSubmitAllowed ) {
							ev.stopImmediatePropagation();
							return false;
						}
					} );
					$( '#wpSummary' ).bind( 'keypress', function ( ev ) {
						if ( ev.keyCode === 13 /* enter */ && !WikiHeader.editformSubmitAllowed ) {
							// prevent tracking
							ev.stopImmediatePropagation();
						}
					} );
				}

				//Mouse out of browser
				$( document ).mouseout( $.proxy( function ( e ) {
					if ( this.isDisplayed ) {
						var from = e.relatedTarget || e.toElement;

						if ( !from || from.nodeName === 'HTML' ) {
							this.hideNavL3();
						}
					}
				}, this ) );

				// remove level 2 items not fitting into one row
				if ( !isValidator ) {
					var menu, items,
						itemHeight = this.subnav2LI.height(),
						itemsRemoved = 0;

					this.subnav2.each( function ( i ) {
						menu = $( this );

						if ( menu.height() > itemHeight ) {
							items = menu.children( 'li' ).reverse();

							if ( i > 0 ) {
								menu.css( 'visibility', 'hidden' ).show();
							}

							// loop through each menu item and remove it if doesn't fit into the first row
							items.each( function () {
								var item = $( this ),
									pos = item.position();

								if ( pos.top === 0 ) {
									// don't check next items
									return false;
								}
								else {
									item.remove();
									itemsRemoved++;
								}
							} );

							if ( i > 0 ) {
								menu.css( 'visibility', 'visible' ).hide();
							}
						}
					} );

					if ( itemsRemoved > 0 ) {
						this.log( 'items removed: ' + itemsRemoved );
					}
				}
			},

			mouseclickL1: function ( event ) {
				// Handle chat link
				var node = $( event.target ),
					otherSubnavs;

				if ( !$( event.currentTarget ).hasClass( 'marked' ) ) {
					event.preventDefault();
					this.subnav2LI.removeClass( 'marked2' );
					this.navLI.removeClass( 'marked' );
					this.hideNavL3();
					$( event.currentTarget ).addClass( 'marked' );

					//Hide all subnavs except for this one
					otherSubnavs = this.subnav2.not();
					if ( $( 'body' ).data( 'accessible' ) ) {
						otherSubnavs.css( 'top', '-9999px' );
					} else {
						otherSubnavs.hide();
					}

					this.activeL1 = event.currentTarget;
					this.showSubNavL2( event.currentTarget );
				}

				if ( node.is( 'a' ) && node.attr( 'data-canonical' ) === 'chat' ) {
					event.preventDefault();
					window.ChatWidget.onClickChatButton( node.attr( 'href' ) );
				}
			},

			mouseoverL1: function ( event ) {
				var self = event.currentTarget;
				// this menu is already opened - don't do anything
				if ( this.activeL1 === self ) {
					return;
				}

				this.mouseoverTimer = setTimeout( $.proxy( function () {
					//Hide all subnavs except for this one
					this.navLI.removeClass( 'marked' );
					this.hideNavL3();

					$( self ).addClass( 'marked' );
					//Hide all subnavs except for this one
					var otherSubnavs = this.subnav2.not();
					if ( $( 'body' ).data( 'accessible' ) ) {
						otherSubnavs.css( 'top', '-9999px' );
					} else {
						otherSubnavs.hide();
					}
					this.activeL1 = self;
					this.showSubNavL2( self );
				}, this ), this.settings.mouseoverDelay );
			},

			mouseoutL1: function () {
				//Stop mouseoverTimer
				clearTimeout( this.mouseoverTimer );
			},

			mouseclickL2: function ( event ) {
				//Hide all subnavs except for this one
				var otherSubnavs = this.subnav3.not( $( event.currentTarget ).find( '.subnav' ) );

				if ( $( event.currentTarget ).find( '.subnav' ).exists() && !$( event.currentTarget ).hasClass( 'marked2' ) ) {
					this.hideNavL3();
					event.preventDefault();
					$( event.currentTarget ).addClass( 'marked2' );
					if ( $( 'body' ).data( 'accessible' ) ) {
						otherSubnavs.css( 'top', '-9999px' );
					} else {
						otherSubnavs.hide();
					}
					this.showSubNavL3( event.currentTarget );
				}
			},

			mouseoverL2: function ( event ) {
				var self = event.currentTarget;

				//Stop mouseoverTimer
				clearTimeout( this.mouseoutTimer );

				this.mouseoverTimer = setTimeout( $.proxy( function () {
					//Hide all subnavs except for this one
					var otherSubnavs = this.subnav3.not( $( self ).find( '.subnav' ) );

					if ( $( 'body' ).data( 'accessible' ) ) {
						otherSubnavs.css( 'top', '-9999px' );
					} else {
						otherSubnavs.hide();
					}

					// remove other active states
					$( self ).siblings().removeClass( 'marked2' );

					this.showSubNavL3( self );
				}, this ), this.settings.mouseoverDelay );
			},

			mouseoutL2: function () {
				//Stop mouseoverTimer
				clearTimeout( this.mouseoverTimer );

				this.mouseoutTimer = setTimeout( $.proxy( function () {
					this.hideNavL3();
				}, this ), this.settings.mouseoutDelay );
			},

			showSubNavL2: function ( parent ) {
				var subnav = $( parent ).children( 'ul' );

				if ( subnav.exists() ) {
					subnav.show();
				}
			},

			showSubNavL3: function ( parent ) {
				var subnav = $( parent ).children( 'ul' );

				if ( subnav.exists() ) {
					$( parent ).addClass( 'marked2' );

					this.isDisplayed = true;
					subnav.css( 'top', this.navtop ).show();
				}
			},

			hideNavL3: function () {
				this.isDisplayed = false;
				this.lastSubnavClicked = -1;
				this.subnav2LI.removeClass( 'marked2' );

				//Hide subnav
				if ( $( 'body' ).data( 'accessible' ) ) {
					this.subnav3.css( 'top', '-9999px' );
				} else {
					this.subnav3.hide();
				}
			},

			positionNav: function () {
				//This runs once. Sets the proper top position of the subnav.
				// Can't be calculated earlier because custom font loading can adjust wiki nav height.
				this.navtop = this.nav.height() - 7;
			},

			firstMenuValidator: function () {
				var widthLevelFirst = 0,
					returnVal = true,
					menuNodes = $( '.ArticlePreview #WikiHeader > nav > ul > li' );

				menuNodes.reverse().each( $.proxy( function ( index, value ) {
					var item = $( value ),
						pos = item.position();

					if ( pos.top === 0 ) {
						// don't check next items
						return false;
					}
					else {
						returnVal = false;
						this.log( 'menu level #1 not valid' );
					}
				}, this ) );

				menuNodes.each( function ( menuItemKey, menuItem ) {
					widthLevelFirst += $( menuItem ).width();
				} );

				if ( widthLevelFirst > 550 ) {
					returnVal = false;
					this.log( 'menu level #1 not valid' );
				}

				return returnVal;
			},

			secondMenuValidator: function () {
				var widthLevelSecond = 0,
					returnVal = true,
					maxWidth = $( '#WikiaPage' ).width() - 280,
					menuNodes = $( '.ArticlePreview #WikiHeader .subnav-2' );

				$.each( menuNodes, $.proxy( function ( index, value ) {
					var menu = $( value );

					menu.show();
					$.each( menu.children( 'li' ), function () {
						widthLevelSecond += $( this ).width();
					} );
					menu.hide();

					if ( widthLevelSecond > maxWidth ) {
						returnVal = false;
						this.log( 'menu level #2 not valid' );
					}
					widthLevelSecond = 0;

				}, this ) );

				// show the first submenu
				menuNodes.eq( 0 ).show();
				return returnVal;
			}
		};

	$( function ( $ ) {
		WikiHeader.init();

		// modify preview dialog
		if ( window.wgIsWikiNavMessage ) {
			// preload messages
			$.getMessages( 'Oasis-navigation-v2' ).done( function () {
				// setup menu in preview mode
				$( window ).bind( 'EditPageAfterRenderPreview', function ( ev, previewNode ) {
					// don't style wiki nav like article content
					previewNode.removeClass( 'WikiaArticle' );
					WikiHeader.init( true );
					var firstMenuValid = WikiHeader.firstMenuValidator(),
						secondMenuValid = WikiHeader.secondMenuValidator(),
						menuParseError = !!previewNode.find( 'nav > ul' ).attr( 'data-parse-errors' ),
						errorMessages = [];

					if ( menuParseError ) {
						errorMessages.push( $.msg( 'oasis-navigation-v2-magic-word-validation' ) );
					}

					if ( !firstMenuValid && !secondMenuValid ) {
						errorMessages.push( $.msg( 'oasis-navigation-v2-level12-validation' ) );
					}
					else if ( !firstMenuValid ) {
						errorMessages.push( $.msg( 'oasis-navigation-v2-level1-validation' ) );
					}
					else if ( !secondMenuValid ) {
						errorMessages.push( $.msg( 'oasis-navigation-v2-level2-validation' ) );
					}

					if ( errorMessages.length > 0 ) {
						$( '#publish' ).remove();
						// TODO: use .getMessages
						new window.BannerNotification(
							errorMessages.join( '</br>' ),
							'error',
							$('.modalContent .ArticlePreview')
						).show();

					} else {
						WikiHeader.editformSubmitAllowed = true;
					}
					previewNode.find( 'nav > ul a' ).click( function () {
						if ( $( this ).attr( 'href' ) === '#' ) {
							return false;
						}
					} );

					previewNode.find( '.msg > a' ).click( function () {
						window.location = this.href;
					} );

				} );
			} );

			// disable submit on editform when preview is closed
			$( window ).bind( 'EditPagePreviewClosed', function () {
				WikiHeader.editformSubmitAllowed = false;
			} );

			// modify size of preview modal
			$( window ).bind( 'EditPageRenderPreview', function ( ev, options ) {
				options.width = ($( '#WikiaPage' ).width() - 271) /* menu width */ + 32 /* padding */;
			} );

			$( '#wpPreview' ).parent().removeClass( 'secondary' );
			// to set the toolbar height in wide mode (so the preview-validator-desc div fits)
			$( '#EditPageMain' ).addClass( 'editpage-wikianavmode' );
		}
	} );
})( this, jQuery );
