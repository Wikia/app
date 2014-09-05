(function (window, $) {
	'use strict';

	var heroData = {
			title: null,
			description: null,
			imagename: null,
			imagepath: null,
			cropposition: 30, // for now let's not give that possibility to the user
			changed: false
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
			heroData.imagepath = imagePath;
			heroData.imagename = imageName;
			heroData.changed = true;

			console.log(heroData);
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
		};

	$('.hero-title').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
	$heroModule.on('change', onChange);
	$heroModule.on('saveEvent', onSave);

})(window, jQuery);
