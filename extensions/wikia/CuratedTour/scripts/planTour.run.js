/**
 * This file is executed on the Special:CuratedTour page.
 */
require(
	[
		'wikia.cookies',
		'jquery',
		'mw',
	],
	function (cookies, $, mw) {
		'use strict';

		if (mw.config.get('initTourPlan') === true) {
			$('.curated-tour-special-plan-button').on('click', editBox.init);
			$('.curated-tour-special-edit-button').on('click', editBox.init);
		}
		if( cookies.get( 'curatedTourEditEditMode' ) !== null ) {
			editBox.init();
		}
	}
);
