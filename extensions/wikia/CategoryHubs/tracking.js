$(document).ready(function() {
	$("#topContribsAllTime > ul.cathub-contributors-list-wide   a").click(function() { WET.byStr("cathub/alltime/top3"); });
	$("#topContribsAllTime > ul.cathub-contributors-list-narrow a").click(function() { WET.byStr("cathub/alltime/top11"); });
	$("#topContribsRecent  > ul.cathub-contributors-list-wide   a").click(function() { WET.byStr("cathub/last7/top3"); });
	$("#topContribsRecent  > ul.cathub-contributors-list-narrow a").click(function() { WET.byStr("cathub/last7/top11"); });

	$("#cathub-tablink-unanswered").click(function() { WET.byStr("cathub/list/tabUnanswered"); });
	$("#cathub-tablink-answered  ").click(function() { WET.byStr("cathub/list/tabAnswered"); });

	$(".cathub-article-link > a").click(function() { WET.byStr("cathub/list/question"); });
	$(".cathub-asked        > a").click(function() { WET.byStr("cathub/list/user"); });

	$(".cathub-button-answer").click(        function() { WET.byStr("cathub/list/buttonAnswer"); });
	$(".cathub-button-save  ").live("click", function() { WET.byStr("cathub/list/buttonSave"); });
	$(".cathub-button-cancel").live("click", function() { WET.byStr("cathub/list/buttonCancel"); });

	$("#mw-subcategories > a").click(function() { WET.byStr("cathub/subcategories"); });
});
