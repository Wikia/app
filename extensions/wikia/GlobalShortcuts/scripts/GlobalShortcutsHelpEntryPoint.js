require(['GlobalShortcutsHelp'], function (gs) {
	'use strict';
	function init() {
		$('#WikiaBar .tools').on('click', 'a[data-name="global-shortcuts-help-entry-point"]', gs.open);
	}
	$(init);
});
