var VideoHandlers = {
	
	modalWidth:		666,
	playerWidth:		660,
	thumbWidthThreshold:	320,

	init: function() {
		$('img.video-thumb').bind( 'click', VideoHandlers.displayVideo );
		//@todo check with macbre if delegate is costly
//		$('#WikiaArticle').delegate( 'img.video-thumb', 'click', VideoHandlers.displayVideoEmbed );
	},
	
	displayVideo : function(e) {
		e.stopPropagation();
		e.preventDefault();
		
		var thumb = $(e.target);
		var thumbParent = thumb.parent();
		// thumbParent is an <a>. need to make relative and block for throbbing to work
		thumbParent.css('position', 'relative').css('display', 'block').startThrobbing();
		
		if (thumb.width() < VideoHandlers.thumbWidthThreshold) {
			VideoHandlers.displayVideoModal(thumb);
		}
		else {
			VideoHandlers.displayVideoEmbed(thumb);
		}
	},
	
	displayVideoEmbed : function(thumb) {		
		var thumbData = thumb.data();
		var thumbParent = thumb.parent();
		
		$.nirvana.getJson(
			'VideoHandlerController',
			'getEmbedCode',
			{
				title: thumbData.video,
				width: thumb.width(),
				autoplay: true
			},
			function( res ) {
				thumbParent.stopThrobbing();
				VideoHandlers.handleResponse(res, thumbParent);
			},
			function(){
				//@todo show error msg
				thumbParent.stopThrobbing();
			}
		);
	},
	
	handleResponse : function(res, elem) {
		if ( res.error ) {
			//@todo handle error
		} else if ( res.asset ) {
			$.getScript(res.asset, function() {
				elem.html('<div style="width: '+res.embedCode.width+'px; height: '+res.embedCode.height+'px; display: inline-block;"><div id="'+res.embedCode.id+'"></div></div>');
				jwplayer( res.embedCode.id ).setup( res.embedCode );
			});
		} else if ( res.embedCode ) {
			elem.html(res.embedCode);
		} else {
			//@todo error
		}
		
	},

	displayVideoModal : function(thumb) {
		var thumbData = thumb.data();
		var thumbParent = thumb.parent();
		
		$.nirvana.getJson(
			'VideoHandlerController',
			'getEmbedCode',
			{
				title: thumbData.video,
				width: VideoHandlers.playerWidth,
				autoplay: true
			},
			function( res ) {
				thumbParent.stopThrobbing();
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
				thumbParent.stopThrobbing();
			}
		);
	}
}

VideoHandlers.init();
