/**
 * Consistent events on touch and touchless devices
 *
 * @author Jakub "Student" Olek <jakubolek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
/*global window, define*/

define( 'events', ['wikia.window'], function ( window, undef ) {
	'use strict';

	return {
		size: (window.onorientationchange !== undef) ? 'orientationchange' : 'resize',
		touch: (window.ontouchstart !== undef) ? 'touchstart' : 'mousedown',
		move: (window.ontouchmove !== undef) ? 'touchmove' : 'mousemove',
		end: (window.ontouchend !== undef) ? 'touchend' : 'mouseup',
		cancel: (window.ontouchcancel !== undef) ? 'touchcancel' : 'mouseup'
	};
});