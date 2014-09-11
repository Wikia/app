/*
 * VisualEditor user interface WikiaTemplateInsertDialog class.
 */

/**
 * Dialog for inserting templates.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTemplateInsertDialog = function VeUiWikiaTemplateInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaTemplateInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaTemplateInsertDialog.static.name = 'wikiaTemplateInsert';

ve.ui.WikiaTemplateInsertDialog.static.icon = 'template';

ve.ui.WikiaTemplateInsertDialog.static.title = OO.ui.deferMsg( 'visualeditor-dialog-transclusion-insert-template' );

/* Static Methods */

/**
 * Adds commas to numbers
 *
 * @param {number} number The number without commas
 * @returns {string} Comma separated sting
 */
ve.ui.WikiaTemplateInsertDialog.static.formatNumber = function ( number ) {
	while ( /(\d+)(\d{3})/.test( number.toString() ) ) {
		number = number.toString().replace( /(\d+)(\d{3})/, '$1' + ',' + '$2' );
	}
	return number;
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTemplateInsertDialog.super.prototype.initialize.call( this );

	// Properties
	this.stackLayout = new OO.ui.StackLayout( { '$': this.$ } );
	this.panel = new OO.ui.PanelLayout( { '$': this.$ } );
	this.select = new OO.ui.SelectWidget( { '$': this.$ } );
	this.offset = 0;

	// Events
	this.stackLayout.$element.on( 'scroll', ve.bind( this.onLayoutScroll, this ) );

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaTemplateInsertDialog' );
	this.select.$element.addClass( 'clearfix' );

	this.panel.$element.append( this.select.$element );
	this.stackLayout.addItems( [ this.panel ] );

	this.$body.append( this.stackLayout.$element );

	this.getMostLinkedTemplateData().done( ve.bind( this.populateOptions, this ) );
};

/**
 * Handle scrolling of the layout
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onLayoutScroll = function () {
	var position = this.stackLayout.$element.scrollTop() + this.stackLayout.$element.outerHeight(),
		threshold = this.select.$element.outerHeight() - 100;

	if ( !this.isPending() && this.offset !== null && position > threshold ) {
		this.getMostLinkedTemplateData().done( ve.bind( this.populateOptions, this ) );
	}
};

/**
 * Use the given template data to generate option widgets and populate the dialog's select widget
 *
 * @param {array} templates
 */
ve.ui.WikiaTemplateInsertDialog.prototype.populateOptions = function ( templates ) {
	var i,
		options = [];

	for ( i = 0; i < templates.length; i++ ) {
		options.push(
			new ve.ui.WikiaTemplateOptionWidget(
				templates[i],
				{
					'$': this.$,
					'icon': 'template-inverted',
					'label': templates[i].title,
					'appears': ve.ui.WikiaTemplateInsertDialog.static.formatNumber( templates[i].uses )
				}
			)
		);
	}

	this.select.addItems( options );
};

/**
 * Fetch the most-linked templates data
 *
 * @returns {jQuery.Promise}
 */
ve.ui.WikiaTemplateInsertDialog.prototype.getMostLinkedTemplateData = function () {
	var deferred = $.Deferred();

	this.pushPending();

	ve.init.target.constructor.static.apiRequest( {
		'action': 'templatesuggestions',
		'offset': this.offset
	} )
		.done( ve.bind( function ( data ) {
			this.offset = data['query-continue'] ? data['query-continue'] : null;
			this.popPending();
			deferred.resolve( data.templates );
		}, this ) )
		.fail( function () {
			deferred.resolve( [] );
		} );

	return deferred.promise();
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTemplateInsertDialog );
