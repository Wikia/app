/**
 * Creates an ve.es.HeadingNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.LeafNode}
 * @param {ve.dm.HeadingNode} model Heading model to view
 */
ve.es.HeadingNode = function( model ) {
	// Inheritance
	ve.es.LeafNode.call( this, model );

	// Properties
	this.currentLevelHash = null;

	// DOM Changes
	this.$.addClass( 'es-headingView' );

	// Events
	var _this = this;
	this.model.on( 'update', function() {
		_this.setClasses();
	} );

	// Initialization
	this.setClasses();
};

/* Methods */

ve.es.HeadingNode.prototype.setClasses = function() {
	var level = this.model.getElementAttribute( 'level' );
	if ( level !== this.currentLevelHash ) {
		this.currentLevelHash = level;
		var classes = this.$.attr( 'class' );
		this.$
			// Remove any existing level classes
			.attr( 'class', classes.replace( / ?es-headingView-level[0-9]+/, '' ) )
			// Add a new level class
			.addClass( 'es-headingView-level' + level );
	}
};

/* Registration */

ve.es.DocumentNode.splitRules.heading = {
	'self': true,
	'children': null
};

/* Inheritance */

ve.extendClass( ve.es.HeadingNode, ve.es.LeafNode );
