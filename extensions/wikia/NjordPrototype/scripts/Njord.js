(function (window, $) {
	'use strict';

	$.event.props.push('dataTransfer');
	function placeCaretAtEnd(el) {
		el.focus();
		if (typeof window.getSelection != "undefined"
			&& typeof document.createRange != "undefined") {
			var range = document.createRange();
			range.selectNodeContents(el);
			range.collapse(false);
			var sel = window.getSelection();
			sel.removeAllRanges();
			sel.addRange(range);
		} else if (typeof document.body.createTextRange != "undefined") {
			var textRange = document.body.createTextRange();
			textRange.moveToElementText(el);
			textRange.collapse(false);
			textRange.select();
		}
	}

	var
		HERO_ASPECT_RATIO = 4 / 16,
		States = {
			list: [
				'zero-state',
				'filled-state',
				'upload-state',
				'edit-state',
				'no-edit-state'
			],
			clearState: function($element) {
				$element.removeClass( this.list.join(' ') );
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

		$imageDiscardBtn = $('.MainPageHeroHeader .image-save-bar .discard-btn'),
		$imageSaveBtn = $('.MainPageHeroHeader .image-save-bar .save-btn'),

		$titleEditBtn = $('.MainPageHeroHeader .title-wrap .title-edit-btn'),
		$titleSaveBtn = $('.MainPageHeroHeader .title-wrap .save-btn'),
		$titleDiscardBtn = $('.MainPageHeroHeader .title-wrap .discard-btn'),
		$titleText = $('.MainPageHeroHeader .title-wrap .title-text'),

		$descriptionElement = $('.MainPageHeroHeader .hero-description'),
		$descriptionEditElement = $('.MainPageHeroHeader .hero-description .edit-box'),
		$descriptionEditBtn = $('.MainPageHeroHeader .hero-description .edit-btn'),
		$descriptionSaveBtn = $('.MainPageHeroHeader .hero-description .save-btn'),
		$descriptionDiscardBtn = $('.MainPageHeroHeader .hero-description .discard-btn'),
		$descriptionEditBoxText = $('.MainPageHeroHeader .hero-description .edit-box .edited-text'),
		$descriptionText = $('.hero-description_text'),

		$body = $('body'),
		$heroHeader = $('.MainPageHeroHeader'),
		$overlay = $('#MainPageHero .overlay'),
		$heroModule = $('#MainPageHero'),
		$heroModuleTitle = $('#MainPageHero .hero-title'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload-mask'),
		$heroModuleAddButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleUpdateButton = $('#MainPageHero .upload .update-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image'),

		saveHeroImageLabel = 'SaveHeroImage',
		saveHeroImageFailLabel = 'SaveHeroImageFail',
		revertHeroImageLabel = 'RevertHeroImage',
		editTitleLabel = 'EditTitle',
		saveTitleLabel = 'SaveTitle',
		saveTitleFailLabel = 'SaveTitleFail',
		revertTitleFailLabel = 'RevertTitle',
		saveSummaryLabel = 'SaveSummary',
		saveSummaryFailLabel = 'SaveSummaryFail',
		revertSummaryLabel = 'RevertSummary',
		editSummaryLabel = 'EditSummary',
		heroModuleAddButtonLabel = 'AddButton-Click',
		heroModuleUpdateButtonLabel = 'UpdateButton-Click',
		imageLoadedLabel = 'ImageLoaded',
		imageLoadedFailLabel = 'ImageLoadedFail',
		dropUrlLabel = 'DropUrl',
		dropFileLabel ='DropFile',
		trackerActionEdit = Wikia.Tracker.ACTIONS.ADD,
		trackerActionDrop = Wikia.Tracker.ACTIONS.HOVER,
		trackerActionError = Wikia.Tracker.ACTIONS.ERROR,
		trackerActionPost = Wikia.Tracker.ACTIONS.SUBMIT,

		trackMom = function( trackLabel, trackAction){
			Wikia.Tracker.track({
				ga_action: trackAction,
				ga_category: 'MOM',
				label: trackLabel,
				trackingMethod: 'ga'
			});
		},

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
					trackMom(saveHeroImageLabel, trackerActionEdit);
				},
				onErrorCallback: function () {
					// TODO: handle failure
					$imageElement.stopThrobbing();
					trackMom(saveHeroImageFailLabel, trackerActionError);
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

			if (heroData.oImage === wgBlankImgUrl) {
				States.setState($imageElement, 'zero-state');
				States.setState($imageSaveElement, 'zero-state');
			} else {
				States.setState($imageElement, 'filled-state');
				States.setState($imageSaveElement, 'filled-state');
			}
			trackMom(revertHeroImageLabel, trackerActionEdit);
		},
		editTitle = function() {
			//turn off description editing
			revertDescription();
			States.setState($titleElement, 'edit-state');
			//FIXME: fix onChange event, caret at end on focus
			$heroModuleTitle.focus();
			$heroModuleTitle.change();
			trackMom(editTitleLabel, trackerActionEdit);
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
					trackMom(saveTitleLabel, trackerActionEdit);
				},
				onErrorCallback: function () {
					// TODO: handle failure
					$titleEditElement.stopThrobbing();
					trackMom(saveTitleFailLabel, trackerActionError);
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
			trackMom(revertTitleFailLabel, trackerActionEdit);
		},
		saveDescription = function () {
			$descriptionEditElement.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroDescription',
				type: 'POST',
				data: {
					'description': heroData.description
				},
				callback: function () {
					$descriptionEditElement.stopThrobbing();
					States.setState($descriptionElement, 'filled-state');
					heroData.oDescription = heroData.description;
					$descriptionText.text(heroData.description);
					trackMom(saveSummaryLabel, trackerActionPost);
				},
				onErrorCallback: function () {
					// TODO: handle failure
					$descriptionEditElement.stopThrobbing();
					trackMom(saveSummaryFailLabel, trackerActionPost);
					$.showModal($.msg('error'), 'Error while saving description');
				}
			});
		},
		editDescription = function () {
			//turn off title editing
			revertTitle();
			States.setState($descriptionElement, 'edit-state');
			//FIXME: fix onChange event, caret at end on focus
			$descriptionEditBoxText.text(heroData.description);
			$descriptionEditBoxText.focus();
			$descriptionEditBoxText.change();
			placeCaretAtEnd($descriptionEditBoxText.get(0));
			trackMom(editSummaryLabel, trackerActionEdit);
		},
		revertDescription = function () {
			heroData.description = heroData.oDescription;
			$descriptionEditBoxText.text(heroData.oDescription);
			States.setState($descriptionElement, 'filled-state');
			trackMom(revertSummaryLabel, trackerActionEdit);
		},

		initializeData = function () {
			heroData.title = heroData.oTitle = $heroModuleTitle.text();
			heroData.description = heroData.oDescription = $descriptionText.text();
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
			heroData.description = $descriptionEditBoxText.text();
			if (imagePath || imageName) {
				heroData.imagepath = imagePath;
				heroData.imagename = imageName;
				heroData.imagechanged = true;
				$overlay.hide();
			} else {
				var caretSave = target.caret();
				$heroModuleTitle.text($heroModuleTitle.text());
//				$heroModuleDescription.text($heroModuleDescription.text());
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
					States.setState($imageElement, 'upload-state');
					States.setState($imageSaveElement, 'upload-state');
					$heroModule.trigger('enableDragging');
					$heroModuleImage.unbind('load');
					$heroModule.stopThrobbing();
				});
				$heroModuleImage.attr('src', data.url);
				$heroModule.trigger('resize');
				$heroModule.trigger('change', [data.url, data.filename]);
				trackMom(imageLoadedLabel, trackerActionPost);
			} else {
				trackMom(imageLoadedFailLabel, trackerActionError);
				$.showModal($.msg('error'), data.errMessage);
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
					$.showModal($.msg('error'), $.msg('unknown-error'));
					trackMom(imageLoadedFailLabel, trackerActionError);
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
			//on(load) on img buged on this jquery
			$heroModuleImage[0].addEventListener('load', onImageLoad);
			$heroModule.on('change', onChange).on('enableDragging', onDraggingEnabled);

			//hero description
			$descriptionElement.on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);

			$descriptionEditBtn.on('click', editDescription);
			$descriptionDiscardBtn.on('click', revertDescription);
			$descriptionSaveBtn.on('click', saveDescription);

			$(window).resize(onResize);
			initializeData();

			//turn off browser image handling
			$body.on('dragover', onDragDisabled).on('dragend', onDragDisabled).on('drop', onDragDisabled);

			$heroModule.on('dragenter', function () {
			//$heroModuleUpload.on('dragover', function () {
				$overlay.show();
				$heroModuleUploadMask.show();
				return false;
			});
			$heroModuleUploadMask.on('dragleave', function (e) {
				$overlay.hide();
				$heroModuleUploadMask.hide();
				e.stopImmediatePropagation();
				return false;
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
					trackMom(dropUrlLabel,trackerActionDrop);
					//if file is uploaded
					fd.append('file', e.dataTransfer.files[0]);
					sendForm(fd);

				} else if (e.dataTransfer.getData('text/html')) {
					//if url
					var $img = $(e.dataTransfer.getData('text/html'));
					if (e.target.src !== $img.attr('src')) {
						trackMom(dropFileLabel,trackerActionDrop);
						fd.append('url', $img.attr('src'));
						sendForm(fd);
					}
				}
			});

			$heroModuleAddButton.on('click', function () {
				$heroModuleInput.click();
				trackMom(heroModuleAddButtonLabel, Wikia.Tracker.ACTIONS.CLICK);
			});

			$heroModuleUpdateButton.on('click', function () {
				$heroModuleInput.click();
				trackMom(heroModuleUpdateButtonLabel, Wikia.Tracker.ACTIONS.CLICK);
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
		States.clearState($heroHeader);
		initializeEditMode();
	}
})(window, jQuery);
