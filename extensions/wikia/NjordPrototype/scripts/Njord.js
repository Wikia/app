(function (window, $) {
	'use strict';

	var heroData = {
			title: null,
			description: null,
			imagename: null,
			imagepath: null,
			cropposition: 30, // for now let's not give that possibility to the user
			imagechanged: false,
			datachanged: false
		},
		$heroModule = $('#MainPageHero'),

		onFocus = function () {
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
				},
				onErrorCallback: function () {
					// TODO: handle failure
				}
			});
		}, onEdit = function () {
			$('.hero-title, .hero-description').each(function() {
				var $this = $(this);
				if($this.attr('contenteditable')) {
					$this.removeAttr('contenteditable');
				} else {
					$this.attr('contenteditable', true);
				}
			});
			$('.overlay').toggle();
			$('.upload').toggle();
		}, onResize = function () {
			$heroModule.height($heroModule.width() * 5 / 16);
		};

	$('.hero-title').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$heroModule.on('change', onChange);
	$heroModule.on('saveEvent', onSave);
	$('.edit-btn').on('click', onEdit);

	$(window).resize(onResize);

})(window, jQuery);
