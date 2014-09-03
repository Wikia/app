'use strict';

var heroData = {
		title: null,
		description: null,
        imagename: null,
		imagepath: null,
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
	}, saveData = function () {
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
	}, onChange = function () {
		var $this = $(this);
		heroData.title = $heroModule.find('.hero-title').text();
		heroData.description = $heroModule.find('.hero-description').text();
		heroData.imagepath = $heroModule.find('.hero-image').attr('src');
		heroData.changed = true;

		//TODO: remove;for debugging purposes
		saveData();
		return $this;
	};

$('.hero-title').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
$('.hero-description').on('focus', onFocus).on('blur keyup paste input', onInput).on('change', onChange);
