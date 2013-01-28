var EditHub = function() {};

EditHub.prototype = {
	form: undefined,
	wmuReady: undefined,
	vetReady: undefined,
	wmuDeffered: undefined,
	vetDeffered: undefined,
	lastActiveWmuButton: undefined,
	lastActiveVetButton: undefined,

	init: function () {
		var validator;

		$('.MarketingToolboxMain .wmu-show').click($.proxy(this.wmuInit, this));
		$('.MarketingToolboxMain .vet-show').click($.proxy(this.vetInit, this));
		$('.remove-sponsored-image').click($.proxy(this.confirmRemoveSponsoredImage, this));

		this.form = $('#marketing-toolbox-form');

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			this.clearSection(
				this.form,
				$.msg('marketing-toolbox-edithub-clearall-confirmation',this.form.data('module-name'))
			)
		}, this));

		$(this.form).find('.clear').click($.proxy(function(event){
			var sectionToReset = $(event.target).parents('.module-box');

			this.clearSection(
				sectionToReset,
				$.msg('marketing-toolbox-edithub-clear-confirmation')
			)
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
					var element = $(this.errorList.length && this.errorList[0].element || [])

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
		}

		this.wmuReady = false;
		this.vetReady = false;
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
					$.getSassCommonURL( 'extensions/wikia/WikiaMiniUpload/css/WMU.scss'),
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

	vetInit: function(event) {
		this.lastActiveVetButton = $(event.target);
		if (!this.vetReady) {
			this.vetDeffered = $.when(
				$.loadYUI(),
				$.loadMustache(),
				$.getResources([
					wgExtensionsPath + '/wikia/WikiaStyleGuide/js/Dropdown.js',
					wgExtensionsPath + '/wikia/VideoEmbedTool/js/VET.js',
					$.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss'),
					$.getSassCommonURL('/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss')
				])
			).then(
				$.proxy(function(event) {
						this.showVet(event);
					},
					this
				)
			);
			$(window).bind('VET_addFromSpecialPage', $.proxy(this.addVideo, this));
			this.vetReady = true;
		}
		else {
			this.showVet(event);
		}
	},

	showVet: function(event) {
		VET_show(event, VET_placeholder, true, true, true, window.wgMarketingToolboxThumbnailSize, undefined, 'newest');
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
					tempImg.height = response.imageHeight
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

	addVideo: function(event, vetData) {
		$.nirvana.sendRequest({
			controller: 'MarketingToolbox',
			method: 'getVideoDetails',
			type: 'get',
			data: {
				'wikiText': vetData.videoWikiText
			},
			callback: $.proxy(function(response) {
				var box = this.lastActiveVetButton.parents('.module-box:first');
				if (!box.length) {
					box = $('.MarketingToolboxMain');
				}

				box.find('.filename-placeholder').html(response.videoFileName);
				box.find('.wmu-file-name-input').val(response.videoFileName).valid();

				box.find('.image-placeholder')
					.empty()
					.html(response.videoFileMarkup);
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
	}
};


var EditHub = new EditHub();
$(function () {
	EditHub.init();
});
