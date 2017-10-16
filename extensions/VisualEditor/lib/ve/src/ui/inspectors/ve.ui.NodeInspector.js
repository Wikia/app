/*!
 * VisualEditor user interface NodeInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Inspector for working with a node.
 *
 * @class
 * @extends ve.ui.FragmentInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.NodeInspector = function VeUiNodeInspector( config ) {
	// Parent constructor
	ve.ui.FragmentInspector.call( this, config );

	// Properties
	this.selectedNode = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.NodeInspector, ve.ui.FragmentInspector );

/* Static Properties */

/**
 * Node classes compatible with this dialog.
 *
 * @static
 * @property {Function}
 * @inheritable
 */
ve.ui.NodeInspector.static.modelClasses = [];

/* Methods */

/**
 * Get the selected node.
 *
 * Should only be called after setup and before teardown.
 * If no node is selected or the selected node is incompatible, null will be returned.
 *
 * @param {Object} [data] Inspector opening data
 * @return {ve.dm.Node} Selected node
 */
ve.ui.NodeInspector.prototype.getSelectedNode = function () {
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
ve.ui.NodeInspector.prototype.initialize = function ( data ) {
	// Parent method
	ve.ui.NodeInspector.super.prototype.initialize.call( this, data );

	// Initialization
	this.$content.addClass( 've-ui-nodeInspector' );
};

/**
 * @inheritdoc
 */
ve.ui.NodeInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.NodeInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.selectedNode = this.getSelectedNode( data );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.NodeInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.NodeInspector.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			this.selectedNode = null;
		}, this );
};
