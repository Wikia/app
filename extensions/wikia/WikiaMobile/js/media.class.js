/**
 * This is a class used in media module to hold all necessary data about a media object
 */
define('wikia.media.class', ['wikia.window'], function(window){
	var supportedVideos = window.supportedVideos || [];

	//Media object that holds all data needed to display it in modal/gallery
	function Media(elem, data, length, i, imgNum){
		this.element = elem;
		this.url = data.full;
		this.imgNum = imgNum;

		if(data.name) {this.name = data.name;}
		if(data.thumb) {this.thumb = data.thumb;}
		if(data.med) {this.med = data.med;}
		if(data.capt) {this.caption = data.capt;}
		if(data.type === Media.types.VIDEO) {
			this.type = Media.types.VIDEO;
			//some providers come with a 'subname' like ooyala/wikiawebinar
			this.supported = ~supportedVideos.indexOf((data.provider || '').split('/')[0]);
		}else{
			this.type = Media.types.IMAGE;
		}

		if(length > 1){
			this.length = length;
			this.number = i;
		}
	}

	Media.prototype.toString = function(){
		return '<section data-type=' + this.type + ' data-num=' + this.imgNum + '><img src=' + this.url + '></section>';
	};

	Media.types = {
		VIDEO: 'video',
		IMAGE: 'image'
	};

	return Media
});