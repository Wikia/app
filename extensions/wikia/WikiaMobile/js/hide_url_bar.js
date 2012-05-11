/*
 *	@define hideURLBar
 *	hides url bar
 *
 * 	@require ads
 * 	to ensure that ad is placed correctly when url bar is being hidden
 *
 * 	@author Jakub Olek
 */
define('hideURLBar', ['ads'], function(ads){
	var w = window;
	return function(){
		if(w.pageYOffset < 20) {
			setTimeout(function(){
				w.scrollTo(0, 1);
				if(!Modernizr.positionfixed) ads.moveSlot();
			}, 1);
		}
	}
});