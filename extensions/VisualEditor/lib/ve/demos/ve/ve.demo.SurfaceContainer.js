/**
 * Demo surface container
 *
 * @class
 * @extends OO.ui.Element
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.init.Target} target Target
 * @param {string} page Page to load
 * @param {string} lang Language
 * @param {string} dir Directionality
 */
ve.demo.SurfaceContainer = function VeDemoSurfaceContainer( target, page, lang, dir ) {
	var pageDropdown, pageLabel, removeButton, $exitReadButton,
		container = this;

	// Parent constructor
	ve.demo.SurfaceContainer.super.call( this );

	// Mixin constructors
	OO.EventEmitter.call( this );

	ve.demo.surfaceContainers.push( this );

	pageDropdown = new OO.ui.DropdownWidget( {
		menu: {
			items: this.getPageMenuItems()
		}
	} );
	pageLabel = new OO.ui.LabelWidget( {
		label: 'Page',
		input: pageDropdown
	} );
	removeButton = new OO.ui.ButtonWidget( {
		icon: 'remove',
		label: 'Remove surface'
	} );
	$exitReadButton = $( '<a href="#">' ).text( 'Back to editor' ).on( 'click', function () {
		container.change( 've' );
		return false;
	} );

	this.modeSelect = new OO.ui.ButtonSelectWidget().addItems( [
		new OO.ui.ButtonOptionWidget( { data: 've', label: 'VE' } ),
		new OO.ui.ButtonOptionWidget( { data: 'edit', label: 'Edit HTML' } ),
		new OO.ui.ButtonOptionWidget( { data: 'read', label: 'Read' } )
	] );
	this.modeSelect.selectItemByData( 've' );

	this.target = target;
	this.surface = null;
	this.lang = lang;
	this.dir = dir;
	this.$surfaceWrapper = $( '<div>' ).addClass( 've-demo-surfaceWrapper' );
	this.mode = null;
	this.pageMenu = pageDropdown.getMenu();
	this.sourceTextInput = new OO.ui.TextInputWidget( {
		multiline: true,
		autosize: true,
		maxRows: 999,
		classes: [ 've-demo-source' ]
	} );
	this.$readView = $( '<div>' ).addClass( 've-demo-read' ).hide();

	// Events
	this.pageMenu.on( 'select', function ( item ) {
		var page = item.getData();
		container.change( 've', page );
		container.modeSelect.selectItemByData( 've' );
	} );
	this.modeSelect.on( 'select', function ( item ) {
		container.change( item.getData() );
	} );
	removeButton.on( 'click', this.destroy.bind( this ) );

	this.$element.addClass( 've-demo-surfaceContainer' ).append(
		$( '<div>' ).addClass( 've-demo-toolbar ve-demo-surfaceToolbar-edit' ).append(
			$( '<div>' ).addClass( 've-demo-toolbar-commands' ).append(
				pageLabel.$element,
				pageDropdown.$element,
				$( '<span class="ve-demo-toolbar-divider">&nbsp;</span>' ),
				this.modeSelect.$element,
				$( '<span class="ve-demo-toolbar-divider">&nbsp;</span>' ),
				removeButton.$element
			)
		),
		$( '<div>' ).addClass( 've-demo-toolbar-commands ve-demo-surfaceToolbar-read' ).append(
			$exitReadButton
		),
		this.$surfaceWrapper,
		this.sourceTextInput.$element.hide(),
		this.$readView
	);

	this.pageMenu.selectItem(
		this.pageMenu.getItemFromData( page ) ||
		this.pageMenu.getFirstSelectableItem()
	);
};

/* Inheritance */

OO.inheritClass( ve.demo.SurfaceContainer, OO.ui.Element );

OO.mixinClass( ve.demo.SurfaceContainer, OO.EventEmitter );

/* Methods */

/**
 * Get menu items for the page menu
 *
 * @return {OO.ui.MenuOptionWidget[]} Menu items
 */
ve.demo.SurfaceContainer.prototype.getPageMenuItems = function () {
	var name, items = [];
	for ( name in ve.demoPages ) {
		items.push(
			new OO.ui.MenuOptionWidget( {
				data: ve.demoPages[ name ],
				label: name
			} )
		);
	}
	return items;
};

/**
 * Change mode or page
 *
 * @param {string} mode Mode to switch to: 've', 'edit or 'read'
 * @param {string} [page] Page to load
 * @return {jQuery.Promise} Promise which resolves when change is complete
 */
