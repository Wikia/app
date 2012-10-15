/**
 * Consistent events on touch and touchless devices
 *
 * @author Jakub "Student" Olek <jakubolek@wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
/*global window, define*/

define('events', function () {
	'use strict';

	var w = window,
		//undefined, helps minification
		u;

	return {
		click: (w.ontap !== u) ? 'tap' : 'click',
		size: (w.onorientationchange !== u) ? 'orientationchange' : 'resize',
		touch: (w.ontouchstart !== u) ? 'touchstart' : 'mousedown',
		move: (w.ontouchmove !== u) ? 'touchmove' : 'mousemove',
		end: (w.ontouchend !== u) ? 'touchend' : 'mouseup',
		cancel: (w.ontouchcancel !== u) ? 'touchcancel' : 'mouseup'
	};
});