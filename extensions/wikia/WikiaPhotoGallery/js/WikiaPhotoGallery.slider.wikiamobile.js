/*global WikiaMobile: true */

$(function(){
	var sliders = document.getElementsByClassName('wkSlider'),
		i = sliders.length,
		width = window.innerWidth,
		height = window.innerHeight,
		width = (height > width) ? width : height,
		slider,
		size = 'big',
		sizePx;

	function onLoad(plc){
		return function(){
			var url = this.src;
			plc.className += ' fade';
			setTimeout(function(){
				plc.style.backgroundImage = 'url(' + url + ')';
				plc.className += 'In';
			}, 100 + ~~(Math.random() * 400));
		}
	}

	while(--i >= 0){
		slider = sliders[i];

		var imgs = slider.getElementsByClassName('img'),
			l = imgs.length,
			j = 0;

		if(l == 5 || width <= 480){
			size = 'small';
		}else if(width <= 680){
			size = 'med';
		}

		slider.className += size + ' on';

		for(; j < l; j++){
			var img = new Image(),
				src = imgs[j].getAttribute('data-src-' + size);

			img.onload = onLoad(imgs[j]);
			img.src = src;
		}
	}
});
