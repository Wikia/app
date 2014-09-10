(function (window, $) {
	'use strict';

	var heroData = {
			oTitle: null,
			oDescription: null,
			oImage: null,
			title: null,
			description: null,
			imagename: null,
			imagepath: null,
			cropposition: 0,
			imagechanged: false,
			datachanged: false
		},
		$heroModule = $('#MainPageHero'),
		$heroImage = $('#MainPageHero .hero-image'),
		load = function () {
			heroData.oTitle = $heroModule.find('.hero-title').text();
			heroData.oDescription = $heroModule.find('.hero-description').text();
			heroData.oImage = $heroModule.find('.hero-image').attr('src');
		}, revert = function () {
			$heroModule.find('.hero-title').text(heroData.oTitle);
			$heroModule.find('.hero-description').text(heroData.oDescription);
			$heroModule.find('.hero-image').attr('src', heroData.oImage);
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
			}
			heroData.changed = true;

			return $this;
		}, onSave = function () {
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'saveHeroData',
				type: 'POST',
				data: {
					wikiData: heroData
				},
				callback: function () {
					// TODO: handle success
					onEdit();
					load();
				},
				onErrorCallback: function () {
					// TODO: handle failure
				}
			});
		}, onEdit = function () {
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
		}, onResize = function () {
			$heroModule.height($heroModule.width() * 5 / 16);
		}, onDraggingEnabled = function () {
			var heroHeight = $heroImage.height(),
				heroModuleHeight = $heroModule.height(),
				heroOffsetTop = $heroImage.offset().top,
				containment = [0, heroOffsetTop - heroHeight + heroModuleHeight, 0, heroOffsetTop];

			$heroImage.draggable({
				axis: 'y',
				containment: containment,
				drag: function () {
					heroData.cropposition = Math.abs($heroImage.position().top) / $heroImage.height();
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
	$('.discard-btn').on('click', function () { onEdit(); revert(); });

	$(window).resize(onResize);
	load();

})(window, jQuery);
