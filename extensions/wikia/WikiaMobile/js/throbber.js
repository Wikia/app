/**
 * Module that shows throbber in a given container
 *
 * @author Jakub "Student" Olek
 */

define('throbber', function throbber(){
	var CLASS = 'wkMblLdr';

	return {
		show: function(elm, options) {
			options = options || {};
			var ldr = elm.getElementsByClassName(CLASS)[0];
			if(ldr) {
				ldr.style.display = 'block';
			} else {
				elm.insertAdjacentHTML('beforeend', '<div class="'+CLASS+'' + (options.center?' cntr':'') +'"><span ' +
					(options.size?'style="width:' + options.size + ';height:'+options.size+'"':'') + '></span></div>');
			}
		},

		hide: function(elm) {
			if(elm = elm.getElementsByClassName(CLASS)[0]){
				elm.style.display = 'none';
			}
		},

		remove: function(elm) {
			if(elm = elm.getElementsByClassName(CLASS)[0]){
				elm.parentElement.removeChild(elm);
			}
		}
	}
});
