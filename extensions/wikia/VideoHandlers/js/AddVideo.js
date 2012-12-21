/*global showComboAjaxForPlaceHolder, UserLoginModal*/

/*
 * Function for adding a video via video modal 
 *
 */
(function($, window) {
	// could be loaded by more than one extension
	if(typeof window.AddVideo == 'function') {
		return;
	}

	// temporary video survey code bugid-68723
	var addSurveyLink = function() {
		var surveyLink = $('#video-survey');
		
		if(!surveyLink.length){
			return;
		}
		
		var messages = surveyLink.find('span'),
			count = messages.length,
			chosen = Math.floor(Math.random() * count);

		messages.eq(chosen).fadeIn();
	};
	
	// run on dom ready
	$(addSurveyLink);
	
	AddVideo = {};
	AddVideo.addVideoCallbackFunction = function(url, controllerName, callback) {
		//GlobalNotification.show( self.addModal.find('.notifyHolder').html(), 'notify' );
		$.nirvana.postJson(
			controllerName,
			'addVideo',
			{
				articleId: wgArticleId,
				url: url
			},
			function( formRes ) {
				/* do this tracking outside
				WikiaTracker.trackEvent(
					'trackingevent',
					{
						'ga_category': settings.gaCat,
						'ga_action': WikiaTracker.ACTIONS.ADD,
						'ga_label': 'add-video-success'
					},
					'both'
				);
				*/
				GlobalNotification.hide();
				if ( formRes.error ) {
					showError( formRes.error );
				} else if ( formRes.html ){
					VET_loader.modal.closeModal();
					// Call success callback
					if($.isFunction(callback)) {
						callback(formRes.html);
					}
				} else {
					//showError( self.addModal.find('.somethingWentWrong').html() );
				}
			},
			function(){
				showError();
			}
		);
	};
	
	window.AddVideo = AddVideo;

})(jQuery, this);

