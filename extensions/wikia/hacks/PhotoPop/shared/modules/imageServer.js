var exports = exports || {};

define.call(exports, function(){
	
	var images = {},
	titanium = typeof Titanium != 'undefined';
	
	return {
		init: function(configImages) {
			var preload,
			prefix = (titanium) ? '' : "extensions/wikia/hacks/PhotoPop/";
			
			for(var prop in configImages){
				preload = new Image();
				preload.src = images[prop] = prefix + "shared/images/" + configImages[prop] + ".png";
			}
		},
		
		get: function(image) {
			return  images[image];
		}
	};
});