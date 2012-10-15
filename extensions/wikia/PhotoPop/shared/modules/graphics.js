var exports = exports || {};

define.call(exports, ['modules/settings'], function(settings){

	var images = {},
	isApp = typeof Titanium != 'undefined',
	prefix = (isApp) ? '' : 'extensions/wikia/PhotoPop/',
	graphics = settings.images,
	preload, imagePath, ext;

	for(var prop in graphics){
		preload = new Image();
		imagePath = graphics[prop];
		ext = (imagePath.indexOf('.jpeg') >= 0 || imagePath.indexOf('.png') >= 0 || imagePath.indexOf('.gif') >= 0) ? '' : '.png';
		preload.src = images[prop] = prefix + "shared/images/" + graphics[prop] + ext;
	}

	return {
		getAsset: function(id) {
			return  images[id];
		},

		getPicture: function(path){
			if(Wikia.Platform.is('app')){
				//mirrors mapUrlToFile in /modules/photoPop.js (mobile app repo)
				var fileName = path.substr(path.lastIndexOf('\/') + 1),
				length = fileName.length;

				//iOS doesn't support filenames longer than 256 characters'
				if(length > 256){
					fileName = fileName.substr(length - 256);
				}

				fileName = window.dataPath + '/' + fileName.replace(/[:\/\%-]/g, '_');
				Titanium.App.fireEvent("Image:load", {imgSrc: fileName, id: 'getImages'});
				return fileName;
			} else {
				return path;
			}
		}
	};
});