MediaTool.VideoPreview = $.createClass(Observable,{

	container: null,

	constructor: function() {
		MediaTool.VideoPreview.superclass.constructor.call(this);
	},

	thumbnailClickAction: function(target) {

		var a = $(target).parents('a').eq(0);
		var img = a.find('img');
		var title = a.attr('data-video-name');
		if ( typeof ImageLightbox != "undefined" ) {
			ImageLightbox.displayInlineVideo(img, title);
		}
	}


});