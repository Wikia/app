var MobileDialog = {
	
	id: null,
	
	extension: null,
	
	init: function(params) {
		$('body').delegate('.wikia-slideshow', 'click', function() {
			console.log("open MobileDialog for: " + params.id + " " + params.extension);
			
			$.get("index.php", function(data) {
				console.log(data);
			});
		});
	}
}