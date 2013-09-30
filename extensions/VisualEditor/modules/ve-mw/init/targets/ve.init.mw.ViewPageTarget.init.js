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

/*global mw */

/**
 * Platform preparation for the MediaWiki view page. This loads (when user needs it) the
 * actual MediaWiki integration and VisualEditor library.
 *
 * @class ve.init.mw.ViewPageTarget.init
 * @singleton
 */
( function () {
	var conf, tabMessages, uri, pageExists, viewUri, veEditUri, isViewPage,
		init, support, getTargetDeferred, userPrefEnabled,
		plugins = [];

	/**
	 * Use deferreds to avoid loading and instantiating Target multiple times.
	 * @returns {jQuery.Promise}
	 */
	function getTarget() {
		var loadTargetDeferred;
		if ( !getTargetDeferred ) {
			getTargetDeferred = $.Deferred();
			loadTargetDeferred = $.Deferred()
				.done( function () {
					var target = new ve.init.mw.ViewPageTarget();
					ve.init.mw.targets.push( target );

					// Transfer methods
					ve.init.mw.ViewPageTarget.prototype.setupSectionEditLinks = init.setupSectionLinks;

					// Add plugins
					target.addPlugins( plugins );

					getTargetDeferred.resolve( target );
				} )
				.fail( getTargetDeferred.reject );

			mw.loader.using( 'ext.visualEditor.viewPageTarget', loadTargetDeferred.resolve, loadTargetDeferred.reject );
		}
		return getTargetDeferred.promise();
	}

	conf = mw.config.get( 'wgVisualEditorConfig' );
	tabMessages = conf.tabMessages;
	uri = new mw.Uri();
	// BUG 49000: For special pages, no information about page existence is
	// exposed to mw.config (see BUG 53774), so we assume it exists.
	pageExists = !!mw.config.get( 'wgArticleId' ) || mw.config.get( 'wgNamespaceNumber' ) < 0;
	viewUri = new mw.Uri( mw.util.wikiGetlink( mw.config.get( 'wgRelevantPageName' ) ) );
	veEditUri = viewUri.clone().extend( { 'veaction': 'edit' } );
	isViewPage = (
		mw.config.get( 'wgIsArticle' ) &&
		!( 'diff' in uri.query )
	);

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

		support: support,

		blacklist: {
			// IE <= 8 has various incompatibilities in layout and feature support
			// IE9 and IE10 generally work but fail in ajax handling when making POST
			// requests to the VisualEditor/Parsoid API which is causing silent failures
			// when trying to save a page (bug 49187)
			'msie': [['<=', 10]],
			// Android 2.x and below "support" CE but don't trigger keyboard input
			'android': [['<', 3]],
			// Firefox issues in versions 12 and below (bug 50780)
			// Wikilink [[./]] bug in Firefox 14 and below (bug 50720)
			'firefox': [['<=', 14]],
			// Opera < 12 was not tested and it's userbase is almost nonexistent anyway
			'opera': [['<', 12]],
			// Blacklist all versions:
			'blackberry': null
		},

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
			var caVeEdit,
				action = pageExists ? 'edit' : 'create',
				pTabsId = $( '#p-views' ).length ? 'p-views' : 'p-cactions',
				$caSource = $( '#ca-viewsource' ),
				$caEdit = $( '#ca-edit' ),
				$caVeEdit = $( '#ca-ve-edit' ),
				$caEditLink = $caEdit.find( 'a' ),
				$caVeEditLink = $caVeEdit.find( 'a' ),
				reverseTabOrder = $( 'body' ).hasClass( 'rtl' ) && pTabsId === 'p-views',
				/*jshint bitwise:false */
				caVeEditNextnode = ( reverseTabOrder ^ conf.tabPosition === 'before' ) ? $caEdit.get( 0 ) : $caEdit.next().get( 0 );

			if ( !$caVeEdit.length ) {
				// The below duplicates the functionality of VisualEditorHooks::onSkinTemplateNavigation()
				// in case we're running on a cached page that doesn't have these tabs yet.

				// If there is no edit tab or a view-source tab,
				// the user doesn't have permission to edit.
				if ( $caEdit.length && !$caSource.length ) {
					// Add the VisualEditor tab (#ca-ve-edit)
					caVeEdit = mw.util.addPortletLink(
						pTabsId,
						// Use url instead of '#'.
						// So that 1) one can always open it in a new tab, even when
						// onEditTabClick is bound.
						// 2) when onEditTabClick is not bound (!isViewPage) it will
						// just work.
						veEditUri,
						tabMessages[action] !== null ? mw.msg( tabMessages[action] ) : $caEditLink.text(),
						'ca-ve-edit',
						mw.msg( 'tooltip-ca-ve-edit' ),
						mw.msg( 'accesskey-ca-ve-edit' ),
						caVeEditNextnode
					);

					$caVeEdit = $( caVeEdit );
					$caVeEditLink = $caVeEdit.find( 'a' );
				}
			} else {
				// Make the state of the page consistent with the config if needed
				/*jshint bitwise:false */
				if ( reverseTabOrder ^ conf.tabPosition === 'before' ) {
					if ( $caEdit[0].nextSibling === $caVeEdit[0] ) {
						$caVeEdit.after( $caEdit );
					}
				} else {
					if ( $caVeEdit[0].nextSibling === $caEdit[0] ) {
						$caEdit.after( $caVeEdit );
					}
				}
				if ( tabMessages[action] !== null ) {
					$caVeEditLink.text( mw.msg( tabMessages[action] ) );
				}
			}

			// Alter the edit tab (#ca-edit)
			if ( tabMessages[action + 'source'] !== null ) {
				$caEditLink.text( mw.msg( tabMessages[action + 'source'] ) );
			}
			// Process appendix messages
			if ( tabMessages[action + 'appendix'] !== null ) {
				$caVeEditLink.append(
					$( '<span>' )
						.addClass( 've-tabmessage-appendix' )
						.text( mw.msg( tabMessages[action + 'appendix'] ) )
				);
			}
			if ( tabMessages[action + 'sourceappendix'] !== null ) {
				$caEditLink.append(
					$( '<span>' )
						.addClass( 've-tabmessage-appendix' )
						.text( mw.msg( tabMessages[action + 'sourceappendix'] ) )
				);
			}

			if ( isViewPage ) {
				// Allow instant switching to edit mode, without refresh
				$caVeEdit.click( init.onEditTabClick );
			}
		},

		setupSectionLinks: function () {
			var $editsections = $( '#mw-content-text .mw-editsection' );

			// match direction to the user interface
			$editsections.css( 'direction', $( 'body' ).css( 'direction' ) );
			// The "visibility" css construct ensures we always occupy the same space in the layout.
			// This prevents the heading from changing its wrap when the user toggles editSourceLink.
			if ( $editsections.find( '.mw-editsection-visualeditor' ).length === 0 ) {
				// If PHP didn't build the section edit links (because of caching), build them
				$editsections.each( function () {
					var $editsection = $( this ),
						$editSourceLink = $editsection.find( 'a' ).eq( 0 ),
						$editLink = $editSourceLink.clone(),
						$divider = $( '<span>' ),
						dividerText = mw.msg( 'pipe-separator' );

					if ( tabMessages.editsectionsource !== null ) {
						$editSourceLink.text( mw.msg( tabMessages.editsectionsource ) );
					}
					if ( tabMessages.editsection !== null ) {
						$editLink.text( mw.msg( tabMessages.editsection ) );
					}
					$divider
						.addClass( 'mw-editsection-divider' )
						.text( dividerText );
					$editLink
						.attr( 'href', function ( i, val ) {
							return new mw.Uri( veEditUri ).extend( {
								'vesection': new mw.Uri( val ).query.section
							} );
						} )
						.addClass( 'mw-editsection-visualeditor' );
					if ( conf.tabPosition === 'before' ) {
						$editSourceLink.before( $editLink, $divider );
					} else {
						$editSourceLink.after( $divider, $editLink );
					}
				} );
			}

			// Process appendix messages
			if ( tabMessages.editsectionappendix ) {
				$editsections.find( '.mw-editsection-visualeditor' )
					.append(
						$( '<span>' )
							.addClass( 've-tabmessage-appendix' )
							.text( mw.msg( tabMessages.editsectionappendix ) )
					);
			}
			if ( tabMessages.editsectionsourceappendix ) {
				$editsections.find( 'a:not(.mw-editsection-visualeditor)' )
					.append(
						$( '<span>' )
							.addClass( 've-tabmessage-appendix' )
							.text( mw.msg( tabMessages.editsectionsourceappendix ) )
					);
			}

			if ( isViewPage ) {
				// Only init without refresh if we're on a view page. Though section edit links
				// are rarely shown on non-view pages, they appear in one other case, namely
				// when on a diff against the latest version of a page. In that case we mustn't
				// init without refresh as that'd initialise for the wrong rev id (bug 50925)
				// and would preserve the wrong DOM with a diff on top.
				$editsections
					.addClass( 'mw-editsection-expanded' )
					.find( '.mw-editsection-visualeditor' )
						.click( init.onEditSectionLinkClick )
				;
			}
		},

		onEditTabClick: function ( e ) {
			// Default mouse button is normalised by jQuery to key code 1.
			// Only do our handling if no keys are pressed, mouse button is 1
			// (e.g. not middle click or right click) and no modifier keys
			// (e.g. cmd-click to open in new tab).
			if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				return;
			}

			e.preventDefault();

			getTarget().done( function ( target ) {
				ve.track( 'Edit', { action: 'edit-link-click' } );
				target.activate();
			} );
		},

		onEditSectionLinkClick: function ( e ) {
			if ( ( e.which && e.which !== 1 ) || e.shiftKey || e.altKey || e.ctrlKey || e.metaKey ) {
				return;
			}

			e.preventDefault();

			getTarget().done( function ( target ) {
				ve.track( 'Edit', { action: 'section-edit-link-click' } );
				target.saveEditSection( $( e.target ).closest( 'h1, h2, h3, h4, h5, h6' ).get( 0 ) );
				target.activate();
			} );
		}
	};

	support.visualEditor = support.es5 &&
		support.contentEditable &&
		( ( 'vewhitelist' in uri.query ) || !$.client.test( init.blacklist, null, true ) );

	userPrefEnabled = (
		// Allow disabling for anonymous users separately from changing the
		// default preference (bug 50000)
		!( conf.disableForAnons && mw.config.get( 'wgUserName' ) === null ) &&

		// User has 'visualeditor-enable' preference enabled (for alpha opt-in)
		// User has 'visualeditor-betatempdisable' preference disabled
		// Because user.options is embedded in the HTML and cached per-page for anons on wikis
		// with static caching (e.g. wgUseFileCache or reverse-proxy) ignore user.options for
		// anons as it is likely outdated.
		(
			mw.config.get( 'wgUserName' ) === null ?
				( conf.defaultUserOptions.enable && !conf.defaultUserOptions.betatempdisable ) :
				(
					mw.user.options.get( 'visualeditor-enable', conf.defaultUserOptions.enable ) &&
						!mw.user.options.get(
							'visualeditor-betatempdisable',
							conf.defaultUserOptions.betatempdisable
						)
				)
		)
	);

	// Whether VisualEditor should be available for the current user, page, wiki, mediawiki skin,
	// browser etc.
	init.isAvailable = (
		support.visualEditor &&

		userPrefEnabled &&

		// Disable on redirect pages until redirects are editable (bug 47328)
		// Property wgIsRedirect is relatively new in core, many cached pages
		// don't have it yet. We do a best-effort approach using the url query
		// which will cover all working redirect (the only case where one can
		// read a redirect page without ?redirect=no is in case of broken or
		// double redirects).
		!mw.config.get( 'wgIsRedirect', !!uri.query.redirect ) &&

		// Only in supported skins
		$.inArray( mw.config.get( 'skin' ), conf.skins ) !== -1 &&

		// Only in enabled namespaces
		$.inArray(
			new mw.Title( mw.config.get( 'wgRelevantPageName' ) ).getNamespaceId(),
			conf.namespaces
		) !== -1 &&

		// Only for pages with a wikitext content model
		mw.config.get( 'wgPageContentModel' ) === 'wikitext'
	);

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

	if ( init.isAvailable ) {
		$( 'html' ).addClass( 've-available' );
	} else {
		$( 'html' ).addClass( 've-not-available' );
		// Don't return here because we do want the skin setup to consistently happen
		// for e.g. "Edit" > "Edit source" even when VE is not available.
	}

	if ( !userPrefEnabled ) {
		// However if ve is not available because of user preferences (as opposed
		// to because of the page, namespace, browser etc.) then we do want to
		// return early as in that case even transformation of edit source should
		// not be done.
		return;
	}

	$( function () {
		if ( init.isAvailable && isViewPage ) {
			if ( uri.query.veaction === 'edit' ) {
				getTarget().done( function ( target ) {
					target.activate();
				} );
			}
		}
		init.setupSkin();
	} );
}() );
