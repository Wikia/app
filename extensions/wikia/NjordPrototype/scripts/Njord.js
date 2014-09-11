(function (window, $) {
	'use strict';

	$.event.props.push('dataTransfer');

	var heroData = {
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
		$editButton = $('#MainPageHero .edit-btn'),
		$saveButton = $('#MainPageHero .save-btn'),
		$heroModule = $('#MainPageHero'),
		$heroModuleTitle = $('#MainPageHero .hero-title'),
		$heroModuleDescription = $('#MainPageHero .hero-description'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload .upload-mask'),
		$heroModuleButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image'),

		initializeData = function () {
			heroData.title = heroData.oTitle = $heroModuleTitle.text();
			heroData.description = heroData.oDescription = $heroModuleDescription.text();
			heroData.imagepath = heroData.oImage = $heroModuleImage.attr('src');
			heroData.cropposition = heroData.oCropposition = $heroModuleImage.data('cropposition');
		}, revertToCurrentZeroState = function () {
			$heroModuleTitle.text(heroData.oTitle);
			$heroModuleDescription.text(heroData.oDescription);
			$heroModuleImage.attr('src', heroData.oImage);
			$heroModuleImage.css({top: 0});
			$heroModuleImage.data('.hero-image', heroData.oCropposition);
			heroData.title = heroData.oTitle;
			heroData.description = heroData.oDescription;
			heroData.imagepath = heroData.oImage;
			heroData.cropposition = heroData.oCropposition;

			$heroModule.trigger('revertedToZeroState');
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
			var $this = $(this);
			heroData.title = $heroModule.find('.hero-title').text();
			heroData.description = $heroModule.find('.hero-description').text();
			if (imagePath || imageName) {
				heroData.imagepath = imagePath;
				heroData.imagename = imageName;
				heroData.imagechanged = true;
				$('.toggle-btn').show();
				$('.overlay').hide();
			}
			heroData.changed = true;

			return $this;
		}, onSave = function () {
			$heroModule.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroData',
				type: 'POST',
				data: {
					wikiData: heroData
				},
				callback: function () {
					$heroModuleImage.draggable('disable');
					onEdit();
					initializeData();
					$heroModule.stopThrobbing();
				},
				onErrorCallback: function () {
					// TODO: handle failure
					$heroModule.stopThrobbing();
				}
			});
		}, onEdit = function () {
			$heroModule.startThrobbing();

			$heroModuleImage.bind('load', function () {
				$heroModule.stopThrobbing();
				$heroModuleImage.unbind('load');

				$('.hero-title, .hero-description').each(function () {
					var $this = $(this);
					if ($this.attr('contenteditable')) {
						$this.removeAttr('contenteditable');
					} else {
						$this.attr('contenteditable', true);
					}
				});
				$('.edit-area').toggle();
				$editButton.toggle();

				$heroModuleImage.css({top: -heroData.oCropposition * $heroModuleImage.height()});
				$heroModule.trigger('enableDragging');
			});
			$heroModuleImage.attr('src', $heroModuleImage.data('fullpath'));
		}, onResize = function () {
			$heroModule.height($heroModule.width() * 5 / 16);
		}, onDraggingEnabled = function () {
			var heroHeight = $heroModuleImage.height(),
				heroModuleHeight = $heroModule.height(),
				heroOffsetTop = $heroModuleImage.offset().top,
				containment = [0, heroOffsetTop - heroHeight + heroModuleHeight, 0, heroOffsetTop];

			$heroModuleImage.draggable({
				axis: 'y',
				containment: containment,
				drag: function () {
					heroData.cropposition = Math.abs($heroModuleImage.position().top) / $heroModuleImage.height();
				}
			});
		}, onDragDisabled = function () {
			return false;
		};

	$heroModuleTitle.on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$heroModule.on('change', onChange).on('saveEvent', onSave).on('enableDragging', onDraggingEnabled);
	$editButton.on('click', onEdit);
	$saveButton.on('click', onSave);
	$('.discard-btn').on('click', revertToCurrentZeroState);
	$('.toggle-upload-btn').on('click', function () {
		$('.toggle-btn').hide();
		$('.overlay').show();
	});
	$('.close-upload-btn').on('click', function () {
		$('.toggle-btn').show();
		$('.overlay').hide();
	});

	$(window).resize(onResize);
	initializeData();

	//turn off browser image handling

	$body.on('dragover', onDragDisabled).on('dragend', onDragDisabled).on('drop', onDragDisabled);

	//those two are needed to cancel default behaviour
	$heroModuleUpload.on('dragenter', function () {
		$('.upload').addClass('upload-hover');
		$heroModuleUploadMask.show();
		return false;
	});
	$heroModuleUploadMask.on('dragleave', function () {
		$('.upload').removeClass('upload-hover');
		$heroModuleUploadMask.hide();
	});
	$heroModuleUploadMask.on('dragend', function () {
		return false;
	});

	$heroModuleUploadMask.on('drop', function (e) {
		$('.upload').removeClass('upload-hover');
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
		}
	});

	function sendForm(formdata) {
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
				$heroModule.height($heroModule.width() * 5 / 16);
				$heroModule.trigger('change', [data.url, data.filename]);
			}
		};
		client.send(formdata);
	}
})(window, jQuery);
