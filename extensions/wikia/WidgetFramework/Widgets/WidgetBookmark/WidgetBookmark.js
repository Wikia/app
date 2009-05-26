function WidgetBookmarkDo(widgetId, cmd, id) {
	$().log(cmd + ' "' + id + '"', 'WidgetBookmark');

	WidgetFramework.update(widgetId, {cmd: cmd, pid: id});
}
