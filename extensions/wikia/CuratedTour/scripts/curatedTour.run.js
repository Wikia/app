/**
 * This file is executed on the Special:CuratedTour page.
 */
require(
	[
		'wikia.cookies',
		'jquery',
		'ext.wikia.curatedTour.editBox',
		'ext.wikia.curatedTour.grabElement'
	],
	function (cookies, $, editBox, grabElement) {
		'use strict';
		console.log('curatedTourEditMode loaded');

	//if (cookies.get('curatedTourEditMode') !== null) {
		editBox.init();
		$(grabElement.init);
	//}
});
