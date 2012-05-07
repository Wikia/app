/**
 * Consistent events on touch and touchless devices
 *
 * @author Jakub "Student" Olek
 */

define('events', function events(){
	var w = window;

	return {
		click: ('ontap' in w) ? 'tap' : 'click',
		touch: ('ontouchstart' in w) ? 'touchstart' : 'mousedown',
		size: ('onorientationchange' in w) ? 'orientationchange' : 'resize'
	}
});