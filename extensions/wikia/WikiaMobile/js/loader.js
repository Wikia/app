/**
 * Module that shows loader in a given container
 *
 * @author Jakub "Student" Olek
 */

(function(){
	if(define){
		//AMD
		define('loader', loader);//late binding
	}else{
		window.Loader = loader();//late binding
	}

	function loader(){
		return {
			show: function(elm, options) {
				options = options || {};
				var ldr = elm.getElementsByClassName('wkMblLdr')[0];
				if(ldr) {
					ldr.style.display = 'block';
				} else {
					elm.insertAdjacentHTML('beforeend', '<div class="wkMblLdr' + (options.center?' cntr':'') +'"><span ' +
						(options.size?'style="width:' + options.size + ';height:'+options.size+'"':'') + '></span></div>');
				}
			},

			hide: function(elm) {
				elm = elm.getElementsByClassName('wkMblLdr')[0];
				if(elm){
					elm.style.display = 'none';
				}
			},

			remove: function(elm) {
				var ldr = elm.getElementsByClassName('wkMblLdr')[0];
				if(ldr){
					ldr.parentElement.removeChild(ldr);
				}
			}
		}
	}
})();