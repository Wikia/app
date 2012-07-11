MediaTool.Cart = $.createClass(MediaTool.Collection,{

	$container: null,
	containerId: null,
	collectionListId: null,
	template: null,
	thumbnailStyle: false,
	mediaSize: null,
	mediaLocation: '',

	constructor: function( containerId, collectionListId ) {
		MediaTool.Cart.superclass.constructor.call(this);
		this.containerId = containerId;
		this.collectionListId = collectionListId;

		MediaTool.bind('showModal', this.onShowModal, this);
		MediaTool.bind('ItemsCollection::itemAdded', this.onCollectionItemAdded, this);
		MediaTool.bind('ItemsCollection::itemFadedOut', this.onCollectionItemFadedOut, this);

		this.bind('itemsChanged', this.onItemsChanged, this);
	},

	onItemsChanged: function() {
		MediaTool.fire('Cart::itemsChanged');
		this.renderHeader();
	},

	onShowModal: function() {
		var self = this;
		this.$container = $('#'+this.containerId);
		this.clear();
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

	renderHeader: function() {
		var self = this;
		this.$container.find('h4').html($.msg('mediatool-selected-media-count', self.getItemsNum()));
	},

	onCollectionItemAdded: function($item) {
		// Item added to list, removing it from cart
		var self = this;
		var itemId = $item.attr('data-id');
		$item.fadeOut(function() {
			MediaTool.fire('Cart::itemFadedOut', $item, self.getItem(itemId));
			self.removeItem(itemId);
		});
	},

	onCollectionItemFadedOut: function($item, itemObject) {
		// Item faded out from list, adding it to cart
		this.appendItem($item, itemObject);
	},

	createItem: function( itemData, itemTemplate, itemOrigin ) {
		var itemId = itemOrigin+'-'+itemData.hash;

		if(!this.exists(itemId)) {
			var item = new MediaTool.Item(itemId, itemData.title, itemData.thumbHtml, itemData.thumbUrl);
			item.isVideo = itemData.isVideo;
			item.origin = itemOrigin;
			item.duration = itemData.duration;
			item.remoteUrl = itemData.remoteUrl;
			item.renderThumbHtml();

			var $item = $($.mustache(itemTemplate, item));

			$item.draggable({
				cancel: "a.ui-icon",
				revert: "invalid",
				containment: "document",
				helper: "clone",
				cursor: "move"
			});

			this.appendItem($item, item);
		}
	},

	uploadRemoteItems: function() {
		var urls = [];
		var self = this;

		$.each(this.items, function(i, item) {
			if(item.origin == 'online') {
				urls.push(item.remoteUrl);
				hasItems = true;
			}
		});

		if(urls.length > 0) {
			MediaTool.callBackend('uploadVideos', { urls: urls }, function(result) {
				$().log(result);
				$.each(result, function(i, r) {
					var item = self.findByRemoteUrl(r.url);
					if(item != null) {
						if(r.status == 'ok') {
							item.title = r.title;
						}
						else {
							self.removeItem(item.id);
						}
					}
				});
				MediaTool.fire('Cart::uploadRemoteItemsComplete', self);
			});
		}

		return (urls.length > 0);
	},

	findByRemoteUrl: function(url) {
		var result = null;
		$.each(this.items, function(i, item) {
			if(item.remoteUrl == url) {
				result = item;
			}
		});
		return result;
	},

	appendItem: function( $item, itemObject ) {
		var $list = $( "ul", this.$container).length ? $( "ul", this.$container ) : $( "<ul class='mediaToolItemList ui-helper-reset'/>" ).appendTo( this.$container );

		$item.appendTo( $list ).fadeIn();

		if(typeof itemObject == 'object') {
			this.addItem(itemObject);
		}
	},

	getThumbnailStyle: function() {
		return this.thumbnailStyle;
	},

	setThumbnailStyle: function(thumbnailStyle) {
		this.thumbnailStyle = thumbnailStyle;
		MediaTool.fire('Cart::thumbnailStyleChanged');
	},

	setMediaSize: function(mediaSize) {
		this.mediaSize = mediaSize;
		MediaTool.fire('Cart::mediaSizeChanged');
	},

	getMediaSize: function() {
		return this.mediaSize;
	},

	getMediaLocation: function() {
		return this.mediaLocation;
	},

	setMediaLocation: function(mediaLocation) {
		this.mediaLocation = mediaLocation;
		MediaTool.fire('Cart::mediaLocationChanged');
	}
});
