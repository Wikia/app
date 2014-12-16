/*!
 * VisualEditor user interface NodeDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Dialog for working with a node.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.NodeDialog = function VeUiNodeDialog( config ) {
	// Parent constructor
	ve.ui.NodeDialog.super.call( this, config );

	// Properties
	this.selectedNode = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.NodeDialog, ve.ui.FragmentDialog );

/* Static Properties */

/**
 * Node classes compatible with this dialog.
 *
 * @static
 * @property {Function}
 * @inheritable
 */
ve.ui.NodeDialog.static.modelClasses = [];

/* Methods */

/**
 * Get the selected node.
 *
 * Should only be called after setup and before teardown.
 * If no node is selected or the selected node is incompatible, null will be returned.
 *
 * @param {Object} [data] Dialog opening data
 * @return {ve.dm.Node} Selected node
 */
ve.ui.NodeDialog.prototype.getSelectedNode = function () {
	var i, len,
		modelClasses = this.constructor.static.modelClasses,
		selectedNode = this.getFragment().getSelectedNode();

	for ( i = 0, len = modelClasses.length; i < len; i++ ) {
		if ( selectedNode instanceof modelClasses[i] ) {
			return selectedNode;
		}
	}
	return null;
};

/**
 * @inheritdoc
 */
ve.ui.NodeDialog.prototype.initialize = function ( data ) {
	// Parent method
	ve.ui.NodeDialog.super.prototype.initialize.call( this, data );

	// Initialization
	this.$content.addClass( 've-ui-nodeDialog' );
};

/**
 * @inheritdoc
 */
ve.ui.NodeDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.NodeDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.selectedNode = this.getSelectedNode( data );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.NodeDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.NodeDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.selectedNode = null;
		}, this );
};
