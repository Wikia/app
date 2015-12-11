require(['GlobalShortcutsHelp'], function (gs) {
	'use strict';
	function init() {
		var $throbber = $('.global-shortcuts-help-entry-point-throbber');
		if ($throbber.length > 0) {
			$('.global-shortcuts-help-entry-point').show().click(gs.open);
			$throbber.remove();
		}
	}
	$(init);
});
