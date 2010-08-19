wgAfterContentAndJS.push(function() {

$("head").append("<link rel=\"stylesheet\" href=\""+wgScriptPath+"/extensions/wikia/SliderTag/slidertag.css?"+wgStyleVersion+"\" type=\"text/css\" />");

function spotlightSlider_setup() {
	//timer for automatic spotlight slideshow
	var spotlightSlider_timer;

	//random integer, 0-3
	var random = 0; //Math.floor(Math.random() * 4);

	//move spotlights
	$(".spotlight-slider").each(function() {
		$(this).css("left", parseInt($(this).css("left")) - (620 * random));
	});

	//select nav
	$("#spotlight-slider-" + random).find(".nav").addClass("selected");

	//show description
	$("#spotlight-slider-" + random).find(".description").show();

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