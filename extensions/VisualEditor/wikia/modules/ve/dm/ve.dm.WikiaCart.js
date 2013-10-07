ve.dm.WikiaCart = function VeDmWikiaCart() {
	// Mixin constructors
	ve.EventEmitter.call( this );

	this.items = [];
};

/* Inheritance */

ve.mixinClass( ve.dm.WikiaCart, ve.EventEmitter );

/* Methods */

ve.dm.WikiaCart.prototype.addItems = function ( items, index ) {
	this.removeItems( items );
	if ( index === undefined || index < 0 || index >= this.items.length ) {
		this.items.push.apply( this.items, items );
	} else if ( index === 0 ) {
		this.items.unshift.apply( this.items, items );
	} else {
		this.items.splice.apply( this.items, [ index, 0 ].concat( items ) );
	}
	this.emit( 'add', items, index === undefined ? this.items.length - items.length : index );
};

ve.dm.WikiaCart.prototype.removeItems = function ( items ) {
	var i, index;
	for ( i = 0; i < items.length; i++ ) {
		index = this.items.indexOf( items[i] );
		if ( index !== -1 ) {
			this.items.splice( index, 1 );
		}
	}
	this.emit( 'remove', items );
};

ve.dm.WikiaCart.prototype.clearItems = function () {
	var items = this.items.slice();
	this.items = [];
	this.emit( 'remove', items );
};