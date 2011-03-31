wgAfterContentAndJS.push(function() {

// TODO: add this as a dependency
importStylesheetURI(wgExtensionsPath + "/wikia/SliderTag/slidertag.css?" + wgStyleVersion);

function spotlightSlider_setup() {
	//timer for automatic spotlight slideshow
	var spotlightSlider_timer;

	//select nav
	$("#spotlight-slider-0").find(".nav").addClass("selected");

	//show description
	$("#spotlight-slider-0").find(".description").show();

	//bind events
	$("#spotlight-slider .nav").click(function() {
		if($("#spotlight-slider .spotlight-slider").queue().length == 0) {
			clearInterval(spotlightSlider_timer);
			spotlightSlider_scroll($(this));
		}
	});
	spotlightSlider_timer = setInterval(spotlightSlider_slideshow, 7000);
}

function spotlightSlider_slideshow() {
	var current = $("#spotlight-slider .selected").parent().prevAll().length;
	var next = (current == $("#spotlight-slider .nav").length - 1) ? 0 : current + 1;
	spotlightSlider_scroll($("#spotlight-slider-" + next).find(".nav"));
}

function spotlightSlider_scroll(nav) {
	//setup variables
	var thumb_index = nav.parent().prevAll().length;
	var scroll_by = parseInt(nav.parent().find(".spotlight-slider").css("left"));
	//set "selected" class
	$("#spotlight-slider .nav").removeClass("selected");
	nav.addClass("selected");
	//hide description
	$("#spotlight-slider .description").clearQueue().hide();
	//scroll
	$("#spotlight-slider .spotlight-slider").animate({
		left: "-=" + scroll_by
	}, function() {
		$("#spotlight-slider-" + thumb_index).find(".description").fadeIn();
	});
}

spotlightSlider_setup();

});