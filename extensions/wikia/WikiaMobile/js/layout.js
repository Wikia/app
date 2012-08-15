/**
 * @define layout
 * @requires section, media, lazyload
 *
 * Layout handling of WikiaMobile
 * ie. Sections, Images, Galleries etc.
 */
define('layout', ['sections', 'media'], function(sections, media) {
	var images = document.getElementsByClassName('media');

	sections.init();

	if(images.length === 0){
		media.oldInit();
	}else{
		media.init(images);
	}
});