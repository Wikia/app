/*
 * Function for adding a video via video modal 
 *
 */
(function($, window) {

	var AddVideo = function(element, options) {
		
		var self = this;

		self.alreadyLoggedIn = false;	

		var settings = {
			modalWidth: 666,
			gaCat: null
		}
		
		var settings = $.extend(settings, options);
		
		var loginWrapper = function ( callback ){
			var message = 'protected';
			if(( wgUserName == null ) && ( !self.alreadyLoggedIn )){
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder( false, "", function() {
						AjaxLogin.doSuccess = function() {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							self.alreadyLoggedIn = true;
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
							self.alreadyLoggedIn = true;
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
			//$(this.rvModule).undelegate( '.addVideo', 'click' );
			$.nirvana.postJson(
				'RelatedVideosController', // TODO: abstract this so there's no dependency on Related Videos
				'getAddVideoModal',
				{
					title: wgTitle,
					format: 'html'
				},
				function( res ) {
					if ( res.html ) {
						self.modal = $.showModal( res.title, res.html, {
							id: 'relatedvideos-add-video',
							width: settings.modalWidth,
							callback : function(){
								//var $rvModule = $(RelatedVideos.rvModule);
								//$rvModule.undelegate( '.addVideo', 'click' );
								//$rvModule.delegate( '.addVideo', 'click', addVideoModal );
								
								enableVideoSubmit();
								initModalScroll('.modalContent');
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
			this.rvAddModal = modal;
			this.rvAddPos = 1;
			this.rvAddMax = Math.ceil(($('.item',this.rvAddModal).length)/3);
			var $rvAddModal = $(this.rvAddModal);
			$rvAddModal.delegate( '.scrollleft', 'click', modalScrollLeft );
			$rvAddModal.delegate( '.scrollright', 'click', modalScrollRight );
			$rvAddModal.delegate( '.add-this-video', 'click', modalAddVideo );
	        $rvAddModal.delegate( 'a.video', 'click', previewVideo );
	        updateModalScrollButtons();
		}

		var updateModalScrollButtons = function() {
	
	        if ( this.rvAddPos == 1 ) {
	            $('.scrollleft', this.rvAddModal).addClass("inactive");
	        } else {
	            $('.scrollleft',this.rvAddModal).removeClass("inactive");
	        }
	
	        if ( this.rvAddPos == this.rvAddMax ) {
	            $('.scrollright', this.rvAddModal).addClass("inactive");
	        } else {
	            $('.scrollright', this.rvAddModal).removeClass("inactive");
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
	
			var scroll_by = parseInt( $('.item',this.rvAddModal).outerWidth(true) * 3 );
			var anim_time = 500;
	
			// button vertical secondary left
			var futureState = this.rvAddPos + param;
	
			if( futureState >= 1 && futureState <= this.rvAddMax ) {
				var scroll_to = (futureState-1) * scroll_by;
				this.rvAddPos = futureState;
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
			} else if (futureState == 0 && this.rvAddMax == 1) {
				$('.page',this.rvAddModal).text(1);
			}
		}

		var enableVideoSubmit = function(){
			var $relatedVideosAddVideo = $('#relatedvideos-add-video');
			$relatedVideosAddVideo.undelegate( '.rv-add-form', 'submit').removeClass('loading');
			$relatedVideosAddVideo.delegate( '.rv-add-form', 'submit', addVideoConfirm );
		}

		var preventVideoSubmit = function(){
			var $relatedVideosAddVideo = $('#relatedvideos-add-video');
			$relatedVideosAddVideo.undelegate( '.rv-add-form', 'submit').addClass('loading');
			$relatedVideosAddVideo.delegate(
				'.rv-add-form',
				'submit',
				function( e ){
					e.preventDefault();
				}
			);
		}

		var addVideoConfirm = function( e ){
			e.preventDefault();
			GlobalNotification.show( $('#relatedvideos-add-video .notifyHolder').html(), 'notify' );
			preventVideoSubmit();
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
							'ga_category': settings.gaCat,
							'ga_action': WikiaTracker.ACTIONS.ADD,
							'ga_label': 'add-video-success'
						},
						'both'
					);
					GlobalNotification.hide();
					var $relatedVideosAddVideo = $('#relatedvideos-add-video');
					if ( formRes.error ) {
						$relatedVideosAddVideo.addClass( 'error-mode' );
						enableVideoSubmit();
						injectModalErrorMessage( formRes.error );
					} else if ( formRes.html ){
						$relatedVideosAddVideo.removeClass( 'error-mode' );
						$relatedVideosAddVideo.closest('.modalWrapper').closeModal();
						// Call success callback
						if($.isFunction(settings.callback)) {
							settings.callback(formRes.html);
						}
					} else {
						$relatedVideosAddVideo.addClass( 'error-mode' );
						enableVideoSubmit();
						injectModalErrorMessage( $('#relatedvideos-add-video .somethingWentWrong').html() );
					}
				},
				function(){
					showError();
				}
			);
		}

		var injectModalErrorMessage = function( error ){
			$( '#relatedvideos-add-video .rv-error td' ).html( error );
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
	
	        $( this.rvAddModal ).delegate( '.preview_back', 'click', function() {
	
	            $("div.RVSuggestPreviewVideo .preview_container", self.rvAddModal).remove();
	            $("div.RVSuggestionCont", self.rvAddModal).show();
	            return false;
	        } );
	        $( self.rvAddModal ).delegate( '.insert', 'click', modalAddVideo );
	
	    }
	
		var modalAddVideo = function(ev) {
			var video = 'File:'+$(ev.target).closest('.item').children('.item-title').attr('data-dbkey');
			$('.videoUrl', self.rvAddModal).val(video);
			addVideoConfirm(ev);
		}
		
		var showError = function() {
			// TODO: make this work with Special:Videos - maybe add error message to options
			GlobalNotification.show( $('.errorWhileLoading').html(), 'error' );		
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

