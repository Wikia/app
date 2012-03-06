var WikiaHubs = {
	trackingCategory: 'wikiahubs',
	init: function() {
		WikiaHubs.el = $('#WikiaHubs');
		WikiaHubs.el.click(WikiaHubs.clickTrackingHandler);
		
		$('body >.modalWrapper').live('click', WikiaHubs.modalClickTrackingHandler);
		$('#WikiaSearch').submit(function(e) {
			WikiaHubs.trackClick('pulse/search-submit');
		});
		//WikiaHubs.trackingCategory = 'video-games';
	},
	trackClick: function(label, value) {
		$.tracker.trackEvent(WikiaHubs.trackingCategory, 'click', label);
	},
	clickTrackingHandler: function(e) {
		var node = $(e.target);
			
		var startTime = new Date();
		
		if(node.closest('.WikiaMosaicSlider').length > 0) {	// Slider
			if(node.closest('.wikia-mosaic-slider-region').length > 0 && node.closest('a').length > 0) {
				WikiaHubs.trackClick('slider/hero');
			} else if(node.closest('.wikia-mosaic-slide').length > 0){
				WikiaHubs.trackClick('slider/thumbnail');
			}
		} else if(node.closest('.wikiahubs-newstabs').length > 0) { // news tabs
			if(node.closest('.tabbernav').length > 0) {
				WikiaHubs.trackClick('news-tabs/select-tab');
			} else if(node.is('img') && node.hasParent('a')) {
				WikiaHubs.trackClick('news-tabs/image-link');
			} else if(node.is('a') || node.hasParent('a')) {
				WikiaHubs.trackClick('news-tabs/content-link');
			}
		} else if(node.closest('.wikiahubs-popular-videos').length > 0) {	// videos
			if(node.hasClass('playButton')) {
				WikiaHubs.trackClick('videos/play');
			} else if(node.closest('.scrollright').length > 0) {
				WikiaHubs.trackClick('videos/carousel-right');
			} else if(node.closest('.scrollleft').length > 0) {
				WikiaHubs.trackClick('videos/carousel-left');
			} else if(node.is('#suggestVideo')) {
				WikiaHubs.trackClick('videos/suggest/button');
			} else if(node.is('a') && node.hasParent('.info')) {
				WikiaHubs.trackClick('videos/username');
			}
		} else if(node.closest('.wikiahubs-from-the-community').length > 0) {	// article suggest
			if(node.is('img') && node.hasParent('a')) {
				WikiaHubs.trackClick('from-the-community/image-link');
			} else if(node.is('a')) {
				if(node.closest('.wikiahubs-ftc-title').length > 0) {
					WikiaHubs.trackClick('from-the-community/title');
				} else if(node.closest('.wikiahubs-ftc-subtitle').length > 0) {
					if(node.is('a:first-child')) {
						WikiaHubs.trackClick('from-the-community/username');
					} else {
						WikiaHubs.trackClick('from-the-community/wikiname');
					}
				} else {
					WikiaHubs.trackClick('from-the-community/content-link');
				}
			} else if(node.is('#suggestArticle')) {
				WikiaHubs.trackClick('from-the-community/suggest/button');
			}
		} else if(node.closest('.wikiahubs-pulse').length > 0) {
			if(node.is('#facebook')) {
				WikiaHubs.trackClick('pulse/facebook');
			} else if(node.is('#twitter')) {
				WikiaHubs.trackClick('pulse/twitter');
			} else if(node.is('#google')) {
				WikiaHubs.trackClick('pulse/google-plus');
			} else if(node.is('#HubSearch')) {
				WikiaHubs.trackClick('pulse/search');
			}
		} else if(node.closest('.wikiahubs-explore').length > 0) {
			if(node.is('a')) {
				if(node.hasParent('.mw-headline')) {
					WikiaHubs.trackClick('explore/list-title');
				} else {
					WikiaHubs.trackClick('explore/list-item');
				}
			}
		} else if(node.closest('.wikiahubs-top-wikis').length > 0) {
			if(node.is('a')) {
				WikiaHubs.trackClick('top-wiki/name');
			}
		}
		
		$().log('tracking took ' + (new Date() - startTime) + ' ms');
	},
	modalClickTrackingHandler: function(e) {
		var node = $(e.target);
		
		$().log(node);
		
		if(node.closest('#relatehubsdvideos-video-player').length > 0) {	// video modal
			if(node.hasClass('wikiahubs-videos-wiki-link')) {
				WikiaHubs.trackClick('videos/modal/wiki-link');
			}
		} else if (node.closest('.VideoSuggestModal').length > 0) {
			if(node.hasClass('submit')) {
				WikiaHubs.trackClick('videos/suggest/submit');
			}
		} else if (node.closest('.ArticleSuggestModal').length > 0) {
			if(node.hasClass('submit')) {
				WikiaHubs.trackClick('from-the-community/suggest/submit');
			}
		}
	}
};

