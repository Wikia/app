// various extra jQuery functionality otherwise stripped from the slim version

$.getScript = function (url) {
	var scriptEl = document.createElement('script');
	scriptEl.src = url;
	document.body.appendChild(scriptEl);
};

$.fn.exists = function () {
	return this.length > 0;
};
