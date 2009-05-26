function WidgetTipsChange(widgetId, tipId, op) {
	WidgetFramework.update(widgetId, {tipId: tipId, op: op});
}
