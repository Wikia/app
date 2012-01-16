$( function(){
	if($('.position-marker').exists()) {
	    $('.editsection a').click(function(e) {
	    	$().log('go to section','PLB');
	        var target = $(e.target),
	    		marker = target.closest('h1,h2,h3').nextAll('.position-marker:first');
	    	if(marker.exists()) {
		        var id = target.closest('h1,h2,h3').nextAll('.position-marker:first').attr('id');
		        window.location =  target.attr('href') + '#' + id ;
		        return false;
	    	} else {
	    		return true;
	    	}
	    });
	}
});
