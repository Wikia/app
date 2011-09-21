var imageServer = {

	images: {},

	init: function(configImages) {
		for(var prop in configImages) {
			imageServer.images[prop] = "extensions/wikia/hacks/PhotoPop/images/" + configImages[prop] + ".png";
			  pic1= new Image(); 
  pic1.src=imageServer.images[prop]; 
		}
	},
	
	get: function(image) {
		console.log(image);
		return  imageServer.images[image];
	}
}