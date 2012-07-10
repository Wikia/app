MediaTool.Renderer = $.createClass(Observable,{

	constructor: function() {
		MediaTool.Renderer.superclass.constructor.call(this);

		MediaTool.bind('editDone', this.onEditDone, this);
	},

	onEditDone: function(cart) {
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

	getPreview: function(item, itemPreviewTpl) {

		return $.mustache(itemPreviewTpl, {
			itemTitle:"test",
			itemWidth:"300",
			itemHeight:"180",
			itemUrl:item.title
		});
	},

	updatePreview: function(item) {

	}

});
