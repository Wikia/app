define(
	'curatedContentTool.pontoBridge',
	[
		'wikia.window',
		'ponto'
	],
	function (w, ponto) {
		/**
		 * @desc Ponto scope object required for communication between iframe and window
		 * @constructor
		 */
		function PontoBridge() {
			this.exit = function (params, callbackId) {
				console.log('MW ponto received openMainPage event', params, callbackId);
				ponto.respond({
					mwWorks: true
				}, callbackId);
			}
		}

		// PontoBaseHandler extension pattern - check Ponto documentation for details
		ponto.PontoBaseHandler.derive(PontoBridge);
		PontoBridge.getInstance = function () {
			return new PontoBridge();
		};

		/**
		 * @desc sets target for ponto and inits iframe
		 * @param {Element} iframe - target iframe
		 */
		PontoBridge.init = function (iframe) {
			ponto.setTarget(Ponto.TARGET_IFRAME, '*', iframe.contentWindow);
			iframe.src = iframe.getAttribute('data-url');
		};

		return PontoBridge;
	}
);
