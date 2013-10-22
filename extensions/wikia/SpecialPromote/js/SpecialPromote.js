var SpecialPromote = function (params) {
	this.headlineNode = null;
	this.descriptionNode = null;

	this.inputParams = {
		title: {
			minChars: 0,
			maxChars: 0
		},
		description: {
			minChars: 0,
			maxChars: 0
		}
	};

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
	this.IMAGE_MODAL_WIDTH = 600;
};

SpecialPromote.prototype = {
	init: function () {
		this.disablePublish();
		this.headlineNode = $('input[name=title]');
		this.descriptionNode = $('textarea[name=description]');
		this.characterCounter = $('.character-counter');
		this.characterCounterHeadline = $('.headline-character-counter');

		this.current.headline = this.original.headline = this.headlineNode.val();
		this.current.description = this.original.description = this.descriptionNode.val();
		this.current.mainImageName = this.original.mainImageName = $('.large-photo img#curMainImageName').data('filename');

		$(".small-photos img.additionalImage").each($.proxy(function (i, img) {
			var fileName = $(img).data('filename');
			this.current.additionalImagesNames.push(fileName);
			this.original.additionalImagesNames.push(fileName);
		}, this));

		this.headlineNode.keyup($.proxy(this.onKeyUp, this));
		this.descriptionNode.keyup($.proxy(this.onKeyUp, this));
		$('body')
			.on('submit', '#ImageUploadForm', $.proxy(this.saveAvatarAIM, this))
			.on('click', '#cancel-button', function() {$('.modalWrapper').closeModal();});
		$('.upload-button').click($.proxy(this.onAddPhotoBtnClick, this));
		$('.UploadTool')
			.submit($.proxy(this.onUploadFormSubmit, this))
			.on(
				'hover',
				'.large-photo, .small-photos-wrapper',
				$.proxy(this.modifyRemoveHandler, this)
			)
			.on('click', '.modify-remove .modify', $.proxy(this.onChangePhotoClick, this))
			.on('click', '.modify-remove .remove', $.proxy(this.onDeletePhotoClick, this));
		$('.WikiaArticle').addClass('SpecialPromoteArticle');

		this.initInput(this.headlineNode);
		this.initInput(this.descriptionNode);
		this.checkPublishButton();
		$().log('SpecialPromote.init finished');
	},
	initInput: function(targetObject) {
		var fieldName = targetObject.attr('name');
		this.initInputParams(targetObject, fieldName);
		this.initValidate(targetObject, fieldName);
	},
	initValidate: function(targetObject, fieldName) {
		var characterCount = targetObject.val().length;

		if (typeof this.inputParams[fieldName].minChars != 'undefined'
			&& typeof this.inputParams[fieldName].maxChars != 'undefined'
		) {
			this.inputParams[fieldName].minChars = parseInt(this.inputParams[fieldName].minChars);
			this.inputParams[fieldName].maxChars = parseInt(this.inputParams[fieldName].maxChars);

			if (this.inputParams[fieldName].minChars > characterCount) {
				if (characterCount) {
					this.addTooLittleCharsError(targetObject, characterCount, this.inputParams[fieldName].minChars);
				}
				this.status[fieldName] = false;
			}
			else if (this.inputParams[fieldName].maxChars < characterCount) {
				if (characterCount) {
					this.addTooManyCharsError(targetObject, characterCount, this.inputParams[fieldName].maxChars);
				}
				this.status[fieldName] = false;
			} else {
				this.status[fieldName] = true;
			}
		}
	},
	initInputParams: function(targetObject, fieldName) {
		this.inputParams[fieldName].minChars = targetObject.data('min');
		this.inputParams[fieldName].maxChars = targetObject.data('max');
	},
	onKeyUp: function (event) {
		var targetObject = $(event.target);
		var fieldName = targetObject.attr('name');
		var characterCount = targetObject.val().length;

		if (this.inputParams[fieldName].minChars > characterCount) {
			this.addTooLittleCharsError(targetObject, characterCount, this.inputParams[fieldName].minChars);
			this.status[fieldName] = false;
		} else if (this.inputParams[fieldName].maxChars < characterCount) {
			this.addTooManyCharsError(targetObject, characterCount, this.inputParams[fieldName].maxChars);
			this.status[fieldName] = false;
		} else {
			targetObject.closest('div').parent().removeClass('error');
			targetObject.closest('div').parent().find('.error').text('');
			this.status[fieldName] = true;
		}

		if (fieldName == 'description') {
			this.characterCounter.text(characterCount);
		}
		else if (fieldName == 'title') {
			this.characterCounterHeadline.text(characterCount);
		}

		this.current.headline = this.headlineNode.val();
		this.current.description = this.descriptionNode.val();

		this.checkPublishButton();
	},
	addTooLittleCharsError: function(targetObject, characterCount, minChars) {
		targetObject.closest('div').parent().addClass('error');
		targetObject.closest('div').parent().find('.error').text(
			$.msg('promote-error-less-characters-than-minimum', characterCount, minChars)
		);
	},
	addTooManyCharsError: function(targetObject, characterCount, maxChars) {
		targetObject.closest('div').parent().addClass('error');
		targetObject.closest('div').parent().find('.error').text(
			$.msg('promote-error-more-characters-than-maximum', characterCount, maxChars)
		);
	},
	checkMainImage: function() {
		var image = $('.large-photo img#curMainImageName').data('filename');
		if(typeof image == 'undefined' ) {
			this.status.mainPhoto = false;
		} else {
			this.status.mainPhoto = !(image == '' || image == null);
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
		if (!data.uploadType) {
			throw new Error('getUploadFormError');
		}
		$.nirvana.sendRequest({
			type: 'get',
			format: 'html',
			controller: 'SpecialPromote',
			method: 'getUploadForm',
			data: data,
			callback: $.proxy(this.showImageModal,this)
		});
		return true;
	},
	showImageModal: function (html) {
		$().log('making modal: ' + this.IMAGE_MODAL_WIDTH);
		$(html).makeModal( {width: this.IMAGE_MODAL_WIDTH} );
	},
	onAddPhotoBtnClick: function (e) {
		e.preventDefault();
		var addPhotoBtn = $(e.currentTarget);
		var uploadType = addPhotoBtn.data('image-type');
		var errorContainer = addPhotoBtn.parent().find('.error');

		if (uploadType === this.UPLOAD_TYPE_ADDITIONAL && this.current.additionalImagesNames.length >= this.ADDITIONAL_IMAGES_LIMIT) {
			addPhotoBtn.parent().addClass('error');
			errorContainer.text($.msg('promote-error-too-many-images'));
			return;
		}
		errorContainer.html('');
		addPhotoBtn.parent().removeClass('error');

		try {
			this.getUploadForm({uploadType: uploadType,lang: window.wgUserLanguage});
		}
		catch(error) {
			this.errorHandler(error);
		}
	},
	onChangePhotoClick: function (e) {
		e.preventDefault();
		var parentNode = $(e.target).parent().parent();
		var target = parentNode.find('img#curMainImageName');
		if ($.isEmptyObject(target[0])) {
			target = parentNode.find('img.additionalImage');
		}

		try {
			this.getUploadForm({
				uploadType: target.data('image-type'),
				imageIndex: target.data('image-index'),
				lang: window.wgUserLanguage
			});
		}
		catch(error) {
			this.errorHandler(error);
			return false;
		}
		return true;
	},
	onDeletePhotoClick: function (e) {
		e.preventDefault();

		var target = $(e.target).parent().parent().find('img.additionalImage');
		this.removeImage({
			uploadType: target.data('image-type'),
			imageIndex: target.data('image-index')
		});
	},
	removeImage: function (params) {
		if (params.uploadType == 'additional') {
			var selectedByName;
			$.each($('.small-photos img.additionalImage'), function(i, element) {
				var elementObject = $(element);
				if (elementObject.data('image-index') == params.imageIndex) {
					selectedByName = elementObject.data('filename');
				}
			});
			try {
				this.removeTempImage(selectedByName);
			}
			catch(error) {
				this.errorHandler(error);
				return false;
			}
			var imagesNamesIndex = this.current.additionalImagesNames.indexOf(selectedByName);
			this.current.additionalImagesNames.splice(imagesNamesIndex, 1);
			$.each($('.small-photos img.additionalImage'), function(i, domElement) {
				var domElementObject = $(domElement);
				if (domElementObject.data('image-index') == params.imageIndex) {
					domElementObject.parent().remove();
				}
			});
		}
		else {
			this.errorHandler(new Error('unknownUploadType'));
			return false;
		}
		this.checkPublishButton();
		return true;
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
		var imageNode = mainImgDiv.find('img#curMainImageName').get(0);
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
					.attr('id', 'curMainImageName')
					.data('filename', file.fileName)
					.data('image-type', 'main')
			);
		}
		$('.large-photo .status div').addClass('hidden');
		this.checkPublishButton();
	},
	addAdditionalImage: function (file) {
		var image;
		if (file.imageIndex) {
			this.current.additionalImagesNames[file.imageIndex] = file.fileName;
			$('.small-photos img').each(function(key, value) {
				var valueObject = $(value);
				if (valueObject.data('image-index') == file.imageIndex) {
					image = valueObject;
				}
			});
			image.attr('src', file.fileUrl);
			image.data('filename', file.fileName);
		} else {
			this.current.additionalImagesNames.push(file.fileName);
			var imagesContainer = $('.small-photos');
			image = new Image();
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
						.attr('class', 'additionalImage')
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
		$('.UploadTool').startThrobbing();
		if(!this.validateData()) {
			$('.UploadTool').stopThrobbing();
			return false;
		}
		var doSave = false;

		$.each(this.current, $.proxy(function (key, value) {
			if (this.current[key] != this.original[key]) {
				doSave = true;
			}
		}, this));

		if (doSave) {
			this.saveWikiPromoData(this.current);
		}
	},
	saveWikiPromoData: function (data) {
		$.nirvana.sendRequest({
			type: 'post',
			format: 'json',
			controller: 'SpecialPromote',
			method: 'saveData',
			data: data,
			callback: function (response) {
				Wikia.Querystring()
					.addCb()
					.goTo();
			},
			onErrorCallback: function () {
				$().log('error');
				$('.UploadTool').stopThrobbing();
			}
		});
	},
	removeTempImage: function (imagename) {
		if (!imagename) {
			throw new Error('removeTempImageError');
		}
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
		return true;
	},
	modifyRemoveHandler: function(e) {
		var targetObject = $(e.currentTarget);
		if (targetObject.find('img').length > 0) {
			targetObject.find('.modify-remove').toggleClass('show');
		}
	},
	errorHandler: function(errorObj) {
		var msg;
		switch (errorObj.message) {
			case 'removeTempImageError':
				msg = 'promote-error-upload-unknown-error';
				break;
			case 'unknownUploadType':
				msg = 'promote-error-upload-type';
				break;
			case 'getUploadFormError':
				msg = 'promote-error-upload-form';
				break;
			default:
				msg = 'promote-error-upload-unknown-error';
		}
		$($.msg(msg)).makeModal( {width: this.IMAGE_MODAL_WIDTH} );
	}
};

$(function () {
	$.loadJQueryAIM().done(function() {
		var SpecialPromoteInstance = new SpecialPromote();
		SpecialPromoteInstance.init();
	});
});
