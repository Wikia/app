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

/**
 * Platform preparation for the MediaWiki view page. This loads (when user needs it) the
 * actual MediaWiki integration and VisualEditor library.
 *
 * @class ve.init.mw.ViewPageTarget.init
 * @singleton
 */
( function () {
	var conf, tabMessages, uri, pageExists, viewUri, veEditUri, isViewPage,
		init, support, targetPromise, enable, userPrefEnabled,
		plugins = [];

	/**
	 * Use deferreds to avoid loading and instantiating Target multiple times.
	 * @returns {jQuery.Promise}
	 */
	function getTarget() {
		if ( !targetPromise ) {
			targetPromise = mw.loader.using( 'ext.visualEditor.viewPageTarget' )
				.then( function () {
					var target = new ve.init.mw.ViewPageTarget();
					$( '#content' ).append( target.$element );

					// Transfer methods
					ve.init.mw.ViewPageTarget.prototype.setupSectionEditLinks = init.setupSectionLinks;

					// Add plugins
					target.addPlugins( plugins );

					return target;
				}, function ( e ) {
					mw.log.warn( 'VisualEditor failed to load: ' + e );
				} );
		}
		return targetPromise;
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

		setupSkin: function () {
			init.setupTabs();
			init.setupSectionLinks();
		},

		setupTabs: function () {
			// HACK: Remove this when the Education Program offers a proper way to detect and disable.
			if (
				// HACK: Work around jscs.requireCamelCaseOrUpperCaseIdentifiers
				mw.config.get( 'wgNamespaceIds' )[ true && 'education_program' ] === mw.config.get( 'wgNamespaceNumber' )
			) {
				return;
			}

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
			} else if ( $caEdit.length && $caVeEdit.length ) {
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

			// If the edit tab is hidden, remove it.
			if ( !( init.isAvailable && userPrefEnabled ) ) {
				$caVeEdit.remove();
			}

			// Alter the edit tab (#ca-edit)
			if ( $( '#ca-view-foreign' ).length ) {
				if ( tabMessages[action + 'localdescriptionsource'] !== null ) {
					$caEditLink.text( mw.msg( tabMessages[action + 'localdescriptionsource'] ) );
				}
			} else {
				if ( tabMessages[action + 'source'] !== null ) {
					$caEditLink.text( mw.msg( tabMessages[action + 'source'] ) );
				}
			}

			if ( conf.tabPosition === 'before' ) {
				$caEdit.addClass( 'collapsible' );
			} else {
				$caVeEdit.addClass( 'collapsible' );
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
			var $editsections = $( '#mw-content-text .mw-editsection' ),
				bodyDir = $( 'body' ).css( 'direction' );

			// Match direction of the user interface
			// TODO: Why is this needed? It seems to work fine without.
			if ( $editsections.css( 'direction' ) !== bodyDir ) {
				// Avoid creating inline style attributes if the inherited value is already correct
				$editsections.css( 'direction', bodyDir );
			}

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
					// Don't mess with section edit links on foreign file description pages
					// (bug 54259)
					if ( !$( '#ca-view-foreign' ).length ) {
						$editLink
							.attr( 'href', function ( i, val ) {
								return new mw.Uri( veEditUri ).extend( {
									vesection: new mw.Uri( val ).query.section
								} );
							} )
							.addClass( 'mw-editsection-visualeditor' );
						if ( conf.tabPosition === 'before' ) {
							$editSourceLink.before( $editLink, $divider );
						} else {
							$editSourceLink.after( $divider, $editLink );
						}
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

	enable = mw.user.options.get( 'visualeditor-enable', conf.defaultUserOptions.enable );

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
					enable && enable !== '0' &&
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

		// Only in supported skins
		$.inArray( mw.config.get( 'skin' ), conf.skins ) !== -1 &&

		// Only in enabled namespaces
		$.inArray(
			new mw.Title( mw.config.get( 'wgRelevantPageName' ) ).getNamespaceId(),
			conf.namespaces
		) !== -1 &&

		// Not on pages which are outputs of the Page Translation feature
		mw.config.get( 'wgTranslatePageTranslation' ) !== 'translation' &&

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

	if ( init.isAvailable && userPrefEnabled ) {
		$( 'html' ).addClass( 've-available' );
	} else {
		$( 'html' ).addClass( 've-not-available' );
		// Don't return here because we do want the skin setup to consistently happen
		// for e.g. "Edit" > "Edit source" even when VE is not available.
	}

	$( function () {
		if ( init.isAvailable ) {
			if ( isViewPage && uri.query.veaction === 'edit' ) {
				var isSection = uri.query.vesection !== undefined;
				init.showLoading();

				ve.track( 'mwedit.init', { type: isSection ? 'section' : 'page', mechanism: 'url' } );
				getTarget().done( function ( target ) {
					target.activate()
						.done( function () {
							ve.track( 'mwedit.ready' );
						} )
						.always( init.hideLoading );
				} );
			}
		}

		if ( userPrefEnabled ) {
			init.setupSkin();
		}
	} );
}() );
