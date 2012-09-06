/*
 * Function for adding a video via video modal 
 *
 */
(function($, window) {

	var AddVideo = function(element, options) {
		
		var self = this;

		var alreadyLoggedIn = false;	

		var settings = {
			modalWidth: 666,
			gaCat: null
		}

		var settings = $.extend(settings, options);

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
				}
				else {
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
		}

		var addVideoModal = function(){
			WikiaTracker.trackEvent(
				'trackingevent',
				{
					'ga_category': settings.gaCat,
					'ga_action': WikiaTracker.ACTIONS.ADD,
					'ga_label': 'add-video'
				},
				'both'
			);
			$.nirvana.postJson(
				controllerName,
				'getAddVideoModal',
				{
					title: wgTitle,
					format: 'html',
				},
				function( res ) {
					if ( res.html ) {
						$.showModal( res.title, res.html, {
							id: 'add-video-modal',
							width: settings.modalWidth,
							callback : function(){
								self.rvAddModal = $('#add-video-modal');
								enableVideoSubmit();
								initModalScroll();
							}
						});
					}
				},
				function(){
					showError();
				}
			);
		}

		var initModalScroll = function( modal ) {
			debugger;
			self.rvAddPos = 1;
			self.rvAddMax = Math.ceil(($('.item',self.rvAddModal).length)/3);
			self.rvAddModal.delegate( '.scrollleft', 'click', modalScrollLeft );
			self.rvAddModal.delegate( '.scrollright', 'click', modalScrollRight );
			self.rvAddModal.delegate( '.add-this-video', 'click', modalAddVideo );
	        self.rvAddModal.delegate( 'a.video', 'click', previewVideo );
	        updateModalScrollButtons();
		}

		var updateModalScrollButtons = function() {
	
	        if ( self.rvAddPos == 1 ) {
	            $('.scrollleft', self.rvAddModal).addClass("inactive");
	        } else {
	            $('.scrollleft', self.rvAddModal).removeClass("inactive");
	        }
	
	        if ( self.rvAddPos == self.rvAddMax ) {
	            $('.scrollright', self.rvAddModal).addClass("inactive");
	        } else {
	            $('.scrollright', self.rvAddModal).removeClass("inactive");
	        }
	    }
	
		var modalScrollLeft = function() {
			modalScroll(-1);
	        updateModalScrollButtons();
		}
	
		var modalScrollRight = function() {
			modalScroll(1);
	        updateModalScrollButtons();
		}
	
		var modalScroll = function( param, callback ) {
			//setup variables
	
			var scroll_by = parseInt( $('.item', self.rvAddModal).outerWidth(true) * 3 );
			var anim_time = 500;
	
			// button vertical secondary left
			var futureState = self.rvAddPos + param;
	
			if( futureState >= 1 && futureState <= self.rvAddMax ) {
				var scroll_to = (futureState-1) * scroll_by;
				self.rvAddPos = futureState;

				//scroll
				$('.container', self.rvAddModal).stop().animate({
					left: -scroll_to
				}, anim_time, function(){
					//hide description
					if (typeof callback == 'function') {
						callback();
					}
				});
			} else if (futureState == 0 && self.rvAddMax == 1) {
				$('.page', self.rvAddModal).text(1);
			}
		}

		var enableVideoSubmit = function(){
			self.rvAddModal.undelegate( '.rv-add-form', 'submit').removeClass('loading');
			self.rvAddModal.delegate( '.rv-add-form', 'submit', addVideoConfirm );
		}

		var preventVideoSubmit = function(){
			self.rvAddModal.undelegate( '.rv-add-form', 'submit').addClass('loading');
			self.rvAddModal.delegate(
				'.rv-add-form',
				'submit',
				function( e ){
					e.preventDefault();
				}
			);
		}

		var addVideoConfirm = function( e ){
			e.preventDefault();
			GlobalNotification.show( self.rvAddModal.find('.notifyHolder').html(), 'notify' );
			preventVideoSubmit();
			$.nirvana.postJson(
				controllerName,
				'addVideo',
				{
					articleId: wgArticleId,
					url: self.rvAddModal.find('input').val()
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
						self.rvAddModal.closest('.modalWrapper').closeModal();
						// Call success callback
						if($.isFunction(settings.callback)) {
							settings.callback(formRes.html);
						}
					} else {
						enableVideoSubmit();
						showError( self.rvAddModal.find('.somethingWentWrong').html() );
					}
				},
				function(){
					showError();
				}
			);
		}

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
	                    $("div.RVSuggestionCont", self.rvAddModal).hide();
	                    $("div.RVSuggestPreviewVideo", self.rvAddModal).html( res.html );
	                    bindPreviewActions();
	                }
	            },
	            function(){
	                showError();
	            }
	        );
	        return false;
	    }
	
	    var bindPreviewActions = function() {
	
	        self.rvAddModal.delegate( '.preview_back', 'click', function() {
	
	            $("div.RVSuggestPreviewVideo .preview_container", self.rvAddModal).remove();
	            $("div.RVSuggestionCont", self.rvAddModal).show();
	            return false;
	        } );
	        self.rvAddModal.delegate( '.insert', 'click', modalAddVideo );
	
	    }
	
		var modalAddVideo = function(ev) {
			var video = 'File:'+$(ev.target).closest('.item').children('.item-title').attr('data-dbkey');
			$('.videoUrl', self.rvAddModal).val(video);
			addVideoConfirm(ev);
		}
		
		var showError = function(error) {
			// TODO: make this work with Special:Videos - maybe add error message to options
			error = error || $('.errorWhileLoading').html();
			GlobalNotification.dom.stop(true, true);
			GlobalNotification.show(error, 'error')
		}
	
		var handleClick = function(e) {
			e.preventDefault();
			loginWrapper(addVideoModal);
		}		

		element.on('click', handleClick);

	}

	$.fn.addVideoButton = function(options) {
	
		return this.each(function() {
			$(this).data('plugin_AddVideo', new AddVideo($(this), options));
		});
	
	}

})(jQuery, this);

