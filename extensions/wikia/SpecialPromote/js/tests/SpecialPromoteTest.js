/*
// Set framework to QUnit
@test-framework QUnit
// Include jQuery and jQuery.wikia and specialPromote
@test-require-file resources/jquery/jquery-1.7.2.js
@test-require-file skins/common/jquery/jquery.wikia.js
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
