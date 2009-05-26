function WidgetTopContentSwitchSection(selector) {
	widgetId = selector.id.split('_')[1];
	selected = selector.options[ selector.selectedIndex ].value;

	WET.byStr('sidebar/TopContent/' + selector.selectedIndex + '_' + selected);

	WidgetFramework.update(widgetId, {at: selected}, function(id, widget) {
		WidgetTopContent_init(id, widget);
	});
}

function WidgetTopContent_init(id, widget) {
	selector = $('#widget_' + id + '_select');
	sectionId = selector.attr('selectedIndex');
	sectionName = selector.attr('options')[sectionId].value;

	widget.find('ul').find('a').each( function() {
		$(this).click( function(e) {
			WET.byStr('TopContent/' + (sectionId+1) + '_' + sectionName + '/' + $(this).html());
		});
	});
}
