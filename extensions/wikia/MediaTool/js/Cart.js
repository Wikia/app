MediaTool.Cart = $.createClass(Observable,{

	items: [],
	$container: null,
	containerId: null,
	collectionListId: null,
	template: null,

	constructor: function( containerId, collectionListId ) {
		MediaTool.Cart.superclass.constructor.call(this);
		this.containerId = containerId;
		this.collectionListId = collectionListId;

		MediaTool.bind('showModal', this.onShowModal, this);
		MediaTool.bind('ItemsCollection::itemAdded', this.onCollectionItemAdded, this);
		MediaTool.bind('ItemsCollection::itemFadedOut', this.onCollectionItemFadedOut, this);
		MediaTool.bind('Cart::itemsChanged', this.onItemsChanged, this);
	},

	onShowModal: function() {
		var self = this;
		this.$container = $('#'+this.containerId);
		this.clear();       // @todo: or this.items = [];, not sure right now
		// Item dropped to cart from list
		this.$container.droppable({
			accept: "#"+self.collectionListId+" li",
			activeClass: "ui-state-highlight",
			drop: function( event, ui ) {
				MediaTool.fire('Cart::itemAdded', ui.draggable);
			}
		});
		this.renderHeader();
	},

	onItemsChanged: function() {
		this.renderHeader();
	},

	renderHeader: function() {
		var self = this;
		$().log('Rendering header, items:'+self.getItemsNum());
        this.$container.find('h4').html($.msg('mediatool-selected-media-count', self.getItemsNum()));
	},

	onCollectionItemAdded: function($item) {
		// Item added to list, removing it from cart
		$item.fadeOut(function() {
			MediaTool.fire('Cart::itemFadedOut', $item);
		});
		this.removeItem($item.attr('data-id'));
	},

	onCollectionItemFadedOut: function($item, itemObject) {
		// Item faded out from list, adding it to cart
		this.appendItem($item, itemObject);
		this.addItem(itemObject);
	},

	addItem: function( item ) {
		this.items.push(item);
		MediaTool.fire('Cart::itemsChanged');
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

		MediaTool.fire('Cart::itemsChanged');
	},

	appendItem: function( $item ) {
		var $list = $( "ul", this.$container).length ? $( "ul", this.$container ) : $( "<ul class='mediaToolItemList ui-helper-reset'/>" ).appendTo( this.$container );

		$item.appendTo( $list ).fadeIn();
	},

	getItemsNum: function() {
		return this.items.length;
	},

	isEmpty: function() {
		return ( this.getItemsNum() == 0 );
	},

	clear: function() {
		this.items = [];
		MediaTool.fire('Cart::itemsChanged');
	}

});
