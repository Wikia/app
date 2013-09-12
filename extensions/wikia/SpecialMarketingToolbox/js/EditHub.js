/*global VET_loader, WMU_skipDetails:true, WMU_show, WMU_openedInEditor:true, confirm, alert */

var EditHub = function() {};

EditHub.prototype = {
	form: undefined,
	wmuReady: undefined,
	wmuDeffered: undefined,
	lastActiveWmuButton: undefined,

	disableArrow: function() {
		var toolboxForm = $('#marketing-toolbox-form').find('.module-box');
		toolboxForm.find('button.navigation').removeAttr('disabled');
		toolboxForm.filter(':first').find('.nav-up').attr('disabled', 'disabled');
		toolboxForm.filter(':last').find('.nav-down').attr('disabled', 'disabled');
	},

	init: function () {
		var validator;
		var initThis = this;

		$('#MarketingToolboxPublish').click($.proxy(this.publishHub, this));

		$('.MarketingToolboxMain .wmu-show').click($.proxy(this.wmuInit, this));
		$('.module-popular-videos').on('click', '.remove', $.proxy(this.popularVideosRemove, this));
		$('.MarketingToolboxMain #marketing-toolbox-removeall').click($.proxy(this.popularVideosRemoveAll, this));
		$('.MarketingToolboxMain .vet-show').each(function() {
			var $this = $(this);

			$this.addVideoButton({
				callbackAfterSelect: function(url, VET) {
					$.nirvana.sendRequest({
						controller: 'MarketingToolboxController',
						method: 'getVideoDetails',
						type: 'get',
						data: {
							'url': url
						},
						callback: function(response) {
							GlobalNotification.hide();
							if ( response.error ) {
								GlobalNotification.show( response.error, 'error' );
							} else {
								if (wgMarketingToolboxModuleIdSelected == wgMarketingToolboxModuleIdFeaturedVideo) {
									var box = $this.parents('.module-box:first');
									if (!box.length) {
										box = $('.MarketingToolboxMain');
									}

									box.find('.filename-placeholder').html(response.videoFileName);
									box.find('.wmu-file-name-input').val(response.videoFileName).valid();

									box.find('.image-placeholder')
										.empty()
										.html(response.videoData.videoThumb);

									// Close VET modal
									VET.close();
								}
								else if (wgMarketingToolboxModuleIdSelected == wgMarketingToolboxModuleIdPopularVideos) {
									$.when(
										$.loadMustache(),
										Wikia.getMultiTypePackage({
											mustache: 'extensions/wikia/SpecialMarketingToolbox/templates/MarketingToolboxVideosController_popularVideoRow.mustache'
										})
									).done(function(libData, packagesData) {
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

		this.form = $('#marketing-toolbox-form');

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			this.clearSection(
				this.form,
				$.msg('marketing-toolbox-edithub-clearall-confirmation',this.form.data('module-name'))
			);
		}, this));

		$(this.form).find('.clear').click($.proxy(function(event){
			var sectionToReset = $(event.target).parents('.module-box');

			this.clearSection(
				sectionToReset,
				$.msg('marketing-toolbox-edithub-clear-confirmation')
			);
		}, this));

		$.validator.addMethod("wikiaUrl", function(value, element) {
			var reg = new RegExp(window.wgMarketingToolboxUrlRegex, 'i');
			return this.optional(element) || reg.test(value);
		}, $.validator.messages.url);

		validator = this.form.validate({
			errorElement: 'p',
			onkeyup: false,
			onfocusout: function(element, event) {
				if ( $.proxy(this.settings.isValidatable, this)(element) ) {
					this.element(element);
				}
			},
			isValidatable: function(element) {
				return !this.checkable(element) && (element.name in this.submitted || !this.optional(element) || element === this.lastActive);
			}
		});

		validator.focusInvalid = function() {
			if( this.settings.focusInvalid ) {
				try {
					var element = $( (this.errorList.length && this.errorList[0].element) || []);

					if (element.is(":visible")) {
						element.focus()
							// manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
							.trigger("focusin");
					} else {
						element.parents('.module-box:first').get(0).scrollIntoView();
					}

				} catch(e) {
					// ignore IE throwing errors when focusing hidden elements
				}
			}
		};

		this.wmuReady = false;

		this.disableArrow();
	},

	wmuInit: function(event) {
		event.preventDefault();
		this.lastActiveWmuButton = $(event.target);
		if (!this.wmuReady) {
			var $input = $(this).prev();
			this.wmuDeffered = $.when(
				$.loadYUI(),
				$.loadJQueryAIM(),
				$.getResources([
					wgExtensionsPath + '/wikia/WikiaMiniUpload/js/WMU.js',
					$.getSassCommonURL( 'extensions/wikia/WikiaMiniUpload/css/WMU.scss')
				]),
				$.loadJQueryAIM()
			).then($.proxy(function() {
				WMU_skipDetails = true;
				WMU_show();
				WMU_openedInEditor = false;
				this.wmuReady = true;
			}, this));
			$(window).bind('WMU_addFromSpecialPage', $.proxy(function(event, wmuData) {
				this.addImage(wmuData);
			}, this));
		}
		else {
			WMU_show();
			WMU_openedInEditor = false;
		}
	},

	addImage: function(wmuData) {
		var fileName = wmuData.imageTitle;
		$.nirvana.sendRequest({
			controller: 'MarketingToolbox',
			method: 'getImageDetails',
			type: 'get',
			data: {
				'fileHandler': fileName
			},
			callback: $.proxy(function(response) {
				var tempImg = new Image();
				tempImg.src = response.fileUrl;
				var box = this.lastActiveWmuButton.parents('.module-box:first');
				if (!box.hasClass('sponsored-image')) { //define dimensions if it's not sponsored image
					tempImg.height = response.imageHeight;
					tempImg.width = response.imageWidth;
				}
				if (!box.length) {
					box = $('.MarketingToolboxMain');
				}

				var imagePlaceholder = box.find('.image-placeholder');
				imagePlaceholder.find('img').remove();
				imagePlaceholder.append(tempImg);
				box.find('.filename-placeholder').html(response.fileTitle);
				box.find('.wmu-file-name-input').val(response.fileTitle).valid();
			}, this)
		});
	},

	clearSection: function(section, msg) {
		if (confirm(msg) == true) {
			this.formReset(section);
		}
	},

	formReset: function(elem) {
		elem.find('input:text, input:password, input:file, input:hidden, select, textarea').val('');
		elem.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
		elem.find('.filename-placeholder').html($.msg('marketing-toolbox-edithub-file-name'));
		elem.find('.image-placeholder').find('img').attr('src', wgBlankImgUrl)
			.end().filter('.video').empty();
		this.removeSponsoredImage();
	},

	popularVideosAdd: function(template, vetData) {
		var html = $.mustache(template, {
			sectionNo: 2,
			videoTitle: vetData.videoFileName,
			videoTime: vetData.videoData.videoTime,
			videoFullUrl: vetData.videoUrl,
			videoThumbnail: vetData.videoData.videoThumb,
			removeMsg: $.msg('marketing-toolbox-edithub-remove'),
			blankImgUrl: window.wgBlankImgUrl
		});
		$('#marketing-toolbox-form .popular-videos-list')
			.prepend(html)
			.find('.module-box')
			.each(this.popularVideosResetIndex);
		this.disableArrow();
	},

	popularVideosRemove: function(event) {
		if (confirm($.msg('marketing-toolbox-hub-module-popular-videos-clear-one-confirm')) == true) {
			var moduleContainer = '.module-box';
			$(event.target).parents(moduleContainer).remove();
			$('.popular-videos-list').find(moduleContainer).each(this.popularVideosResetIndex);
			this.disableArrow();
		}
	},

	popularVideosRemoveAll: function(event) {
		if (confirm($.msg('marketing-toolbox-hub-module-popular-videos-clear-confirm')) == true) {
			$('.popular-videos-list .module-box').remove();
		}
	},

	popularVideosResetIndex: function(index, element) {
		$(element).find('h3').text(index + 2 + '.');
	},

	confirmRemoveSponsoredImage: function() {
		if (confirm($.msg('marketing-toolbox-edithub-clear-sponsored-image')) == true) {
			this.removeSponsoredImage();
		}
	},

	removeSponsoredImage: function() {
		$('.sponsored-image')
			.find('#MarketingToolboxsponsoredImage').val('')
			.end()
			.find('.image-placeholder img').remove()
			.end()
			.find('span.filename-placeholder').text('');
	},

	publishHub: function() {
		var qs = Wikia.Querystring(window.location);

		$.nirvana.sendRequest({
			controller: 'MarketingToolbox',
			method: 'publishHub',
			type: 'post',
			data: {
				'date': qs.getVal('date'),
				'region': qs.getVal('region'),
				'verticalId': qs.getVal('verticalId'),
				'sectionId': qs.getVal('sectionId')
			},
			callback: function(data){
				if (data.success) {
					window.open(data.hubUrl);
					var container = $('.grid-4.alpha:first');
					container.find('p.success').remove();

					var info = $('<p />')
						.addClass('success')
						.text(data.successText);

					container.prepend(info);
					info.get(0).scrollIntoView();
				} else {
					alert(data.errorMsg);
				}
			}
		});
	}
};


var EditHub = new EditHub();
$(function () {
	EditHub.init();
});
