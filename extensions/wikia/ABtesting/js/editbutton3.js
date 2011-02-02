(function() {
	var WikiaPageHeader = $("#WikiaPageHeader");
	var details = WikiaPageHeader.find("details");
	var editbutton = WikiaPageHeader.find(".wikia-button, .wikia-menu-button");
	var history = details.find(".history");
	
	// move edit button
	editbutton.detach().prependTo(details);
	
	// insert blank image for separator
	$('<img src="' + wgBlankImgUrl + '" class="separator">').insertAfter(editbutton).css("left", editbutton.width() + 10);
	
	// slide history menu over
	history.css("margin-left", editbutton.width() + 17);
	
})();