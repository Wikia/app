/**
 * Creates an ve.es.ListNode object.
 * 
 * @class
 * @constructor
 * @extends {ve.es.BranchNode}
 * @param {ve.dm.ListNode} model List model to view
 */
ve.es.ListNode = function( model ) {
	// Inheritance
	ve.es.BranchNode.call( this, model );

	// DOM Changes
	this.$.addClass( 'es-listView' );

	// Events
	var _this = this;
	this.model.on( 'update', function() {
		_this.enumerate();
	} );

	// Initialization
	this.enumerate();
};

/* Methods */

/**
 * Set the number labels of all ordered list items.
 * 
 * @method
 */
ve.es.ListNode.prototype.enumerate = function() {
	var styles,
		levels = [];
	for ( var i = 0; i < this.children.length; i++ ) {
		styles = this.children[i].model.getElementAttribute( 'styles' );
		levels = levels.slice( 0, styles.length );
		if ( styles[styles.length - 1] === 'number' ) {
			if ( !levels[styles.length - 1] ) {
				levels[styles.length - 1] = 0;
			}
			this.children[i].$icon.text( ++levels[styles.length - 1] + '.' );
		} else {
			this.children[i].$icon.text( '' );
			if ( levels[styles.length - 1] ) {
				levels[styles.length - 1] = 0;
			}
		}
	}
};

/* Registration */

ve.es.DocumentNode.splitRules.list = {
	'self': false,
	'children': true
};

/* Inheritance */

ve.extendClass( ve.es.ListNode, ve.es.BranchNode );
