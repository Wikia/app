var VideoHandlers = {
	
	modalWidth:		666,

	init: function() {
		$('img.video-thumb').bind( 'click', VideoHandlers.displayVideoEmbed );
		//@todo check with macbre if delegate is costly
//		$('#WikiaArticle').delegate( 'img.video-thumb', 'click', VideoHandlers.displayVideoEmbed );
	},
	
	displayVideoEmbed : function(e) {
		e.stopPropagation();
		e.preventDefault();
		
		var thumb = $(e.target);
		var thumbData = thumb.data();
		var thumbParent = thumb.parent();
		
		thumbParent.startThrobbing();
		
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
				VideoHandlers.handleResponse(res, thumbParent)
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
			//@todo tbd
			elem.html('<div style="width: '+res.embedCode.width+'; height: '+res.embedCode.height+';"><div id="'+res.embedCode.id+'"></div></div>');
			jwplayer( res.embedCode.id ).setup( res.embedCode );
		} else {
			//@todo error
		}
		
	},

	displayVideoModal : function(e) {
		e.stopPropagation();
		e.preventDefault();
		
		var thumb = $(e.target);
		var thumbData = thumb.data();
		var thumbParent = thumb.parent();


//		$.showModal( thumbData.video, '', {
//			'id': 'embedded-video-player',
//			'width': RelatedVideos.modalWidth,
//			'callback' : function(){
//				
//				
//				
//				
//				
//				jwplayer( res.embedCode.id ).setup( res.embedCode );
//			}			
//		});
		
		
		
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