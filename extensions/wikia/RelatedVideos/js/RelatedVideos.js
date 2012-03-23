/*global jwplayer:true */
var RelatedVideos = {

	lockTable:		[],
	videoPlayerLock:	false,
	maxRooms:		1,
	currentRoom:		1,
	modalWidth:		666,
	alreadyLoggedIn:	false,
	heightThreshold:	600,
	playerHeight:           371,
	onRightRail: false,
	videosPerPage: 3,
	rvModule: null,
	isHubVideos: false,
	isHubExtEnabled: false,
	isHubExtPage: false,
	gaCat:			'RelatedVideos',

	init: function(relatedVideosModule) {
		this.rvModule = $(relatedVideosModule);
		if ( this.rvModule.closest('.WikiaRail').size() > 0 ) {
			this.onRightRail = true;
			this.videosPerPage = 4;
		}
		
		if( this.rvModule.hasClass('RelatedHubsVideos') ) {
			this.isHubVideos = true;
		}
		
		if(typeof WikiaHubs != 'undefined' ) {
			this.isHubExtEnabled = true;
			if($('.WikiaHubs').length > 0 ) {
				this.isHubExtPage = true;
			}
		}

		var importantContentHeight = $('#WikiaArticle').height();
		importantContentHeight += $('#WikiaArticleComments').height();
		if ( !this.onRightRail && $('span[data-placeholder="RelatedVideosModule"]').length != 0 ){
			$('span[data-placeholder="RelatedVideosModule"]').replaceWith( relatedVideosModule );
		}
		if (
				(!this.isHubExtEnabled && (this.onRightRail || importantContentHeight >= RelatedVideos.heightThreshold)) 
				||
				(this.isHubExtEnabled && this.isHubExtPage && this.isHubVideos)
		) {
			relatedVideosModule.removeClass('RelatedVideosHidden');
			relatedVideosModule.delegate( 'a.video-play', 'click', RelatedVideos.displayVideoModal );
			relatedVideosModule.delegate( '.scrollright', 'click', RelatedVideos.scrollright );
			relatedVideosModule.delegate( '.scrollleft', 'click', RelatedVideos.scrollleft );
			relatedVideosModule.delegate( '.addVideo', 'click', RelatedVideos.addVideoLoginWrapper );
			relatedVideosModule.delegate( '.remove', 'click', RelatedVideos.removeVideoLoginWrapper );
			$('body').delegate( '#relatedvideos-video-player-embed-show', 'click', function() {
				$('#relatedvideos-video-player-embed-code').show();
				$('#relatedvideos-video-player-embed-show').hide();
			});
			
			RelatedVideos.maxRooms = relatedVideosModule.attr('data-count');
			if ( RelatedVideos.maxRooms < 1 ) {
				RelatedVideos.maxRooms = 1;
			}
			RelatedVideos.checkButtonState();
			$('.addVideo',this.rvModule).wikiaTooltip( $('.addVideoTooltip',this.rvModule).html() );
			if(this.onRightRail) {
				$('.remove',this.rvModule).wikiaTooltip( $('.removeVideoTooltip',this.rvModule).html() );
			}
		}
		WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.VIEW } );
	},

	// Scrolling modal items

	scrollright: function(){
		RelatedVideos.showImages();
		WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.PAGINATE, 'ga_label':'paginate-next', 'ga_value':RelatedVideos.currentRoom+1 } );
		RelatedVideos.scroll( 1, false );
	},

	scrollleft: function(){
		WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.PAGINATE, 'ga_label':'paginate-prev', 'ga_value':RelatedVideos.currentRoom-1 } );
		RelatedVideos.scroll( -1, false );
	},

	scroll: function( param, callback ) {
		//setup variables

		if( this.onRightRail ) {
			var scroll_by = parseInt( $('.group',this.rvModule).outerWidth(true) );
			var anim_time = 300;
		} else {
			var scroll_by = parseInt( $('.item',this.rvModule).outerWidth(true) * 3 );
			var anim_time = 500;
		}
		//scroll_by = scroll_by * param;

		// button vertical secondary left
		var futureState = RelatedVideos.currentRoom + param;
		//if (( $('#RelatedVideosRL .container').queue().length == 0 ) &&
		//	(( futureState >= 1 ) && ( futureState <= RelatedVideos.maxRooms ))) {
		if( futureState >= 1 && futureState <= RelatedVideos.maxRooms ) {
			var scroll_to = (futureState-1) * scroll_by;
			$('.page',this.rvModule).text(futureState);
			RelatedVideos.currentRoom = futureState;
			$('.container',this.rvModule).clearQueue();
			RelatedVideos.checkButtonState();
			//scroll
			$('.container',this.rvModule).stop().animate({
				left: -scroll_to
				//left: '-=' + scroll_by
			}, anim_time, function(){
				//hide description
				if (typeof callback == 'function') {
					callback();
				}
			});
		} else if (futureState == 0 && RelatedVideos.maxRooms == 1) {
            $('.page',this.rvModule).text(1);
        }
	},

	regroup: function() {
		if ( !this.onRightRail ) { return; }
		var container = $('.container',this.rvModule);
		$('.group .item',this.rvModule).each( function() {
			$(this).appendTo( container );
		});
		$('.group',this.rvModule).remove();

		var group = null;
		$('.container > .item',this.rvModule).each( function(i) {
			if( i % 4 == 0 ) {
				if(group) { group.appendTo( container ); }
				group = $('<div class="group"></div>');
			}
			$(this).appendTo( group );
		});
		if(group) { group.appendTo( container ); }

	},

	// State calculations & refresh

	checkButtonState: function() {
		$('.scrollleft',this.rvModule).removeClass( 'inactive' );
		$('.scrollright',this.rvModule).removeClass( 'inactive' );
		if ( RelatedVideos.currentRoom == 1 ){
			$('.scrollleft',this.rvModule).addClass( 'inactive' );
		}
		if ( RelatedVideos.currentRoom == RelatedVideos.maxRooms ) {
			$('.scrollright',this.rvModule).addClass( 'inactive' );
		}
	},

	showImages: function(){
		var rl = this;
		$('div.item a.video-thumbnail img',this.rvModule).each( function (i) {
			if ( i < ( ( RelatedVideos.currentRoom + (rl.videosPerPage-1) ) * rl.videosPerPage ) ){
				if ( $(this).attr( 'data-src' ) != "" ){
					$(this).attr( 'src', $(this).attr( 'data-src' ) );
				}
			}
		});
	},

	recalculateLenght: function(){
		var numberItems = $( '.container .item',this.rvModule ).size();
		$( '.tally em',this.rvModule ).html( numberItems );
        if ( numberItems == 0 ) {
            $( '.novideos' ).show();
        } else {
            $( '.novideos' ).hide();
        }
		if ( this.onRightRail ) {
			numberItems = Math.ceil( ( numberItems ) / this.videosPerPage );
		} else {
			numberItems = Math.ceil( ( numberItems + 1 ) / this.videosPerPage );
		}
        if( numberItems == 0) { numberItems = 1; }
		RelatedVideos.maxRooms = numberItems;
		$( '.maxcount',this.rvModule ).text( numberItems );
        if(numberItems < RelatedVideos.currentRoom) {
            RelatedVideos.scroll(-1);
        }
		RelatedVideos.checkButtonState();
	},

	// general helper functions

	loginWrapper: function ( callback, target ){
		var message = 'protected';
		if(( wgUserName == null ) || ( RelatedVideos.alreadyLoggedIn )){
			if (window.wgComboAjaxLogin) {
				showComboAjaxForPlaceHolder( false, "", function() {
					AjaxLogin.doSuccess = function() {
						$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
						RelatedVideos.alreadyLoggedIn = true;
						callback( target );
					};
					AjaxLogin.close = function() {
						$('#AjaxLoginBoxWrapper').closeModal();
						$( window ).scrollTop( $(RelatedVideos.rvModule).offset().top + 100 );
					}
				}, false, message );
			}
			else {
				UserLoginModal.show({
					callback: function() {
						$( window ).scrollTop( $(RelatedVideos.rvModule).offset().top + 100 );
						RelatedVideos.alreadyLoggedIn = true;
						callback(target);
					}
				});
			}
		} else {
			callback( target );
		}
	},

	showError: function(){
		GlobalNotification.warn( $('.errorWhileLoading').html() );
	},

	// Video Modal

	displayVideoModal : function(e) {
		e.preventDefault();
		var url = $(this).attr('data-ref');
		var external = $(this).attr('data-external');
		var link = $(this).attr('href');
		
		if( RelatedVideos.isHubVideos ) {
			var wikiLink = $(this).attr('data-wiki');
			var controlerName = 'RelatedHubsVideosController';
		} else {
			var wikiLink = '';
			var controlerName = 'RelatedVideosController';
		}
		
		// get index of clicked item
		var eventTarget = $(e.target);
		var localItem = eventTarget.closest('.item');
		var localGroup = localItem.closest('.group');
		var container = localGroup.closest('.container');
		var allGroups = container.children();
		var localAllItems = localGroup.children();
		var localItemIndex = localAllItems.index(localItem);
		var localGroupIndex = allGroups.index(localGroup);
		var clickedIndex = (localGroupIndex * RelatedVideos.videosPerPage) + localItemIndex;

		WikiaTracker.trackEvent( { 'tracking_method':'both', 
			'ga_category':RelatedVideos.gaCat, 
			'ga_action':WikiaTracker.ACTIONS.PLAY_VIDEO, 
			'ga_label':($(this).hasClass('video-thumbnail') ? 'thumbnail' : 'title'), 
			'ga_value':clickedIndex+1, // tracked values must be one-indexed
			'internal_params':{'video_title':url} } );

		$.nirvana.getJson(
			controlerName,
			'getVideo',
			{
				video_title: url,
				external: external,
				cityShort: window.cityShort,
				videoHeight: RelatedVideos.playerHeight,
				controlerName: controlerName,
				wikiLink: wikiLink
			},
			function( res ) {
				if ( res.error ) {
					$.showModal( /*res.title*/ '', res.error, {
						'width': RelatedVideos.modalWidth
					});
				} else if ( res.json ) {
					if( RelatedVideos.isHubVideos ) {
						var displayTitle = res.title;
						var modalId = 'relatehubsdvideos-video-player';
					} else {
						var displayTitle = '';
						var modalId = 'relatedvideos-video-player';
					}
					
					$.showModal( /*res.title*/ displayTitle, res.html, {
						'id': modalId,
						'width': RelatedVideos.modalWidth,
						'callback' : function(){
							$('#relatedvideos-video-player-embed-code').wikiaTooltip( $('.embedCodeTooltip',this.rvModule).html() );
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
			},
			function(){
				RelatedVideos.showError();
			}
		);
	},

	// Add Video

	addVideoLoginWrapper: function( e ){
		e.preventDefault();
		RelatedVideos.loginWrapper( RelatedVideos.addVideoModal, this );
	},

	enableVideoSubmit: function(){
		$('#relatedvideos-add-video').undelegate( '.rv-add-form', 'submit' );
		$('#relatedvideos-add-video').delegate( '.rv-add-form', 'submit', RelatedVideos.addVideoConfirm );

	},

	preventVideoSubmit: function(){
		$('#relatedvideos-add-video').undelegate( '.rv-add-form', 'submit' );
		$('#relatedvideos-add-video').delegate(
			'.rv-add-form',
			'submit',
			function( e ){
				e.preventDefault();
			}
		);

	},
	addVideoModal: function( target ){
		WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.ADD, 'ga_label':'add-video' } );
		$(this.rvModule).undelegate( '.addVideo', 'click' );
		$.nirvana.postJson(
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
							$(RelatedVideos.rvModule).undelegate( '.addVideo', 'click' );
							$(RelatedVideos.rvModule).delegate( '.addVideo', 'click', RelatedVideos.addVideoModal );
							RelatedVideos.enableVideoSubmit();
						}
					});
				}
			},
			function(){
				RelatedVideos.showError();
			}
		);
	},

	addVideoConfirm: function( e ){
		e.preventDefault();
		GlobalNotification.notify( $('#relatedvideos-add-video .notifyHolder').html() );
		RelatedVideos.preventVideoSubmit();
		$.nirvana.postJson(
			'RelatedVideosController',
			'addVideo',
			{
				articleId: wgArticleId,
				url: $('#relatedvideos-add-video input').val()
			},
			function( formRes ) {
				WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.ADD, 'ga_label':'add-video-success' } );
				GlobalNotification.hide();
				if ( formRes.error ) {
					$('#relatedvideos-add-video').addClass( 'error-mode' );
					RelatedVideos.enableVideoSubmit();
					RelatedVideos.injectCaruselElementError( formRes.error );
				} else if ( formRes.html ){
					$('#relatedvideos-add-video').removeClass( 'error-mode' );
					$('#relatedvideos-add-video').closest('.modalWrapper').closeModal();
					RelatedVideos.injectCaruselElement( formRes.html );
				} else {
					$('#relatedvideos-add-video').addClass( 'error-mode' );
					RelatedVideos.enableVideoSubmit();
					RelatedVideos.injectCaruselElementError( $('#relatedvideos-add-video .somethingWentWrong').html() );
				}
			},
			function(){
				RelatedVideos.showError();
			}
		);
	},

	injectCaruselElement: function( html ){
		$( '#relatedvideos-add-video' ).closest('.modalWrapper').closeModal();
		var scrollLength = -1 * ( RelatedVideos.currentRoom - 1 );
		RelatedVideos.scroll(
			scrollLength,
			function(){
				$( html ).css('display', 'inline-block')
					.prependTo( $('.container',RelatedVideos.rvModule) )
					.fadeOut( 0 )
					.fadeIn( 'slow', function(){
						RelatedVideos.recalculateLenght();
					});
				RelatedVideos.regroup();
			}
		);
	},

	injectCaruselElementError: function( error ){
		$( '#relatedvideos-add-video .rv-error td' ).html( error );
	},

	// Remove Video

	removeVideoLoginWrapper: function( e ){
		e.preventDefault();
		WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.REMOVE, 'ga_label':'remove-video' } );
		RelatedVideos.loginWrapper( RelatedVideos.removeVideoClick, this );
	},

	removeVideoClick: function( target ){
		var parentItem = $(target).parents('.item');
		var item = $(parentItem).find('a.video-thumbnail');
		var title = item.attr('data-ref');
		$.confirm({
			content: $( '.deleteConfirm',RelatedVideos.rvModule ).html(),
			onOk: function(){
				RelatedVideos.removeVideoItem( parentItem );
				WikiaTracker.trackEvent( { 'tracking_method':'both', 'ga_category':RelatedVideos.gaCat, 'ga_action':WikiaTracker.ACTIONS.REMOVE, 'ga_label':'remove-video-success', 'internal_params':{ 'video_title':title } } );
			}
		});
	},

	removeVideoItem: function( parentItem ){
		$( parentItem ).fadeTo( 'slow', 0 );
		var item = $(parentItem).find('a.video-thumbnail');
		$.nirvana.postJson(
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
					RelatedVideos.regroup();
				}

			},
			function(){
				RelatedVideos.showError();
			}
		);
	}
};

//on content ready
$().ready(function() {
	RelatedVideos.init($('#RelatedVideosRL').size() > 0 ? $('#RelatedVideosRL') : $('#RelatedVideos'));
});
