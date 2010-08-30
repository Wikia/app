$("#editingTips dd").css("display", "none");
//var showDone = true;
$(function() {
	
	$("#toggleEditingTips").click( function() {
		var editor_elements = $("#toolbar, #editform textarea, #editingTipsToggleDiv");
	
		if ($("#editingTips").is(":visible")) {
			$("#editingTips").hide();
			$("#toggleEditingTips").text(editingtips_show);
			
			
			$("#editform textarea").removeClass("editingtips-textarea");		
			$.each(editor_elements, function () {
				$(this).removeClass("editingtips-shown");
				$(this).addClass("editingtips-hidden");
			});
		}
		else {
			$("#editingTips").show();
			$("#toggleEditingTips").text(editingtips_hide);
			$("#editform textarea").addClass("editingtips-textarea");
			$.each(editor_elements, function () {
				$(this).addClass("editingtips-shown");
				$(this).removeClass("editingtips-hidden");
			});
		}
		return false;
	
	});
	
	$("#editingTips dt").click( function() {
		var parents = $(this).parent().find("dd");
		$.each(parents, function() {
			if ($(this).is(":visible")) {
				
				$(this).slideUp("fast");
			}
		});
	
		if ($(this).next().is(":hidden")) {
			$(this).next().slideDown("fast");
		}
	});
});