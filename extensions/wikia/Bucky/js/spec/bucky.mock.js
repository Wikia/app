define('bucky.mock', [], function () {
	'use strict';

	var bucky = function () {
		return this;
	};

	bucky.timer = {
		start: $.noop,
		stop: $.noop
	};

	return bucky;
});