var SuggestModal = {
	init: function() {
		// show modal for suggest article
		$('#suggestArticle').click(function() {
			$().log(window.wgUserName );
			if ( window.wgUserName ) {
				SuggestModal.suggestArticle();
			} else {
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder( false, false, function() {
						AjaxLogin.doSuccess = function() {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModal.suggestArticle();
						};
						AjaxLogin.close = function() {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true );
				} else {
					UserLoginModal.show({
						callback:function() { 
							SuggestModal.suggestArticle();
						}
					});
				}
			}
		});
		// show modal for suggest related videos
		$('#suggestVideo').click(function() {
			if ( window.wgUserName ) {
				SuggestModal.suggestVideo();
			} else {
				if (window.wgComboAjaxLogin) {
					showComboAjaxForPlaceHolder( false, false, function() {
						AjaxLogin.doSuccess = function() {
							$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
							SuggestModal.suggestVideo();
						};
						AjaxLogin.close = function() {
							$('#AjaxLoginBoxWrapper').closeModal();
						};
					}, false, true );
				} else {
					UserLoginModal.show({
						callback:function() { 
							SuggestModal.suggestVideo();
						}
					});
				}
			}
		});
	},

	suggestArticle: function() {
		$.get(window.wgScriptPath + '/wikia.php', {
				controller: 'WikiaHubsSuggestController',
				method: 'modalArticle',
				format: 'html'
		}, function(html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModal.closeModal});
				var wikiaForm = new WikiaForm(modal.find('form'));

				modal.find('input[name=articleurl]').focus(function(){
					if ( $(this).parent().is('.default-value') ) {
						$(this).val('');
						$(this).parent().removeClass('default-value');
					}
				});

				// show submit button
				SuggestModal.showSubmit(modal);

				modal.find('button.submit').click(function(e) {
					e.preventDefault();
					var articleurl = modal.find('input[name=articleurl]').val();
					var reason = modal.find('textarea[name=reason]').val();
					$.nirvana.sendRequest({
						controller: 'WikiaHubsSuggestController',
						method: 'modalArticle',
						format: 'json',
						data:{
							hubname: window.wgPageName,
							articleurl: articleurl,
							reason: reason,
							submit: 1
						},
						callback: function(res){
							if(res['result'] == 'ok') {
								modal.find('.WikiaForm').replaceWith('<p>'+res['msg']+'</p>');
								modal.find('.close-button').show();
							} else if (res['result'] == 'error') {
								wikiaForm.showInputError(res['errParam'], res['msg']);
							} else {
								// TODO: show error message
								GlobalNotification.warn('Something is wrong');
							}
						}
					});
				});
				
				modal.find('button.cancel').click(function(e) {
					e.preventDefault();
					SuggestModal.closeModal(modal);
				});
		});
	},

	suggestVideo: function() {
		$.get(window.wgScriptPath + '/wikia.php', {
				controller: 'WikiaHubsSuggestController',
				method: 'modalRelatedVideos',
				format: 'html'
		}, function(html) {
				var modal = $(html).makeModal({width: 490, onClose: SuggestModal.closeModal});
				var wikiaForm = new WikiaForm(modal.find('form'));

				modal.find('input[name=videourl]').focus(function(){
					if ( $(this).parent().is('.default-value') ) {
						$(this).val('');
						$(this).parent().removeClass('default-value');
					}
				});

				modal.find('input[name=wikiname]').focus(function(){
					if ( $(this).parent().is('.default-value') ) {
						$(this).val('');
						$(this).parent().removeClass('default-value');
					}
				});

				// show submit button
				SuggestModal.showSubmit(modal);

				modal.find('button.submit').click(function(e) {
					e.preventDefault();
					var videourl = modal.find('input[name=videourl]').val();
					var wikiname = modal.find('input[name=wikiname]').val();
					$.nirvana.sendRequest({
						controller: 'WikiaHubsSuggestController',
						method: 'modalRelatedVideos',
						format: 'json',
						data:{
							hubname: window.wgPageName,
							videourl: videourl,
							wikiname: wikiname,
							submit: 1
						},
						callback: function(res){
							if(res['result'] == 'ok') {
								modal.find('.WikiaForm').replaceWith('<p>'+res['msg']+'</p>');
								modal.find('.close-button').show();
							} else if (res['result'] == 'error') {
								wikiaForm.showInputError(res['errParam'], res['msg']);
							} else {
								// TODO: show error message
								GlobalNotification.warn('Something is wrong');
							}
						}
					});
				});
				
				modal.find('button.cancel').click(function(e) {
					e.preventDefault();
					SuggestModal.closeModal(modal);
				});
		});
	},

	showSubmit: function(modal) {
		$('.WikiaForm.WikiaHubs').keyup(function(){
			var empty = false;
			$('.WikiaForm.WikiaHubs .required').each(function() {
				if ( $(this).is('.default-value') || $(this).find('input').val() == '' || $(this).find('textarea').val() == '' ) {
					empty = true;
				}
			});
			if (!empty) {
				modal.find('button.submit').removeAttr('disabled');
			} else {
				modal.find('button.submit').attr('disabled', 'disabled');
			}
		});
	},
	
	closeModal: function(modal) {
		if ( !window.wgUserName ) {
			var searchstring = window.location.search;
			if( typeof searchstring === "undefined" ) {
				searchstring = '';
			}
			
			if( searchstring === '' ) {
				window.location = window.location + '?cb=' + Math.floor(Math.random()*10000);
			} else if( searchstring.substr(0,1) == '?' ) {
				window.location = window.location + '&cb=' + Math.floor(Math.random()*10000);
			}
		} else if( typeof(modal.closeModal) === 'function' ) {
			modal.closeModal();
		}
	}

};

$(function() {
//	if ((typeof window.wgEnableWikiaHubsExt != 'undefined') && wgEnableWikiaHubsExt ) {
		SuggestModal.init();
//	}
	WikiaHubs.init();
});

