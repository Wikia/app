$(function() {
	WikiaNewFiles.init();
});

var WikiaNewFiles = {
	init: function() {
		$("#gallery-")
		.find(".wikia-gallery-item-user").click(function() { WikiaNewFiles.resultTrack($(this), 'username') })
		.end()
		.find(".wikia-gallery-item-posted").click(function() { WikiaNewFiles.resultTrack($(this), 'postedinArticle') })
		.end()
		.find(".wikia-gallery-item-more").click(function() { WikiaNewFiles.resultTrack($(this), 'postedinMore') });

		$("#newfiles-nav")
		.find(".navigation-showbots").click(function() { WikiaNewFiles.navTrack('showbots') })
		.end()
		.find(".navigation-hidebots").click(function() { WikiaNewFiles.navTrack('hidebots') })
		.end()
		.find(".navigation-older").click(function() { WikiaNewFiles.navTrack('older') })
		.end()
		.find(".navigation-newer").click(function() { WikiaNewFiles.navTrack('newer') })
		.end()
		.find(".navigation-filesfrom").click(function() { WikiaNewFiles.navTrack('filesfrom') });
	},

	resultTrack: function( elem, linkType ) {
		var index = elem.closest(".wikia-gallery-item").prevAll().length + 1;
		//alert("Tracking '" + '/newFilesGallery/' + linkType + '/' + index + "'");
		$.tracker.byStr('/newFilesGallery/' + linkType + '/' + index);
	},

	navTrack: function ( navType ) {
		//alert("Tracking '" + '/newFilesGallery/' + navType + "'")
		$.tracker.byStr('/newFilesGallery/' + navType)
	}
};
