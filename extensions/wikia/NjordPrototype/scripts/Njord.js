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
	};

	var
		HERO_ASPECT_RATIO = 3.89 / 16,
		States = {
			list: [
				'zero-state',
				'filled-state',
				'upload-state',
				'edit-state',
				'no-edit-state'
			],
			clearState: function ($element) {
				$element.removeClass(this.list.join(' '));
			},
			setState: function ($element, $state) {
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
		$titleEditBoxText = $('.MainPageHeroHeader .title-wrap .edit-box .hero-title'),

		$imageDiscardBtn = $('.MainPageHeroHeader .image-save-bar .discard-btn'),
		$imageSaveBtn = $('.MainPageHeroHeader .image-save-bar .save-btn'),

		$titleEditBtn = $('.MainPageHeroHeader .title-wrap .title-edit-btn'),
		$titleText = $('.MainPageHeroHeader .title-wrap .title-text'),

		$descriptionElement = $('.MainPageHeroHeader .hero-description'),
		$descriptionSaveBtn = $('.MainPageHeroHeader .hero-description .save-btn'),
		$descriptionDiscardBtn = $('.MainPageHeroHeader .hero-description .discard-btn'),
		$descriptionEditBoxText = $('.MainPageHeroHeader .hero-description .edit-box .edited-text'),
		$descriptionText = $('.hero-description-text'),

		$body = $('body'),
		$heroHeader = $('.MainPageHeroHeader'),
		$overlay = $('#MainPageHero .overlay'),
		$heroModule = $('#MainPageHero'),
		$heroModuleTitle = $('.MainPageHeroHeader .hero-title'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload-mask'),
		$heroModuleAddButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleUpdateButton = $('#MainPageHero .upload .update-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image'),
		$heroPositionText = $('#MainPageHero .position-info'),

		$wikiaArticle = $('#WikiaArticle'),

		trackDragOnlyOncePerImage = false,

		saveHeroImageLabel = 'publish-hero-image',
		saveHeroImageFailLabel = 'hero-image-fail',
		revertHeroImageLabel = 'discard-hero-image',
		editTitleLabel = 'edit-hero-title',
		saveTitleLabel = 'publish-hero-title',
		saveTitleFailLabel = 'hero-title-fail',
		revertTitleFailLabel = 'discard-hero-title',
		saveSummaryLabel = 'publish-hero-summary',
		saveSummaryFailLabel = 'hero-summary-fail',
		revertSummaryLabel = 'discard-hero-summary',
		moveImageLabel = 'move-image-hero-position',
		editSummaryLabel = 'edit-hero-summary',
		heroModuleAddButtonLabel = 'add-hero-image',
		heroModuleUpdateButtonLabel = 'update-hero-image',
		imageLoadedLabel = 'hero-image-loaded',
		imageLoadedFailLabel = 'hero-image-load-fail',
		dropUrlLabel = 'drag-drop-hero-image',
		dropFileLabel = 'drag-drop-hero-image',

		trackerActionClick = Wikia.Tracker.ACTIONS.CLICK,
		trackerActionError = Wikia.Tracker.ACTIONS.ERROR,
		trackerActionSuccess = Wikia.Tracker.ACTIONS.SUCCESS,
		trackerActionHover = Wikia.Tracker.ACTIONS.HOVER,

		trackHelper = function(trackLabel, trackAction, trackCategory){
			Wikia.Tracker.track({
				ga_action: trackAction,
				ga_category: trackCategory,
				label: trackLabel,
				trackingMethod: 'ga'
			});
		},
		trackMom = function (trackLabel, trackAction) {
			trackHelper(trackLabel, trackAction, 'MOM');
		},
		saveImage = function () {
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
				callback: function (data) {
					if (data.success) {
						$heroModuleImage.draggable({disabled: true});
						$heroModuleImage.removeClass('drag-cursor');
						$heroModuleImage.attr('src', heroData.oImage = heroData.imagepath);
						$heroModuleImage.data('fullpath', heroData.imagepath);
						$heroModuleImage.data('cropposition', heroData.oCropposition = heroData.cropposition);
						States.setState($imageElement, 'filled-state');
						States.setState($imageSaveElement, 'filled-state');
					} else {
						revertImage();
					}
					$imageElement.stopThrobbing();
				},
				onErrorCallback: function () {
					revertImage();
					$imageElement.stopThrobbing();
					trackMom(saveHeroImageFailLabel, trackerActionError);
				}
			});
		},
		revertImage = function () {
			$imageElement.startThrobbing();
			$heroModuleImage.draggable({disabled: true});
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
		},
		editTitle = function () {
			States.setState($titleElement, 'edit-state');
			$heroModuleTitle.change();
			editDescription();
			$heroModuleTitle.focus();
			placeCaretAtEnd($titleEditBoxText.get(0));
		},
		revertTitle = function () {
			$heroModuleTitle.text(heroData.oTitle);
			$titleText.text(heroData.oTitle);
			if (heroData.oTitle === "") {
				States.setState($titleElement, 'zero-state');
			} else {
				States.setState($titleElement, 'filled-state');
			}
		},
		saveTitleAndDescription = function() {
			var title = heroData.title.trim(),
				description = heroData.description.trim();

			$titleEditElement.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveTitleAndDescription',
				type: 'POST',
				data: {
					'title': title,
					'description': description
				},
				callback: function (data) {
					if (data.success) {
						$titleText.text(heroData.oTitle = title);
						States.setState($titleElement, 'filled-state');
						States.setState($descriptionElement, 'filled-state');
						heroData.oDescription = description;
						$descriptionText.text(description);
					} else {
						revertDescriptionAndTitle();
					}
					$titleEditElement.stopThrobbing();
				},
				onErrorCallback: function () {
					revertDescriptionAndTitle();
					$titleEditElement.stopThrobbing();
					trackMom(saveTitleFailLabel, trackerActionError);
				}
			});
		},
		editDescription = function () {
			States.setState($descriptionElement, 'edit-state');

			//FIXME: fix onChange event, caret at end on focus
			$descriptionEditBoxText.text(heroData.description);
			$descriptionEditBoxText.focus();
			$descriptionEditBoxText.change();
			placeCaretAtEnd($descriptionEditBoxText.get(0));
		},
		revertDescriptionAndTitle = function () {
			heroData.description = heroData.oDescription;
			if (heroData.oDescription == undefined || heroData.oDescription.trim() === "") {
				States.setState($descriptionElement, 'zero-state');
			} else {
				States.setState($descriptionElement, 'filled-state');
			}
			$descriptionEditBoxText.text(heroData.oDescription);
			revertTitle()
		},

		initializeData = function () {
			heroData.title = heroData.oTitle = $heroModuleTitle.text();
			heroData.description = heroData.oDescription = $descriptionText.text();
			heroData.imagepath = heroData.oImage = $heroModuleImage.data('fullpath');
			heroData.cropposition = heroData.oCropposition = $heroModuleImage.data('cropposition');
		}, onPaste = function (e) {
			var $this = $(this);
			window.setTimeout(function() {
				$this.html($this.text());
				placeCaretAtEnd($this.get(0));
			}, 1);
			return $this;
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
				if (typeof target !== 'undefined' && target.caret === 'function') {
					var caretSave = target.caret();
					$heroModuleTitle.text($heroModuleTitle.text());
					target.caret(caretSave);
				}
			}

			if (heroData.title.trim().length === 0 || heroData.description.trim().length === 0) {
				$descriptionSaveBtn.attr("disabled", "disabled");
			} else {
				$descriptionSaveBtn.removeAttr("disabled");
			}

			heroData.changed = true;
		}, onImageLoad = function () {
			var top = -heroData.cropposition * $heroModuleImage.height();
			if (top + $heroModuleImage.height() >= $heroModule.height()) {
				$heroModuleImage.css({top: top});
			} else {
				$heroModuleImage.css({top: 0});
			}
			$heroModule.stopThrobbing();
			$heroModule.trigger('resize');
			trackDragOnlyOncePerImage = false;
		}, onResize = function () {
			if (!$imageElement.hasClass('zero-state')) {
				$heroModule.outerHeight(Math.floor($heroModule.width() * HERO_ASPECT_RATIO));
			}
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
					if (!trackDragOnlyOncePerImage) {
						trackDragOnlyOncePerImage = true;
						trackMom(moveImageLabel, trackerActionClick);
					}
				}
			});
		}, onDragDisabled = function () {
			return false;
		},
		onAfterSendForm = function (data) {
			if (data.isOk) {
				$heroModuleImage.bind('load', function () {
					if ($imageElement.hasClass('zero-state')) {
						$heroModule.outerHeight(Math.floor($heroModule.width() * HERO_ASPECT_RATIO));
					}
					States.setState($imageElement, 'upload-state');
					States.setState($imageSaveElement, 'upload-state');
					$heroModule.trigger('enableDragging');
					$heroModuleImage.unbind('load');
					$heroModule.stopThrobbing();
				});
				$heroModuleImage.attr('src', data.url);
				$heroModule.trigger('resize');
				$heroModule.trigger('change', [data.url, data.filename]);
				trackMom(imageLoadedLabel, trackerActionSuccess);

			} else {
				trackMom(imageLoadedFailLabel, trackerActionError);
				new window.GlobalNotification(data.errMessage, 'error').show();
				$heroModule.stopThrobbing();
			}
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
					trackMom(imageLoadedFailLabel, trackerActionError);
					$heroModule.stopThrobbing();
				},
				processData: false,
				contentType: false
			});

		}, initializeEditMode = function () {
			//load messages
			$imageSaveBtn.on('click', saveImage)
				.on('click', function () {
					trackMom(saveHeroImageLabel, trackerActionClick);
				});
			$imageDiscardBtn.on('click', revertImage)
				.on('click', function () {
					trackMom(revertHeroImageLabel, trackerActionClick);
				});
			$titleEditBtn.on('click', editTitle)
				.on('click', function () {
					trackMom(editTitleLabel, trackerActionClick);
				});
			$heroModuleTitle.on('focus', onFocus)
				.on('blur keyup paste input', onInput)
				.on('paste', onPaste)
				.on('change', onChange);

			//on(load) on img buged on this jquery
			$heroModuleImage[0].addEventListener('load', onImageLoad);
			$heroModule.on('change', onChange)
				.on('enableDragging', onDraggingEnabled);

			//hero description
			$descriptionElement.on('focus', onFocus)
				.on('blur keyup paste input', onInput)
				.on('change', onChange);

			$descriptionDiscardBtn.on('click', revertDescriptionAndTitle)
				.on('click', function () {
					trackMom(revertSummaryLabel, trackerActionClick);
				});
			$descriptionSaveBtn.on('click', saveTitleAndDescription)
				.on('click', function () {
					trackMom(saveSummaryLabel, trackerActionClick);
				});
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
					trackMom(dropFileLabel, trackerActionHover);
					//if file is uploaded
					fd.append('file', e.dataTransfer.files[0]);
					sendForm(fd);

				} else if (e.dataTransfer.getData('text/html')) {
					//if url
					var $img = $(e.dataTransfer.getData('text/html'));
					if (e.target.src !== $img.attr('src')) {
						trackMom(dropUrlLabel, trackerActionHover);
						fd.append('url', $img.attr('src'));
						sendForm(fd);
					}
				}
			});

			$heroModuleAddButton.on('click', function () {
				$heroModuleInput.click();
				trackMom(heroModuleAddButtonLabel, trackerActionClick);
			});

			$heroModuleUpdateButton.on('click', function () {
				$heroModuleInput.click();
				trackMom(heroModuleUpdateButtonLabel, trackerActionClick);
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

			$heroPositionText.on('mousedown', function(e) {
				$heroModuleImage.trigger(e);
			});
		}, initializeEditButton = function () {
			var onclose = new MutationObserver(function (m) {
				$('.MainPageHeroHeader .global-edit-wrap').show();
				onclose.disconnect();
			});
			var onload = new MutationObserver(function (m) {
				$('.MainPageHeroHeader .global-edit-wrap').hide();
				onload.disconnect();
				onclose.observe($wikiaArticle[0], {childList: true});
			});
			$('#ca-ve-edit').on('click', function () {
				onload.observe($wikiaArticle[0], {childList: true});
				//TODO make a distinction between Visual editor and old one
				trackHelper('edit', 'click', 'article');
			});
			if (window.location.search.indexOf('veaction=edit') >= 0) {
				onload.observe($wikiaArticle[0], {childList: true});
			}
		};

	//TODO: pass actual user rights
	if (window.wgUserName) {
		States.clearState($heroHeader);
		initializeEditMode();
	}
	initializeEditButton();
	$heroModule.trigger('resize');
	$(window).resize(onResize);
})(window, jQuery);
