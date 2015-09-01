/*!
 * VisualEditor Standalone Initialization Mobile Target class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Initialization standalone mobile target.
 *
 * @class
 * @extends ve.init.sa.Target
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [toolbarConfig] Configuration options for the toolbar
 */
ve.init.sa.MobileTarget = function VeInitSaMobileTarget( config ) {
	// Parent constructor
	ve.init.sa.MobileTarget.super.call( this, config );

	this.$element.addClass( 've-init-sa-mobileTarget' );
};

/* Inheritance */

OO.inheritClass( ve.init.sa.MobileTarget, ve.init.sa.Target );

/* Static Properties */

ve.init.sa.MobileTarget.static.toolbarGroups = [
	// History
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-history' ),
		include: [ 'undo' ]
	},
	// Style
	{
		classes: [ 've-test-toolbar-style' ],
		type: 'list',
		icon: 'textStyle',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		include: [ { group: 'textStyle' }, 'language', 'clear' ],
		forceExpand: [ 'bold', 'italic', 'clear' ],
		promote: [ 'bold', 'italic' ],
		demote: [ 'strikethrough', 'code', 'underline', 'language', 'clear' ]
	},
	// Link
	{
		header: OO.ui.deferMsg( 'visualeditor-linkinspector-title' ),
		include: [ 'link' ]
	},
	// Structure
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-structure' ),
		type: 'list',
		icon: 'listBullet',
		indicator: 'down',
		include: [ { group: 'structure' } ],
		demote: [ 'outdent', 'indent' ]
	},
	// Insert
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		type: 'list',
		icon: 'insert',
		label: '',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		indicator: 'down',
		include: '*'
	},
	// Table
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-table' ),
		type: 'list',
		icon: 'table',
		indicator: 'down',
		include: [ { group: 'table' } ],
		demote: [ 'deleteTable' ]
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.init.sa.MobileTarget.prototype.createSurface = function ( dmDoc, config ) {
	return new ve.ui.MobileSurface( dmDoc, this.getSurfaceConfig( config ) );
};

/**
 * @inheritdoc
 */
ve.init.sa.MobileTarget.prototype.setupToolbar = function ( surface ) {
	// Parent method
	ve.init.sa.MobileTarget.super.prototype.setupToolbar.call( this, surface );

	this.getToolbar().$bar.append( surface.context.$element );
};
