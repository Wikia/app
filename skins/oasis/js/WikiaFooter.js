/**
* global ToolbarCustomize:true
* global require
**/
var WikiaFooterApp = {

	init: function() {
		'use strict';
		//Variables
		if( window.wgEnableWikiaBarExt ) {
		//the admin tool bar is within wikia bar container which is outside the #WikiaPage
			this.footer = $( '#WikiaBarWrapper' ).find( '.wikia-bar' );
		} else {
		//the admin tool bar is positioned absolutely but in DOM in it's in #WikiaFooter within #WikiaPage
			this.footer = $( '#WikiaFooter' );
		}
		this.toolbar = this.footer.children( '.toolbar' );
		this.windowObj = $( window );
		this.originalWidth = this.toolbar.width();

		// avoid stack overflow in IE (RT #98938)
		if ( this.toolbar.exists() ) {
			if (
				!( navigator.platform in {'iPad':'', 'iPhone':'', 'iPod':''} ||
					( navigator.userAgent.match( /android/i ) !== null ) )
			) {
				this.addScrollEvent();
				this.addResizeEvent();
			}
			this.tcToolbar = new ToolbarCustomize.Toolbar( this.footer.find( '.tools' ) );
		}
	},
	addScrollEvent: function() {
		'use strict';
		WikiaFooterApp.windowObj.off( 'scroll.FooterAp' );
		WikiaFooterApp.windowObj.on( 'scroll.FooterAp', WikiaFooterApp.resolvePosition ).triggerHandler( 'scroll' );
	},
	addResizeEvent: function (){
		'use strict';
		WikiaFooterApp.windowObj.on( 'resize', WikiaFooterApp.centerBar ).triggerHandler( 'resize' );
	},
	centerBar: function() {
		'use strict';
		var w = WikiaFooterApp.windowObj.width();
		if ( w < WikiaFooterApp.originalWidth && WikiaFooterApp.footer.hasClass( 'float' ) ) {
			WikiaFooterApp.toolbar.css( 'width', w + 10 );
			if ( !WikiaFooterApp.toolbar.hasClass( 'small' ) ) {
				WikiaFooterApp.toolbar.addClass( 'small' );
			}
		} else if ( WikiaFooterApp.toolbar.hasClass( 'small' ) ) {
			WikiaFooterApp.toolbar.css( 'width', WikiaFooterApp.originalWidth );
			WikiaFooterApp.toolbar.removeClass( 'small' );
		}
		WikiaFooterApp.resolvePosition();
	},
	// this is called while scrolling
	resolvePosition: function() {
		'use strict';
		// Disable floating for RTE
		if ( window.wgIsEditPage ) {
			return;
		}

		var scrollTop = WikiaFooterApp.windowObj.scrollTop(),
			scroll = scrollTop + WikiaFooterApp.windowObj.height(),
			line = 0;

		if ( WikiaFooterApp.footer.offset() ) {
			line = WikiaFooterApp.footer.offset().top + WikiaFooterApp.toolbar.outerHeight();
		}

		if ( scroll > line && WikiaFooterApp.footer.hasClass( 'float' ) ) {
			WikiaFooterApp.footer.removeClass( 'float' );
			WikiaFooterApp.centerBar();
		} else if ( scroll < line && !WikiaFooterApp.footer.hasClass( 'float' ) ) {
			WikiaFooterApp.footer.addClass( 'float' );
			WikiaFooterApp.centerBar();
		}
	}
};

