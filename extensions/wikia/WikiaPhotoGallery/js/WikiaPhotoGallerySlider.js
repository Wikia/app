if ( scriptAlreadyLoaded != 'SliderGallery' ){
	var scriptAlreadyLoaded = 'SliderGallery'

	wgAfterContentAndJS.push(function() {

	importStylesheetURI(wgExtensionsPath + '/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.css?' + wgStyleVersion);

	function wikiaPhotoGallerySlider_setup() {

		//timer for automatic wikiaPhotoGallery slideshow
		var wikiaPhotoGallerySlider_timer;

		//random integer, 0-3
		var random = 0; //Math.floor(Math.random() * 4);

		//move spotlights
		$(".wikiaPhotoGallery-slider").each(function() {
			$(this).css("left", parseInt($(this).css("left")) - (620 * random));
		});

		//select nav
		$("#wikiaPhotoGallery-slider-" + random).find(".nav").addClass("selected");

		//show description
		$("#wikiaPhotoGallery-slider-" + random).find(".description").show();
		$("#wikiaPhotoGallery-slider-" + random).find(".description-background").show();

		//bind events
		$("#wikiaPhotoGallery-slider .nav").click(function() {
			if($("#wikiaPhotoGallery-slider .wikiaPhotoGallery-slider").queue().length == 0) {
				clearInterval(wikiaPhotoGallerySlider_timer);
				wikiaPhotoGallerySlider_scroll($(this));
			}
		});
		wikiaPhotoGallerySlider_timer = setInterval(wikiaPhotoGallerySlider_slideshow, 7000);
		$("#wikiaPhotoGallery-slider").css('display', 'block');
	}

	function wikiaPhotoGallerySlider_slideshow() {

		var current = $("#wikiaPhotoGallery-slider .selected").parent().prevAll().length;
		var next = ( ( current == $("#wikiaPhotoGallery-slider .nav").length - 1 ) || ( current > 3 ) ) ? 0 : current + 1;
		wikiaPhotoGallerySlider_scroll($("#wikiaPhotoGallery-slider-" + next).find(".nav"));
	}

	function wikiaPhotoGallerySlider_scroll(nav) {
		//setup variables

		var thumb_index = nav.parent().prevAll().length;
		var scroll_by = parseInt(nav.parent().find(".wikiaPhotoGallery-slider").css("left"));
		//set "selected" class
		$("#wikiaPhotoGallery-slider .nav").removeClass("selected");
		nav.addClass("selected");
		//hide description
		$("#wikiaPhotoGallery-slider .description").clearQueue().hide();
		//scroll
		$("#wikiaPhotoGallery-slider .wikiaPhotoGallery-slider").animate({
			left: "-=" + scroll_by
		}, function() {
			$("#wikiaPhotoGallery-slider-" + thumb_index).find(".description").fadeIn();

		});
	}

	wikiaPhotoGallerySlider_setup();

	});
}