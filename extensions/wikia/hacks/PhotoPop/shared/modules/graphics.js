var exports = exports || {};

define.call(exports, function(){
	
	var images = {},
	isApp = typeof Titanium != 'undefined';
	
	return {
		init: function(configImages) {
			var preload,
			prefix = (isApp) ? '' : 'extensions/wikia/hacks/PhotoPop/',
			imagePath,
			ext;
			
			for(var prop in configImages){
				preload = new Image();
				imagePath = configImages[prop];
				ext = (imagePath.indexOf('.jpeg') >= 0 || imagePath.indexOf('.png') >= 0 || imagePath.indexOf('.gif') >= 0) ? '' : '.png';
				preload.src = images[prop] = prefix + "shared/images/" + configImages[prop] + ext;
			}
		},
		
		getAsset: function(image) {
			return  images[image];
		},
		
		getPicture: function(gameId, image){
			var prefix = (isApp) ? '/' + gameId + '/' + image : image;
		}
	};
});