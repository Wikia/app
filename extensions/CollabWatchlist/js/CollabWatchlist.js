function onCollabWatchlistSelection(tagIdBasename, listId) {
	// We have multiple <select> tags, one which contains all tags,
	// one for each collaborative watchlist and an empty one. Upon selection
	// of a collaborative watchlist we swap the select tags.
	var allTags = document.getElementById(tagIdBasename);
	var elem = document.getElementById(tagIdBasename + '-' + listId);
	if(elem == null) {
		elem = document.getElementById(tagIdBasename + '-empty');
		if(elem == null)
			return;
	}
	var clonedElem = elem.cloneNode(true);
	clonedElem.setAttribute('id', tagIdBasename);
	clonedElem.setAttribute('name', allTags.getAttribute('name'));
	clonedElem.style.display = 'inline';
	allTags.parentNode.replaceChild(clonedElem, allTags);
}