var cathub_state = "unanswered";

$(document).ready(function() {
	$("#topContribsAllTime > ul.cathub-contributors-list-wide   a").click(function() { WET.byStr("cathub/alltime/top3"); });
	$("#topContribsAllTime > ul.cathub-contributors-list-narrow a").click(function() { WET.byStr("cathub/alltime/top11"); });
	$("#topContribsRecent  > ul.cathub-contributors-list-wide   a").click(function() { WET.byStr("cathub/last7/top3"); });
	$("#topContribsRecent  > ul.cathub-contributors-list-narrow a").click(function() { WET.byStr("cathub/last7/top11"); });

	$("#cathub-tablink-unanswered").click(function() { cathub_state = "unanswered"; WET.byStr("cathub/list/tabUnanswered"); });
	$("#cathub-tablink-answered  ").click(function() { cathub_state = "answered";   WET.byStr("cathub/list/tabAnswered"); });

	$(".cathub-article-link > a").click(function() { WET.byStr("cathub/list/" + cathub_state + "/question"); });
	$(".cathub-asked        > a").click(function() { WET.byStr("cathub/list/" + cathub_state + "/user"); });

	$(".cathub-button-answer").click(        function() { WET.byStr("cathub/list/" + cathub_state + "/btnAnswer"); });
	$(".cathub-button-save  ").live("click", function() { WET.byStr("cathub/list/" + cathub_state + "/btnSave"); });
	$(".cathub-button-cancel").live("click", function() { WET.byStr("cathub/list/" + cathub_state + "/btnCancel"); });

	$("#mw-subcategories > a").click(function() { WET.byStr("cathub/subcategories"); });
});
