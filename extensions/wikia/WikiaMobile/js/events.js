/**
 * Consistent events on touch and touchless devices
 *
 * @author Jakub "Student" Olek
 */

define('events', function(){
	var w = window;

	return {
		click: ('ontap' in w) ? 'tap' : 'click',
		size: ('onorientationchange' in w) ? 'orientationchange' : 'resize',
		touch: ('ontouchstart' in w) ? 'touchstart' : 'mousedown',
		move: ('ontouchmove' in w) ? 'touchmove' : 'mousemove',
		end: ('ontouchend' in w) ? 'touchend' : 'mouseup',
		cancel: ('ontouchcancel' in w) ? 'touchcancel' : 'mouseup'
	}
});