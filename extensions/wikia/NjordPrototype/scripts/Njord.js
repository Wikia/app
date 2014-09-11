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
		$heroModule = $('#MainPageHero'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload .upload-mask'),
		$heroModuleButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image'),
		load = function () {
			heroData.title = heroData.oTitle = $heroModule.find('.hero-title').text();
			heroData.description = heroData.oDescription = $heroModule.find('.hero-description').text();
			heroData.imagepath = heroData.oImage = $heroModule.find('.hero-image').attr('src');
			heroData.cropposition = heroData.oCropposition = $heroModuleImage.data('cropposition');
		}, revert = function () {
			$heroModule.find('.hero-title').text(heroData.oTitle);
			$heroModule.find('.hero-description').text(heroData.oDescription);
			$heroModule.find('.hero-image').attr('src', heroData.oImage);
			$heroModule.find('.hero-image').css({top: 0});
			$heroModuleImage.data('.hero-image', heroData.oCropposition);
			$('.edit-area').toggle();
			$('.edit-btn').toggle();
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
			console.log('onSave');
			$heroModule.startThrobbing();
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroData',
				type: 'POST',
				data: {
					wikiData: heroData
				},
				callback: function () {
					console.log('success callback');
					$heroModuleImage.draggable('disable');
					onEdit();
					load();
					$heroModule.stopThrobbing();
				},
				onErrorCallback: function () {
					// TODO: handle failure
					console.log('failure callback');
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
				$('.edit-btn').toggle();

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
		};

	$('.hero-title').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$heroModule.on('change', onChange);
	$heroModule.on('saveEvent', onSave);
	$heroModule.on('enableDragging', onDraggingEnabled);
	$('.edit-btn').on('click', onEdit);
	$('.save-btn').on('click', onSave);
	$('.discard-btn').on('click', function () {
		revert();
	});
	$('.toggle-upload-btn').on('click', function () {
		$('.toggle-btn').hide();
		$('.overlay').show();
	});
	$('.close-upload-btn').on('click', function () {
		$('.toggle-btn').show();
		$('.overlay').hide();
	});

	$(window).resize(onResize);
	load();

	//turn off browser image handling
	$body.on('dragover', function () {
		return false;
	});
	$body.on('dragend', function () {
		return false;
	});
	$body.on('drop', function () {
		return false;
	});

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
