/* global require */
require([
	'jquery', 'wikia.window', 'wikia.articleNavUserTools',  'wikia.venusToc'
], function ($, win, userTools, tocModule) {
	'use strict';

	var isTouchScreen = win.Wikia.isTouchScreen(),
		$tocButton = $('#articleNavToc');

	/**
	 * @desc handler that initialises TOC
	 * @param {Event} event
	 */
	function initTOChandler(event) {
		event.stopPropagation();
		tocModule.init(event.target.id, isTouchScreen);
	}

	//Initialize user tools
	userTools.init();

	// initialize TOC in left navigation on first hover / click (touch device)
	// only if there are sections from which ToC is built
	if (tocModule.isEnabled()) {
		$tocButton.parent().removeClass('hidden');
		$tocButton.one(isTouchScreen ? 'click' : 'mouseenter', initTOChandler);
	}
});
