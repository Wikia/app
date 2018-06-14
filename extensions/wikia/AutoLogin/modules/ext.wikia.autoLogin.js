require(['mw'], function (mw) {

	function initAutoLoginFrame() {
		var autoLoginFrame = document.createElement('iframe');
		autoLoginFrame.src = mw.config.get('wgAutoLoginPassiveExternalEndpoint');

		document.body.appendChild(autoLoginFrame);
	}

	if (document.readyState === 'ready') {
		initAutoLoginFrame();
	} else {
		document.addEventListener('DOMContentLoaded', initAutoLoginFrame);
	}
});
