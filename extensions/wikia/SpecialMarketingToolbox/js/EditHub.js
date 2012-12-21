var EditHub = function() {};

EditHub.prototype = {
	form: undefined,
	wmuReady: undefined,
	vetReady: undefined,
	wmuDeffered: undefined,
	vetDeffered: undefined,
	lastActiveWmuButton: undefined,

	init: function () {
		$('.MarketingToolboxMain .wmu-show').click($.proxy(this.wmuInit, this));
		$('.MarketingToolboxMain .vet-show').click($.proxy(this.vetInit, this));

		this.form = $('#marketing-toolbox-form');

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			if (confirm($.msg('marketing-toolbox-edithub-clearall-confirmation',this.form.data('module-name'))) == true) {
				this.formReset(this.form);
			}
		}, this));

		$(this.form).find('.clear').click($.proxy(function(event){
			var sectionToReset = $(event.target).parents('.module-box');
			this.formReset(sectionToReset);
		}, this));

		$.validator.addMethod("wikiaUrl", function(value, element) {
			var reg = new RegExp(window.wgMarketingToolboxUrlRegex, 'i');
			return this.optional(element) || reg.test(value);
		}, $.validator.messages.url);

		this.form.validate({
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
				$.getResources([
					wgExtensionsPath + '/wikia/WikiaMiniUpload/js/WMU.js',
					wgExtensionsPath + '/wikia/WikiaMiniUpload/css/WMU.css',
					'/resources/wikia/libraries/aim/jquery.aim.js'
				])
			).then($.proxy(function() {
				WMU_skipDetails = true;
				WMU_show();
				this.wmuReady = true;
			}, this));
			$(window).bind('WMU_addFromSpecialPage', $.proxy(function(event, wmuData) {
				this.addImage(wmuData);
			}, this));
		}
		else {
			WMU_show();
		}
	},

	vetInit: function(event) {
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
			).then(function() {
				VET_show();
			});
			$(window).bind('VET_addFromSpecialPage', $.proxy(this.addVideo, this));
			this.vetReady = true;
		}
		else {
			VET_show();
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
				tempImg.height = response.imageHeight
				tempImg.width = response.imageWidth;

				var box = this.lastActiveWmuButton.parents('.module-box:first');
				if (!box.length) {
					box = $('.MarketingToolboxMain');
				}

				var imagePlaceholder = box.find('.image-placeholder');
				imagePlaceholder.find('img').remove();
				imagePlaceholder.append(tempImg);
				box.find('.filename-placeholder').html(fileName);
				box.find('.wmu-file-name-input').val(fileName).valid();
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
			callback: function(response) {
				$('.MarketingToolboxMain').append(response.fileName);
			}
		});
	},

	formReset: function(elem) {
		elem.find('input:text, input:password, input:file, input:hidden, select, textarea').val('');
		elem.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
		elem.find('.filename-placeholder').html($.msg('marketing-toolbox-edithub-file-name'));
		elem.find('.image-placeholder').find('img').attr('src', wgBlankImgUrl);
	}
};


var EditHub = new EditHub();
$(function () {
	EditHub.init();
});