ve.demo.SurfaceContainer.prototype.change = function ( mode, page ) {
	var html, closePromise,
		container = this,
		currentDir = 'ltr';

	if ( mode === this.mode && !page ) {
		return $.Deferred().resolve().promise();
	}

	this.modeSelect.selectItemByData( mode );

	switch ( this.mode ) {
		case 've':
			closePromise = this.$surfaceWrapper.slideUp().promise();
			if ( !page ) {
				html = this.surface.getHtml();
				currentDir = this.surface.getModel().getDocument().getDir();
			}
			this.surface.destroy();
			this.surface = null;
			break;

		case 'edit':
			closePromise = this.sourceTextInput.$element.slideUp().promise();
			if ( !page ) {
				html = this.sourceTextInput.getValue();
			}
			break;

		case 'read':
			closePromise = this.$readView.slideUp().promise();
			if ( !page ) {
				html = ve.properInnerHtml( this.$readView[ 0 ] );
			}
			break;

		default:
			closePromise = $.Deferred().resolve().promise();
			break;
	}

	return closePromise.done( function () {
		var isRead = mode === 'read',
			otherDir = currentDir === 'ltr' ? 'rtl' : 'ltr',
			$editStylesheets = $( 'link[rel=stylesheet]:not(.stylesheet-read):not(.stylesheet-' + otherDir + ')' );

		$( '.ve-demo-targetToolbar' ).toggle( !isRead );
		container.$element.find( '.ve-demo-surfaceToolbar-edit' ).toggle( !isRead );
		container.$element.find( '.ve-demo-surfaceToolbar-read' ).toggle( isRead );
		$editStylesheets.prop( 'disabled', isRead );

		switch ( mode ) {
			case 've':
				if ( page ) {
					container.loadPage( page );
				} else if ( html !== undefined ) {
					container.loadHtml( html );
				}
				break;

			case 'edit':
				container.sourceTextInput.$element.show();
				container.sourceTextInput.setValue( html ).adjustSize();
				container.sourceTextInput.$element.hide().slideDown();
				break;

			case 'read':
				container.$readView.html( html ).css( 'direction', currentDir ).slideDown();
				break;
		}
		container.mode = mode;
	} );
};

/**
 * Load a page into the editor
 *
 * @param {string} src Path of html to load
 */
ve.demo.SurfaceContainer.prototype.loadPage = function ( src ) {
	var container = this;

	container.emit( 'changePage' );

	ve.init.platform.getInitializedPromise().done( function () {
		container.$surfaceWrapper.slideUp().promise().done( function () {
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

				container.loadHtml( pageHtml );
			} );
		} );
	} );
};

/**
 * Load HTML into the editor
 *
 * @param {string} pageHtml HTML string
 */
ve.demo.SurfaceContainer.prototype.loadHtml = function ( pageHtml ) {
	var container = this;

	if ( this.surface ) {
		this.surface.destroy();
	}

	this.surface = this.target.addSurface(
		ve.dm.converter.getModelFromDom(
			ve.createDocumentFromHtml( pageHtml ),
			{ lang: this.lang, dir: this.dir }
		),
		{ placeholder: 'Start your document' }
	);

	this.target.setSurface( this.surface );

	this.$surfaceWrapper.empty().append( this.surface.$element.parent() )
		.hide().slideDown().promise().done( function () {
			// Check surface still exists
			if ( container.surface ) {
				container.surface.getView().focus();
			}
		} );
};

/**
 * Reload the container
 *
 * @param {string} lang Language
 * @param {string} dir Directionality
 */
ve.demo.SurfaceContainer.prototype.reload = function ( lang, dir ) {
	var container = this;

	this.lang = lang;
	this.dir = dir;

	this.change( 've' ).done( function () {
		container.loadHtml( container.surface.getHtml() );
	} );
};

/**
 * Destroy the container
 */
ve.demo.SurfaceContainer.prototype.destroy = function () {
	var container = this;
	this.$element.slideUp().promise().done( function () {
		if ( container.surface ) {
			container.surface.destroy();
		}
		container.$element.remove();
	} );
	ve.demo.surfaceContainers.splice( ve.demo.surfaceContainers.indexOf( container ), 1 );
	this.emit( 'changePage' );
};
