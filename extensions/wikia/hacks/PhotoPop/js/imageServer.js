var imageServer = {
	processImages: function(obj) {
		for(var prop in obj) {
			if(obj[prop].indexOf('.png') != -1) {
				obj[prop] = "extensions/wikia/hacks/PhotoPop/" + obj[prop];
			}
		}
	}
}