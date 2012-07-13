MediaTool.VideoPreview = $.createClass(Observable,{

	container: null,

	constructor: function() {
		MediaTool.VideoPreview.superclass.constructor.call(this);
	},

	thumbnailClickAction: function(target) {

		var a = $(target).parents('a').eq(0);
		var img = a.find('img');
		var title = a.attr('data-video-name');
		this.displayInlineVideo(img, title);
	},

	displayInlineVideo: function(targetImage, imageName) {

		var parentTag = targetImage.parent();
		if (!parentTag.is('a')) {
			return;
		}
		parentTag.wrap('<span class="wikiaVideoPlaceholder" />');
		var wrapperTag = parentTag.parent('span.wikiaVideoPlaceholder');

		var imageWidth = targetImage.width();
		var imageHeight = targetImage.height();
		var remoteUrl = parentTag.attr("data-remote-url");


		MediaTool.callBackend('getEmbedCode', {
			'maxheight': imageHeight,
			'maxwidth': imageWidth,
			'imgTitle': imageName,
			'videoInline': 1,
			'remoteUrl': remoteUrl
		}, function(res) {
			jQuery(parentTag).siblings('span.Wikia-video-title-bar').eq(0).remove();
			if (res && ( res.html || res.jsonData ) ) {
				if (res.asset) {
					$.getScript(res.asset, function() {
						wrapperTag.find('a').hide();
						wrapperTag.append( '<div id="'+res.jsonData.id+'" style="width:'+imageWidth+'px; height:'+imageHeight+'px; display: inline-block;" class="Wikia-video-enabledEmbedCode"></div>');
						$('body').append('<script>' + res.jsonData.script + ' loadJWPlayer(); </script>');
					});
				} else {
					wrapperTag.find('a').hide();
					wrapperTag.append('<div  class="Wikia-video-enabledEmbedCode">'+res.html+'</div>');
				}
			}
		});

	}

});