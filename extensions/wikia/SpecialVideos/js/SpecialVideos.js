var SpecialVideos = {
	init: function() {
		$('.WikiaDropdown').wikiaDropdown({
			onChange: function(e, $target) {
				var currSort = this.$selectedItemsList.text(),
					newSort = $target.text();

				if(currSort != newSort) {
					var sort = $target.data('sort');
					(new Wikia.Querystring(window.wgEditHubUrl)).setVal('sort', sort).goTo();
				}
			}
		});

		$('.addVideo').addVideoButton({
			callbackAfterSelect: function(url) {
				$.nirvana.postJson(
					// controller
					'VideosController',
					// method
					'addVideo',
					// data
					{ url: url },
					// success callback
					function( formRes ) {
						GlobalNotification.hide();
						if ( formRes.error ) {
							GlobalNotification.show( formRes.error, 'error' );
						} else {
							VET_loader.modal.closeModal();
							window.location.search = "?sort=recent";
						}
					},
					// error callback
					function() {
						GlobalNotification.show( $.msg('vet-error-while-loading'), 'error' );
					}
				);
				// Don't move on to second VET screen.  We're done.
				return false; 
			}
		});
		
		$('.VideoGrid').on('click', '.remove', function(e) {
			var videoElement = $(e.target).parents('.video-element'),
				videoName = videoElement.find('.video').data('video-name');
			if(videoName) {
				$.confirm({
					title: $.msg('specialvideos-remove-modal-title'),
					content: $.msg('specialvideos-remove-modal-message'),
					width: 600,
					onOk: function() {
						$.nirvana.sendRequest({
							controller: 'VideoHandler',
							method: 'removeVideo',
							format: 'json',
							data: {
								videoTitle: videoName
							},
							callback: function(json) {
								// print error message if error
								// reload page instead?
								//(new Wikia.Querystring(window.location)).addCb().goTo();	// reload page with cb
							}
						});
						
						// we assume that above call works majority of the time, so we fade it out here without checking response
						videoElement.fadeOut('slow', function() {
							videoElement.remove();
							$('.video-element').each(function(index, el) {
								el = $(el);
								if (index % 3 === 0) {
									el.addClass('alpha');
								} else {
									el.removeClass('alpha');
								}
							});
						});
						
					}
				});
			}
		});
	}
};

$(function() {
	SpecialVideos.init();
});