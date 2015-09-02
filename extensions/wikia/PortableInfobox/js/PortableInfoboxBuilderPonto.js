'use strict';

define('wikia.infoboxBuilder.ponto', ['wikia.window', 'ponto'], function (window, ponto) {
	function InfoboxBuilderPonto() {
		/**
		 * sends wiki context to infobox builder in mercury
		 * @returns {{isWikiaContext: boolean, isLoggedIn: boolean}}
		 */
		this.isWikiaContext = function () {
			return {
				isWikiaContext: true,
				isLoggedIn: window.wqUserName !== null ? true : false
			}
		};

		/**
		 * redirects to template page
		 * @param {String} title
		 * @returns {Boolean}
		 */
		this.redirectToTemplatePage = function (title) {
			window.location = window.location.origin + '/wiki/Template:' + title;
			return true;
		}
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(InfoboxBuilderPonto);
	InfoboxBuilderPonto.getInstance = function() {
		return new InfoboxBuilderPonto();
	};

	return InfoboxBuilderPonto;
});
