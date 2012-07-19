/*
 * @define ads
 * module used to handle ads on wikiamobile
 * closing it and keeping it on the screen
 *
 * @require events
 *
 * @author Jakub Olek
 */

define('ads', ['events'], function(ev){

	var d = document,
		adSlot,
		adSlotStyle,
		w,
		ftr;

	function moveSlot(plus){
		if(adSlotStyle){
			adSlotStyle.top = Math.min((w.pageYOffset + w.innerHeight - 50 + ~~plus), ftr.offsetTop + 150) + 'px';
		}
	}

	function init(){
		adSlot = d.getElementById('wkAdPlc');

		if(adSlot){
			adSlotStyle = adSlot.style;
			w = window;
			ftr = d.getElementById('wkFtr');

			var close = d.getElementById('wkAdCls'),
				i = 0,
				click = ev.click,
				adExist = function(){
					if(adSlot.childElementCount > 3){
						close.className = 'show';
						adSlot.className += ' show';

						close.addEventListener(click, function() {
							//track('ad/close');
							adSlot.className += ' anim';
							setTimeout(function(){d.body.removeChild(adSlot);},800);
							w.removeEventListener('scroll', moveSlot);
						}, false);

						if(Modernizr.positionfixed){
							adSlot.className += ' fixed';
						}else{
							w.addEventListener('scroll', moveSlot);
						}
						return true;
					}
				};

			if(!adExist()) {

				var int = setInterval(function() {
					if(!adExist() && i < 5) {
						i += 1;
					}else{
						d.body.removeChild(adSlot);
						clearInterval(int);
					}
				}, 1000);
			}
		}
	}

	return {
		init: init,
		moveSlot: moveSlot
	}
});