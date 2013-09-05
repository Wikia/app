/**
 * This is a class used in media module to hold all necessary data about a media object
 */
define('wikia.media.class', ['wikia.window'], function(window){
	var supportedVideos = window.supportedVideos || [];

	//Media object that holds all data needed to display it in modal/gallery
	function Media(data){
		var image = data.image;
		this.element = data.element;
		this.url = image.full;
		this.imgNum = data.imgNum;

		if(image.name) this.name = image.name;
		if(image.thumb) this.thumb = image.thumb;
		if(image.med) this.med = image.med;
		if(image.capt) this.caption = image.capt;

		if(image.type === Media.types.VIDEO) {
			this.type = Media.types.VIDEO;
			//some providers come with a 'subname' like ooyala/wikiawebinar
			this.supported = supportedVideos.indexOf((image.provider || '').split('/')[0]) != -1;
		}else{
			this.type = Media.types.IMAGE;
		}

		if(data.length > 1){
			this.length = data.length;
			this.number = data.number;
		}
	}

	Media.prototype.toString = function(){
		return '<section data-type="' + this.type + '" data-num="' + this.imgNum + '"><img src="' + this.url + '"></section>';
	};

	Media.types = {
		VIDEO: 'video',
		IMAGE: 'image'
	};

	return Media
});