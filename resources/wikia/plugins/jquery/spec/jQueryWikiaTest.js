/*
 // Include jQuery and jQuery.wikia
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset resources/jquery/jquery-1.7.2.js
 @test-require-asset resources/wikia/jquery.wikia.js
 */

describe("jquery wikia", function(){
	$.fn.makeModal = function() {return $('body')};

	it("show modal test with raw HTML", function() {
		$.showModal('test Titlte', '<a onclick="testFunction(\'<references />\')">test link</a>', {rawHTML: true});
		expect($('body').html().trim()).toBe('<div><h1>test Titlte</h1><a onclick="testFunction(\'&lt;references /&gt;\')">test link</a></div>');
		$('body').empty();
	});

	it("show modal test", function() {
		$.showModal('2nd test Titlte', '<a onclick="testFunction(\'<references />\')">test link</a>', {});
		expect($('body').html().trim()).toBe('<div><h1>2nd test Titlte</h1><a onclick="testFunction(\'&lt;references &gt;&lt;/a&gt;\')">test link</a></div>');
		$('body').empty();
	});
});

