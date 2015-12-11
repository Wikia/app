define('GlobalShortcuts', [], function () {
	'use strict';
	function Init() {
		console.log('im in');
	}
	return new Init();
});

require(['jquery', 'GlobalShortcuts'], function ($, gs) {
	'use strict';
	$(gs);
});
