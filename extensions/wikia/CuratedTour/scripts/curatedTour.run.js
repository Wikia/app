/**
 * This file is executed on the Special:CuratedTour page.
 */
require(
	[
		'wikia.cookies',
		'jquery',
		'ext.wikia.curatedTour.editBox'
	],
	function (cookies, $, editBox) {
		'use strict';
		console.log('curatedTourEditMode loaded');

	//if (cookies.get('curatedTourEditMode') !== null) {
		editBox.init();
	//}
});
