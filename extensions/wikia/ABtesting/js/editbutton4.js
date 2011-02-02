(function() {
	var action = '?action=history';
	if (document.location.search) {
		action = '&action=history';
	}
	$("#WikiaPageHeader").find("details").before('<a href="' + document.location.href + action + '" class="historyLink">History</a>');

	
})();