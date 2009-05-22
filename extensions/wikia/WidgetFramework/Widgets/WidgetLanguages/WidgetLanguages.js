function WidgetLanguagesHandleRedirect(elem) {
	var selected = elem.options[elem.selectedIndex];
	WET.byStr('widget/WidgetLanguages/' + selected.text);
	window.location.href = selected.value;
}
