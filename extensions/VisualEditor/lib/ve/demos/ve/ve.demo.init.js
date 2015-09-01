/*!
 * VisualEditor standalone demo
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

new ve.init.sa.Platform( ve.messagePaths ).initialize().done( function () {

	var $toolbar = $( '.ve-demo-targetToolbar' ),
		$editor = $( '.ve-demo-editor' ),
		target = new ve.demo.target(),

		currentLang = $.i18n().locale,
		currentDir = target.$element.css( 'direction' ) || 'ltr',
		device = ve.demo.target === ve.init.sa.DesktopTarget ? 'desktop' : 'mobile',

		// Menu widgets
		addSurfaceContainerButton = new OO.ui.ButtonWidget( {
			icon: 'add',
			label: 'Add surface'
		} ),

		messageKeyButton = new OO.ui.ButtonWidget( {
			icon: 'textLanguage',
			label: 'Lang keys'
		} ),
		languageInput = new ve.ui.LanguageInputWidget( {
			requireDir: true,
			hideCodeInput: true,
			availableLanguages: ve.availableLanguages,
			dialogManager: new OO.ui.WindowManager( { factory: ve.ui.windowFactory, classes: [ 've-demo-languageSearchDialogManager' ] } )
		} ),
		deviceSelect = new OO.ui.ButtonSelectWidget().addItems( [
			new OO.ui.ButtonOptionWidget( { data: 'desktop', label: 'Desktop' } ),
			new OO.ui.ButtonOptionWidget( { data: 'mobile', label: 'Mobile' } )
		] );

	function updateStylesFromDir() {
		var oldDir = currentDir === 'ltr' ? 'rtl' : 'ltr';

		$( '.stylesheet-' + currentDir ).prop( 'disabled', false );
		$( '.stylesheet-' + oldDir ).prop( 'disabled', true );

		$( 'body' ).css( 'direction', currentDir )
			.addClass( 've-demo-dir-' + currentDir )
			.removeClass( 've-demo-dir-' + oldDir );
	}

	// Initialization

	deviceSelect.selectItemByData( device );

	deviceSelect.on( 'select', function ( item ) {
		location.href = location.href.replace( device, item.getData() );
	} );

	addSurfaceContainerButton.on( 'click', function () {
		addSurfaceContainer();
	} );

	messageKeyButton.on( 'click', function () {
		languageInput.setLangAndDir( 'qqx', currentDir );
	} );

	languageInput.setLangAndDir( currentLang, currentDir );
	// Dir doesn't change on init but styles need to be set
	updateStylesFromDir();
	target.$element.attr( 'lang', currentLang );

	languageInput.on( 'change', function ( lang, dir ) {
		if ( dir === currentDir && lang !== 'qqx' && ve.availableLanguages.indexOf( lang ) === -1 ) {
			return;
		}

		$.i18n().locale = currentLang = lang;
		currentDir = dir;

		updateStylesFromDir();
		target.$element.attr( 'lang', currentLang );

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
			var i;
			for ( i = 0; i < ve.demo.surfaceContainers.length; i++ ) {
				ve.demo.surfaceContainers[ i ].reload( currentLang, currentDir );
			}
		} );
	} );

	languageInput.setLangAndDir( currentLang, currentDir );

	$toolbar.append(
		$( '<div>' ).addClass( 've-demo-toolbar-commands' ).append(
			addSurfaceContainerButton.$element,
			$( '<span class="ve-demo-toolbar-divider">&nbsp;</span>' ),
			messageKeyButton.$element,
			languageInput.$element,
			$( '<span class="ve-demo-toolbar-divider">&nbsp;</span>' ),
			deviceSelect.$element
		)
	);

	$editor.append( target.$element );

	function updateHash() {
		var i, pages = [];
		if ( history.replaceState ) {
			for ( i = 0; i < ve.demo.surfaceContainers.length; i++ ) {
				pages.push( ve.demo.surfaceContainers[ i ].pageMenu.getSelectedItem().getData() );
			}
			history.replaceState( null, document.title, '#!' + pages.join( ',' ) );
		}
	}

	function addSurfaceContainer( page ) {
		var surfaceContainer;

		if ( !page && ve.demo.surfaceContainers.length ) {
			page = ve.demo.surfaceContainers[ ve.demo.surfaceContainers.length - 1 ].pageMenu.getSelectedItem().getData();
		}

		surfaceContainer = new ve.demo.SurfaceContainer( target, page, currentLang, currentDir );
		surfaceContainer.on( 'changePage', updateHash );
		updateHash();
		target.$element.append( surfaceContainer.$element );
	}

	function createSurfacesFromHash( hash ) {
		var i, pages = [];
		if ( /^#!pages\/.+$/.test( hash ) ) {
			pages = hash.slice( 2 ).split( ',' );
		}
		if ( pages.length ) {
			for ( i = 0; i < pages.length; i++ ) {
				addSurfaceContainer( pages[ i ] );
			}
		} else {
			addSurfaceContainer( 'pages/simple.html' );
		}
	}

	createSurfacesFromHash( location.hash );

	// TODO: hashchange handler?
} );
