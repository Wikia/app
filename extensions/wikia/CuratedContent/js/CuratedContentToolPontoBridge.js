define(
	'curatedContentTool.pontoBridge',
	['wikia.window','ponto'],
	function (w, ponto) {
		/**
		 * @desc Ponto scope object required for communication between iframe and window
		 * @constructor
		 */
		function PontoBridge() {
			this.exit = function (params) {
				// TODO we can use params.saved boolean to display some notification

				require(['curatedContentTool.modal'], function (modal) {
					modal.close();
				});
			};

			this.setFocus = function () {
				document.getElementById("CuratedContentToolIframe").contentWindow.focus();
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
