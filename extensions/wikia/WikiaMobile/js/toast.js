/**
 * Show toast message
 *
 * @author Jakub "Student" Olek
 */

(function(){
	if(define){
		//AMD
		define('toast', ['wikia.window'], toast);//late binding
	}else{
		window.Toast = toast(window);//late binding
	}

	function toast(w){
		var wkTst,
			d = w.document;

		return{
			show: function(msg, opt){
				if(msg){
					opt = opt || {};

					var t = this,
						oTime = opt.timeout,
						time = (typeof oTime === 'undefined') ? 5000 : (typeof oTime === 'number' ? oTime : false);

					if(d.body.className.indexOf('hasToast') > -1){
						wkTst.innerHTML = msg;
					}else{
						d.body.insertAdjacentHTML('beforeend', '<div id=wkTst class="hide clsIco">' + msg + '</div>' );
						wkTst = d.getElementById('wkTst');
						wkTst.addEventListener('click', function(){
							t.hide();
						});
						d.body.className += ' hasToast';
					}
					wkTst.className = 'show clsIco';

					if(opt.error){
						wkTst.className += ' err';
					}

					if(time){
						setTimeout(function(){
							t.hide();
						}, time);
					}
				}else{
					throw 'Empty message';
				}
			},

			hide: function(){
				wkTst.className = 'hide clsIco';
			}
		};
	}
})();