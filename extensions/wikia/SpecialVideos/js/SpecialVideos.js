/**
 * JS file for Special:Videos page. Runs on Monobook and Oasis.
 */

$(function() {

var SpecialVideos = {
	init: function() {
		this.initDropdown();
		this.initAddVideo();
		this.initRemoveVideo();
	},
	/**
	 * Initializes the wikia style guide dropdown which allows
	 * users to sort and filter the videos displayed on the page.
	 */
	initDropdown: function() {
		$('.WikiaDropdown').wikiaDropdown({
			onChange: function(e, $target) {
				var sort = $target.data( 'sort' );
				( new Wikia.Querystring() ).setVal( 'sort', sort ).goTo();
			}
		});
	},
	/**
	 * Binds an event to open the VET when the add video button is clicked.
	 * Only used in Oasis
	 */
	initAddVideo: function() {
		var addVideoButton = $('.addVideo');
		if( $.isFunction( $.fn.addVideoButton ) ) {
			addVideoButton.addVideoButton({
				callbackAfterSelect: function(url) {
					require(['wikia.vet'], function(vet) {
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
									vet.close();
									(new Wikia.Querystring()).setVal('sort', 'recent').goTo();
								}
							},
							// error callback
							function() {
								GlobalNotification.show( $.msg('vet-error-while-loading'), 'error' );
							}
						);
					});
					// Don't move on to second VET screen.  We're done.
					return false;
				}
			});
		} else {
			addVideoButton.hide();
		}
	},
	/**
	 * When you hover over a video, a trash icon appears. Clicking on the trash
	 * icon will open a modal to confirm you want to remove that video.
	 * Only used in Oasis.
	 */
	initRemoveVideo: function() {
		$('.VideoGrid').on('click', '.remove', function(e) {
			var videoElement = $(e.target).parents('.video-element'),
				videoName = videoElement.find('.video > img').attr('data-video-name');
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
								title: videoName
							},
							callback: function(json) {
								// print error message if error
								if(json.result === 'ok') {
									(new Wikia.Querystring(window.location)).addCb().goTo();	// reload page with cb
								} else {
									GlobalNotification.show(json['msg'], 'error');
								}

							}
						});

					}
				});
			} else {
				GlobalNotification.show( $.msg('oasis-generic-error'), 'error' );
			}
		});
	}
};

SpecialVideos.init();

});