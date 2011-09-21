var exports = exports || {};

define.call(exports, {
	
	images: {},

	init: function(configImages) {
		var preload = new Image(),
		link = "",
		prefix = (document) ? "extensions/wikia/hacks/PhotoPop/" : null;
		
		for(var prop in configImages) {
			link = this.images[prop] = prefix + "shared/images/" + configImages[prop] + ".png"; 
			preload.src = link; 
		}
	},
	
	get: function(image) {
		return  this.images[image];
	}
});