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
		adSlot = d.getElementById('wkAdPlc');

	function moveSlot(plus){
		adSlotStyle.top = Math.min((w.pageYOffset + w.innerHeight - 50 + ~~plus), ftr.offsetTop + 150) + 'px';
	}

	if(adSlot){
		var w = window,
			close = d.getElementById('wkAdCls'),
			adSlotStyle = adSlot.style,
			//+150 to have space for the ad
			ftr = d.getElementById('wkFtr'),
			i = 0,
			click = ev.click,
			adExist = function(){
				if(adSlot.childElementCount > 3){
					close.className = 'show';
					adSlotStyle.height = '50px';
					close.addEventListener(click, function() {
						//track('ad/close');
						adSlot.className += ' anim';
						setTimeout(function(){d.body.removeChild(adSlot);},800);
						w.removeEventListener('scroll', moveSlot);
					}, false);

					if(Modernizr.positionfixed){
						adSlotStyle.position = 'fixed';
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

	return {
		moveSlot: moveSlot
	}
});