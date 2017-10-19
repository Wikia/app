define(
	'wikia.articleVideo.featuredVideo.jwplayer.autoplayToggle',
	['wikia.articleVideo.featuredVideo.autoplay', 'wikia.articleVideo.featuredVideo.jwplayer.instance'],
	function (featuredVideoAutoplay, playerInstance) {

		function addAutoplayToggle($settingsTopbar) {
			$settingsTopbar
				.find('.jw-settings-close')
				.before(
					'<input type="checkbox" id="featuredVideoAutoplayToggle" class="wds-switch__input"' +
					(featuredVideoAutoplay.isAutoplayEnabled() ? ' checked>' : '>') +
					'<label for="featuredVideoAutoplayToggle" class="wds-switch__label">Autoplay</label>'
				);

			$settingsTopbar
				.find('.wds-switch__label')
				.on('mouseup pointerup touchstart', function (event) {
					event.stopPropagation();

					featuredVideoAutoplay.toggleAutoplay(!event.target.previousSibling.checked);
				})
				.on('click', function () {
					playerInstance.trigger('autoplayToggle', {
						willAutoplay: !event.target.previousSibling.checked
					})
				});
		}

		return function () {
			// we need to get player container instead of #featured-video__player,
			// because we think jwplayer replaces this element and we lost on click listener
			var $playerContainer = $('.featured-video__player-container');

			if (featuredVideoAutoplay.inAutoplayCountries) {
				$playerContainer.on('click', '.jw-settings-submenu-button', function () {
					if (!$('#featuredVideoAutoplayToggle').length) {
						var $settingsTopbar = $playerContainer.find('.jw-settings-menu .jw-settings-topbar');

						addAutoplayToggle($settingsTopbar);
					}
				});
			}
		}
});
