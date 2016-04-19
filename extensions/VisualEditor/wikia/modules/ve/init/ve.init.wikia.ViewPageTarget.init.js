/*!
 * VisualEditor MediaWiki ViewPageTarget init.
 *
 * This file must remain as widely compatible as the base compatibility
 * for MediaWiki itself (see mediawiki/core:/resources/startup.js).
 * Avoid use of: ES5, SVG, HTML5 DOM, ContentEditable etc.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global require, veTrack, Wikia */

/**
 * Platform preparation for the MediaWiki view page. This loads (when user needs it) the
 * actual MediaWiki integration and VisualEditor library.
 *
 * @class ve.init.mw.ViewPageTarget.init
 * @singleton
 */
( function () {
	var conf, tabMessages, uri, pageExists, viewUri, veEditUri, isViewPage,
		init, support, targetDeferred,
		plugins = [],
		// Used by tracking calls that go out before ve.track is available.
		trackerConfig = {
			category: 'editor-ve',
			trackingMethod: 'analytics'
		},
		spinnerTimeoutId = null,
		vePreferred;

	function initSpinner() {
		var $spinner = $( '<div>' )
				.addClass( 've-spinner visible' )
				.attr( 'data-type', 'loading' ),
			$content = $( '<div>' ).addClass( 'content' ),
			$icon = $( '<div>' ).addClass( 'loading' ),
			$message = $( '<p>' )
				.addClass( 'message' )
				.text( mw.message( 'wikia-visualeditor-loading' ).plain() ),
			$fade = $( '<div>' ).addClass( 've-spinner-fade');

		$content
			.append( $icon )
			.append( $message );

		$spinner
			.append( $content )
			.appendTo( $( 'body' ) )
			.css( 'opacity', 1 )
			.hide();

		$fade.appendTo( '#WikiaArticle' ).hide();

		// Cleanup spinner when hook is fired
		mw.hook( 've.activationComplete' ).add( function hide() {
			if ( spinnerTimeoutId ) {
				clearTimeout( spinnerTimeoutId );
				spinnerTimeoutId = null;
			}
		} );
	}

	function showSpinner() {
		var $spinner = $( '.ve-spinner[data-type="loading"]' ),
			$message = $spinner.find( 'p.message' ),
			$fade = $( '.ve-spinner-fade' );

		$message.hide();
		$spinner.fadeIn( 400 );
		$fade.show().css( 'opacity', 0.75 );

		// Display a message if loading is taking longer than 3 seconds
		spinnerTimeoutId = setTimeout( function () {
			if ( $spinner.is( ':visible' ) ) {
				$message.slideDown( 400 );
			}
		}, 3000 );
	}

	initSpinner();

	/**
	 * Use deferreds to avoid loading and instantiating Target multiple times.
	 * @returns {jQuery.Promise}
	 */
	// Wikia change -
	function getTarget() {
		var loadTargetDeferred;

		ve.track( 'wikia', {
			action: Wikia.Tracker.ACTIONS.IMPRESSION,
			label: 'edit-page'
		} );

		showSpinner();

		if ( !targetDeferred ) {
			targetDeferred = $.Deferred();
			loadTargetDeferred = $.Deferred();
			mw.loader.using( 'ext.visualEditor.wikia.oasisViewPageTarget', loadTargetDeferred.resolve, loadTargetDeferred.reject );
			$.when(
				$.getResources( [
					window.wgResourceBasePath + '/resources/wikia/libraries/vignette/vignette.js',
					$.getSassCommonURL( '/extensions/VisualEditor/wikia/VisualEditor-Oasis.scss' )
				] ),
				loadTargetDeferred
			).done( function () {
				var target = new ve.init.wikia.ViewPageTarget();
				target.$element.insertAfter( '#mw-content-text' );

				// Transfer methods
				ve.init.mw.ViewPageTarget.prototype.setupSectionEditLinks = init.setupSectionLinks;

				// Add plugins
				target.addPlugins( plugins );

				targetDeferred.resolve( target );
			} );
		}
		return targetDeferred.promise();
	}

	conf = mw.config.get( 'wgVisualEditorConfig' );
	tabMessages = conf.tabMessages;
	uri = new mw.Uri();
	pageExists = !!mw.config.get( 'wgRelevantArticleId' );
	viewUri = new mw.Uri( mw.util.getUrl( mw.config.get( 'wgRelevantPageName' ) ) );
	isViewPage = (
		mw.config.get( 'wgIsArticle' ) &&
		!( 'diff' in uri.query )
	);
	// On a view page, extend the current URI so parameters like oldid are carried over
	// On a non-view page, use viewUri
	veEditUri = ( isViewPage ? uri : viewUri ).clone().extend( { veaction: 'edit' } );
	vePreferred = !!mw.config.get( 'wgVisualEditorPreferred' );

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
			Object.create &&
			Object.keys &&
			String.prototype.trim &&
			window.JSON &&
			JSON.parse &&
			JSON.stringify &&
			Function.prototype.bind
		),
		contentEditable: 'contentEditable' in document.createElement( 'div' ),
		svg: !!(
			document.createElementNS &&
			document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' ).createSVGRect
		)
	};

	init = {

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
		 *     mw.libs.ve.addPlugin( 'ext.gadget.foobar' );
		 *
		 *     // Register a callback
		 *     mw.libs.ve.addPlugin( function ( target ) {
		 *         ve.dm.Foobar = .....
		 *     } );
		 *
		 *     // Register a callback that loads another script
		 *     mw.libs.ve.addPlugin( function () {
		 *         return $.getScript( 'http://example.com/foobar.js' );
		 *     } );
		 *
		 * @param {string|Function} plugin Module name or callback that optionally returns a promise
		 */
		addPlugin: function ( plugin ) {
			plugins.push( plugin );
		},

		setupTabs: function () {
			$( '#ca-ve-edit' ).click( init.onEditTabClick );
		},

		setupSectionLinks: function () {
			$( '#mw-content-text' ).find( '.editsection a' ).click( init.onEditSectionLinkClick );
		},

		onEditTabClick: function ( e ) {
			// Default mouse button is normalised by jQuery to key code 1.
			// Only do our handling if no keys are pressed, mouse button is 1
			// (e.g. not middle click or right click) and no modifier keys
			// (e.g. cmd-click to open in new tab).
			if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				return;
			}

			init.showLoading();
			ve.track( 'mwedit.init', { type: 'page', mechanism: 'click' } );

			if ( history.pushState && uri.query.veaction !== 'edit' ) {
				// Replace the current state with one that is tagged as ours, to prevent the
				// back button from breaking when used to exit VE. FIXME: there should be a better
				// way to do this. See also similar code in the ViewPageTarget constructor.
				history.replaceState( { tag: 'visualeditor' }, document.title, uri );
				// Set veaction to edit
				history.pushState( { tag: 'visualeditor' }, document.title, veEditUri );
				// Update mw.Uri instance
				uri = veEditUri;
			}

			e.preventDefault();

			Wikia.Tracker.track( trackerConfig, {
				action: Wikia.Tracker.ACTIONS.CLICK,
				category: 'article',
				label: 've-edit'
			} );

			if ( window.veTrack ) {
				veTrack( {
					action: 've-edit-page-start',
					trigger: 'onEditTabClick'
				} );
			}

			getTarget().done( function ( target ) {
				target.activate()
					.done( function () {
						ve.track( 'mwedit.ready' );
					} )
					.always( init.hideLoading );
			} );
		},

		onEditSectionLinkClick: function ( e ) {
			if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				return;
			}

			init.showLoading();
			ve.track( 'mwedit.init', { type: 'section', mechanism: 'click' } );

			if ( history.pushState && uri.query.veaction !== 'edit' ) {
				// Replace the current state with one that is tagged as ours, to prevent the
				// back button from breaking when used to exit VE. FIXME: there should be a better
				// way to do this. See also similar code in the ViewPageTarget constructor.
				history.replaceState( { tag: 'visualeditor' }, document.title, uri );
				// Change the state to the href of the section link that was clicked. This saves
				// us from having to figure out the section number again.
				history.pushState( { tag: 'visualeditor' }, document.title, this.href );
			}

			e.preventDefault();

			Wikia.Tracker.track( trackerConfig, {
				action: Wikia.Tracker.ACTIONS.CLICK,
				category: 'article',
				label: 've-section-edit'
			} );

			if ( window.veTrack ) {
				veTrack( {
					action: 've-edit-page-start',
					trigger: 'onEditSectionLinkClick'
				} );
			}

			getTarget().done( function ( target ) {
				target.saveEditSection( $( e.target ).closest( 'h1, h2, h3, h4, h5, h6' ).get( 0 ) );
				target.activate()
					.done( function () {
						ve.track( 'mwedit.ready' );
					} )
					.always( init.hideLoading );
			} );
		},

		showLoading: function () {
			if ( !init.$loading ) {
				init.$loading = $( '<div class="mw-viewPageTarget-loading"></div>' );
			}
			$( '#firstHeading' ).prepend( init.$loading );
		},

		hideLoading: function () {
			if ( init.$loading ) {
				init.$loading.detach();
			}
		}
	};

	support.visualEditor = support.es5 &&
		support.contentEditable &&
		support.svg &&
		( ( 'vewhitelist' in uri.query ) || !$.client.test( init.blacklist, null, true ) );

	// Whether VisualEditor should be available for the current user, page, wiki, mediawiki skin,
	// browser etc.
	init.isAvailable = (
		support.visualEditor &&

		// Only in enabled namespaces
		$.inArray(
			new mw.Title( mw.config.get( 'wgRelevantPageName' ) ).getNamespaceId(),
			conf.namespaces
		) !== -1
	);

	init.isInValidNamespace = function ( article ) {
		// Only in enabled namespaces
		return $.inArray(
			new mw.Title( article ).getNamespaceId(),
			conf.namespaces
		) !== -1;
	};

	init.canCreatePageUsingVE = function () {
		return support.visualEditor && vePreferred;
	};

	// Note: Though VisualEditor itself only needs this exposure for a very small reason
	// (namely to access init.blacklist from the unit tests...) this has become one of the nicest
	// ways to easily detect whether the VisualEditor initialisation code is present.
	//
	// The VE global was once available always, but now that platform integration initialisation
	// is properly separated, it doesn't exist until the platform loads VisualEditor core.
	//
	// Most of mw.libs.ve is considered subject to change and private.  The exception is that
	// mw.libs.ve.isAvailable is public, and indicates whether the VE editor itself can be loaded
	// on this page. See above for why it may be false.
	mw.libs.ve = init;

	function setupRedlinks() {
		$( document ).on(
			'mouseover click',
			'a[href*="action=edit"][href*="&redlink"]:not([href*="veaction=edit"])',
			function () {
				var $element = $( this ),
					href = $element.attr( 'href' ),
					articlePath = mw.config.get( 'wgArticlePath' ).replace( '$1', '' ),
					redlinkArticle = new mw.Uri( href ).path.replace( articlePath, '' );

				if ( init.isInValidNamespace( decodeURIComponent( redlinkArticle ) ) ) {
					$element.attr( 'href', href.replace( 'action=edit', 'veaction=edit' ) );
				}
			}
		);
	}

	function removeVELink() {
		var $edit = $( '#ca-edit' ),
			$veEdit = $( '#ca-ve-edit' );

		$( 'html' ).addClass( 've-not-available' );
		// If VE is the main edit link, clone the href into it
		if ( vePreferred && $veEdit.length > 0 ) {
			$veEdit.attr( 'href', $edit.attr( 'href' ) );
			$edit.parent().remove();
		} else {
			$veEdit.parent().remove();
		}
	}

	if ( init.isAvailable ) {
		$( function () {
			if (mw.config.get('wgEnableVisualEditorTourExperiment')) {
				mw.hook('ve.activationComplete').add(function initTour() {
					require(['VisualEditorTourExperimentInit'], function (veTourInit) {
						veTourInit.init();
					});
				});
			}
			if ( isViewPage && uri.query.veaction === 'edit' ) {
				var isSection = uri.query.vesection !== undefined;
				init.showLoading();

				ve.track( 'mwedit.init', { type: isSection ? 'section' : 'page', mechanism: 'url' } );
				if ( window.veTrack ) {
					veTrack( {
						action: 've-edit-page-start',
						trigger: 'activateOnPageLoad'
					} );
				}
				getTarget().done( function ( target ) {
					target.activate()
						.done( function () {
							ve.track( 'mwedit.ready' );
						} )
						.always( init.hideLoading );
				} );
			}
			if ( isViewPage ) {
				init.setupTabs();
				if ( vePreferred ) {
					init.setupSectionLinks();
				}
			}
			if ( vePreferred ) {
				setupRedlinks();
			}
		} );
	} else {
		removeVELink();
	}

}() );
