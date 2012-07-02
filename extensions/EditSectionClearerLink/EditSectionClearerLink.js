/* JavaScript for EditSectionClearerLink extension */

function editSectionHighlightOn (section) {
	document.getElementById("articleSection-" + section).className = 'highlightedSection';
}

function editSectionHighlightOff (section) {
	document.getElementById("articleSection-" + section).className = 'editableSection';
}

function editSectionActivateLink (section) {
	document.getElementById("editSection-" + section).className = 'editsection editSectionActive';
	document.getElementById("editSectionAnchor-" + section).className = 'editSectionLinkActive';
	document.getElementById("editSectionChrome-" + section).className = 'editSectionChromeActive';
}

function editSectionInactivateLink (section) {
	document.getElementById("editSection-" + section).className = 'editsection editSectionInactive';
	document.getElementById("editSectionAnchor-" + section).className = 'editSectionLinkInactive';
	document.getElementById("editSectionChrome-" + section).className = 'editSectionChromeInactive';
}
