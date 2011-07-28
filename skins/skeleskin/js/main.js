var SkeleSkin = {
	init: function(){
		//slide up the addressbar on webkit mobile browsers for maximum reading area
		if(window.scrollTo) window.scrollTo(0, 1);
	}
}

$(document).ready(SkeleSkin.init);