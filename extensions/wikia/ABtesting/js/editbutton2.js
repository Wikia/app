(function() {
	var button = $("#WikiaPageHeader").find(".wikia-button");
	var icon = button.find(".sprite").detach();
	
	button.before(icon).show();
})();