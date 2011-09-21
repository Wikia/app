var exports = exports || {};

define.call(exports, {
	
	images: {},

	init: function(configImages) {
		var preload = new Image(),
			link = "";
		for(var prop in configImages) {
			link = this.images[prop] = "extensions/wikia/hacks/PhotoPop/shared/images/" + configImages[prop] + ".png"; 
			preload.src = link; 
		}
	},
	
	get: function(image) {
		return  this.images[image];
	}
});