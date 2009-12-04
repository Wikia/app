var count = 0;
var stickies = [
	
        // todo fetch from api a data set, yeah
	'Can you add to the page about<br /><a href="#">Axl Rose</a>?',
	'Can you add to the page about<br /><a href="#">Some really freaking long, crazy article name</a>?',
	'Can you upload a photo to the page about<br /><a href="#">Kermit the Frog</a>?',
	'Can you start an article about<br /><a href="#">The Chaosmaker</a>?'
];
$(function() {
	$("#wikisticky_curl, #wikisticky_next").bind("click", flipNote);
	
	stickyContentHeight = $("#wikisticky_content").height() - $("#wikisticky_content strong").height() - $("#wikisticky_next").outerHeight();
	updateSticky();
});
function flipNote(e) {
	e.preventDefault();
	$("#wikisticky_content p").fadeOut("fast", updateSticky);
	$("#wikisticky_content strong").fadeOut("fast");
	$("#wikisticky_next").hide();
	$("#wikisticky_curl").animate({
		width: "900px"
	}, function() {
		$("#wikisticky_content p, #wikisticky_next, #wikisticky_content strong").fadeIn("slow");
		$(this).css({
			bottom: "-80px",
			right: "-80px",
			width: "80px"
		}).animate({
			bottom: "-8px",
			right: "-8px"
		});
	});
}
function updateSticky() {
	//set content
	$("#wikisticky_content p").html(stickies[count]);
	count++;
	if (count == stickies.length) {
		count = 0;	
	}
	//set font size and position
	var paragraph = $("#wikisticky_content p");
	paragraph.css("fontSize", "14pt");
	var verticalDifference = stickyContentHeight - paragraph.height();	
	while (verticalDifference < 0) {
		paragraph.css("fontSize", parseInt( paragraph.css("fontSize") ) - 1);
		verticalDifference = stickyContentHeight - paragraph.height();
	}
	paragraph.css("top", verticalDifference / 2);
}	
