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
	gaCat:			'related-videos',

	init: function(relatedVideosModule) {
		this.rvModule = $(relatedVideosModule);
		if ( this.rvModule.closest('.WikiaRail').size() > 0 ) {
			this.onRightRail = true;
			this.videosPerPage = 3;
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
		var $RelatedVideosPlaceholder = $('span[data-placeholder="RelatedVideosModule"]');
		if ( !this.onRightRail && $RelatedVideosPlaceholder.length != 0 ){
			$RelatedVideosPlaceholder.replaceWith( relatedVideosModule );
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
			$('body').delegate( '#relatedvideos-video-player-embed-show', 'click', function() {
				$('#relatedvideos-video-player-embed-code').show();
				$('#relatedvideos-video-player-embed-show').hide();
			});

			RelatedVideos.maxRooms = relatedVideosModule.attr('data-count');
			if ( RelatedVideos.maxRooms < 1 ) {
				RelatedVideos.maxRooms = 1;
			}
			RelatedVideos.trackItemImpressions(RelatedVideos.currentRoom);
			RelatedVideos.checkButtonState();
			$('.addVideo',this.rvModule).tooltip({
				delay: { show: 500, hide: 100 }
			});
		}
		WikiaTracker.trackEvent(
			'trackingevent',
			{
				'ga_category':RelatedVideos.gaCat,
				'ga_action':WikiaTracker.ACTIONS.VIEW
			},
			'both'
		);
	},

	// Scrolling modal items

	scrollright: function(){
		RelatedVideos.showImages();
		WikiaTracker.trackEvent(
			'trackingevent',
			{
				'ga_category':RelatedVideos.gaCat,
				'ga_action':WikiaTracker.ACTIONS.PAGINATE,
				'ga_label':'paginate-next',
				'ga_value':RelatedVideos.currentRoom + 1
			},
			'both'
		);
		RelatedVideos.scroll( 1, false );
	},

	scrollleft: function(){
		WikiaTracker.trackEvent(
			'trackingevent',
			{
				'ga_category':RelatedVideos.gaCat,
				'ga_action':WikiaTracker.ACTIONS.PAGINATE,
				'ga_label':'paginate-prev',
				'ga_value':RelatedVideos.currentRoom - 1
			},
			'both'
		);
		RelatedVideos.scroll( -1, false );
	},

	scroll: function( param, callback ) {
		//setup variables

		var scroll_by, anim_time;
		if( this.onRightRail ) {
			scroll_by = parseInt( $('.group',this.rvModule).outerWidth(true) );
			anim_time = 300;
		} else {
			scroll_by = parseInt( $('.item',this.rvModule).outerWidth(true) * 3 );
			anim_time = 500;
		}
		//scroll_by = scroll_by * param;

		// button vertical secondary left
		var futureState = RelatedVideos.currentRoom + param;
		RelatedVideos.trackItemImpressions(futureState);
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

	initModalScroll: function( modal ) {
		this.rvAddModal = modal;
		this.rvAddPos = 1;
		this.rvAddMax = Math.ceil(($('.item',this.rvAddModal).length)/3);
		var $rvAddModal = $(this.rvAddModal);
		$rvAddModal.delegate( '.scrollleft', 'click', RelatedVideos.modalScrollLeft );
		$rvAddModal.delegate( '.scrollright', 'click', RelatedVideos.modalScrollRight );
		$rvAddModal.delegate( '.add-this-video', 'click', RelatedVideos.modalAddVideo );
        $rvAddModal.delegate( 'a.video', 'click', RelatedVideos.previewVideo );
        this.updateModalScrollButtons();
	},

    previewVideo: function() {
        var videoTitle = $(this).siblings(".item-title").eq(0).attr("data-dbkey");
        $.nirvana.postJson(
            'RelatedVideosController',
            'getVideoPreview',
            {
                vTitle: videoTitle
            },
            function( res ) {
                if ( res.html ) {
                    $("div.RVSuggestionCont", RelatedVideos.rvAddModal).hide();
                    $("div.RVSuggestPreviewVideo", RelatedVideos.rvAddModal).html( res.html );
                    RelatedVideos.bindPreviewActions();
                }
            },
            function(){
                RelatedVideos.showError();
            }
        );
        return false;
    },

    bindPreviewActions: function() {

        $( RelatedVideos.rvAddModal ).delegate( '.preview_back', 'click', function() {

            $("div.RVSuggestPreviewVideo .preview_container", RelatedVideos.rvAddModal).remove();
            $("div.RVSuggestionCont", RelatedVideos.rvAddModal).show();
            return false;
        } );
        $( RelatedVideos.rvAddModal ).delegate( '.insert', 'click', RelatedVideos.modalAddVideo );

    },

    updateModalScrollButtons: function() {

        if ( this.rvAddPos == 1 ) {
            $('.scrollleft',RelatedVideos.rvAddModal).addClass("inactive");
        } else {
            $('.scrollleft',RelatedVideos.rvAddModal).removeClass("inactive");
        }

        if ( this.rvAddPos == this.rvAddMax ) {
            $('.scrollright',RelatedVideos.rvAddModal).addClass("inactive");
        } else {
            $('.scrollright',RelatedVideos.rvAddModal).removeClass("inactive");
        }

    },

	modalAddVideo: function(ev) {
		var video = 'File:'+$(ev.target).closest('.item').children('.item-title').attr('data-dbkey');
		$('.videoUrl',RelatedVideos.rvAddModal).val(video);
		RelatedVideos.addVideoConfirm(ev);
	},

	modalScrollLeft: function() {
		RelatedVideos.modalScroll(-1);
        RelatedVideos.updateModalScrollButtons();
	},

	modalScrollRight: function() {
		RelatedVideos.modalScroll(1);
        RelatedVideos.updateModalScrollButtons();
	},

	modalScroll: function( param, callback ) {
		//setup variables

		var scroll_by = parseInt( $('.item',this.rvAddModal).outerWidth(true) * 3 );
		var anim_time = 500;

		// button vertical secondary left
		var futureState = RelatedVideos.rvAddPos + param;

		if( futureState >= 1 && futureState <= RelatedVideos.rvAddMax ) {
			var scroll_to = (futureState-1) * scroll_by;
			RelatedVideos.rvAddPos = futureState;
			//console.log('future state ' + futureState);

			//$('.container',this.rvAddModal).clearQueue();
			//RelatedVideos.checkButtonState();

			//scroll
			$('.container',this.rvAddModal).stop().animate({
				left: -scroll_to
			}, anim_time, function(){
				//hide description
				if (typeof callback == 'function') {
					callback();
				}
			});
		} else if (futureState == 0 && RelatedVideos.rvAddMax == 1) {
			$('.page',this.rvAddModal).text(1);
		}
	},

	trackItemImpressions: function(room) {
		var titles = [];
		var orders = [];
		var group = $( $('.container .group', this.rvModule)[room-1] );
		var itemLinks = group.find('a.video-thumbnail');
		itemLinks.each( function(i) {
			titles.push( $(this).data('ref') );
			orders.push( (room-1)*RelatedVideos.videosPerPage + i+1 );
		});

		if (titles.length) {
			WikiaTracker.trackEvent(
				'trackingevent',
				{
					'ga_category':RelatedVideos.gaCat,
					'ga_action':WikiaTracker.ACTIONS.IMPRESSION,
					'ga_label':'video',
					'video_titles': "'" + titles.join("','") + "'",
					'orders': orders.join(',')
				},
				'internal'
			);
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
			if( i % RelatedVideos.videosPerPage == 0 ) {
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
				var $thisJquery = $(this);
				if ( $thisJquery.attr( 'data-src' ) != "" ){
					$thisJquery.attr( 'src', $thisJquery.attr( 'data-src' ) );
				}
			}
		});
	},

	recalculateLength: function(){
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
		GlobalNotification.show( $('.errorWhileLoading').html(), 'error' );
	},

	// Video Modal

	displayVideoModal : function(e) {
		e.preventDefault();
		var $thisJquery = $(this);
		var url = $thisJquery.attr('data-ref');
		var external = $thisJquery.attr('data-external');
		var link = $thisJquery.attr('href');

		if( RelatedVideos.isHubVideos ) {
			var wikiLink = $thisJquery.attr('data-wiki');
			var controlerName = 'RelatedHubsVideosController';
		} else {
			var wikiLink = '';
			var controlerName = 'RelatedVideosController';
		}

		// get index of clicked item
		var eventValue = 0;
		var eventTarget = $(e.target);
		if (eventTarget) {
			var localItem = eventTarget.closest('.item');
			var localGroup = localItem.closest('.group');
			var container = localGroup.closest('.container');
			var allGroups = container.children();
			var localAllItems = localGroup.children();
			var localItemIndex = localAllItems.index(localItem);
			var localGroupIndex = allGroups.index(localGroup);
			var clickedIndex = (localGroupIndex * RelatedVideos.videosPerPage) + localItemIndex;
			eventValue = clickedIndex+1;	// tracked values must be one-indexed
		}

		WikiaTracker.trackEvent(
			'trackingevent',
			{
				'ga_category':RelatedVideos.gaCat,
				'ga_action':WikiaTracker.ACTIONS.PLAY_VIDEO,
				'ga_label':($(this).hasClass('video-thumbnail') ? 'thumbnail' : 'title'),
				'ga_value':eventValue,
				'video_title':url
			},
			'both'
		);

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
		var $relatedVideosAddVideo = $('#relatedvideos-add-video');
		$relatedVideosAddVideo.undelegate( '.rv-add-form', 'submit').removeClass('loading');
		$relatedVideosAddVideo.delegate( '.rv-add-form', 'submit', RelatedVideos.addVideoConfirm );
	},

	preventVideoSubmit: function(){
		var $relatedVideosAddVideo = $('#relatedvideos-add-video');
		$relatedVideosAddVideo.undelegate( '.rv-add-form', 'submit').addClass('loading');
		$relatedVideosAddVideo.delegate(
			'.rv-add-form',
			'submit',
			function( e ){
				e.preventDefault();
			}
		);

	},
	addVideoModal: function( target ){
		WikiaTracker.trackEvent(
			'trackingevent',
			{
				'ga_category':RelatedVideos.gaCat,
				'ga_action':WikiaTracker.ACTIONS.ADD,
				'ga_label':'add-video'
			},
			'both'
		);
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
							var $rvModule = $(RelatedVideos.rvModule);
							$rvModule.undelegate( '.addVideo', 'click' );
							$rvModule.delegate( '.addVideo', 'click', RelatedVideos.addVideoModal );
							RelatedVideos.enableVideoSubmit();
							RelatedVideos.initModalScroll('.modalContent');
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
		GlobalNotification.show( $('#relatedvideos-add-video .notifyHolder').html(), 'notify' );
		RelatedVideos.preventVideoSubmit();
		$.nirvana.postJson(
			'RelatedVideosController',
			'addVideo',
			{
				articleId: wgArticleId,
				url: $('#relatedvideos-add-video input').val()
			},
			function( formRes ) {
				WikiaTracker.trackEvent(
					'trackingevent',
					{
						'ga_category':RelatedVideos.gaCat,
						'ga_action':WikiaTracker.ACTIONS.ADD,
						'ga_label':'add-video-success'
					},
					'both'
				);
				GlobalNotification.hide();
				var $relatedVideosAddVideo = $('#relatedvideos-add-video');
				if ( formRes.error ) {
					$relatedVideosAddVideo.addClass( 'error-mode' );
					RelatedVideos.enableVideoSubmit();
					RelatedVideos.injectCaruselElementError( formRes.error );
				} else if ( formRes.html ){
					$relatedVideosAddVideo.removeClass( 'error-mode' );
					$relatedVideosAddVideo.closest('.modalWrapper').closeModal();
					RelatedVideos.injectCaruselElement( formRes.html );
				} else {
					$relatedVideosAddVideo.addClass( 'error-mode' );
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
				$( html ).css('display', 'inline-block') /* JSlint ignore */
					.prependTo( $('.container',RelatedVideos.rvModule) )
					.fadeOut( 0 )
					.fadeIn( 'slow', function(){
						RelatedVideos.recalculateLength();
					});
				RelatedVideos.regroup();
			}
		);
	},

	injectCaruselElementError: function( error ){
		$( '#relatedvideos-add-video .rv-error td' ).html( error );
	}

};

//on content ready
$().ready(function() {
	RelatedVideos.init($('#RelatedVideosRL').size() > 0 ? $('#RelatedVideosRL') : $('#RelatedVideos'));
});
