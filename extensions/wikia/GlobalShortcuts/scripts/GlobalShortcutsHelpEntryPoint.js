require(['GlobalShortcutsHelp'], function (gs) {
	'use strict';
	function init() {
		var $throbber = $('.global-shortcuts-help-entry-point-throbber'),
			entryPoint;
		if ($throbber.length > 0) {
			entryPoint = $('.global-shortcuts-help-entry-point');
			entryPoint.show();
			entryPoint.click(gs.open);
			$throbber.remove();
		}
	}
	$(init);
});
