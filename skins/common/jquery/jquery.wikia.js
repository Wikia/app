jQuery.fn.log = function (msg) {
	if (typeof console != 'undefined') {
		console.log(msg);
	}
	return this;
};
