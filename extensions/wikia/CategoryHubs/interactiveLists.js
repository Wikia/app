
$(document).ready(function(){
	$("#tabs").tabs(); // active jQuery UI tab widget for answered/unanswered

	// Answer button.
	$(".cathub-button-answer").click(function(){
		$(this).parents("li").find(".cathub-actual-answer").show();
		$(this).hide();
	});
});
