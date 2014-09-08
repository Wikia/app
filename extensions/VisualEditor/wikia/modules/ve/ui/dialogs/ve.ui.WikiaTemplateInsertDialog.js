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

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTemplateInsertDialog.super.prototype.initialize.call( this );

	// Properties
	this.select = new OO.ui.SelectWidget( { '$': this.$ } );

	/* Temporary. Use this to generate 6 option widgets */
	var i, options;
	options = [];
	for ( i = 0; i < 6; i++ ) {
		options.push(
			new ve.ui.WikiaTemplateOptionWidget(
				i,
				{
					'$': this.$,
					'icon': 'template-reversed',
					'label': 'Super Long Template Name with truncated text because this thing is too long',
					'appears': '20'
				}
			)
		);
	}

	// Events

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaTemplateInsertDialog' );

	this.select.addItems( options );

	this.$body.append( this.select.$element );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTemplateInsertDialog );
