define('bucky.mock', [], function () {
	'use strict';

	var bucky = $.noop;

	bucky.timer = {
		start: $.noop,
		stop: $.noop
	};

	return bucky;
});
