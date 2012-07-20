MediaTool.Renderer = $.createClass(Observable,{

	container: null,

	constructor: function() {
		MediaTool.Renderer.superclass.constructor.call(this);
	},

	getMediaThumb: function(item) {
		return '<div class="timer">'+item.duration+'</div><span class="Wikia-video-play-button min" style="width: 96px; height: 72px;"></span><img alt="" src="'+item.thumbUrl+'" width="96" height="72" data-video="'+item.title+'" class="Wikia-video-thumb"/>';
	},

	getPreview: function(item, params) {
		var itemPreview = '';
		if ( params.useBorder ) {

			itemPreview =  $.mustache(params.borderTpl, {
				itemWidth:params.width+2,
				name: item.uploader.name,
				userPageUrl: item.uploader.userPageUrl,
				avatarUrl: item.uploader.avatarUrl,
				photo: $.mustache(params.itemTpl, {
					itemTitle:item.title,
					itemWidth:params.width,
					itemHeight:item.getHeight(params.width),
					itemRatio:item.ratio,
					itemUrl:item.thumbUrl
				})
			});

		} else {

			itemPreview = $.mustache(params.itemTpl, {
				itemTitle:item.title,
				itemWidth:params.width,
				itemHeight:item.getHeight(params.width),
				itemRatio:item.ratio,
				itemUrl:item.thumbUrl
			});
		}
		return $.mustache(params.inputsTpl, {
			itemPreview: itemPreview,
			itemTitle: item.title,
			itemCaption: item.caption,
			canEditName: (item.origin === "online"),
			itemName: item.name,
			itemId: item.id,
			itemOrigin: item.origin,
			canFollow: (item.origin !== "remote"),
			itemIsFollowed: item.isFollowed,
			itemCaption: item.caption,
			itemDescription: item.description
		});
	}

});

MediaTool.MainRenderer = $.createClass(MediaTool.Renderer,{
	constructor: function() {
		MediaTool.MainRenderer.superclass.constructor.call(this);
		MediaTool.bind('editDone', this.onEditDone, this);
		MediaTool.bind('Cart::uploadRemoteItemsComplete', this.onUploadRemoteItemsComplete, this);
	},

	wikiTextCallback: null,

	setWikiTextCallback: function(wikiTextCallback) {
		this.wikiTextCallback = wikiTextCallback;
	},

	onEditDone: function(cart) {
		var hasRemoteItems = cart.uploadRemoteItems();
		if(!hasRemoteItems) {
			// no need to wait for upload result, proceed with rendering
			this.renderCartContent(cart);
		}
	},

	renderCartContent: function(cart) {
		if (this.wikiTextCallback) {
			this.wikiTextCallback( this.getWikitext(cart) );
		}

		// @todo use events for that
		cart.clear();
	},

	onUploadRemoteItemsComplete: function(cart) {
		this.renderCartContent(cart);
	},

	getWikitext: function(cart) {
		var result = '';
		var mediaStyle = (cart.getThumbnailStyle() ? '|thumb' : '') + '|' + cart.getMediaLocation() + '|' + cart.getMediaSize() + 'px';
		$.each(cart.items, function(i, item) {
			result += "[[" + item.title + mediaStyle + "]]\n";
		});
		return result;
	},

	updatePreview: function( params ) {

		this.container = $('.media-tool-preview', MediaTool.dialogWrapper);

		var playOverlayClass = "mid";

		if ( params.width <= 170 ) {
			playOverlayClass = 'min';
		}
		if ( params.width > 360 ) {
			playOverlayClass = 'max';
		}

		$('a.image', this.container).each(function() {

			var playButton = $(this).find('span.Wikia-video-play-button');
			var image = $(this).find('img');
			var aspectRatio =  parseFloat( image.attr('data-aspect-ratio') );
			var imgHeight = Math.floor( params.width / aspectRatio );
			image.css({ width:params.width, height:imgHeight} );
			playButton.css( {width:params.width, height:imgHeight} );
			playButton.attr("class", "Wikia-video-play-button "+playOverlayClass);
			$(this).parents('figure.thumb').eq(0).css( {width: parseInt(params.width,10)+2 } );
		});

	}

});
