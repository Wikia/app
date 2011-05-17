
if ( scriptAlreadyLoaded != 'SliderGallery' ){
	var scriptAlreadyLoaded = 'SliderGallery'

	importStylesheetURI(wgExtensionsPath + '/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.css?' + wgStyleVersion);

	function wikiaPhotoGallerySlider_setup() {

		//timer for automatic wikiaPhotoGallery slideshow
		var wikiaPhotoGallerySlider_timer;

		//random integer, 0-3
		var random = 0; //Math.floor(Math.random() * 4);

		//move spotlights
		$(".wikiaPhotoGallery-slider-body").each(function() {
			$(this).css("left", parseInt($(this).css("left")) - (620 * random));
		});
		
		//for(var i in allSliders){
		$.each(allSliders, function(i, val){

			//select nav
			$("#wikiaPhotoGallery-slider-" + val + "-" + random).find(".nav").addClass("selected");

			//show description
			$("#wikiaPhotoGallery-slider-" + val + "-" + random).find(".description").css('display','block');
			$("#wikiaPhotoGallery-slider-" + val + "-" + random).find(".description-background").css('display','block');

			//bind events
			$("#wikiaPhotoGallery-slider-body-" + val + " .nav").click(function() {
				if( $("#wikiaPhotoGallery-slider-body-" + val + " .wikiaPhotoGallery-slider").queue().length == 0 ){
					clearInterval( wikiaPhotoGallerySlider_timer );
					wikiaPhotoGallerySlider_scroll( $(this) );
				}
			});

			$("#wikiaPhotoGallery-slider-body-" + allSliders[i]).css('display', 'block');
		});
		wikiaPhotoGallerySlider_timer = setInterval(wikiaPhotoGallerySlider_slideshow, 7000);

	}

	function wikiaPhotoGallerySlider_slideshow() {
		for(var i in allSliders){
			var current = $("#wikiaPhotoGallery-slider-body-" + allSliders[i] + " .selected").parent().prevAll().length;
			var next = ( ( current == $("#wikiaPhotoGallery-slider-body-" + allSliders[i] + " .nav").length - 1 ) || ( current > 3 ) ) ? 0 : current + 1;
			wikiaPhotoGallerySlider_scroll($("#wikiaPhotoGallery-slider-" + allSliders[i] + "-" + next).find(".nav"), allSliders[i]);
		}

	}

	function wikiaPhotoGallerySlider_scroll( nav ) {
		
		//setup variables
		var thumb_index = nav.parent().prevAll().length;
		var scroll_by = parseInt(nav.parent().find(".wikiaPhotoGallery-slider").css("left"));
		var slider_body = nav.closest(".wikiaPhotoGallery-slider-body");
		var parent_id = slider_body.attr('id');

		if ( $("#" + parent_id + " .wikiaPhotoGallery-slider").queue().length == 0){
	
			//set "selected" class
			$("#" + parent_id + " .nav").removeClass("selected");
			nav.addClass("selected");

			//hide description
			$("#" + parent_id + " .description").clearQueue().hide();

			//scroll
			$("#" + parent_id + " .wikiaPhotoGallery-slider").animate({
				left: "-=" + scroll_by
			}, function() {
				slider_body.find( ".wikiaPhotoGallery-slider-" + thumb_index ).find( ".description" ).fadeIn();
			});
		}
	}

	wikiaPhotoGallerySlider_setup();
}