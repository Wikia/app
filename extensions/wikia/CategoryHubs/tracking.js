var cathub_state = "unanswered";

$(document).ready(function() {
	var cat_prefix = '';
	if( !$( '#tag-tabs' ).exists()  ) {
		cat_prefix = 'cathub';
	} else {
		cat_prefix = 'answertags';
	}

	$("#topContribsAllTime > ul.cathub-contributors-list-wide   a").click(function() { WET.byStr( cat_prefix + "/alltime/top3"); });
	$("#topContribsAllTime > ul.cathub-contributors-list-narrow a").click(function() { WET.byStr( cat_prefix + "/alltime/top11"); });
	$("#topContribsRecent  > ul.cathub-contributors-list-wide   a").click(function() { WET.byStr( cat_prefix + "/last7/top3"); });
	$("#topContribsRecent  > ul.cathub-contributors-list-narrow a").click(function() { WET.byStr( cat_prefix + "/last7/top11"); });

	$("#cathub-tablink-unanswered").click(function() { cathub_state = "unanswered"; WET.byStr( cat_prefix + "/list/tabUnanswered"); });
	$("#cathub-tablink-answered  ").click(function() { cathub_state = "answered";   WET.byStr( cat_prefix + "/list/tabAnswered"); });

	$(".cathub-article-link > a").click(function() { WET.byStr( cat_prefix + "/list/" + cathub_state + "/question"); });
	$(".cathub-asked        > a").click(function() { WET.byStr( cat_prefix + "/list/" + cathub_state + "/user"); });

	$(".cathub-button-answer").click(        function() { WET.byStr( cat_prefix + "/list/" + cathub_state + "/btnAnswer"); });
	$(".cathub-button-save  ").live("click", function() { WET.byStr( cat_prefix + "/list/" + cathub_state + "/btnSave"); });
	$(".cathub-button-cancel").live("click", function() { WET.byStr( cat_prefix + "/list/" + cathub_state + "/btnCancel"); });

	$("#mw-subcategories > a").click(function() { WET.byStr( cat_prefix + "/subcategories"); });
});

if ((typeof $.getUrlVar("useoldcats") != "undefined") && ($.getUrlVar("useoldcats") != 0)) {
	$("#bodyContent").ready(function() {
		$(".pagingLinks").find("a").each(function() {
			$(this).attr("href", function() { return $(this).attr("href") + "&useoldcats=1"; });
		});
	});
}
