MediaTool.Renderer = $.createClass(Observable,{

	container: null,

	constructor: function() {
		MediaTool.Renderer.superclass.constructor.call(this);

		MediaTool.bind('editDone', this.onEditDone, this);
		MediaTool.bind('Cart::uploadRemoteItemsComplete', this.onUploadRemoteItemsComplete, this);
	},

	onUploadRemoteItemsComplete: function(cart) {
		this.renderCartContent(cart);
	},

	onEditDone: function(cart) {
		var hasRemoteItems = cart.uploadRemoteItems();
		if(!hasRemoteItems) {
			// no need to wait for upload result, proceed with rendering
			this.renderCartContent(cart);
		}
	},

	renderCartContent: function(cart) {
		RTE.mediaEditor.addVideo(this.getWikitext(cart), {});

		// @todo use events for that
		cart.clear();
	},

	getWikitext: function(cart) {
		var result = '';
		$.each(cart.items, function(i, item) {
			result += "[["+item.title+"]]\n";
		});
		return result;
	},

	getMediaThumb: function(item) {
		return '<div class="timer">'+item.duration+'</div><span class="Wikia-video-play-button min" style="width: 96px; height: 72px;"></span><img alt="" src="'+item.thumbUrl+'" width="96" height="72" data-video="'+item.title+'" class="Wikia-video-thumb"/>';
	},

	getPreview: function(item, params) {

		return $.mustache(params.itemTpl, {
			itemTitle:item.title,
			itemWidth:params.width,
			itemHeight:item.getHeight(params.width),
			itemRatio:item.ratio,
			itemUrl:item.thumbUrl
		});
	},

	updatePreview: function( params ) {

		this.container = $('.mediatool-preview', MediaTool.dialogWrapper);

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
			 var aspectRatio =  image.attr('data-aspect-ratio') + 0;
			 var imgHeight = Math.floor( params.width / aspectRatio );
			 image.css({ width:params.width, height:imgHeight} );
			 playButton.css( {width:params.width, height:imgHeight} );
			 playButton.attr("class", "Wikia-video-play-button "+playOverlayClass);
		 });
	}

});
