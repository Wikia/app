function WidgetTopContent_init(id, widget) {
	var selector = $('#widget_' + id + '_select');

	if (!selector.exists()) {
		// this instance was rendered using WidgetTag - leave
		return;
	}

	var sectionId = selector.attr('selectedIndex'),
		sectionName = selector.attr('options')[sectionId].value;

	widget.find('ul').find('a').each( function() {
		$(this).click( function(e) {
			WET.byStr('TopContent/' + (sectionId+1) + '_' + sectionName + '/' + $(this).html());
		});
	});
}

function WidgetTopContentSwitchSection(selector) {
	var widgetId = selector.id.split('_')[1],
		selected = selector.options[ selector.selectedIndex ].value;

	WET.byStr('sidebar/TopContent/' + selector.selectedIndex + '_' + selected);

	$('#widget_' + widgetId + '_content').html('').addClass('widget_loading');

	$.getJSON(wgScript + '?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&at='+selected, function(res) {
		if(res.success) {
			$('#widget_' + res.id +'_content').removeClass('widget_loading').html(res.body);
			if(res.title) {
				$('#widget_' + res.id +'_header').html(res.title);
			}
			 WidgetTopContent_init(res.id, $('#widget_' + res.id));
		}
	});
}
