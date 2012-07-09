MediaTool.Collection = $.createClass(Observable,{

	items: [],

	constructor: function() {
		MediaTool.Collection.superclass.constructor.call(this);
	},

	addItem: function( item ) {
		this.items.push(item);
		this.fire('itemsChanged');
	},

	removeItem: function( itemId ) {
		var self = this;
		var items = [];

		$.each(self.items, function(i, item) {
			if(item.id != itemId) {
				items.push(item);
			}
		});
		this.items = items;

		this.fire('itemsChanged');
	},

	getItemsNum: function() {
		return this.items.length;
	},

	isEmpty: function() {
		return ( this.getItemsNum() == 0 );
	},

	clear: function() {
		this.items = [];
		this.fire('itemsChanged');
	},

	getItem: function(id) {
		var result = null;
		$.each(this.items, function(i, item) {
			if(item.id == id) {
				result = item;
			}
		});
		return result;
	}

});