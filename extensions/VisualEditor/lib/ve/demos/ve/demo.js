/*!
 * VisualEditor standalone demo
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

$( function () {
	ve.init.platform.initialize().done( function () {

		function getDemoPageItems() {
			var name, items = [];
			for ( name in ve.demoPages ) {
				items.push(
					new OO.ui.MenuOptionWidget( {
						data: ve.demoPages[name],
						label: name
					} )
				);
			}
			return items;
		}

		var initialPage,

			lastMode = null,

			$menu = $( '.ve-demo-menu' ),
			$editor = $( '.ve-demo-editor' ),
			target = new ve.init.sa.Target(),

			switching = false,

			currentLang = $.i18n().locale,
			currentDir = target.$element.css( 'direction' ) || 'ltr',

			// Menu widgets
			pageDropdown = new OO.ui.DropdownWidget( {
				menu: {
					items: getDemoPageItems()
				}
			} ),
			pageLabel = new OO.ui.LabelWidget(
				{ label: 'Page', input: pageDropdown }
			),
			pageMenu = pageDropdown.getMenu(),
			addSurfaceButton = new OO.ui.ButtonWidget( { icon: 'add' } ),

			modeSelect = new OO.ui.ButtonSelectWidget().addItems( [
				new OO.ui.ButtonOptionWidget( { data: 've', label: 'VE' } ),
				new OO.ui.ButtonOptionWidget( { data: 'edit', label: 'Edit HTML' } ),
				new OO.ui.ButtonOptionWidget( { data: 'read', label: 'Read' } )
			] ),
			messageKeyButton = new OO.ui.ButtonWidget( {
				label: 'Lang keys'
			} ),
			languageInput = new ve.ui.LanguageInputWidget( {
				requireDir: true,
				availableLanguages: ve.availableLanguages,
				dialogManager: new OO.ui.WindowManager( { factory: ve.ui.windowFactory, classes: ['ve-demo-languageSearchDialogManager'] } )
			} ),
			sourceTextInput = new OO.ui.TextInputWidget( {
				$: this.$,
				multiline: true,
				autosize: true,
				maxRows: 999,
				classes: ['ve-demo-source']
			} ),
			$readView = $( '<div>' ).addClass( 've-demo-read' ).hide();

		// Initialization
		pageMenu.on( 'select', function ( item ) {
			var page = item.getData();
			if ( history.replaceState ) {
				history.replaceState( null, document.title, '#!/src/' + page );
			}
			switchPage( 've', page );
		} );

		addSurfaceButton.on( 'click', function () {
			addSurface( '' );
		} );

		messageKeyButton.on( 'click', function () {
			languageInput.setLangAndDir( 'qqx', currentDir );
		} );

		languageInput.languageCodeField.$element.hide();

		languageInput.setLangAndDir( currentLang, currentDir );

		languageInput.on( 'change', function ( lang, dir ) {
			if ( dir === currentDir && lang !== 'qqx' && ve.indexOf( lang, ve.availableLanguages ) === -1 ) {
				return;
			}

			$.i18n().locale = currentLang = lang;
			currentDir = dir;

			// HACK: Override/restore message functions for qqx mode
			if ( lang === 'qqx' ) {
				ve.init.platform.getMessage = function ( key ) { return key; };
			} else {
				ve.init.platform.getMessage = ve.init.sa.Platform.prototype.getMessage;
			}

			// Re-bind as getMessage may have changed
			OO.ui.msg = ve.init.platform.getMessage.bind( ve.init.platform );

			// HACK: Re-initialize page to load message files
			ve.init.platform.initialize().done( function () {
				loadPage( location.hash.slice( 7 ), true );
			} );
		} );

		modeSelect.on( 'select', function ( item ) {
			if ( !switching ) {
				switchPage( item.getData() );
			}
		} );

		function switchPage( mode, page ) {
			var model, doc, html, closePromise,
				currentDir = 'ltr';

			switching = true;
			modeSelect.selectItem( modeSelect.getItemFromData( mode ) );
			switching = false;

			switch ( lastMode ) {
				case 've':
					closePromise = target.$element.slideUp().promise();
					if ( !page ) {
						model = target.getSurface().getModel().getDocument() ;
						doc = ve.dm.converter.getDomFromModel( model );
						html = ve.properInnerHtml( doc.body );
						currentDir = model.getDir();
					}
					break;

				case 'edit':
					closePromise = sourceTextInput.$element.slideUp().promise();
					if ( !page ) {
						html = sourceTextInput.getValue();
					}
					break;

				case 'read':
					closePromise = $readView.slideUp().promise();
					if ( !page ) {
						html = ve.properInnerHtml( $readView[0] );
					}
					break;

				default:
					closePromise = $.Deferred().resolve().promise();
					break;
			}

			closePromise.done( function () {
				switch ( mode ) {
					case 've':
						target.$element.slideDown();
						if ( page ) {
							loadPage( page );
						} else if ( html ) {
							loadTarget( html );
						}
						break;

					case 'edit':
						sourceTextInput.$element.show();
						sourceTextInput.setValue( html ).adjustSize();
						sourceTextInput.$element.hide().slideDown();
						break;

					case 'read':
						$readView.html( html ).css( 'direction', currentDir ).slideDown();
						break;
				}
				lastMode = mode;
			} );
		}

		languageInput.setLangAndDir( currentLang, currentDir );

		$menu.append(
			$( '<div>' ).addClass( 've-demo-menu-commands' ).append(
				pageLabel.$element,
				pageDropdown.$element,
				addSurfaceButton.$element,
				$( '<span class="ve-demo-menu-divider">&nbsp;</span>' ),
				modeSelect.$element,
				$( '<span class="ve-demo-menu-divider">&nbsp;</span>' ),
				messageKeyButton.$element,
				languageInput.$element
			)
		);

		$editor.append( target.$element, sourceTextInput.$element.hide(), $readView );

		/**
		 * Load a page into the editor
		 *
		 * @private
		 * @param {string} src Path of html to load
		 * @param {boolean} [forceDir] Force directionality to its current value, otherwise guess from src
		 */
		function loadPage( src, forceDir ) {
			if ( !forceDir ) {
				currentDir = src.match( /rtl\.html$/ ) ? 'rtl' : 'ltr';
			}

			ve.init.platform.getInitializedPromise().done( function () {
				var promise = target.getSurface() ?
					target.getSurface().$element.slideUp().promise() :
					$.Deferred().resolve().promise();

				promise.done( function () {
					$.ajax( {
						url: src,
						dataType: 'text'
					} ).always( function ( result, status ) {
						var pageHtml;

						if ( status === 'error' ) {
							pageHtml = '<p><i>Failed loading page ' + $( '<span>' ).text( src ).html() + '</i></p>';
						} else {
							pageHtml = result;
						}

						loadTarget( pageHtml );
					} );
				} );
			} );
		}

		function loadTarget( pageHtml ) {
			target.clearSurfaces();

			var oldDir = currentDir === 'ltr' ? 'rtl' : 'ltr';

			$( '.stylesheet-' + currentDir ).prop( 'disabled', false );
			$( '.stylesheet-' + oldDir ).prop( 'disabled', true );

			target.$element.css( 'direction', currentDir );

			addSurface( pageHtml );
		}

		function addSurface( html ) {
			var surface = target.addSurface(
				ve.dm.converter.getModelFromDom(
					ve.createDocumentFromHtml( html ),
					target.$element.ownerDocument,
					currentLang,
					currentDir
				)
			);
			surface.$element.hide().slideDown().promise().done( function () {
				surface.getView().focus();
			} );
		}

		// Open initial page
		if ( /^#!\/src\/.+$/.test( location.hash ) ) {
			initialPage = location.hash.slice( 7 );
		} else {
			initialPage = pageMenu.getFirstSelectableItem().getData();
			// Per W3 spec, history.replaceState does not fire hashchange
		}
		pageMenu.selectItem( pageMenu.getItemFromData( initialPage ) );

		window.addEventListener( 'hashchange', function () {
			if ( /^#!\/src\/.+$/.test( location.hash ) ) {
				pageMenu.selectItem( pageMenu.getItemFromData( location.hash.slice( 7 ) ) );
			}
		} );

	} );
} );
