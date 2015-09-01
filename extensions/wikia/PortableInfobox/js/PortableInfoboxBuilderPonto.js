'use strict';

define('wikia.infoboxbuilder.ponto', ['wikia.window', 'ponto'], function (window, ponto) {
	function InfoboxBuilderPonto() {
		this.isWikiaContext = function () {
			return {
				isWikiaContext: true,
				isLoggedIn: window.wqUserName !== null ? true : false
			}
		}
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(InfoboxBuilderPonto);
	InfoboxBuilderPonto.getInstance = function() {
		return new InfoboxBuilderPonto();
	};

	return InfoboxBuilderPonto;
});
