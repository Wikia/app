function WidgetLanguages_init(id, widget) {
	widget.find('a').each( function() {
		$(this).click(function() {
			WET.byStr('widget/WidgetLanguages/' + $(this).text());
		});
	});
}
