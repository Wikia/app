/**
 * @define layout
 * @requires section, media, lazyload
 *
 * Layout handling of WikiaMobile
 * ie. Sections, Images, Galleries etc.
 */

(function(w){
	var onload = function() {
		require(['lazyload', 'sections'], function(lazyLoad, sections){
			var processedSections = {};

			lazyLoad(document.getElementsByClassName('noSect'));

			sections.addEventListener('open', function () {
				var self = this,
					id = self.getAttribute('data-index');

				if (id && !processedSections[id]) {
					lazyLoad(self.getElementsByClassName('lazy'));

					processedSections[id] = true;
				}
			}, true);
		});
	};

	w.addEventListener ? w.addEventListener('load', onload) : w.attachEvent('onload', onload);
})(window);

define('layout', ['sections', 'media'], function(sections, media) {
	var images = document.getElementsByClassName('media');

	sections.init();

	if(images.length === 0){
		media.oldInit();
	}else{
		media.init(images);
	}
});