( function() {
	'use strict';
	window.ToolbarCustomize = window.ToolbarCustomize || {};
	var TC = window.ToolbarCustomize;

	TC.MenuGroup = $.createClass( window.Observable, {

		showTimer: false,
		hideTimer: false,

		showTimeout: 300,
		hideTimeout: 350,

		showing: false,
		visible: false,

		constructor: function() {
			TC.MenuGroup.superclass.constructor.call( this );
			this.showTimer = window.Timer.create( $.proxy( this.show, this ), this.showTimeout );
			this.hideTimer = window.Timer.create( $.proxy( this.hide, this ), this.hideTimeout );
		},

		add: function( el ) {
			var e = $( el );
			e.unbind( '.menugroup' )
				.bind( 'mouseenter.menugroup', $.proxy( this.delayedShow, this ) )
				.bind( 'mouseleave.menugroup', $.proxy( this.delayedHide, this ) )
				.children( 'a', 'img' )
					.unbind( '.menugroup' )
					.bind( 'click.menugroup', $.proxy( this.showOnClick, this ) );
		},

		remove: function( el ) {
			$( el ).unbind( '.menugroup' )
				.children( 'a', 'img' )
					.unbind( '.menugroup' );
		},

		show: function() {
			this.hideTimer.stop();
			this.showTimer.stop();
			if ( !this.showing || this.visible === this.showing ) {
				return;
			}

			if ( this.visible ) {
				this.hide();
			}
			if ( this.showing ) {
				this.visible = this.showing;
				this.showing = false;
				this.fire( 'menushow', this, this.visible, this.visible.children( 'ul' ) );
				this.visible.children( 'ul' ).show();
			}
		},

		delayedShow: function( evt ) {
			this.showing = $( evt.currentTarget );
			if ( this.visible ) {
				this.show( evt );
			} else {
				this.hideTimer.stop();
				this.showTimer.start();
			}
		},

		showOnClick: function( evt ) {
			evt.preventDefault();
			this.showing = $( evt.currentTarget ).parent();
			this.show( evt );
		},

		hide: function() {
			this.hideTimer.stop();
			this.showTimer.stop();
			if ( this.visible ) {
				this.fire( 'menuhide', this, this.visible, this.visible.children( 'ul' ) );
				this.visible.children( 'ul' ).hide();
				this.visible = false;
			}
		},

		delayedHide: function() {
			this.hideTimer.stop();
			if ( this.visible ) {
				this.hideTimer.start();
			} else if ( this.showing ) {
				this.showing = false;
				this.showTimer.start();
			}
		}

	} );

	TC.Toolbar = $.createClass( Object, {

		el: false,
		more: false,

		menuGroup: false,

		constructor: function ( el ) {
			TC.Toolbar.superclass.constructor.call( this );
			this.el = el;
			this.menuGroup = new TC.MenuGroup();
			this.menuGroup.bind( 'menushow', this.onShowMenu, this );
			this.initialize();
		},

		initialize: function() {
			this.el.find( '.tools-customize' ).click( $.proxy( this.openConfiguration, this ) );
			this.menuGroup.add( this.el.find( 'li.menu' ) );

			var that = this;

			//Attach event listener to an event which is triggered after updating user tools
			$('body').on('userToolsItemAdded', function(event, data) {
				that.load(data);
			});

			require( ['wikia.fluidlayout'], function( fluidlayout ) {
				that.handleOverflowMenu( fluidlayout.getBreakpointSmall(), 2 * fluidlayout.getAdSkinWidth(),
					window.wgOasisResponsive ? false : fluidlayout.getBreakpointSmall() );
			});
		},

		openConfiguration: function( evt ) {
			evt.preventDefault();
			require( ['wikia.toolsCustomization'], function( TC ) {
				new TC.ToolsCustomization( this).show();
				return false;
			} );
		},

		buildOveflowItem: function () {
			return this.el.find( '.overflow-menu' );
		},

		generateMediaQuery: function ( moreable, minWidth, breakpoint, gapWidth, nonResponsiveBreakpoint ) {
			var firstMediaJSQuery = true,
				mediaJSQueries = '',
				moreableCount = moreable.length,
				alreadyAdded = ( minWidth >= breakpoint ),
				lastMediaQuery = false;

			moreable.each( function ( i, v ) {
				var elemWidth = $( v ).outerWidth( true );

				if ( nonResponsiveBreakpoint !== false && ( minWidth + elemWidth > nonResponsiveBreakpoint ) ) {
					lastMediaQuery = true;
				}

				if ( !alreadyAdded && ( ( minWidth + elemWidth ) >= breakpoint ) ) {
					alreadyAdded = true;
					elemWidth += gapWidth;
				}

				mediaJSQueries += '@media screen ';
				if ( !firstMediaJSQuery ) {
					mediaJSQueries += 'and (min-width:' + minWidth + 'px) ';
				}

				if ( !lastMediaQuery ) {
					mediaJSQueries += 'and (max-width:' + ( minWidth + elemWidth ) + 'px) ';
				}

				mediaJSQueries += '{ .WikiaBarWrapper .tools > .overflow:nth-of-type(n + ' + ( i + 1 ) +
					') { display:none; } ' + '.WikiaBarWrapper .tools .overflow-menu {  display: block; }' +
					'.WikiaBarWrapper .tools .overflow-menu .overflow:nth-of-type(-n + ' + ( moreableCount - i ) +
					') { display:block; }} ';

				if ( lastMediaQuery ) {
					return false;
				}

				minWidth += elemWidth;

				firstMediaJSQuery = false;
			} );

			return mediaJSQueries;
		},
		getMinWidth: function( all ) {
			var arrow = this.el.parents( '.wikia-bar:first' ).find( '.arrow' ),
				minWidth = parseInt( this.el.css( 'padding-left' ), 10 ) +
					parseInt( this.el.css( 'padding-right' ), 10 ) +
					arrow.outerWidth( true ),
				notMoreable = all.filter( ':not(.overflow)' );

			notMoreable.each( function( i, v ) {
				minWidth += $( v ).outerWidth( true );
			} );

			return minWidth;
		},

		generateSubMenu: function( moreable ) {
			var where = moreable.last().next(),
				liMore = this.buildOveflowItem(),
				more = liMore.children( 'ul' ).empty();

			if ( where.exists() ) {
				where.before (liMore );
			} else {
				this.el.append( liMore );
			}

			moreable.each( function ( i, v ) {
				$( v ).clone().prependTo( more );
			} );
			this.menuGroup.add( liMore,$.proxy( this.onShowMenu,this ) );
		},
		addStyles: function( mediaJsQueries ) {
			var id = 'WikiaFooterMediaQueries',
				styles = '<style id="' + id + '" type"text/css">' + mediaJsQueries + '</style>';

			// <style> tag in IE 8 is read-only so it needs to be created from scratch each time
			$( '#' + id ).remove();
			$( 'head' ).append( styles );
		},

		handleOverflowMenu: function ( breakpoint, gapWidth, nonResponsiveBreakpoint ) {
			var all = this.el.children( 'li' ),
				moreable = all.filter( '.overflow' ),
				minWidth = this.getMinWidth( all );

			this.addStyles( this.generateMediaQuery( moreable, minWidth, breakpoint, gapWidth,
				nonResponsiveBreakpoint ) );

			this.generateSubMenu( moreable );
		},

		onShowMenu: function( mgroup, li, ul ) {
			ul.css( 'left', ( li.offset().left-this.el.offset().left ) + 'px' );
			ul.css( 'right', 'auto' );
		},

		load: function( html ) {
			this.el.children( 'li' ).not( '.loadtime' ).remove();
			this.el.prepend( $( html ) );
			this.initialize();
		}

	} );
})();

$( function() {
	'use strict';

	WikiaFooterApp.init();
} );
