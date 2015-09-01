/*!
 * VisualEditor UserInterface Table Context class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context menu for editing tables.
 *
 * Two are usually generated for column and row actions separately.
 *
 * @class
 * @extends ve.ui.Context
 *
 * @constructor
 * @param {ve.ce.TableNode} tableNode
 * @param {string} itemGroup Tool group to use, 'col' or 'row'
 * @param {Object} [config] Configuration options
 * @cfg {string} [indicator] Indicator to use on button
 */
ve.ui.TableContext = function VeUiTableContext( tableNode, itemGroup, config ) {
	config = config || {};

	// Parent constructor
	ve.ui.TableContext.super.call( this, tableNode.surface.getSurface(), config );

	// Properties
	this.tableNode = tableNode;
	this.itemGroup = itemGroup;
	this.indicator = new OO.ui.IndicatorWidget( {
		classes: [ 've-ui-tableContext-indicator' ],
		indicator: config.indicator
	} );
	this.popup = new OO.ui.PopupWidget( {
		classes: [ 've-ui-tableContext-menu' ],
		$container: this.surface.$element,
		width: 150
	} );

	// Events
	this.indicator.$element.on( 'mousedown', this.onIndicatorMouseDown.bind( this ) );
	this.onDocumentMouseDownHandler = this.onDocumentMouseDown.bind( this );

	// Initialization
	this.popup.$body.append( this.$group );
	this.$element.addClass( 've-ui-tableContext' ).append( this.indicator.$element, this.popup.$element );
	// Visibility is handled by the table overlay
	this.toggle( true );
};

/* Inheritance */

OO.inheritClass( ve.ui.TableContext, ve.ui.Context );

/* Static Properties */

ve.ui.TableContext.static.groups = {
	col: [ 'insertColumnBefore', 'insertColumnAfter', 'deleteColumn' ],
	row: [ 'insertRowBefore', 'insertRowAfter', 'deleteRow' ]
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.TableContext.prototype.getRelatedSources = function () {
	var i, l,
		items = this.constructor.static.groups[ this.itemGroup ];

	if ( !this.relatedSources ) {
		this.relatedSources = [];

		for ( i = 0, l = items.length; i < l; i++ ) {
			this.relatedSources.push( {
				type: 'item',
				name: items[ i ]
			} );
		}
	}
	return this.relatedSources;
};

/**
 * @inheritdoc
 */
ve.ui.TableContext.prototype.onContextItemCommand = function () {
	this.toggleMenu( false );
};

/**
 * Handle mouse down events on the indicator
 *
 * @param {jQuery.Event} e Mouse down event
 */
ve.ui.TableContext.prototype.onIndicatorMouseDown = function ( e ) {
	e.preventDefault();
	this.toggleMenu();
};

/**
 * Handle document mouse down events
 *
 * @param {jQuery.Event} e Mouse down event
 */
ve.ui.TableContext.prototype.onDocumentMouseDown = function ( e ) {
	if ( !$( e.target ).closest( this.$element ).length ) {
		this.toggleMenu( false );
	}
};

/**
 * @inheritdoc
 */
ve.ui.TableContext.prototype.toggleMenu = function ( show ) {
	var dir, surfaceModel, surfaceView;

	// Parent method
	ve.ui.TableContext.super.prototype.toggleMenu.call( this, show );

	surfaceModel = this.surface.getModel();
	surfaceView = this.surface.getView();

	this.popup.toggle( show );
	if ( this.popup.isVisible() ) {
		this.tableNode.setEditing( false );
		surfaceModel.connect( this, { select: 'toggleMenu' } );
		surfaceView.$document.on( 'mousedown', this.onDocumentMouseDownHandler );
		dir = surfaceView.getDocument().getDirectionFromSelection( surfaceModel.getSelection() ) || surfaceModel.getDocument().getDir();
		this.$element
			.removeClass( 've-ui-dir-block-rtl ve-ui-dir-block-ltr' )
			.addClass( 've-ui-dir-block-' + dir );
	} else {
		surfaceModel.disconnect( this );
		surfaceView.$document.off( 'mousedown', this.onDocumentMouseDownHandler );
	}
};
