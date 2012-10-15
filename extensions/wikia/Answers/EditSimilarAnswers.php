<?php

$wgHooks["EditSimilar::getSimilarArticles"][] = "wfGetSimilarArticlesOnAnswers";

function wfGetSimilarArticlesOnAnswers(&$data) {
		$html = HomePageList::related_unanswered_questions();
		$html = preg_replace("/^<li>/", "", $html);
		$html = preg_replace("/<\\/li>$/", "", $html);
		$res  = explode("</li><li>", $html);

		$data = $res;
		return false;
}
