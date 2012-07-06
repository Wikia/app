/*
// Set framework to QUnit
@test-framework QUnit
// Include jQuery and jQuery.wikia and specialPromote
@test-require-file resources/jquery/jquery-1.7.2.js
@test-require-file resources/wikia/jquery.wikia.js
@test-require-file extensions/wikia/SpecialPromote/js/SpecialPromote.js
*/

function specialPromoteSetup() {
	// create a SpecialPromote instance and mock methods
	$.showModal = function() {return true;}
	$.nirvana.sendRequest = function() {return true;}
	$.msg = function() {return true;}
	return new SpecialPromote();
}

module("Module A");
test("removeImage test", function() {
	var s = specialPromoteSetup();
	s.current.mainImageName = 'a';
	s.current.additionalImagesNames = ['a', 'b'];
	ok( s.removeImage({uploadType: s.UPLOAD_TYPE_MAIN, imageIndex: 1}) == true, 'main - Should return true' );
	ok( s.removeImage({uploadType: s.UPLOAD_TYPE_MAIN}) == true, 'main, no index - Should return true' );
	ok( s.removeImage({uploadType: s.UPLOAD_TYPE_ADDITIONAL, imageIndex: 1}) == true, 'additional, index - Should return true' );
	ok( s.removeImage({uploadType: s.UPLOAD_TYPE_ADDITIONAL, imageIndex: 0}) == !true, 'additional, index=0 - Should not return true' );
	ok( s.removeImage({uploadType: s.UPLOAD_TYPE_ADDITIONAL}) == !true, 'additional, no index - Should not return true' );
	ok( s.removeImage({imageIndex: 1}) == !true, 'index, but no type - Should not return true' );
	ok( s.removeImage({}) !== true, 'no params - should not return true' );
});

test("modifyImage test", function() {
	var s = specialPromoteSetup();
	var wrapperHtml = $('<div class="input-group main-image required"><label>Main Image</label><a href="#" data-image-type="main" class="wikia-button upload-button" title="Add a photo"><img src="" class="sprite photo">Add a photo</a><br class="clear"><div class="large-photo"><div class="modify-remove"><a class="modify" href="#">Modify</a></div><img id="curMainImageName" src="http://images.marcin.wikia-dev.com/__cb65/wikiaglobal/images/thumb/2/2d/Wikia-Visualization-Main.jpg/550px-0%2C550%2C42%2C309-Wikia-Visualization-Main.jpg" data-filename="Wikia-Visualization-Main.jpg" data-image-type="main"></div><span class="explanatory-copy">This is the main image that will represent your wiki on wikia.com. Choose an image that will show people what the wiki is about. You can always change it to keep it current.</span></div>');
	var wrapperEvent = $.Event('click', {target: wrapperHtml.find('.modify-remove .modify')});
	ok( s.onChangePhotoClick(wrapperEvent) == true, 'type=main - should return true' );
	var wrapperHtmlNoType = $('<div class="input-group main-image required"><label>Main Image</label><a href="#" data-image-type="main" class="wikia-button upload-button" title="Add a photo"><img src="" class="sprite photo">Add a photo</a><br class="clear"><div class="large-photo"><div class="modify-remove"><a class="modify" href="#">Modify</a></div><img id="curMainImageName" src="http://images.marcin.wikia-dev.com/__cb65/wikiaglobal/images/thumb/2/2d/Wikia-Visualization-Main.jpg/550px-0%2C550%2C42%2C309-Wikia-Visualization-Main.jpg" data-filename="Wikia-Visualization-Main.jpg"></div><span class="explanatory-copy">This is the main image that will represent your wiki on wikia.com. Choose an image that will show people what the wiki is about. You can always change it to keep it current.</span></div>');
	var wrapperEventNoType = $.Event('click', {target: wrapperHtmlNoType.find('.modify-remove .modify')});
	ok( s.onChangePhotoClick(wrapperEventNoType) !== true, 'no type - should not return true' );
});
