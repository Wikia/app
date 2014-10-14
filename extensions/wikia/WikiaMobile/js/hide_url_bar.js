/**
 * Hides url bar
 * to ensure that ad is placed correctly
 * when url bar is being hidden
 *
 * @define hideURLBar
 * @require ads
 *
 * @author Jakub Olek
 *
 * based on:
 * @see http://24ways.org/2011/raising-the-bar-on-mobile
 *
 */
/*global window, define, setTimeout, setInterval, clearInterval*/

require(['jquery', 'wikia.window'], function ($, w) {
	'use strict';

	var doc = w.document;

	// If there's a hash, or addEventListener is undefined, stop here
	if(!location.hash && w.addEventListener){
		//scroll to 1
		w.scrollTo( 0, 1 );

		var scrollTop = 1,
			getScrollTop = function(){
				return w.pageYOffset || doc.compatMode === "CSS1Compat" && doc.documentElement.scrollTop || doc.body.scrollTop || 0;
			},
			//reset to 0 on bodyready, if needed
			bodycheck = setInterval(function(){
				if( doc.body ){
					clearInterval( bodycheck );
					scrollTop = getScrollTop();
					w.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
				}
			}, 15 );

		$(function(){
			if( getScrollTop() < 20 ){
				setTimeout(function(){
					//reset to hide addr bar at onload
					w.scrollTo( 0, scrollTop === 1 ? 0 : 1 );

					//make sure ad is fixed
					$.event.trigger('ads:fix');
				}, 0);
			}
		});
	}
});