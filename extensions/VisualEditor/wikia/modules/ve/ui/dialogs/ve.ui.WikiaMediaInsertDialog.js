/*!
 * VisualEditor user interface WikiaMediaInsertDialog class.
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.WikiaMediaInsertDialog = function VeUiMWMediaInsertDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );

	// Properties
	this.panels = {};
	this.pages = {};
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaInsertDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.WikiaMediaInsertDialog.static.name = 'wikiaMediaInsert';

ve.ui.WikiaMediaInsertDialog.static.icon = 'media';

/* Methods */

/**
 * Add a page to a panel.
 *
 * @method
 * @param {string} panelName Symbolic name of panel
 * @param {string} pageName Symbolic name of page
 * @param {Object} [config] Condifugration options
 * @chainable
 */
ve.ui.WikiaMediaInsertDialog.prototype.addPage = function ( panelName, pageName, config ) {
	var panel = new ve.ui.PanelLayout( { '$$': this.frame.$$, 'scrollable': true } );

	panel.$.removeClass( 've-ui-panelLayout' );

	this.pages[panelName][pageName] = panel;

	if ( config.$content ) {
		panel.$.append( config.$content );
	}

	this.panels[panelName].addItems( [panel], config.index );

	return this;
};

ve.ui.WikiaMediaInsertDialog.prototype.initialize = function () {
	var panel;

	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.panels.contentPanel = new ve.ui.StackPanelLayout( { '$$': this.frame.$$ } );

	// Initialization
	for ( panel in this.panels ) {
		this.pages[panel] = {};
	}

	// TODO: replace with widget
	this.$cart = this.$$( '<div>' )
		.addClass( 've-ui-wikiaMediaInsertDialog-cartWidget' )
		.text( 'Cart' )
		.appendTo( this.$body );

	this.panels.contentPanel.$
		.addClass( 've-ui-wikiaMediaInsertDialog-contentPanel' )
		.prependTo( this.$body );

	this.addPage( 'contentPanel', 'testContent', {
		$content: this.$$( '<div>' ).text( 'content' )
	} );

	this.frame.$content.addClass( 've-ui-wikiaMediaInsertDialog-content' );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaMediaInsertDialog );
