/*global jwplayer:true, WikiaHubs */
var RelatedVideos = {

	maxRooms: 1,
	currentRoom: 1,
	heightThreshold: 600,
	onRightRail: false,
	videosPerPage: 3,
	rvModule: null,
	isHubVideos: false,
	isHubExtEnabled: false,
	isHubExtPage: false,
	gaCat: 'related-videos',
	totalVideos: null,

	// Lazy Loading
	loadedCount: 0,
	seeMorePlaceholderAdded: false,

	init: function(relatedVideosModule) {
		// DOM caching
		this.rvModule = $(relatedVideosModule);
		this.rvContainer = $('.container', this.rvModule);
		this.rvScrollRight = $('.scrollright', this.rvModule);
		this.rvScrollLeft = $('.scrollleft', this.rvModule);
		this.rvPage = $('.page', this.rvModule);
		this.rvMaxCount = $('.maxcount', this.rvModule);
		this.rvTallyCount = $('.tally em', this.rvModule);
		this.rvNoVideos = $('.novideos', this.rvModule);

		// If we're lazy loading, loaded count will not equal the total number of videos to be shown
		// Cache the number loaded on init
		this.loadedCount = $('.item', this.rvModule).length;
		
		if ( this.rvModule.closest('.WikiaRail').size() > 0 ) {
			// Right rail 
			this.onRightRail = true;
			this.totalVideos = window.RelatedVideosIds.length;
			this.rvContainer.on('click', '.remove', this.removeVideoLoginWrapper);
			
			// If we don't have any items to lazy load, add the see-more-placeholder on init
			this.handleSeeMorePlaceholder();
		} else {
			// Hubs
			this.totalVideos = this.loadedCount;		
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
		
		// TODO: Clean this up so it's clear when we're talking about right rail vs. hubs etc. (Liz)
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
			relatedVideosModule.on( 'click', '.scrollright', this.scrollright );
			relatedVideosModule.on( 'click', '.scrollleft', this.scrollleft );
			
			relatedVideosModule.find('.addVideo').addVideoButton({
				gaCat: RelatedVideos.gaCat,
				callback: RelatedVideos.injectCaruselElement
			}).tooltip({
				delay: { show: 500, hide: 100 }
			});
			
			$('body').on( 'click', '#relatedvideos-video-player-embed-show', function() {
				$('#relatedvideos-video-player-embed-code').show();
				$(this).hide();
			});

			RelatedVideos.maxRooms = relatedVideosModule.attr('data-count');
			if ( RelatedVideos.maxRooms < 1 ) {
				RelatedVideos.maxRooms = 1;
			}
			RelatedVideos.trackItemImpressions(RelatedVideos.currentRoom);
			RelatedVideos.checkButtonState();
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

	// Scrolling items

	scrollright: function(){
		RelatedVideos.lazyLoad();

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
			scroll_by = parseInt( $('.group', this.rvModule).outerWidth(true) );
			anim_time = 300;
		} else {
			scroll_by = parseInt( $('.item', this.rvModule).outerWidth(true) * 3 );
			anim_time = 500;
		}

		// button vertical secondary left
		var futureState = RelatedVideos.currentRoom + param;
		RelatedVideos.trackItemImpressions(futureState);
		if( futureState >= 1 && futureState <= this.maxRooms ) {
			var scroll_to = (futureState-1) * scroll_by;

			this.rvPage.text(futureState);
			this.currentRoom = futureState;
			this.rvContainer.clearQueue();
			this.checkButtonState();
			
			//scroll
			this.rvContainer.stop().animate({
				left: -scroll_to
				//left: '-=' + scroll_by
			}, anim_time, function(){
				//hide description
				if (typeof callback == 'function') {
					callback();
				}
			});
		} else if (futureState == 0 && RelatedVideos.maxRooms == 1) {
			this.rvPage.text(1);
		}
	},

	trackItemImpressions: function(room) {
		var titles = [];
		var orders = [];
		var group = this.rvContainer.find('.group').eq(room-1);
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
		if ( !this.onRightRail ) { 
			return; 
		}
		
		var self = this,
			container = this.rvContainer;
		
		$('.group .item', container).each( function() {
			$(this).appendTo( container );
		});
		$('.group', container).remove();

		var group = null;
		container.children('.item').each( function(i) {
			if( i % self.videosPerPage == 0 ) {
				if(group) { 
					group.appendTo( container ); 
				}
				group = $('<div class="group"></div>');
			}
			$(this).appendTo( group );
		});
		
		if(group) { 
			group.appendTo( container ); 
		}

	},

	// State calculations & refresh

	checkButtonState: function() {
		this.rvScrollLeft.removeClass( 'inactive' );
		this.rvScrollRight.removeClass( 'inactive' );
		if ( this.currentRoom == 1 ){
			this.rvScrollLeft.addClass( 'inactive' );
		}
		if ( this.currentRoom == RelatedVideos.maxRooms ) {
			this.rvScrollRight.addClass( 'inactive' );
		}
	},

	// Lazy load image src
	// Only for hubs
	showImages: function(){
		var rl = this;
		$('div.item a.video-thumbnail img', this.rvModule).each( function (i) {
			if ( i < ( ( RelatedVideos.currentRoom + (rl.videosPerPage-1) ) * rl.videosPerPage ) ){
				var $thisJquery = $(this);
				if ( $thisJquery.attr( 'data-src' ) != "" ){
					$thisJquery.attr( 'src', $thisJquery.attr( 'data-src' ) );
				}
			}
		});
	},
	
	// Lazy load html
	lazyLoad: function() {
		// Only for onRightRail
		// Hubs will divert to showImages();
		if(!RelatedVideos.onRightRail) {
			RelatedVideos.showImages();
			return;
		}
		
		var self = this,
			idx = this.loadedCount, // cache index to avoid race conditions
			totalCount = window.RelatedVideosIds.length;

		var getItems = function() {
			for(var i = 0; i < self.videosPerPage; i++) {

				// Stop lazy loading if we've got all the videos
				if(self.loadedCount >= totalCount) {
					self.lazyLoaded = true;
					break;
				}

				// update lazy loading progress
				self.loadedCount += 1; 

				// Load new videos
				$.nirvana.sendRequest({
					controller: 'RelatedVideos',
					method: 'getCaruselElementRL',
					type: 'GET',
					format: 'json',
					data: {
						videoTitle: window.RelatedVideosIds[idx + i],
						preloaded: true
					}, 
					callback: function(data) {
						var html = self.mustacheTemplate.mustache(data);
						
						self.doLazyInsert(html);
						self.handleSeeMorePlaceholder();
					}
				});	
			}		
		}
		
		if(this.mustacheTemplate) {
			getItems();		
		} else {
			// Load all the resources for Lazy Loading
			$.when(
				$.loadMustache(),
				Wikia.getMultiTypePackage({
					mustache: 'extensions/wikia/RelatedVideos/templates/RelatedVideosController_getCaruselElementRL.mustache'
				})
			).done(function(libData, packagesData) {
				// cache mustache template for carousel item
				self.mustacheTemplate = $(packagesData[0].mustache[0]).wrap('<div></div>').parent();
				getItems();
			});
		}
		
	},

	handleSeeMorePlaceholder: function() {
		if(!this.seeMorePlaceholderAdded && $('.item', this.rvModule).length == this.totalVideos) {
			var seeMorePlaceholder = $('.seeMorePlaceholder', this.rvModule).addClass('item');
			this.doLazyInsert(seeMorePlaceholder);
			this.seeMorePlaceholderAdded = true;
		}						
	},
	
	doLazyInsert: function(item) {
		var last = $('.group',this.rvModule).last();
		
		if(last.children().length < this.videosPerPage) {
			// There's space for this item in the last group, append it
			$(item).appendTo(last).show();
		} else {
			// All the groups are full, create a new one
			var newDiv = $('<div class="group"></div>').appendTo(this.rvContainer);
			$(item).appendTo(newDiv).show();
		}
	},

	recalculateLength: function(){
		// Update video tally text
		var numberElem = this.rvTallyCount;
		numberElem.text( parseInt(numberElem.text()) + 1 );

		// Update carousel progress
		var numberItems = this.totalVideos;
		
		// Account for placeholder item
		if(this.onRightRail) {
			numberItems += 1;
		}

        if ( numberItems == 0 ) {
            this.rvNoVideos.show();
        } else {
            this.rvNoVideos.hide();
        }

		if ( this.onRightRail ) {
			numberItems = Math.ceil( ( numberItems ) / this.videosPerPage );
		} else {
			numberItems = Math.ceil( ( numberItems + 1 ) / this.videosPerPage );
		}

        if( numberItems == 0) { numberItems = 1; }

		// Update carousel progress text
		this.maxRooms = numberItems;
		this.rvMaxCount.text( numberItems );

        if(numberItems < this.currentRoom) {
            this.scroll(-1);
        }

		this.checkButtonState();
	},

	// general helper functions

	showError: function(){
		GlobalNotification.show( $('.errorWhileLoading').html(), 'error' );
	},

	// Inject newly added video into carousel - different from lazy loading
	injectCaruselElement: function( html ){
		$( '#add-video-modal' ).closest('.modalWrapper').closeModal();
		var scrollLength = -1 * ( RelatedVideos.currentRoom - 1 );
		RelatedVideos.scroll(
			scrollLength,
			function(){
				$( html ).css('display', 'inline-block') /* JSlint ignore */
					.prependTo( RelatedVideos.rvContainer )
					.fadeOut( 0 )
					.fadeIn( 'slow', function(){
						RelatedVideos.totalVideos += 1;
						RelatedVideos.recalculateLength();
					});
				RelatedVideos.regroup();
			}
		);
	},

	// Remove Video
	
	removeVideoLoginWrapper: function( e ){
		e.preventDefault();

		var self = this,
			callback = RelatedVideos.removeVideoClick;

		var message = 'protected';
		if(( wgUserName == null ) && ( !alreadyLoggedIn )){
			if (window.wgComboAjaxLogin) {
				showComboAjaxForPlaceHolder( false, "", function() {
					AjaxLogin.doSuccess = function() {
						$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
						alreadyLoggedIn = true;
						callback(self);
					};
					AjaxLogin.close = function() {
						$('#AjaxLoginBoxWrapper').closeModal();
						$( window ).scrollTop( element.offset().top + 100 );
					}
				}, false, message );
			} else {
				UserLoginModal.show({
					callback: function() {
						$( window ).scrollTop( element.offset().top + 100 );
						alreadyLoggedIn = true;
						callback(self);
					}
				});
			}
		} else {
			callback(self);
		}
	},

	removeVideoClick: function(target) {
		var parentItem = $(target).parents('.item');
		$.confirm({
			title: $( '.deleteConfirmTitle', RelatedVideos.rvModule ).html(),
			content: $( '.deleteConfirm', RelatedVideos.rvModule ).html(),
			onOk: function(){
				RelatedVideos.removeVideoItem( parentItem );
			}
		});
	},

	removeVideoItem: function(parentItem) {
		$( parentItem ).fadeTo( 'slow', 0 );
		var item = $(parentItem).find('a.video-thumbnail');
		$.nirvana.sendRequest({
			controller: 'RelatedVideos',
			method: 'removeVideo',
			format: 'json',
			data: {
				external:	item.attr('data-external'),
				title:		item.attr('data-ref'),
				articleId:	wgArticleId
			}, 
			callback: function(formRes) {
				if ( formRes.error ) {
					$.showModal( '', formRes.error, {
						'width': RelatedVideos.modalWidth,
						callback: function(){
							$( parentItem ).fadeTo( 'slow', 1 );
						}
					});
				} else {
					$(parentItem).remove();
					RelatedVideos.totalVideos -= 1;
					RelatedVideos.recalculateLength();
					RelatedVideos.lazyLoad();
					RelatedVideos.regroup();
				}

			},
			onErrorCallback: function(){
				RelatedVideos.showError();
			}
		});
	}
};

//on content ready
$().ready(function() {
	var railElem = $('#RelatedVideosRL');
	RelatedVideos.init(railElem.length > 0 ? railElem : $('#RelatedVideos'));
});
