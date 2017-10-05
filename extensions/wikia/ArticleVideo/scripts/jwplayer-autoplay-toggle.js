define('wikia.articleVideo.jwPlayerAutoplayToggle', ['wikia.featuredVideo.autoplay'], function (featuredVideoAutoplay) {

	return function (playerInstance) {
		var inAutoplayCountries = featuredVideoAutoplay.inAutoplayCountries,
			// TODO extract it to separate module
			autoplayCookieName = 'featuredVideoAutoplay';

		function addAutoplayToggleButton() {
			playerInstance.addButton(
				"<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" class='wds-icon'>\n" +
				"<path fill-rule=\"evenodd\" d=\"M23.905 21.84a.775.775 0 0 1-.018.777.802.802 0 0 1-.686.383H.8a.804.804 0 0 1-.688-.383.775.775 0 0 1-.017-.777l11.2-20.458c.28-.51 1.13-.51 1.41 0l11.2 20.458zM11 8.997v6.006c0 .544.448.997 1 .997.556 0 1-.446 1-.997V8.997C13 8.453 12.552 8 12 8c-.556 0-1 .446-1 .997zM11 19c0 .556.448 1 1 1 .556 0 1-.448 1-1 0-.556-.448-1-1-1-.556 0-1 .448-1 1z\"/>\n" +
				"</svg>",
				"Toggle Autoplay",
				function () {
					featuredVideoAutoplay.toggleAutoplay();

					console.log('autoplay', featuredVideoAutoplay.isAutoplayEnabled());
				},
				"autoplayToggle"
			);
		}

		if (inAutoplayCountries) {
			addAutoplayToggleButton();

			playerInstance.on('resize', function (event) {
				if (event.width < 600) {
					playerInstance.removeButton('autoplayToggle');
				} else {
					addAutoplayToggleButton();
				}
			})
		}
	}
});
