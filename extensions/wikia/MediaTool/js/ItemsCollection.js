MediaTool.ItemsCollection = $.createClass(Observable,{

	items: [],
	containerId: null,
	containerListId: null,
	$container: null,
	$containerList: null,
	cartId: null,
	template: null,

	constructor: function( containerId, containerListId, cartId ) {
		MediaTool.ItemsCollection.superclass.constructor.call(this);
		this.containerId = containerId;
		this.containerListId = containerListId;
		this.cartId = cartId;

		MediaTool.bind('showModal', this.onShowModal, this);
		MediaTool.bind('ItemsCollection::refreshTemplate', this.onRefreshTemplate, this);
		MediaTool.bind('Cart::itemAdded', this.onCartItemAdded, this);
		MediaTool.bind('Cart::itemFadedOut', this.onCartItemFadedOut, this);
	},

	onShowModal: function() {
		this.$container = $('#'+this.containerId);
		this.$container.addClass('loading');
		this.refreshItems();
	},

	onRefreshTemplate: function() {
		var self = this;
		this.$containerList = $('#'+this.containerListId);
		$( "li", this.$containerList ).draggable({
			cancel: "a.ui-icon",
			revert: "invalid",
			containment: "document",
			helper: "clone",
			cursor: "move"
		});

		// Item dropped back from cart to list
		this.$containerList.droppable({
			accept: "#"+self.cartId+" li",
			activeClass: "custom-state-active",
			drop: function( event, ui ) {
				MediaTool.fire('ItemsCollection::itemAdded', ui.draggable);
			}
		});
	},

	onCartItemAdded: function($item) {
		// Item added to cart, removing it from list
		var self = this;
		$item.fadeOut(function() {
			MediaTool.fire('ItemsCollection::itemFadedOut', $item, self.getItem($item.attr('data-id')));
		});
		this.removeItem();
	},

	onCartItemFadedOut: function($item) {
		this.appendItem($item);
	},

	removeItem: function(itemId) {
		// @todo implement
	},

	appendItem: function( $item ) {
		$item.appendTo( this.$containerList ).fadeIn();
	},

	refreshItems: function() {
		var self = this;
		MediaTool.callBackend('getRecentMedia', {}, function(items) {
			self.items = [];
			$.each(items, function(i, item) {
				self.items.push(new MediaTool.Item('item-'+(i+1), item.video, item.file, item.thumbHtml));
			});
			self.refreshTemplate();
		});
	},

	refreshTemplate: function() {
		var html = $.mustache(this.template, {
			'title':'Media recently added to wiki',
			'items':this.items
		});
		this.$container.html(html);
		this.$container.removeClass('loading');

		MediaTool.fire('ItemsCollection::refreshTemplate');
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