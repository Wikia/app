(function (window, $) {
	'use strict';

	var EditHub = {
		disableArrow: function () {
			var editHubForm = $('#edit-hub-form').find('.module-box');
			editHubForm.find('button.navigation').removeAttr('disabled');
			editHubForm.filter(':first').find('.nav-up').attr('disabled', 'disabled');
			editHubForm.filter(':last').find('.nav-down').attr('disabled', 'disabled');
		},

		init: function () {
			var validator,
				initThis = this,
				editHubMain = $('.EditHubMain');

			$('#EditHubPublish').click($.proxy(this.publishHub, this));

			editHubMain.find('.wmu-show').click($.proxy(this.wmuInit, this));
			$('.module-popular-videos').on('click', '.remove', $.proxy(this.popularVideosRemove, this));
			$('#edit-hub-removeall').click($.proxy(this.popularVideosRemoveAll, this));
			editHubMain.find('.vet-show').each(function () {
				var $this = $(this),
					videoEmbedMain;

				$this.addVideoButton({
					callbackAfterSelect: function (url, VET) {
						require( ['wikia.throbber'], function( throbber ) {
							videoEmbedMain = $('#VideoEmbedMain');
							throbber.show(videoEmbedMain);
						});

						$.nirvana.sendRequest({
							controller: 'EditHubController',
							method: 'uploadAndGetVideo',
							type: 'post',
							data: {
								'url': url
							},
							callback: function (response) {
								require( ['wikia.throbber'], function( throbber ) {
									throbber.remove(videoEmbedMain);
								});
								var selectedModule = parseInt(window.wgEditHubModuleIdSelected),
									box;

								if (response.error) {
									new window.BannerNotification(response.error, 'error')
										.show();
								} else {
									if (selectedModule === parseInt(window.wgEditHubModuleIdFeaturedVideo)) {
										box = $this.parents('.module-box:first');
										if (!box.length) {
											box = $('.EditHubMain');
										}

										box.find('.filename-placeholder').html(response.videoFileName);
										box.find('.wmu-file-name-input').val(response.videoFileName).valid();

										box.find('.image-placeholder')
											.empty()
											.html(response.videoData.videoThumb);

										// Close VET modal
										VET.close();
									}
									else if (selectedModule === parseInt(window.wgEditHubModuleIdPopularVideos)) {
										$.when(
												$.loadMustache(),
												Wikia.getMultiTypePackage({
													mustache: 'extensions/wikia/WikiaHubsServices/modules/templates/' +
														'WikiaHubs_popularVideoRow.mustache'
												})
											).done(function (libData, packagesData) {
												initThis.popularVideosAdd(packagesData[0].mustache[0], response);
												VET.close();
											});
									}
								}
							}
						});
						// Don't move on to second VET screen.  We're done.
						return false;
					},
					searchOrder: 'newest'
				});
			});
			$('.remove-sponsored-image').click($.proxy(this.confirmRemoveSponsoredImage, this));

			this.form = $('#edit-hub-form');

			$('#edit-hub-clearall').click($.proxy(function () {
				this.clearSection(
					this.form,
					$.msg('edit-hub-edithub-clearall-confirmation', this.form.data('module-name'))
				);
			}, this));

			$(this.form).find('.clear').click($.proxy(function (event) {
				var sectionToReset = $(event.target).parents('.module-box');

				this.clearSection(
					sectionToReset,
					$.msg('edit-hub-edithub-clear-confirmation')
				);
			}, this));

			$.validator.addMethod('wikiaUrl', function (value, element) {
				var reg = new RegExp(window.wgEditHubUrlRegex, 'i');
				return this.optional(element) || reg.test(value);
			}, $.validator.messages.url);

			validator = this.form.validate({
				errorElement: 'p',
				onkeyup: false,
				onfocusout: function (element) {
					if ($.proxy(this.settings.isValidatable, this)(element)) {
						this.element(element);
					}
				},
				isValidatable: function (element) {
					return !this.checkable(element) && (element.name in this.submitted || !this.optional(element) ||
						element === this.lastActive);
				}
			});

			validator.focusInvalid = function () {
				if (this.settings.focusInvalid) {
					try {
						var element = $((this.errorList.length && this.errorList[0].element) || []);

						if (element.is(':visible')) {
							element.focus()
								// manually trigger focusin event
								// without it, focusin handler isn't called, findLastActive won't have anything to find
								.trigger('focusin');
						} else {
							element.parents('.module-box:first').get(0).scrollIntoView();
						}

					} catch (e) {
						// ignore IE throwing errors when focusing hidden elements
					}
				}
			};

			this.wmuReady = false;

			this.disableArrow();
		},

		wmuInit: function (event) {
			event.preventDefault();
			/* jshint camelcase: false */
			this.lastActiveWmuButton = $(event.target);
			if (!this.wmuReady) {
				this.wmuDeffered = $.when(
						$.loadYUI(),
						$.loadJQueryAIM(),
						$.getResources([
							window.wgExtensionsPath + '/wikia/WikiaMiniUpload/js/WMU.js',
							$.getSassCommonURL('extensions/wikia/WikiaMiniUpload/css/WMU.scss')
						]),
						$.loadJQueryAIM()
					).then($.proxy(function () {
						window.WMU_skipDetails = true;
						window.WMU_show();
						window.WMU_openedInEditor = false;
						this.wmuReady = true;
					}, this));
				$(window).bind('WMU_addFromSpecialPage', $.proxy(function (event, wmuData) {
					this.addImage(wmuData);
				}, this));
			}
			else {
				window.WMU_show();
				window.WMU_openedInEditor = false;
			}
			/* jshint camelcase: true */
		},

		addImage: function (wmuData) {
			var fileName = wmuData.imageTitle;
			$.nirvana.sendRequest({
				controller: 'EditHub',
				method: 'getImageDetails',
				type: 'get',
				data: {
					'fileHandler': fileName
				},
				callback: $.proxy(function (response) {
					var tempImg = new Image(),
						box = this.lastActiveWmuButton.parents('.module-box:first'),
						imagePlaceholder;

					tempImg.src = response.fileUrl;
					if (!box.hasClass('sponsored-image')) { //define dimensions if it's not sponsored image
						tempImg.height = response.imageHeight;
						tempImg.width = response.imageWidth;
					}
					if (!box.length) {
						box = $('.EditHubMain');
					}

					imagePlaceholder = box.find('.image-placeholder');
					imagePlaceholder.find('img').remove();
					imagePlaceholder.append(tempImg);
					box.find('.filename-placeholder').html(response.fileTitle);
					box.find('.wmu-file-name-input').val(response.fileTitle).valid();
				}, this)
			});
		},

		clearSection: function (section, msg) {
			if (window.confirm(msg) === true) {
				this.formReset(section);
			}
		},

		formReset: function (elem) {
			elem.find('input:text, input:password, input:file, input:hidden, select, textarea').val('');
			elem.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
			elem.find('.filename-placeholder').html($.msg('wikia-hubs-file-name'));
			elem.find('.image-placeholder').find('img').attr('src', window.wgBlankImgUrl)
				.end().filter('.video').empty();
			this.removeSponsoredImage();
		},

		popularVideosAdd: function (template, vetData) {
			var html = $.mustache(template, {
				sectionNo: 2,
				videoTitle: vetData.videoFileName,
				videoTime: vetData.videoData.videoTime,
				videoFullUrl: vetData.videoUrl,
				videoThumbnail: vetData.videoData.videoThumb,
				removeMsg: $.msg('edit-hub-edithub-remove'),
				blankImgUrl: window.wgBlankImgUrl
			});
			$('#edit-hub-form').find('.popular-videos-list')
				.prepend(html)
				.find('.module-box')
				.each(this.popularVideosResetIndex);
			this.disableArrow();
		},

		popularVideosRemove: function (event) {
			if (window.confirm($.msg('wikia-hubs-module-popular-videos-clear-one-confirm')) === true) {
				var moduleContainer = '.module-box';
				$(event.target).parents(moduleContainer).remove();
				$('.popular-videos-list').find(moduleContainer).each(this.popularVideosResetIndex);
				this.disableArrow();
			}
		},

		popularVideosRemoveAll: function () {
			if (window.confirm($.msg('wikia-hubs-module-popular-videos-clear-confirm')) === true) {
				$('.popular-videos-list .module-box').remove();
			}
		},

		popularVideosResetIndex: function (index, element) {
			$(element).find('h3').text(index + 2 + '.');
		},

		confirmRemoveSponsoredImage: function () {
			if (window.confirm($.msg('edit-hub-edithub-clear-sponsored-image')) === true) {
				this.removeSponsoredImage();
			}
		},

		removeSponsoredImage: function () {
			$('.sponsored-image')
				.find('#EditHubsponsoredImage').val('')
				.end()
				.find('.image-placeholder img').remove()
				.end()
				.find('span.filename-placeholder').text('');
		},

		publishHub: function () {
			var qs = Wikia.Querystring(window.location);

			$.nirvana.sendRequest({
				controller: 'EditHub',
				method: 'publishHub',
				type: 'post',
				data: {
					date: qs.getVal('date'),
					cityId: window.cityId,
					sectionId: qs.getVal('sectionId')
				},
				callback: function (data) {

					if (data.success) {
						var info = $('<p />').addClass('success').text(data.successText);

						$('.grid-4.alpha:first p.success').remove();
						$('#edit-hub-form').prepend(info);
						info.get(0).scrollIntoView();

						window.open(data.hubUrl);
					} else {
						window.alert(data.errorMsg);
					}
				}
			});
		}
	};

	window.EditHub = EditHub;
	$(function () {
		EditHub.init();
	});
})(window, jQuery);

