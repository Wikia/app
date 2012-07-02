var SpecialPromote = function (params) {
	this.headlineNode = null;
	this.descriptionNode = null;

	this.original = {
		headline: null,
		description: null,
		mainImageName: null,
		additionalImagesNames: []
	};

	this.current = {
		headline: null,
		description: null,
		mainImageName: null,
		additionalImagesNames: []
	};

	this.uploadType = null;
	this.imageIndex = null;
	this.status = {
		title: false,
		description: false,
		mainPhoto: false
	};

	this.ADDITIONAL_IMAGES_LIMIT = 9;
	this.UPLOAD_TYPE_MAIN = 'main';
	this.UPLOAD_TYPE_ADDITIONAL = 'additional';
}

SpecialPromote.prototype = {
	init: function () {
		this.disablePublish();
		this.headlineNode = $('input[name=title]');
		this.descriptionNode = $('textarea[name=description]');
		this.characterCounter = $('.character-counter');

		this.current.headline = this.original.headline = this.headlineNode.val();
		this.current.description = this.original.description = this.descriptionNode.val();
		this.current.mainImageName = this.original.mainImageName = $('.large-photo img').data('filename');

		$(".small-photos img").each($.proxy(function (i, img) {
			var fileName = $(img).data('filename');
			this.current.additionalImagesNames.push(fileName);
			this.original.additionalImagesNames.push(fileName);
		}, this));

		this.headlineNode.keyup($.proxy(this.onKeyUp, this));
		this.descriptionNode.keyup($.proxy(this.onKeyUp, this));
		$('body').on('submit', '#ImageUploadForm', $.proxy(this.saveAvatarAIM, this));
		$('.upload-button').click($.proxy(this.onAddPhotoBtnClick, this));
		$('.UploadTool').submit($.proxy(this.onUploadFormSubmit, this));
		$('.UploadTool').on(
			'hover',
			'.large-photo, .small-photos-wrapper',
			$.proxy(this.modifyRemoveHandler, this)
		);
		$('.UploadTool')
			.on('click', '.modify-remove .modify', $.proxy(this.onChangePhotoClick, this))
			.on('click', '.modify-remove .remove', $.proxy(this.onDeletePhotoClick, this));

		this.headlineNode.keyup();
		this.descriptionNode.keyup();
		this.checkPublishButton();
		$().log('SpecialPromote.init finished');
	},
	onKeyUp: function (event) {
		var targetObject = $(event.target);
		var minChars = targetObject.data('min');
		var maxChars = targetObject.data('max');
		var fieldName = targetObject.attr('name');
		var characterCount = targetObject.val().length;

		if (typeof minChars != 'undefined' && typeof maxChars != 'undefined') {
			minChars = parseInt(minChars);
			maxChars = parseInt(maxChars);

			if (minChars > characterCount) {
				targetObject.closest('div').parent().find('.error').text(
					$.msg('promote-error-less-characters-than-minimum', characterCount, minChars)
				);
				this.status[fieldName] = false;
			} else if (maxChars < characterCount) {
				targetObject.closest('div').parent().find('.error').text(
					$.msg('promote-error-more-characters-than-maximum', characterCount, maxChars)
				);
				this.status[fieldName] = false;
			} else {
				targetObject.closest('div').parent().find('.error').text('');
				this.status[fieldName] = true;
			}
		}
		if (fieldName == 'description') {
			this.characterCounter.text(characterCount);
		}

		this.current.headline = this.headlineNode.val();
		this.current.description = this.descriptionNode.val();

		this.checkPublishButton();

	},
	checkMainImage: function() {
		var image = $('.large-photo img').data('filename');
		if(typeof image == 'undefined') {
			this.status.mainPhoto = false;
		} else if (image == '' || image == null) {
			this.status.mainPhoto = false;
		} else {
			this.status.mainPhoto = true;
		}
	},
	checkPublishButton: function() {
		this.checkMainImage();
		if (this.validateData()) {
			this.enablePublish();
		} else {
			this.disablePublish();
		}
	},
	getUploadForm: function (data) {
		$.nirvana.sendRequest({
			type: 'post',
			format: 'html',
			controller: 'SpecialPromote',
			method: 'getUploadForm',
			data: data,
			callback: function (html) {
				$.showModal($.msg('promote-upload-form-modal-title'), html);
			}
		});
	},
	onAddPhotoBtnClick: function (e) {
		e.preventDefault();
		var addPhotoBtn = $(e.currentTarget);
		var uploadType = addPhotoBtn.data('image-type');
		var errorContainer = addPhotoBtn.parent().find('.error');

		if (uploadType === this.UPLOAD_TYPE_ADDITIONAL && this.current.additionalImagesNames.length > this.ADDITIONAL_IMAGES_LIMIT) {
			errorContainer.text($.msg('promote-error-too-many-images'));
			return;
		} else {
			errorContainer.html('');
		}

		this.getUploadForm({uploadType: uploadType});
	},
	onChangePhotoClick: function (e) {
		e.preventDefault();
		var target = $(e.target).parent().parent().find('img');

		this.getUploadForm({
			uploadType: target.data('image-type'),
			imageIndex: target.data('image-index')
		});
	},
	onDeletePhotoClick: function (e) {
		e.preventDefault();

		var target = $(e.target).parent().parent().find('img');
		this.removeImage({
			uploadType: target.data('image-type'),
			imageIndex: target.data('image-index')
		});
	},
	removeImage: function (params) {
		if (params.uploadType == 'main') {
			this.removeTempImage(this.current.mainImageName);
			this.current.mainImageName = null;
			$('.large-photo img').remove();
			$('.modify-remove').removeClass('show');
		} else if (params.uploadType == 'additional') {
			this.removeTempImage(this.current.additionalImagesNames[params.imageIndex - 1]);
			this.current.additionalImagesNames.splice(params.imageIndex - 1, 1);
			$.each($('.small-photos img'), function(i, element) {
				if ($(element).data('image-index') == params.imageIndex) {
					$(element).parent().remove();
				}
			});
		}
		this.checkPublishButton();
	},
	saveAvatarAIM: function (event) {
		var form = $("#ImageUploadForm");
		var submitBtn = form.find('#submit-button');

		$.AIM.submit(form, {
			onStart: $.proxy(function () {
				submitBtn.attr('disabled', 'disabled');
			}, this),
			onComplete: $.proxy(function (response) {
				var errorContainer = $('.modalWrapper .error'), unknownErrorMsg = $.msg('promote-error-upload-unknown-error');
				try {
					response = JSON.parse(response);
					if (typeof(response.fileName) !== 'undefined' && typeof(response.fileUrl) !== 'undefined') {
						this.setTempFile(response);
						$('.modalWrapper').closeModal();
					} else {
						if(typeof response.errorMessages[0] == 'undefined') {
							errorContainer.text(unknownErrorMsg);
						} else {
							errorContainer.text(response.errorMessages.join("\n"));
						}
					}
				} catch (e) {
					errorContainer.text(unknownErrorMsg);
					$().log(e);
				}
				$(submitBtn).removeAttr('disabled');
			}, this)
		});
	},
	setTempFile: function (file) {
		switch (file.uploadType) {
			case this.UPLOAD_TYPE_MAIN:
				this.setMainImage(file);
				break;
			case this.UPLOAD_TYPE_ADDITIONAL:
				this.addAdditionalImage(file);
				break;
			default:
				$().log('ERROR: no correct upload type found');
				break;
		}
	},
	setMainImage: function (file) {
		this.current.mainImageName = file.fileName;

		var mainImgDiv = $('.large-photo');
		var imageNode = mainImgDiv.find('img').get(0);
		if (typeof(imageNode) !== 'undefined') {
			$(imageNode)
				.attr('src', file.fileUrl)
				.data('filename', file.fileName)
				.data('image-type', 'main');
		} else {
			var image = new Image();
			mainImgDiv.append(
				$(image)
					.attr('src', file.fileUrl)
					.data('filename', file.fileName)
					.data('image-type', 'main')
			);
		}
		this.checkPublishButton();
	},
	addAdditionalImage: function (file) {
		if (file.imageIndex) {
			this.current.additionalImagesNames[file.imageIndex] = file.fileName;
			var image = $('.small-photos img:eq(' + (file.imageIndex - 1) + ')');
			image.attr('src', file.fileUrl);
			image.data('filename', file.fileName);
		} else {
			this.current.additionalImagesNames.push(file.fileName);
			var imagesContainer = $('.small-photos');
			var image = new Image();
			var smallPhotosWrapper = $('<div class="small-photos-wrapper"></div>');
			var modifyRemoveNode = $('<div class="modify-remove"><a class="modify" href="#">'
			+$.msg('promote-modify-photo')
			+'</a> <a class="remove" href="#">'
			+$.msg('promote-remove-photo')+'</a></div>');
			smallPhotosWrapper
				.append(modifyRemoveNode)
				.append(
					$(image)
						.attr('src', file.fileUrl)
						.data('filename', file.fileName)
						.data('image-type', this.UPLOAD_TYPE_ADDITIONAL)
						.data('image-index', this.current.additionalImagesNames.length)
				);
			imagesContainer.append(smallPhotosWrapper);
		}

		this.checkPublishButton();
	},
	validateData: function () {
		var result = {valid:true};

		$.each(this.status, $.proxy(function (key, value) {
			if (value == false) {
				this.valid = false;
			}
		},result));

		return result.valid ;
	},
	disablePublish: function () {
		$('.button').attr('disabled', 'disabled');
	},
	enablePublish: function () {
		$('.button').removeAttr('disabled');
	},
	onUploadFormSubmit: function (e) {
		e.preventDefault();
		if(!this.validateData()) {
			return false;
		}
		var doSave = false;

		$.each(this.current, $.proxy(function (key, value) {
			if (this.current[key] != this.original[key]) {
				doSave = true;
			}
		}, this));

		if (doSave) this.saveWikiPromoData(this.current);
	},
	saveWikiPromoData: function (data) {
		$.nirvana.sendRequest({
			type: 'post',
			format: 'json',
			controller: 'SpecialPromote',
			method: 'saveData',
			data: data,
			callback: function (response) {
				var url = new Wikia.Querystring();
				url.setVal('cb', Math.ceil(Math.random() * 10001));
				url.goTo();
			},
			onErrorCallback: function () {
				$().log('error');
			}
		});
	},
	removeTempImage: function (imagename) {
		$.nirvana.sendRequest({
			type: 'post',
			format: 'json',
			controller: 'SpecialPromote',
			method: 'removeTempImage',
			data: {
				fileName: imagename
			},
			callback: function (response) {
			},
			onErrorCallback: function () {
				$().log('error');
			}
		});
	},
	modifyRemoveHandler: function(e) {
		if ($(e.currentTarget).find('img').length > 0) {
			$(e.currentTarget).find('.modify-remove').toggleClass('show');
		}
	}
};

var SpecialPromoteInstance = new SpecialPromote();
$(function () {
	SpecialPromoteInstance.init();
});
