/* global GlobalNotification */

/**
 * JS file for Special:Videos page. Runs on Monobook and Oasis.
 */

$(function () {
	'use strict';

	var SpecialVideos = {
		init: function () {
			this.$wrapper = $('.special-videos-grid');
			this.initEllipses();
			this.initDropdown();
			this.initAddVideo();
			this.initRemoveVideo();
		},
		initEllipses: function() {
			var self = this;
			$(window)
				.on('resize.specialvideos', function () {
					self.$wrapper.find('.title').ellipses();
				})
				.trigger('resize.specialvideos');
		},
		/**
		 * Initializes the wikia style guide dropdown which allows
		 * users to sort and filter the videos displayed on the page.
		 */
		initDropdown: function () {
			$('.WikiaDropdown').wikiaDropdown({
				onChange: function (e, $target) {
					var sort = $target.data('sort'),
						category = $target.data('category'),
						qs = new Wikia.Querystring();

					qs.setVal('sort', sort);
					if (category) {
						qs.setVal('category', category);
					} else {
						qs.removeVal('category');
					}
					qs.goTo();
				}
			});
		},
		/**
		 * Binds an event to open the VET when the add video button is clicked.
		 * Only used in Oasis
		 */
		initAddVideo: function () {
			var addVideoButton = $('.addVideo');
			if ($.isFunction($.fn.addVideoButton)) {
				addVideoButton.addVideoButton({
					callbackAfterSelect: function (url, VET) {
						$.nirvana.postJson(
							// controller
							'VideosController',
							// method
							'addVideo',
							// data
							{
								url: url
							},
							// success callback
							function (formRes) {
								window.GlobalNotification.hide();
								if (formRes.error) {
									window.GlobalNotification.show(formRes.error, 'error');
								} else {
									VET.close();
									(new Wikia.Querystring()).setVal('sort', 'recent').goTo();
								}
							},
							// error callback
							function () {
								window.GlobalNotification.show($.msg('vet-error-while-loading'), 'error');
							}
						);
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
		initRemoveVideo: function () {
			this.$wrapper.on('click', '.remove', function (e) {
				var videoElement = $(e.target).parents('.video-element'),
					videoName = videoElement.find('.video > img').attr('data-video-name');
				if (videoName) {
					$.confirm({
						title: $.msg('specialvideos-remove-modal-title'),
						content: $.msg('specialvideos-remove-modal-message'),
						width: 600,
						onOk: function () {
							$.nirvana.sendRequest({
								controller: 'VideoHandler',
								method: 'removeVideo',
								format: 'json',
								data: {
									title: videoName
								},
								callback: function (json) {
									// print error message if error
									if (json.result === 'ok') {
										// reload page with cb
										(new Wikia.Querystring(window.location)).addCb().goTo();
									} else {
										GlobalNotification.show(json['msg'], 'error');
									}

								}
							});
						}
					});
				} else {
					GlobalNotification.show($.msg('oasis-generic-error'), 'error');
				}
			});
		}
	};

	SpecialVideos.init();

});
