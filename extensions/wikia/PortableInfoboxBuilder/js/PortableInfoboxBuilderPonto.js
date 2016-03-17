'use strict';

define('wikia.infoboxBuilder.ponto', ['wikia.window', 'ponto'], function (w, ponto) {
	function InfoboxBuilderPonto() {
		/**
		 * sends wiki context to infobox builder in mercury
		 * @returns {{isWikiaContext: boolean, isLoggedIn: boolean}}
		 */
		this.isWikiaContext = function () {
			return {
				isWikiaContext: true,
				isLoggedIn: w.wqUserName !== null
			};
		};

		/**
		 * redirects to template page
		 * @returns {Boolean}
		 */
		this.redirectToTemplatePage = function () {
			w.location = w.templatePageUrl;
			return true;
		};

		/**
		 * redirects to source editor
		 * @returns {Boolean}
		 */
		this.redirectToSourceEditor = function () {
			w.location = w.sourceEditorUrl;
			return true;
		}
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(InfoboxBuilderPonto);
	InfoboxBuilderPonto.getInstance = function () {
		return new InfoboxBuilderPonto();
	};

	return InfoboxBuilderPonto;
});
