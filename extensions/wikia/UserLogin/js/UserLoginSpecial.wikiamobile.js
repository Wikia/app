require(['jquery', 'wikia.window', 'wikia.loader', 'toast'], function ($, window, loader, toast) {
	'use strict';

	function init() {
		var msgBox = document.getElementById('wkLgnMsg'),
			msg = msgBox && msgBox.innerText;

		if (msg) {
			toast.show(msg);
		}
	}

	$(init);
});
