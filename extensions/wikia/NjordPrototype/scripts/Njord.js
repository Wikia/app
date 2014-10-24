(function (window, $) {
	'use strict';

	$.event.props.push('dataTransfer');

	var
		HERO_ASPECT_RATIO = 4 / 16,
		States = {
			list: [
				'zero-state',
				'filled-state',
				'upload-state',
				'edit-state'
			],
			clearState: function($element) {
				$element.removeClass( this.list.join(' '));
			},
			setState: function($element, $state) {
				if (this.list.indexOf($state) >= 0) {
					this.clearState($element);
					$element.addClass($state);
				}
			}
		},
		heroData = {
			oTitle: null,
			oDescription: null,
			oImage: null,
			oCropposition: 0,
			title: null,
			description: null,
			imagename: null,
			imagepath: null,
			cropposition: 0,
			imagechanged: false,
			datachanged: false
		},
		//hero image elements
		$imageElement = $('.MainPageHeroHeader .image-wrap'),
		$imageSaveElement = $('.MainPageHeroHeader .image-save-bar'),
		$titleElement = $('.MainPageHeroHeader .title-wrap'),
		$titleEditElement = $('.MainPageHeroHeader .title-wrap .edit-box'),
		$descElement = $('.MainPageHeroHeader .hero-desciprion'),

		$imageDiscardBtn = $('.MainPageHeroHeader .image-save-bar .discard-btn'),
		$imageSaveBtn = $('.MainPageHeroHeader .image-save-bar .save-btn'),

		$titleEditBtn = $('.MainPageHeroHeader .title-wrap .title-edit-btn'),
		$titleSaveBtn = $('.MainPageHeroHeader .title-wrap .save-btn'),
		$titleDiscardBtn = $('.MainPageHeroHeader .title-wrap .discard-btn'),
		$titleText = $('.MainPageHeroHeader .title-wrap .title-text'),

		$body = $('body'),
		$overlay = $('#MainPageHero .overlay'),
		$heroModule = $('#MainPageHero'),
		$heroModuleTitle = $('#MainPageHero .hero-title'),
		$heroModuleDescription = $('#MainPageHero .hero-description'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload .upload-mask'),
		$heroModuleAddButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleUpdateButton = $('#MainPageHero .upload .update-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image'),

		saveImage = function() {
			States.setState($imageSaveElement, 'filled-state');
			$imageElement.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroImage',
				type: 'POST',
				data: {
					'imagename': heroData.imagename,
					'cropposition': heroData.cropposition
				},
				callback: function() {
					$heroModuleImage.draggable({ disabled: true });
					$heroModuleImage.removeClass('drag-cursor');
					$heroModuleImage.attr('src', heroData.oImage = heroData.imagepath);
					$heroModuleImage.data('fullpath', heroData.imagepath);
					$heroModuleImage.data('cropposition', heroData.oCropposition = heroData.cropposition);
					$imageElement.stopThrobbing();
					States.setState($imageElement, 'filled-state');
					States.setState($imageSaveElement, 'filled-state');
				},
				onErrorCallback: function () {
					// TODO: handle failure
					$imageElement.stopThrobbing();
				}
			});
		},
		revertImage = function() {
			$heroModuleImage.draggable({ disabled: true });
			$heroModuleImage.removeClass('drag-cursor');
			$heroModuleImage.attr('src', heroData.oImage);
			$heroModuleImage.css({top: -heroData.oCropposition * $heroModuleImage.height()});
			$heroModuleImage.data('.hero-image', heroData.oCropposition);
			heroData.imagepath = heroData.oImage;
			heroData.imagename = null;
			heroData.cropposition = heroData.oCropposition;
			heroData.imagechanged = false;

			if (heroData.oImage === "") {
				States.setState($imageElement, 'zero-state');
				States.setState($imageSaveElement, 'zero-state');
			} else {
				States.setState($imageElement, 'filled-state');
				States.setState($imageSaveElement, 'filled-state');
			}
		},
		editTitle = function() {
			States.setState($titleElement, 'edit-state');
			//FIXME: fix onChange event, caret at end on focus
			$heroModuleTitle.focus();
			$heroModuleTitle.change();
		},
		saveTitle = function() {
			$titleEditElement.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroTitle',
				type: 'POST',
				data: {
					'title': heroData.title
				},
				callback: function() {
					$titleEditElement.stopThrobbing();
					$titleText.text(heroData.oTitle = heroData.title);
					States.setState($titleElement, 'filled-state');
				},
				onErrorCallback: function () {
					// TODO: handle failure
					$titleEditElement.stopThrobbing();
				}
			});
		},
		revertTitle = function() {
			$heroModuleTitle.text(heroData.oTitle);
			$titleText.text(heroData.oTitle);
			if (heroData.oTitle === "") {
				States.setState($titleElement, 'zero-state');
			} else {
				States.setState($titleElement, 'filled-state');
			}
		},
		saveDescription = function() {},
		revertDescription = function() {},

		initializeData = function () {
			heroData.title = heroData.oTitle = $heroModuleTitle.text();
			heroData.description = heroData.oDescription = $heroModuleDescription.text();
			heroData.imagepath = heroData.oImage = $heroModuleImage.data('fullpath');
			heroData.cropposition = heroData.oCropposition = $heroModuleImage.data('cropposition');
		}, onFocus = function () {
			var $this = $(this);
			$this.data('before', $this.html());
			return $this;
		}, onInput = function () {
			var $this = $(this);
			if ($this.data('before') !== $this.html()) {
				$this.data('before', $this.html());
				$this.trigger('change');
			}
			return $this;
		}, onChange = function (event, imagePath, imageName) {
			var target = $(event.target);

			heroData.title = $heroModuleTitle.text();
			heroData.description = $heroModuleDescription.text();
			if (imagePath || imageName) {
				heroData.imagepath = imagePath;
				heroData.imagename = imageName;
				heroData.imagechanged = true;
				$toggleButton.show();
				$overlay.hide();
			} else {
				var caretSave = target.caret();
				$heroModuleTitle.text($heroModuleTitle.text());
				$heroModuleDescription.text($heroModuleDescription.text());
				target.caret(caretSave);
			}
			heroData.changed = true;
		}, onImageLoad = function () {
			var top = -heroData.cropposition * $heroModuleImage.height();
			$heroModule.stopThrobbing();
			if (top + $heroModuleImage.height() >= $heroModule.height()) {
				$heroModuleImage.css({top: top});
			} else {
				$heroModuleImage.css({top: 0});
			}
			$heroModule.trigger('resize');
		}, onResize = function () {
			$heroModule.height($heroModule.width() * HERO_ASPECT_RATIO);
		}, onDraggingEnabled = function () {
			var heroHeight = $heroModuleImage.height(),
				heroModuleHeight = $heroModule.height(),
				heroOffsetTop = $heroModule.offset().top,
				containment = [0, heroOffsetTop - heroHeight + heroModuleHeight, 0, heroOffsetTop];

			$heroModuleImage.addClass('drag-cursor');
			$heroModuleImage.draggable({
				disabled: false,
				axis: 'y',
				containment: containment,
				drag: function () {
					heroData.cropposition = Math.abs($heroModuleImage.position().top) / $heroModuleImage.height();
				}
			});
		}, onDragDisabled = function () {
			return false;
		},
		onAfterSendForm = function (data) {
			if (data.isOk) {
				$heroModuleImage.bind('load', function () {
					$heroModule.stopThrobbing();
					$heroModule.trigger('enableDragging');
					$heroModuleImage.unbind('load');
				});
				$heroModuleImage.attr('src', data.url);
				$heroModule.trigger('resize');
				$heroModule.trigger('change', [data.url, data.filename]);
			} else {
				//var msg = JSMessages(jQuery.nirvana, jQuery, context);
				alert(data.errMessage);
			}
			$heroModule.stopThrobbing();
		},
		sendForm = function (formdata) {
			$heroModule.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'upload',
				type: 'POST',
				data: formdata,
				callback: onAfterSendForm,
				onErrorCallback: function () {
					// TODO: handle failure
					$heroModule.stopThrobbing();
				},
				processData : false,
				contentType : false
			});

		}, initializeEditMode = function () {
			$imageSaveBtn.on('click', saveImage);
			$imageDiscardBtn.on('click', revertImage);
			$titleEditBtn.on('click', editTitle);
			$titleSaveBtn.on('click', saveTitle);
			$titleDiscardBtn.on('click', revertTitle);

			$heroModuleTitle.on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
			$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
			//on(load) on img buged on this jquery
			$heroModuleImage[0].addEventListener('load', onImageLoad);
			$heroModule.on('change', onChange).on('enableDragging', onDraggingEnabled);
			$('.toggle-upload-btn').on('click', function () {
				$toggleButton.hide();
				$overlay.show();
			});
			$('.close-upload-btn').on('click', function () {
				$toggleButton.show();
				$overlay.hide();
			});

			$(window).resize(onResize);
			initializeData();

			//turn off browser image handling

			$body.on('dragover', onDragDisabled).on('dragend', onDragDisabled).on('drop', onDragDisabled);

			//those two are needed to cancel default behaviour
			$heroModuleUpload.on('dragenter', function () {
				$overlay.show();
				$heroModuleUploadMask.show();
				return false;
			});
			$heroModuleUploadMask.on('dragleave', function () {
				$overlay.hide();
				$heroModuleUploadMask.hide();
			});
			$heroModuleUploadMask.on('dragend', function () {
				return false;
			});

			$heroModuleUploadMask.on('drop', function (e) {
				$overlay.hide();
				$heroModuleUploadMask.hide();
				e.preventDefault();
				var fd = new FormData();
				if (e.dataTransfer.files.length) {
					//if file is uploaded
					fd.append('file', e.dataTransfer.files[0]);
					sendForm(fd);
				} else if (e.dataTransfer.getData('text/html')) {
					//if url
					var $img = $(e.dataTransfer.getData('text/html'));
					if (e.target.src !== $img.attr('src')) {
						fd.append('url', $img.attr('src'));
						sendForm(fd);
					}
				}
			});

			$heroModuleAddButton.on('click', function () {
				$heroModuleInput.click();
			});

			$heroModuleUpdateButton.on('click', function () {
				$heroModuleInput.click();
			});

			$heroModuleInput.on('change', function () {
				if ($heroModuleInput[0].files.length) {
					var fd = new FormData();
					fd.append('file', $heroModuleInput[0].files[0]);
					sendForm(fd);
					//reset input
					$heroModuleInput.wrap('<form>').closest('form').get(0).reset();
					$heroModuleInput.unwrap();
				}
			});
		};

	if (window.wgUserName) {
		initializeEditMode();
	}
})(window, jQuery);
