/*!
 * VisualEditor MediaWiki ViewPageTarget init.
 *
 * This file must remain as widely compatible as the base compatibility
 * for MediaWiki itself (see mediawiki/core:/resources/startup.js).
 * Avoid use of: ES5, SVG, HTML5 DOM, ContentEditable etc.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw, veTrack, Wikia */

/**
 * Platform preparation for the MediaWiki view page. This loads (when user needs it) the
 * actual MediaWiki integration and VisualEditor library.
 *
 * @class ve.init.mw.WikiaViewPageTarget.init
 * @singleton
 */
( function () {
	var conf, tabMessages, uri, pageExists, viewUri, veEditUri, viewPage,
		init, support, getTargetDeferred, $edit, $veEdit, vePreferred,
		plugins = [], veUIEnabled, browserSupported,
		// Used by tracking calls that go out before ve.track is available.
		trackerConfig = {
			'category': 'editor-ve',
			'trackingMethod': 'both'
		},
		indicatorTimeoutId = null;

	function initIndicator() {
		var $indicator = $( '<div>' )
				.addClass( 've-indicator visible' )
				.attr( 'data-type', 'loading' ),
			$content = $( '<div>' ).addClass( 'content' ),
			$icon = $( '<div>' ).addClass( 'loading' ),
			$message = $( '<p>' )
				.addClass( 'message' )
				.text( mw.message( 'wikia-visualeditor-loading' ).plain() );

		$content
			.append( $icon )
			.append( $message );

		$indicator
			.append( $content )
			.appendTo( $( 'body' ) )
			.css( 'opacity', 1 )
			.hide();

		// Cleanup indicator when hook is fired
		mw.hook( 've.activationComplete' ).add( function hide() {
			if ( indicatorTimeoutId ) {
				clearTimeout( indicatorTimeoutId );
				indicatorTimeoutId = null;
			}
			if ( $indicator.is( ':visible' ) ) {
				$indicator.fadeOut( 400 );
			}
		} );
	}

	function showIndicator() {
		var $indicator = $( '.ve-indicator[data-type="loading"]' ),
			$message = $indicator.find( 'p.message' );

		$message.hide();
		$indicator.fadeIn( 400 );

		// Display a message if loading is taking longer than 3 seconds
		indicatorTimeoutId = setTimeout( function () {
			if ( $indicator.is( ':visible' ) ) {
				$message.slideDown( 400 );
			}
		}, 3000 );
	}

	initIndicator();

	/**
	 * Use deferreds to avoid loading and instantiating Target multiple times.
	 * @returns {jQuery.Promise}
	 */
	function getTarget() {
		var loadTargetDeferred;

		showIndicator();

		if ( !getTargetDeferred ) {
			Wikia.Tracker.track( trackerConfig, {
				'action': Wikia.Tracker.ACTIONS.IMPRESSION,
				'label': 'edit-page'
			} );
			getTargetDeferred = $.Deferred();
			loadTargetDeferred = $.Deferred();

			$.when(
				loadTargetDeferred,
				$.getResources( $.getSassCommonURL( '/extensions/VisualEditor/wikia/VisualEditor.scss' ) )
			).done( function () {
				var target = new ve.init.mw.WikiaViewPageTarget();
				ve.init.mw.targets.push( target );

				// Transfer methods
				ve.init.mw.WikiaViewPageTarget.prototype.setupSectionEditLinks = init.setupSectionLinks;

				// Add plugins
				target.addPlugins( plugins );

				getTargetDeferred.resolve( target );
			} ).fail( getTargetDeferred.reject );

			mw.loader.using( 'ext.visualEditor.wikiaViewPageTarget', loadTargetDeferred.resolve, loadTargetDeferred.reject );
		}
		return getTargetDeferred.promise();
	}

	conf = mw.config.get( 'wgVisualEditorConfig' );
	tabMessages = conf.tabMessages;
	uri = new mw.Uri( location.href );
	// For special pages, no information about page existence is exposed to
	// mw.config, so we assume it exists TODO: fix this in core.
	pageExists = !!mw.config.get( 'wgArticleId' ) || mw.config.get( 'wgNamespaceNumber' ) < 0;
	viewUri = new mw.Uri( mw.util.getUrl( mw.config.get( 'wgRelevantPageName' ) ) );
	veEditUri = viewUri.clone().extend( { 'veaction': 'edit' } );
	viewPage = (
		mw.config.get( 'wgIsArticle' ) &&
		!( 'diff' in uri.query )
	);
	veUIEnabled = mw.config.get( 'wgEnableVisualEditorUI' );
	vePreferred = mw.config.get( 'wgVisualEditor' ).visualEditorPreferred;

	support = {
		es5: !!(
			// It would be much easier to do a quick inline function that asserts "use strict"
			// works, but since IE9 doesn't support strict mode (and we don't use strict mode) we
			// have to instead list all the ES5 features we do use.
			Array.isArray &&
			Array.prototype.filter &&
			Array.prototype.indexOf &&
			Array.prototype.map &&
			Date.now &&
			Date.prototype.toJSON &&
			Function.prototype.bind &&
			Object.create &&
			Object.keys &&
			String.prototype.trim &&
			window.JSON &&
			JSON.parse &&
			JSON.stringify
		),
		contentEditable: 'contentEditable' in document.createElement( 'div' )
	};

	init = {
		activateOnPageLoad: uri.query.veaction === 'edit',

		support: support,

		blacklist: conf.blacklist,

		/**
		 * Add a plugin module or function.
		 *
		 * Plugins are run after VisualEditor is loaded, but before it is initialized. This allows
		 * plugins to add classes and register them with the factories and registries.
		 *
		 * The parameter to this function can be a ResourceLoader module name or a function.
		 *
		 * If it's a module name, it will be loaded together with the VisualEditor core modules when
		 * VE is loaded. No special care is taken to ensure that the module runs after the VE
		 * classes are loaded, so if this is desired, the module should depend on
		 * ext.visualEditor.core .
		 *
		 * If it's a function, it will be invoked once the VisualEditor core modules and any
		 * plugin modules registered through this function have been loaded, but before the editor
		 * is intialized. The function takes one parameter, which is the ve.init.mw.Target instance
		 * that's initializing, and can optionally return a jQuery.Promise . VisualEditor will
		 * only be initialized once all promises returned by plugin functions have been resolved.
		 *
		 *     @example
		 *     // Register ResourceLoader module
		 *     ve.libs.mw.addPlugin( 'ext.gadget.foobar' );
		 *
		 *     // Register a callback
		 *     ve.libs.mw.addPlugin( function ( target ) {
		 *         ve.dm.Foobar = .....
		 *     } );
		 *
		 *     // Register a callback that loads another script
		 *     ve.libs.mw.addPlugin( function () {
		 *         return $.getScript( 'http://example.com/foobar.js' );
		 *     } );
		 *
		 * @param {string|Function} plugin Module name or callback that optionally returns a promise
		 */
		addPlugin: function( plugin ) {
			plugins.push( plugin );
		},

		setupSkin: function () {
			init.setupTabs();
			init.setupSectionLinks();
		},

		setupTabs: function () {
			$( '#ca-ve-edit' ).click( init.onEditTabClick );
		},

		setupSectionLinks: function () {
			if ( vePreferred ) {
				$( '#mw-content-text' ).find( '.editsection a' ).click( init.onEditSectionLinkClick );
			}
		},

		onEditTabClick: function ( e ) {
			// Default mouse button is normalised by jQuery to key code 1.
			// Only do our handling if no keys are pressed, mouse button is 1
			// (e.g. not middle click or right click) and no modifier keys
			// (e.g. cmd-click to open in new tab).
			if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				if ( window.veTrack ) {
					veTrack( {
						action: 've-edit-page-ignored',
						trigger: 'onEditTabClick'
					} );
				}
				return;
			}

			e.preventDefault();

			Wikia.Tracker.track( trackerConfig, {
				'action': Wikia.Tracker.ACTIONS.CLICK,
				'category': 'article',
				'label': 've-edit'
			} );

			if ( window.veTrack ) {
				veTrack( {
					action: 've-edit-page-start',
					trigger: 'onEditTabClick'
				} );
			}
			getTarget().done( function ( target ) {
				target.activate();
			} );
		},

		onEditSectionLinkClick: function ( e ) {
			if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				if ( window.veTrack ) {
					veTrack( {
						action: 've-edit-page-ignored',
						trigger: 'onEditTabClick'
					} );
				}
				return;
			}

			e.preventDefault();

			Wikia.Tracker.track( trackerConfig, {
				'action': Wikia.Tracker.ACTIONS.CLICK,
				'category': 'article',
				'label': 've-section-edit'
			} );

			if ( window.veTrack ) {
				veTrack( {
					action: 've-edit-page-start',
					trigger: 'onEditSectionLinkClick'
				} );
			}
			getTarget().done( function ( target ) {
				target.saveEditSection( $( e.target ).closest( 'h1, h2, h3, h4, h5, h6' ).get( 0 ) );
				target.activate();
			} );
		}
	};

	browserSupported = support.es5 &&
		support.contentEditable &&
		( ( 'vewhitelist' in uri.query ) || !$.client.test( init.blacklist, null, true ) );

	init.isInValidNamespace = function ( article ) {
		// Only in enabled namespaces
		return $.inArray(
			new mw.Title( article ).getNamespaceId(),
			conf.namespaces
		) !== -1;
	};

	init.canCreatePageUsingVE = function () {
		return browserSupported && vePreferred;
	};

	// Note: Though VisualEditor itself only needs this exposure for a very small reason
	// (namely to access init.blacklist from the unit tests...) this has become one of the nicest
	// ways to easily detect whether the VisualEditor initialisation code is present.
	//
	// The VE global was once available always, but now that platform integration initialisation
	// is properly separated, it doesn't exist until the platform loads VisualEditor core.
	window.mw.libs.ve = init;

	function setupRedlinks() {
		$( document ).on(
			'mouseover click',
			'a[href*="action=edit"][href*="&redlink"]:not([href*="veaction=edit"])',
			function() {
				var $element = $( this ),
					href = $element.attr( 'href' ),
					articlePath = mw.config.get( 'wgArticlePath' ).replace( '$1', '' ),
					redlinkArticle = new mw.Uri( href ).path.replace( articlePath, '' );

				if ( init.isInValidNamespace( redlinkArticle ) ) {
					$element.attr( 'href', href.replace( 'action=edit', 'veaction=edit' ) );
				}
			}
		);
	}

	function removeVELink() {
		// This class may still be used by CSS
		$( 'html' ).addClass( 've-not-available' );
		$edit = $( '#ca-edit' );
		$veEdit = $( '#ca-ve-edit' );
		// If VE is the main edit link, clone the alternate edit attributes into it
		if ( vePreferred ) {
			$veEdit.attr( { href: $edit.attr( 'href' ), accesskey: $edit.attr( 'accesskey' ) } );
			$edit.parent().remove();
		} else {
			$veEdit.parent().remove();
		}
	}

	if ( browserSupported ) {
		if ( viewPage && init.isInValidNamespace( mw.config.get( 'wgRelevantPageName' ) ) ) {
			$( function () {
				if ( init.activateOnPageLoad ) {
					if ( window.veTrack ) {
						veTrack( {
							action: 've-edit-page-start',
							trigger: 'activateOnPageLoad'
						} );
					}
					getTarget().done( function ( target ) {
						target.activate();
					} );
				}
				init.setupSkin();
			} );
		} else {
			removeVELink();
		}

		if ( vePreferred ) {
			$( setupRedlinks );
		}
	} else {
		removeVELink();
	}
}() );
