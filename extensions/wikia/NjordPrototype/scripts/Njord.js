(function (window, $) {
	'use strict';

	$.event.props.push('dataTransfer');

	var
		HERO_ASPECT_RATIO = 212 / 500,
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
		$body = $('body'),
		$discardButton = $('#MainPageHero .discard-btn'),
		$editButton = $('#MainPageHero .edit-btn'),
		$toggleButton = $('#MainPageHero .toggle-btn'),
		$saveButton = $('#MainPageHero .save-btn'),
		$uploadButton = $('#MainPageHero .upload'),
		$overlay = $('#MainPageHero .overlay'),
		$heroModule = $('#MainPageHero'),
		$heroModuleTitle = $('#MainPageHero .hero-title'),
		$heroModuleDescription = $('#MainPageHero .hero-description'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload .upload-mask'),
		$heroModuleButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image'),
		$heroModuleEditArea = $('#MainPageHero .edit-area'),

		initializeData = function () {
			heroData.title = heroData.oTitle = $heroModuleTitle.text();
			heroData.description = heroData.oDescription = $heroModuleDescription.text();
			heroData.imagepath = heroData.oImage = $heroModuleImage.data('fullpath');
			heroData.cropposition = heroData.oCropposition = $heroModuleImage.data('cropposition');
		}, revertToCurrentZeroState = function () {
			$heroModuleTitle.text(heroData.oTitle);
			$heroModuleDescription.text(heroData.oDescription);
			$heroModuleImage.attr('src', heroData.oImage);
			$heroModuleImage.css({top: -heroData.oCropposition * $heroModuleImage.height()});
			$heroModuleImage.data('.hero-image', heroData.oCropposition);
			heroData.title = heroData.oTitle;
			heroData.description = heroData.oDescription;
			heroData.imagepath = heroData.oImage;
			heroData.imagename = null;
			heroData.cropposition = heroData.oCropposition;
			heroData.datachanged = false;
			heroData.imagechanged = false;

			$heroModule.trigger('revertedToZeroState');
		}, zeroState = function () {
			$('.hero-title, .hero-description').each(function () {
				$(this).removeAttr('contenteditable');
			});
			$toggleButton.show();
			$overlay.hide();
			$heroModuleEditArea.hide();
			$editButton.show();
			$heroModuleImage.draggable({ disabled: true });
			$heroModuleImage.removeClass('drag-cursor');
			$heroModule.stopThrobbing();
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
		}, onDataSaved = function () {
			$heroModuleImage.draggable({ disabled: true });
			$heroModuleImage.removeClass('drag-cursor');
			$heroModuleTitle.text(heroData.oTitle = heroData.title);
			$heroModuleTitle.text(heroData.oDescription = heroData.description);
			$heroModuleImage.attr('src', heroData.oImage = heroData.imagepath);
			$heroModuleImage.data('fullpath', heroData.imagepath);
			$heroModuleImage.data('cropposition', heroData.oCropposition = heroData.cropposition);

			revertToCurrentZeroState();
		}, onSave = function () {
			$heroModule.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroData',
				type: 'POST',
				data: {
					wikiData: heroData
				},
				callback: onDataSaved,
				onErrorCallback: function () {
					// TODO: handle failure
					$heroModule.stopThrobbing();
				}
			});
		}, onEdit = function () {
			$heroModule.startThrobbing();
			$('.hero-title, .hero-description').each(function () {
				$(this).attr('contenteditable', true);
			});
			$heroModuleEditArea.show();
			$editButton.hide();
			if ($heroModuleImage.attr('src') !== $heroModuleImage.data('fullpath')) {
				$heroModuleImage.attr('src', $heroModuleImage.data('fullpath'));
			} else {
				onImageLoad();
			}
		}, onImageLoad = function () {
			var top = -heroData.cropposition * $heroModuleImage.height();
			$heroModule.stopThrobbing();
			if (top + $heroModuleImage.height() >= $heroModule.height()) {
				$heroModuleImage.css({top: top});
			} else {
				$heroModuleImage.css({top: 0});
			}
			$heroModule.trigger('resize');
			$heroModule.trigger('enableDragging');
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
		}, sendForm = function (formdata) {
			$heroModule.startThrobbing();

			var client = new XMLHttpRequest();
			client.open('POST', '/wikia.php?controller=Njord&method=upload', true);
			client.onreadystatechange = function () {
				if (client.readyState === 4 && client.status === 200) {
					var data = JSON.parse(client.responseText);

					$heroModuleImage.bind('load', function () {
						$heroModule.stopThrobbing();
						$heroModule.trigger('enableDragging');
						$heroModuleImage.unbind('load');
					});
					$heroModuleImage.attr('src', data.url);
					$heroModule.trigger('resize');
					$heroModule.trigger('change', [data.url, data.filename]);
				}
			};
			client.send(formdata);
		}, initializeEditMode = function () {
			$editButton.show();

			$heroModuleTitle.on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
			$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
			//on(load) on img buged on this jquery
			$heroModuleImage[0].addEventListener('load', onImageLoad);
			$heroModule.on('change', onChange).on('enableDragging', onDraggingEnabled);
			$heroModule.on('revertedToZeroState', zeroState);
			$editButton.on('click', onEdit);
			$saveButton.on('click', onSave);
			$discardButton.on('click', revertToCurrentZeroState);
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
				$uploadButton.addClass('upload-hover');
				$heroModuleUploadMask.show();
				return false;
			});
			$heroModuleUploadMask.on('dragleave', function () {
				$uploadButton.removeClass('upload-hover');
				$heroModuleUploadMask.hide();
			});
			$heroModuleUploadMask.on('dragend', function () {
				return false;
			});

			$heroModuleUploadMask.on('drop', function (e) {
				$uploadButton.removeClass('upload-hover');
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

			$heroModuleButton.on('click', function () {
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
