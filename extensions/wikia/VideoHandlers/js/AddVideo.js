/*global showComboAjaxForPlaceHolder, UserLoginModal*/

/*
 * Function for adding a video via video modal 
 *
 */
(function($, window) {

	var AddVideo = function(element, options) {
		
		var self = this,
			alreadyLoggedIn = false,
			assetsLoaded = false;

		var settings = {
			modalWidth: 666,
			gaCat: null
		}

		settings = $.extend(settings, options);

		var controllerName = 'VideosController';
		
		if ( wgIsArticle == true ) {
			controllerName = 'RelatedVideosController';
		}

		var loginWrapper = function ( callback ){
			var message = 'protected';
			if(( wgUserName == null ) && ( !alreadyLoggedIn )){
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder( false, "", function() {
						AjaxLogin.doSuccess = function() {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							alreadyLoggedIn = true;
							callback();
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
							callback();
						}
					});
				}
			} else {
				callback();
			}
		};

		var showVideoModal = function() {
			$.showModal( self.addModalData.title, self.addModalData.html, {
				id: 'add-video-modal',
				width: settings.modalWidth,
				callback : function(){
					self.addModal = $('#add-video-modal');
					enableVideoSubmit();
					initModalScroll();
				}
			});		
		};

		var getVideoModal = function(){
			WikiaTracker.trackEvent(
				'trackingevent',
				{
					'ga_category': settings.gaCat,
					'ga_action': WikiaTracker.ACTIONS.ADD,
					'ga_label': 'add-video'
				},
				'both'
			);
			
			if(assetsLoaded) {
				showVideoModal();
			} else {
				$.when(
					// Important: keep this as the first item in the deferredList array for param ordering in $.when()
					$.nirvana.sendRequest({
						controller: controllerName, 
						method: 'getAddVideoModal', 
						type: 'GET',
						format: 'json',
						data: {
							title: wgTitle
						}
					}),
					$.getResources([$.getSassCommonURL('/extensions/wikia/VideoHandlers/css/AddVideoModal.scss')])
				)
				.done(function(response) {
					var data = response[0]; // get data from ajax response
					if(data && data.html) {
						assetsLoaded = true;
						self.addModalData = data;
						showVideoModal();
					} else {
						showError();
					}
				})
				.fail(showError);
			}
		};
		
		var initModalScroll = function( modal ) {
			self.addPos = 1;
			self.addMax = Math.ceil(($('.item',self.addModal).length)/3);
			self.addModal.delegate( '.scrollleft', 'click', modalScrollLeft );
			self.addModal.delegate( '.scrollright', 'click', modalScrollRight );
			self.addModal.delegate( '.add-this-video', 'click', modalAddVideo );
	        self.addModal.delegate( 'a.video', 'click', previewVideo );
	        updateModalScrollButtons();
		};

		var updateModalScrollButtons = function() {
	
	        if ( self.addPos == 1 ) {
	            $('.scrollleft', self.addModal).addClass("inactive");
	        } else {
	            $('.scrollleft', self.addModal).removeClass("inactive");
	        }
	
	        if ( self.addPos == self.addMax ) {
	            $('.scrollright', self.addModal).addClass("inactive");
	        } else {
	            $('.scrollright', self.addModal).removeClass("inactive");
	        }
	    };
	
		var modalScrollLeft = function() {
			modalScroll(-1);
	        updateModalScrollButtons();
		};
	
		var modalScrollRight = function() {
			modalScroll(1);
	        updateModalScrollButtons();
		};
	
		var modalScroll = function( param, callback ) {
			//setup variables
	
			var scroll_by = parseInt( $('.item', self.addModal).outerWidth(true) * 3 );
			var anim_time = 500;
	
			// button vertical secondary left
			var futureState = self.addPos + param;
	
			if( futureState >= 1 && futureState <= self.addMax ) {
				var scroll_to = (futureState-1) * scroll_by;
				self.addPos = futureState;

				//scroll
				$('.container', self.addModal).stop().animate({
					left: -scroll_to
				}, anim_time, function(){
					//hide description
					if (typeof callback == 'function') {
						callback();
					}
				});
			} else if (futureState == 0 && self.addMax == 1) {
				$('.page', self.addModal).text(1);
			}
		};

		var enableVideoSubmit = function(){
			self.addModal.undelegate( '.add-form', 'submit').removeClass('loading');
			self.addModal.delegate( '.add-form', 'submit', addVideoConfirm );
		};

		var preventVideoSubmit = function(){
			self.addModal.undelegate( '.add-form', 'submit').addClass('loading');
			self.addModal.delegate(
				'.add-form',
				'submit',
				function( e ){
					e.preventDefault();
				}
			);
		};

		var addVideoConfirm = function( e ){
			e.preventDefault();
			GlobalNotification.show( self.addModal.find('.notifyHolder').html(), 'notify' );
			preventVideoSubmit();
			$.nirvana.postJson(
				controllerName,
				'addVideo',
				{
					articleId: wgArticleId,
					url: self.addModal.find('input').val()
				},
				function( formRes ) {
					WikiaTracker.trackEvent(
						'trackingevent',
						{
							'ga_category': settings.gaCat,
							'ga_action': WikiaTracker.ACTIONS.ADD,
							'ga_label': 'add-video-success'
						},
						'both'
					);
					GlobalNotification.hide();
					if ( formRes.error ) {
						enableVideoSubmit();
						showError( formRes.error );
					} else if ( formRes.html ){
						self.addModal.closest('.modalWrapper').closeModal();
						// Call success callback
						if($.isFunction(settings.callback)) {
							settings.callback(formRes.html);
						}
					} else {
						enableVideoSubmit();
						showError( self.addModal.find('.somethingWentWrong').html() );
					}
				},
				function(){
					showError();
				}
			);
		};

	    // Only used on article pages in related videos module
	    var previewVideo = function() {
	        var videoTitle = $(this).siblings(".item-title").eq(0).attr("data-dbkey");
	        $.nirvana.postJson(
	            'RelatedVideosController',
	            'getVideoPreview',
	            {
	                vTitle: videoTitle
	            },
	            function( res ) {
	                if ( res.html ) {
	                    $("div.RVSuggestionCont", self.addModal).hide();
	                    $("div.RVSuggestPreviewVideo", self.addModal).html( res.html );
	                    bindPreviewActions();
	                }
	            },
	            function(){
	                showError();
	            }
	        );
	        return false;
	    };
	
	    var bindPreviewActions = function() {
	
	        self.addModal.delegate( '.preview_back', 'click', function() {
	
	            $("div.RVSuggestPreviewVideo .preview_container", self.addModal).remove();
	            $("div.RVSuggestionCont", self.addModal).show();
	            return false;
	        } );
	        self.addModal.delegate( '.insert', 'click', modalAddVideo );
	
	    };
	
		var modalAddVideo = function(ev) {
			var video = 'File:'+$(ev.target).closest('.item').children('.item-title').attr('data-dbkey');
			$('.videoUrl', self.addModal).val(video);
			addVideoConfirm(ev);
		};
		
		var showError = function(error) {
			// check if error is a string because it could be xhr response or undefined
			error = typeof error == 'string' ? error : $('.errorWhileLoading').html();
			GlobalNotification.dom.stop(true, true);
			GlobalNotification.show(error, 'error');
		};
	
		var handleClick = function(e) {
			e.preventDefault();
			loginWrapper(getVideoModal);
		};	

		element.on('click', handleClick);

	};

	$.fn.addVideoButton = function(options) {
	
		return this.each(function() {
			$(this).data('plugin_AddVideo', new AddVideo($(this), options));
		});
	
	}

})(jQuery, this);

