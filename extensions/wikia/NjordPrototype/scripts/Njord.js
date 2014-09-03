(function (window, $) {
	'use strict';

	var heroData = {
		title: null,
		description: null,
		imageName: null,
		imagePath: null
	},
	$heroModule = $('#MainPageHero');

	heroData.title = $heroModule.find('.hero-title').text();
	heroData.description = $heroModule.find('.hero-description').text();
	heroData.imagePath = $heroModule.find('.hero-image').attr('src');

	$heroModule.on('focus', '[contenteditable]',function () {
		var $this = $(this);
		$this.data('before', $this.html());
		return $this;
	}).on('blur keyup paste input', '[contenteditable]', function () {
		var $this = $(this);
		if ($this.data('before') !== $this.html()) {
			$this.data('before', $this.html());
			$this.trigger('change');
		}
		return $this;
	});
})(window, jQuery);
