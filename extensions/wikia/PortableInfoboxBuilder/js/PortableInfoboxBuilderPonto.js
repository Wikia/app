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
		 * redirects to given page
		 * @returns {Boolean}
		 */
		this.redirectToPage = function (url) {
			w.location = url;
			return true;
		};

		/**
		 * redirects to previous page
		 * @returns {Boolean}
		 */
		this.redirectToPreviousPage = function () {
			w.history.back();
			return true;
		};
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(InfoboxBuilderPonto);
	InfoboxBuilderPonto.getInstance = function () {
		return new InfoboxBuilderPonto();
	};

	return InfoboxBuilderPonto;
});
