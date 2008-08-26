function WidgetLanguagesHandleRedirect(elem) {
	var selected = elem.options[elem.selectedIndex];
	YAHOO.Wikia.Tracker.trackByStr(null, 'widget/WidgetLanguages/' + selected.text);
	window.location.href = selected.value;
}
