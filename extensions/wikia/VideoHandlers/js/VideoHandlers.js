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
				if ( res.error ) {
					$.showModal( thumbData.video, res.error, {
						'width': RelatedVideos.modalWidth
					});
				} else if ( res.asset ) {
					$.getScript(res.asset, function() {
						$.showModal( thumbData.video, '<div id="'+res.embedCode.id+'"></div>', {
							'id': 'embedded-video-player',
							'width': VideoHandlers.modalWidth,
							'callback' : function(){
								jwplayer( res.embedCode.id ).setup( res.embedCode );
							}
						});
					});
				} else if ( res.embedCode ) {
					$.showModal( thumbData.video, res.embedCode, {
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