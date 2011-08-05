
function mwError(e){
	console.log("MediaWiki API error: ");
	console.log(e); // note: .code and .info are provided.
} // end mwError()

/**
 * Given an array of pages, gets a representative image url of one of the pages (chosen randomly)
 * and then passes it into the successCallback.
 */
function getImageFromPages(pageTitles, successCallback){
	var imageUrl;
	if(pageTitles.length > 0){
		var index = Math.floor(Math.random() * pageTitles.length);
		var pageTitle = pageTitles[index].title;
		console.log("Page: " + pageTitle);

		var imageApiParams = {
			'action': 'imageserving',
			'wisTitle': pageTitle
		};
		Mediawiki.apiCall(imageApiParams, function(data){
			if(data.error){
				mwError(data.error);
			} else if(typeof data.image.imageserving != "undefined"){
				console.log("Image: " + data.image.imageserving);
				imageUrl = data.image.imageserving;
				
				// If we got a match, pass the imageUrl into the success callback.
				if((typeof successCallback == "function") && (typeof imageUrl != "undefined")){
					successCallback( imageUrl );
				} else {
					console.log("Callback was not a function: ");
					console.log(successCallback);
				}
			}

			// Didn't get a match, call the function again.
			if(typeof imageUrl == "undefined"){
				pageTitles.splice(index, 1); // remove the item just looked at
				getImageFromPages(pageTitles, successCallback);
			}
		}, mwError);
		
	}

	return imageUrl;
} // getImageFromPages()

$(document).ready(function(){

	// TODO: Use the MediaWiki API to get an image from the configured category.
	
		// TODO: Indicate on-screen that we're loading a game.
	
		// TODO: Find the category to use.
		
		// Pull a selection of pages in the category (using the API).
		var categoryTitle = 'Category:Characters';
		var apiParams = {
			'action': 'query',
			'list': 'categorymembers',
			'cmlimit': 1000,
			'cmtitle': categoryTitle
		};
		Mediawiki.apiCall(apiParams, function(data){
			if(data.error){
				mwError(data.error);
			} else {
				console.log("Got categories: ");
				console.log(data);
				if(data.query.categorymembers){
					// Randomly get a page from the category (and its associated image) until we find a page which has an image.
					var imageUrl = "";
					getImageFromPages(data.query.categorymembers, function(imageUrl){
						// Set the image as the background for the game.
console.log("FINAL URL: " + imageUrl);
						if(imageUrl != ""){
							$('#gameBoard').css('background-image', 'url('+imageUrl+')');
						} else {
						
							// TODO: Surface the error to the user that something is wrong and we couldn't make a game out of this category.
							// TODO: Surface the error to the user that something is wrong and we couldn't make a game out of this category.

						}
					});
				}
			}
		}, mwError);

		


	// Now that an image is set up, enable the click-handling.
	$('#gameBoard div').click(function(){
		$(this).addClass('transparent'); // uses CSS3 transitions
	});
});
