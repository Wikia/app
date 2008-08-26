/*
 * Adapted from monobook, with possibility to set display to block or inline.
 */
function toggleVisibilityE(_levelId, _otherId, _linkId, _type) {
	var thisLevel = document.getElementById(_levelId);
	var otherLevel = document.getElementById(_otherId);
	var linkLevel = document.getElementById(_linkId);
	if (thisLevel.style.display == 'none') {
		thisLevel.style.display = _type;
		otherLevel.style.display = 'none';
		linkLevel.style.display = 'inline';
	} else {
		thisLevel.style.display = 'none';
		otherLevel.style.display = 'inline';
		linkLevel.style.display = 'none';
	}
}

/*
 * Simple function to add user information inline.
 */
function showUserInfo( sourceVar, targetId ) {
	var targetElement = document.getElementById(targetId);
	targetElement.innerHTML = eval( sourceVar );
}
