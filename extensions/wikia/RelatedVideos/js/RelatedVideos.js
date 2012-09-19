/*global jwplayer:true */
var RelatedVideos = {

	//lockTable:		[],
	//videoPlayerLock:	false,
	maxRooms:		1,
	currentRoom:		1,
	//modalWidth:		666,
	//alreadyLoggedIn:	false,
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
			//this.videosPerPage = 3;
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
			relatedVideosModule.delegate( '.scrollright', 'click', RelatedVideos.scrollright );
			relatedVideosModule.delegate( '.scrollleft', 'click', RelatedVideos.scrollleft );
			
			relatedVideosModule.find('.addVideo').addVideoButton({
				gaCat: RelatedVideos.gaCat,
				callback: RelatedVideos.injectCaruselElement
			});
			
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

	showError: function(){
		GlobalNotification.show( $('.errorWhileLoading').html(), 'error' );
	},

	injectCaruselElement: function( html ){
		$( '#add-video-modal' ).closest('.modalWrapper').closeModal();
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
	}


};

//on content ready
$().ready(function() {
	RelatedVideos.init($('#RelatedVideosRL').size() > 0 ? $('#RelatedVideosRL') : $('#RelatedVideos'));
});
