// TODO remove in ADEN-6836
if (window && document && !window.moatjw) {
	var scriptElement = document.createElement('script');
	scriptElement.async = true;
	scriptElement.src = 'https://z.moatads.com/jwplayerplugin0938452/moatplugin.js';
	document.head.appendChild(scriptElement);
}
