'use strict';

define('wikia.infoboxBuilder.ponto', ['wikia.window', 'ponto'], function (w, ponto) {
	var currentCallbackId = null;

	function InfoboxBuilderPonto() {
		/**
		 * sends wiki context to infobox builder in mercury
		 * @returns {{isWikiaContext: boolean, isLoggedIn: boolean}}
		 */
		this.isWikiaContext = function () {
			return {
				isWikiaContext: true,
				isLoggedIn: w.wqUserName !== null,
				// checks if infobox builder is opened in VE context
				isVEContext: isVEContext(),
				isCKContext: isCKContext()
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

		this.returnToVE = function (infoboxTitle) {
			w.ve.ui.commandRegistry.emit('infoboxBuilderReturnToVE', infoboxTitle);
		};

		this.returnToCK = function (infoboxTitle) {
			window.CKEDITOR.fire('new-infobox-created', infoboxTitle);
		};

		this.exposeForReloading = function (params, callbackId) {
			currentCallbackId = callbackId;
		};

		this.reloadInfoboxBuilder = function () {
			currentCallbackId && ponto.respond({}, currentCallbackId);
		};
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(InfoboxBuilderPonto);
	InfoboxBuilderPonto.getInstance = function () {
		return new InfoboxBuilderPonto();
	};

	/**
	 * checks if infobox builder is opened in VE context
	 * @returns {boolean}
	 */
	function isVEContext() {
		return w.document.querySelector('html.ve-activated') !== null;
	}

	/**
	 * checks if infobox builder is opened in VE context
	 * @returns {boolean}
	 */
	function isCKContext() {
		return !!window.CKEDITOR;
	}

	return InfoboxBuilderPonto;
});
