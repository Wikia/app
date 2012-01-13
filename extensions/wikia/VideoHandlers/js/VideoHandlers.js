var VideoHandlers = {
	
	modalWidth:		666,

	init: function() {
		$('img.video-thumb').bind( 'click', VideoHandlers.displayVideoModal );
	},

	displayVideoModal : function(e) {
		e.stopPropagation();
		e.preventDefault();
		
		var thumb = $(e.target);
		var thumbData = thumb.data();

		$.nirvana.getJson(
			'VideoHandlerController',
			'getEmbedCode',
			{
				title: thumbData.video,
				width: thumb.width(),
				autoplay: true
			},
			function( res ) {
				if ( res.errors ) {
					$.showModal( thumbData.video, res.error, {
						'width': RelatedVideos.modalWidth
					});
				} else if ( res.embedCode ) {
				} else if ( res.html ) {
					$.showModal( thumbData.video, res.html, {
						'id': 'embedded-video-player',
						'width': VideoHandlers.modalWidth
					});
				} else {
					//@todo do something if modal seems to be broken
				}
			},
			function(){
				//@todo show error msg
			}
		);
	}
}

VideoHandlers.init();