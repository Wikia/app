/**
 * View file for the featured video form
 * @extends 'videopageadmin.views.editbase'
 */
define('videopageadmin.views.featured', [
	'videopageadmin.views.editbase',
	'videopageadmin.views.thumbnailupload',
	'BannerNotification'
], function (EditBaseView, ThumbnailUploader, BannerNotification) {
	'use strict';

	var FeaturedVideo = EditBaseView.extend({
		initialize: function () {
			EditBaseView.prototype.initialize.call(this, arguments);
			this.$fieldsToValidate = this.$el.find('.description, .display-title, .video-key, .alt-thumb');
			this.bannerNotification = new BannerNotification().setType('error');

			_.bindAll(this, 'initAddVideo', 'initValidator', 'clearForm');

			this.initAddVideo();
			this.initValidator();
		},
		events: function () {
			return _.extend({}, EditBaseView.prototype.events, {
				'click .media-uploader-btn': 'addImage',
				'form:reset': 'clearForm'
			});
		},
		initValidator: function () {
			EditBaseView.prototype.initValidator.call(this, arguments);
			_.each(this.$fieldsToValidate, function (elem) {
				$(elem).rules('add', {
					required: true,
					messages: {
						required: function (len, elem) {
							var msg,
								$elem = $(elem);
							if ($elem.hasClass('video-key')) {
								msg = $.msg('videopagetool-formerror-videokey');
							} else if ($elem.hasClass('alt-thumb')) {
								msg = $.msg('videopagetool-formerror-altthumb');
							} else {
								msg = $.msg('htmlform-required');
							}
							return msg;
						}
					}
				});
			});
		},
		/**
		 * Apply $.fn.addVideoButton to each add video button on the form
		 * @todo: use Backbone for data updating instead of nirvana
		 */
		initAddVideo: function () {
			_.each(this.$el.find('.add-video-button'), function (elem) {
				var $elem = $(elem),
					$box = $elem.closest('.form-box'),
					$videoKeyInput = $elem.siblings('.video-key'),
					$videoTitle = $elem.siblings('.video-title'),
					$displayTitleInput = $box.find('.display-title'),
					$descInput = $box.find('.description'),
					$thumb = $box.find('.video-thumb'),
					callbackAfterSelect;

				callbackAfterSelect = function (url, vet) {
					var $altThumbKey,
						req;

					$altThumbKey = $box.find('.alt-thumb').val();
					req = {};

					if ($altThumbKey.length) {
						req.altThumbKey = $altThumbKey;
					}

					req.url = url;

					$.nirvana.sendRequest({
						controller: 'VideoPageAdminSpecial',
						method: 'getFeaturedVideoData',
						type: 'GET',
						format: 'json',
						data: req,
						callback: function (json) {
							if (json.result === 'ok') {

								var video = json.video;
								$thumb.html();

								// update input value and remove any error messages that might be there.
								$videoKeyInput
									.val(video.videoKey)
									.removeClass('error')
									.next('.error')
									.remove();
								$videoTitle
									.removeClass('alternative')
									.text(video.videoTitle);
								$displayTitleInput
									.val(video.displayTitle)
									.trigger('keyup'); // for validation
								$descInput.val(video.description)
									.trigger('keyup'); // for validation

								// Update thumbnail html
								$thumb.html(video.videoThumb);

								// close VET modal
								vet.close();
							} else {
								bannerNotification.setContent(json.msg).show();
							}
						}
					});

					// Don't move on to second VET screen.  We're done.
					return false;
				};

				$elem.addVideoButton({
					callbackAfterSelect: callbackAfterSelect
				});
			});
		},
		addImage: function (e) {
			e.preventDefault();

			new ThumbnailUploader({
				el: $(e.currentTarget).closest('.form-box')
			});

		},
		/*
		 * This reset is very specific to this form since it covers reverting titles and thumbnails
		 * @TODO: we may want to just create a default empty version of the form and hide it if it's not needed.
		 * that way we could just replace all the HTML to its default state without worrying about clearing every form
		 * field.
		 */
		clearForm: function () {
			// Reset video title
			this.$el.find('.video-title')
				.text($.msg('videopagetool-video-title-default-text'))
				.addClass('alternative');

			// Rest the video thumb
			this.$el.find('.video-thumb')
				.html('');

			// Hide all thumbnail preview links
			this.$el.find('.preview-large-link')
				.hide();

			// reset custom thumb name
			this.$el.find('.alt-thumb-name')
				.text($.msg('videopagetool-image-title-default-text'))
				.addClass('alternative');
		}
	});

	return FeaturedVideo;
});
