MediaTool.ItemsCollection = $.createClass(MediaTool.Collection,{

	containerId: null,
	containerListId: null,
	$container: null,
	$containerList: null,
	cartId: null,
	template: null,
	itemTemplate: null,

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
		var itemId = $item.attr('data-id');
		$item.fadeOut(function() {
			MediaTool.fire('ItemsCollection::itemFadedOut', $item, self.getItem(itemId));
			self.removeItem(itemId);
		});
	},

	onCartItemFadedOut: function($item, itemObject) {
		if(itemObject.origin != 'online') {
			this.appendItem($item, itemObject);
		}
	},

	appendItem: function( $item, itemObject ) {
		$item.appendTo( this.$containerList ).fadeIn();

		if(typeof itemObject == 'object') {
			this.addItem(itemObject);
		}
	},

	refreshItems: function() {
		var self = this;
		MediaTool.callBackend('getRecentMedia', {}, function(items) {
			self.items = [];
			$.each(items, function(i, item) {
				var newItem = new MediaTool.Item( item );

				self.items.push(newItem);
			});
			self.refreshTemplate();
		});
	},

	refreshTemplate: function() {
		var html = $.mustache(this.template, {
			'title':'Media recently added to wiki',
			'items':this.items
		}, {item: this.itemTemplate } /* partials */);

		this.$container.html(html);
		this.$container.removeClass('loading');

		MediaTool.fire('ItemsCollection::refreshTemplate');
	}

});