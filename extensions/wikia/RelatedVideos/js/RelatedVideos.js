var RelatedVideos = {
	
	lockTable:		new Array(),
	videoPlayerLock:	false,
	maxRooms:		1,
	currentRoom:		1,
	modalWidth:		660,
	playerHeight:		371,

	init: function() {
		$('#RelatedVideos').delegate( 'a.video-thumbnail', 'click', RelatedVideos.displayVideoModal );
		$('#RelatedVideos').delegate( '.scrollright', 'click', RelatedVideos.scrollright );
		$('#RelatedVideos').delegate( '.scrollleft', 'click', RelatedVideos.scrollleft );
		$('#RelatedVideos').delegate( '.addVideo', 'click', RelatedVideos.addVideoLoginWrapper );
		$('#RelatedVideos').delegate( '.remove', 'click', RelatedVideos.removeVideoLoginWrapper );
		RelatedVideos.maxRooms = $('#RelatedVideos').attr('data-count');
		if ( RelatedVideos.maxRooms < 1 ) RelatedVideos.maxRooms = 1;
		RelatedVideos.checkButtonState();
		$('#RelatedVideos .addVideo').wikiaTooltip( $('#RelatedVideos .addVideoTooltip').html() );		
	},

	// Scrolling modal items

	scrollright: function(){
		RelatedVideos.showImages();
		RelatedVideos.track( 'module/scrollRight' );
		RelatedVideos.scroll( 1, false );
	},
	
	scrollleft: function(){
		RelatedVideos.track( 'module/scrollLight' );
		RelatedVideos.scroll( -1, false );
	},

	scroll: function( param, callback ) {
		//setup variables

		var scroll_by = parseInt( $('#RelatedVideos .item').outerWidth(true) * 3 );
		scroll_by = scroll_by * param;
		// button vertical secondary left
		var futureState = RelatedVideos.currentRoom + param;
		if (( $('#RelatedVideos .container').queue().length == 0 ) &&
			(( futureState >= 1 ) && ( futureState <= RelatedVideos.maxRooms ))) {
			//scroll
			$('#RelatedVideos .container').animate({
				left: '-=' + scroll_by
			}, 500, function(){
				//hide description
				RelatedVideos.currentRoom = futureState;
				$('#RelatedVideos .container').clearQueue();
				RelatedVideos.checkButtonState();
				if (typeof callback == 'function') {
					callback();
				}
			});
			
		}
	},
	// State calculations & refresh

	checkButtonState: function(){

		$('#RelatedVideos .scrollleft').removeClass( 'inactive' );
		$('#RelatedVideos .scrollright').removeClass( 'inactive' );
		if ( RelatedVideos.currentRoom == 1 ){
			$('#RelatedVideos .scrollleft').addClass( 'inactive' );
		}
		if ( RelatedVideos.currentRoom == RelatedVideos.maxRooms ) {
			$('#RelatedVideos .scrollright').addClass( 'inactive' );
		}
	},

	showImages: function(){
		$('#RelatedVideos div.item a.video-thumbnail img').each( function (i) {
			if ( i < ( ( RelatedVideos.currentRoom + 2 ) * 3 ) ){
				if ( $(this).attr( 'data-src' ) != "" ){
					$(this).attr( 'src', $(this).attr( 'data-src' ) );
				}
			}
		});
	},
	
	recalculateLenght: function(){
		var numberItems = $( '#RelatedVideos .container .item' ).size();
		$( '#RelatedVideos .tally em' ).html( numberItems );
		numberItems = Math.ceil( ( numberItems + 1 ) / 3 );
		RelatedVideos.maxRooms = numberItems;
		RelatedVideos.checkButtonState();
	},

	// general helper functions

	loginWrapper: function ( callback, target ){
		var message = 'protected';
		if( wgUserName == null){
			showComboAjaxForPlaceHolder( false, "", function() {
				AjaxLogin.doSuccess = function() {
					$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
					callback( target );
				};
				AjaxLogin.close = function() {
					$('#AjaxLoginBoxWrapper').closeModal();
					$(window).scrollTop( $('#RelatedVideos').offset().top + 100 );
				}
			}, false, message );
		} else {
			callback( target );
		}
	},

	track: function(fakeUrl) {
		$.tracker.byStr('relatedVideos/' + fakeUrl);
	},

	// Video Modal

	displayVideoModal : function(e) {
		e.preventDefault();
		RelatedVideos.track( 'module/thumbnailClick' );
		var url = $(this).attr('data-ref');
		var external = $(this).attr('data-external');
		var link = $(this).attr('href');
		$.nirvana.getJson(
			'RelatedVideosController',
			'getVideo',
			{
				title: url,
				external: external,
				cityShort: window.cityShort,
				videoHeight: RelatedVideos.playerHeight
			},
			function( res ) {
				if ( res.json ) {
					$.showModal( /*res.title*/ '', res.html, {
						'id': 'relatedvideos-video-player',
						'width': RelatedVideos.modalWidth,
						'callback' : function(){
							$('#relatedvideos-video-player-embed-code').wikiaTooltip( $('#RelatedVideos .embedCodeTooltip').html() );
							jwplayer( res.json.id ).setup( res.json );
						}
					});
				} else if ( res.html ) {
					$.showModal( /*res.title*/ '', res.html, {
						'id': 'relatedvideos-video-player',
						'width': RelatedVideos.modalWidth
					});
				} else {
					// redirect if modal seems to be broken
					window.location.href = link;
				}
			}
		);
	},

	// Add Video

	addVideoLoginWrapper: function( e ){
		e.preventDefault();
		RelatedVideos.track( 'module/addVideo/beforeLogin' );
		RelatedVideos.loginWrapper( RelatedVideos.addVideoModal, this );
	},
	
	addVideoModal: function( target ){
		RelatedVideos.track( 'module/addVideo/afterLogin' );
		$('#RelatedVideos').undelegate( '.addVideo', 'click' );
		$.nirvana.getJson(
			'RelatedVideosController',
			'getAddVideoModal',
			{
				title: wgTitle,
				format: 'html'
			},
			function( res ) {
				if ( res.html ) {
					$.showModal( res.title, res.html, {
						id: 'relatedvideos-add-video',
						width: RelatedVideos.modalWidth,
						callback : function(){
							$('#RelatedVideos').undelegate( '.addVideo', 'click' );
							$('#RelatedVideos').delegate( '.addVideo', 'click', RelatedVideos.addVideoModal );
							$('#relatedvideos-add-video .relatedVideosConfirm').undelegate( '.button', 'click' );
							$('#relatedvideos-add-video .relatedVideosConfirm').delegate( '.button', 'click', RelatedVideos.addVideoConfirm );
						}
					});
				}
			}
		);
	},

	addVideoConfirm: function( e ){
		e.preventDefault();
		//GlobalNotification.notify( $('#relatedvideos-add-video .notifyHolder').html() );
		$('#relatedvideos-add-video .relatedVideosConfirm').undelegate( '.button', 'click', RelatedVideos.addVideoConfirm );
		$.nirvana.getJson(
			'RelatedVideosController',
			'addVideo',
			{
				articleId: wgArticleId,
				url: $('#relatedvideos-add-video input').val()
			},
			function( formRes ) {
				//GlobalNotification.hide();
				if ( formRes.error ) {
					$('#relatedvideos-add-video').addClass( 'error-mode' );
					$('#relatedvideos-add-video .relatedVideosConfirm').undelegate( '.button', 'click' );
					$('#relatedvideos-add-video .relatedVideosConfirm').delegate( '.button', 'click', RelatedVideos.addVideoConfirm );
					RelatedVideos.injectCaruselElementError( formRes.error );
				} else if ( formRes.html ){
					$('#relatedvideos-add-video').removeClass( 'error-mode' );
					$('#relatedvideos-add-video').closest('.modalWrapper').closeModal();
					RelatedVideos.injectCaruselElement( formRes.html );
				} else {
					$('#relatedvideos-add-video').addClass( 'error-mode' );
					$('#relatedvideos-add-video .relatedVideosConfirm').undelegate( '.button', 'click' );
					$('#relatedvideos-add-video .relatedVideosConfirm').delegate( '.button', 'click', RelatedVideos.addVideoConfirm );
					RelatedVideos.injectCaruselElementError( $('#relatedvideos-add-video .somethingWentWrong').html() );
				}
			}
		)
	},

	injectCaruselElement: function( html ){
		$( '#relatedvideos-add-video' ).closest('.modalWrapper').closeModal();
		var scrollLength = -1 * ( RelatedVideos.currentRoom - 1 );
		RelatedVideos.scroll(
			scrollLength,
			function(){
				$( html ).css('display', 'inline-block')
					.prependTo( $('#RelatedVideos .container') )
					.fadeOut( 0 )
					.fadeIn( 'slow', function(){
						RelatedVideos.recalculateLenght();
					});
			}
		);
	},

	injectCaruselElementError: function( error ){
		$( '#relatedvideos-add-video .rv-error td' ).html( error );
	},

	// Remove Video

	removeVideoLoginWrapper: function( e ){
		e.preventDefault();
		RelatedVideos.track( 'module/removeVideo/beforeLogin' );
		RelatedVideos.loginWrapper( RelatedVideos.removeVideoClick, this );
	},

	removeVideoClick: function( target ){
		RelatedVideos.track( 'module/removeVideo/afterLogin' );
		var parentItem = $(target).parents('.item');
		$.confirm({
			content: $( '#RelatedVideos .deleteConfirm' ).html(),
			onOk: function(){
				RelatedVideos.removeVideoItem( parentItem );
			}
		});
	},

	removeVideoItem: function( parentItem ){
		$( parentItem ).fadeTo( 'slow', 0 );
		var item = $(parentItem).find('a.video-thumbnail');
		$.nirvana.getJson(
			'RelatedVideosController',
			'removeVideo',
			{
				external:	item.attr('data-external'),
				title:		item.attr('data-ref'),
				articleId:	wgArticleId
			},
			function( formRes ) {
				if ( formRes.error ) {
					$.showModal( '', formRes.error, {
						'width': RelatedVideos.modalWidth,
						callback: function(){
							$( parentItem ).fadeTo( 'slow', 1 );
						}
					});
				} else {
					$(parentItem).remove();
					RelatedVideos.recalculateLenght();
					RelatedVideos.showImages();
				}

			}
		)
	}
};

//on content ready
RelatedVideos.init();