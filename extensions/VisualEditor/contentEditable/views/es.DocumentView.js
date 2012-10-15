/**
 * Creates an es.DocumentView object.
 * 
 * @class
 * @constructor
 * @extends {es.DocumentViewBranchNode}
 * @param {es.DocumentModel} documentModel Document model to view
 * @param {es.SurfaceView} surfaceView Surface view this view is a child of
 */
es.DocumentView = function( model, surfaceView ) {
	// Inheritance
	es.DocumentViewBranchNode.call( this, model );

	// Properties
	this.surfaceView = surfaceView;

	// DOM Changes
	this.$.addClass( 'es-documentView' );
	this.$.attr('contentEditable', 'true');
};

/* Static Members */


/**
 * Mapping of symbolic names and splitting rules.
 * 
 * Each rule is an object with a self and children property. Each of these properties may contain
 * one of two possible values:
 *     Boolean - Whether a split is allowed
 *     Null - Node is a leaf, so there's nothing to split
 * 
 * @example Paragraph rules
 *     {
 *         'self': true
 *         'children': null
 *     }
 * @example List rules
 *     {
 *         'self': false,
 *         'children': true
 *     }
 * @example ListItem rules
 *     {
 *         'self': true,
 *         'children': false
 *     }
 */
es.DocumentView.splitRules = {};

/* Methods */

/**
 * Get the document offset of a position created from passed DOM event
 * 
 * @method
 * @param e {Event} Event to create es.Position from
 * @returns {Integer} Document offset
 */
es.DocumentView.prototype.getOffsetFromEvent = function( e ) {
	var position = es.Position.newFromEventPagePosition( e );
	return this.getOffsetFromRenderedPosition( position );
};

es.DocumentView.splitRules.document = {
	'self': false,
	'children': true
};

/* Inheritance */

es.extendClass( es.DocumentView, es.DocumentViewBranchNode );
