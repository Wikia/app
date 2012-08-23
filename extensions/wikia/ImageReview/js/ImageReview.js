$(function() {
	// cycle through radio fields on each image click
	var images = $('#ImageReviewForm div.img-container');
	images.bind('click', function(ev) {
		var img = $(this),
			cell = img.closest('li'),
			fields = cell.find('input'),
			selectedField = fields.filter(':checked'),
			selectedIndex = Math.max(0, fields.index(selectedField));

		// select the next radio
		var stateId = (selectedIndex + 1) % fields.length;

		fields.eq(stateId).click();
		cell.attr('class', 'state-' + fields.eq(stateId).val());
	});

	// do the same for checkboxes
	var checkboxes = $('#ImageReviewForm input');
	checkboxes.bind('click', function(ev) {
		var checkbox = $(this),
			cell = checkbox.closest('li');

		var stateId = checkbox.val();

		cell.attr('class', 'state-' + stateId);
	});
	
	images = $('.img-container img');
	var imagesMap = {};
	for(var i = 0; i < images.length; i++ ) {
		imagesMap[$(images[i]).attr('id')] = false;
	}

	$('.img-container img').onImagesLoad({ 
        each: function(e){
			imagesMap[$(e).attr('id')] = true;
		}
	});
	if(wgImageReviewAction != 'questionable') {
		$('#ImageReviewForm').submit(function(){
			for(var i in imagesMap ) {
				if(!imagesMap[i]) {					
					$('#' + i).closest('li').find('input').attr("disabled", true);
				}
			}
		});	
	}	
});