<?php
/**
 * HomePageList - API wrappers for answers' home page lists (recent questions sidebar, main page lists etc.)
 *
 * @author Przemek Piotrowski (Nef) <ppiotr@wikia-inc.com>
 */

$wgHooks["ParserFirstCallInit"][] = "wfHomePageList";

$wgAjaxExportList[] = "HomePageListAjax";
function HomePageListAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal("method", false);

	if (method_exists("HomePageList", $method)) {
		$data = HomePageList::$method(/* is_ajax */ true);

		if (is_array($data)) {
			$json = json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType("application/json; charset=utf-8");
		} else {
			$response = new AjaxResponse($data);
			$response->setContentType("text/html; charset=utf-8");
		}

		return $response;
	}
}

function wfHomePageList() {
	global $wgParser;

	$wgParser->setHook("homepage_new_questions", array("HomePageList", "homepage_new_questions_tag"));
	$wgParser->setHook("homepage_recently_answered_questions", array("HomePageList", "homepage_recently_answered_questions_tag"));

	return true;
}


class HomePageList {
	const CACHE_EXPIRE = 900;
	const RECENT_UNANSWERED_QUESTIONS_LIMIT = 15;

	function recent_unanswered_questions($is_ajax = false) {
		global $wgRequest;

		if ($is_ajax) {
			$cmstart = $wgRequest->getVal("cmstart");
			$cmend   = $wgRequest->getVal("cmend");

			$param = array();
			if (!empty($cmstart)) $param["cmstart"] = $cmstart;
			if (!empty($cmend  )) $param["cmend"  ] = $cmend;

			return self::_recent_unanswered_questions($param, /* ignore cache */ true);
		} else {
			return self::_recent_unanswered_questions();
		}
	}

	function _recent_unanswered_questions($param = array(), $ignore_cache = false) {
		global $wgMemc, $wgAnswersRecentUnansweredQuestionsLimit;
		wfProfileIn(__METHOD__);

		$mkey =  wfMemcKey("HPL", "recent_unanswered_questions");
		$html = $ignore_cache ? "" : $wgMemc->get($mkey);
		if (empty($html)) {

			$req = new FauxRequest(
				array_merge(
				array(
					"action"      => "query",
					"list"        => "categorymembers",
					"cmtitle"     => "Category:" . wfMsgForContent("unanswered_category"),
					"cmnamespace" =>  0,
					"cmprop"      => "title|timestamp",
					"cmsort"      => "timestamp",
					"cmdir"       => "desc",
					"cmlimit"     => $wgAnswersRecentUnansweredQuestionsLimit ? $wgAnswersRecentUnansweredQuestionsLimit : self::RECENT_UNANSWERED_QUESTIONS_LIMIT,
				)
				, $param)
			);

			$api = new ApiMain($req);
			$api->execute();
			$res = $api->GetResultData();

			if ($res["query"]["categorymembers"]) {
				$timestamp1 = "";
				foreach ($res["query"]["categorymembers"] as $recent_q => $ignore_me) {
					$page = $res["query"]["categorymembers"][$recent_q];
					$url  = str_replace(" ", "_", $page["title"]);

					$oQuestion = new DefaultQuestion($url);
					if ( !is_null($oQuestion) && !$oQuestion->badWordsTest() && !$oQuestion->filterWordsTest() ) {
						$text = $page["title"] . "?";
						$timestamp = $page["timestamp"];
						$html .= "<li><a href=\"/wiki/" . urlencode($url) . "\">" . htmlspecialchars(Answer::s2q($text)) . "</a></li>";

						if (empty($timestamp1)) $timestamp1 = $timestamp;
					}
					unset($oQuestion);
				}

				if (!empty($timestamp)) {
					$html .= "<span id=\"timestamp1\" style=\"display: none\">{$timestamp1}</span>";
					$html .= "<span id=\"timestamp\"  style=\"display: none\">{$timestamp }</span>";
				}
			}

			$wgMemc->set($mkey, $html, self::CACHE_EXPIRE);
		}

		wfProfileOut(__METHOD__);
		return $html;
	}

	function related_answered_questions($is_ajax = false) {
		global $wgRequest, $wgTitle;

		if ($is_ajax) {
			$title = $wgRequest->getVal("title");
			if (empty($title)) return "";

			$title = Title::newFromText($title);
			if (!is_object($title) || !($title instanceof Title)) return "";

			return self::_related_answered_questions($title, /* ignore cache */ true);
		} else {
			return self::_related_answered_questions($wgTitle);
		}
	}

	function _related_answered_questions($wgTitle, $ignore_cache = false) {
		return self::_related_questions("related_answered_questions", "yes", $wgTitle, $ignore_cache);
	}

	static  function related_unanswered_questions($is_ajax = false) {
		global $wgRequest, $wgTitle;

		if ($is_ajax) {
			$title = $wgRequest->getVal("title");
			if (empty($title)) return "";

			$title = Title::newFromText($title);
			if (!is_object($title) || !($title instanceof Title)) return "";

			return self::_related_unanswered_questions($title, /* ignore cache */ true);
		} else {
			return self::_related_unanswered_questions($wgTitle);
		}
	}

	function _related_unanswered_questions($wgTitle, $ignore_cache = false) {
		return self::_related_questions("related_unanswered_questions", "no", $wgTitle, $ignore_cache);
	}

	function _related_questions($key, $answered, $wgTitle, $ignore_cache = false) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		$category = array();
		foreach (array_keys($wgTitle->getParentCategories()) as $c) {
				$c = preg_replace("/^.*:/", "", $c);
				$c = str_replace("_", " ", $c);
				// ...but skip un/answered cats
				if ($c != wfMsgForContent("answered_category") && $c != wfMsgForContent("unanswered_category")) { // c is dbkey, wgVars are plain text - utf fail if wgVars contain utf
					$category[] = str_replace(" ", "_", $c);
				}
		}
		sort($category);
		$category = implode("|", $category);

		if (!empty($category)) {
			$mkey =  wfMemcKey("HPL", $key, $category);
			$html = $ignore_cache ? "" : $wgMemc->get($mkey);
			if (empty($html)) {
				$req = new FauxRequest(
					array(
						"action"      => "query",
						"list"        => "categoriesonanswers",
						"coatitle"    => $category,
						"coaanswered" => $answered,
						"coalimit"    =>  5,
					)
				);
				$api = new ApiMain($req);
				$api->execute();
				$res = $api->GetResultData();

				if (isset($res["query"]) && isset($res["query"]["categoriesonanswers"])) {
					foreach ($res["query"]["categoriesonanswers"] as $recent_q => $ignore_me) {
						$page = $res["query"]["categoriesonanswers"][$recent_q];
						if ($wgTitle->getText() == $page["title"]) continue;
						$url  = str_replace(" ", "_", $page["title"]);
						$oQuestion = new DefaultQuestion($url);
						if ( !is_null($oQuestion) && !$oQuestion->badWordsTest() && !$oQuestion->filterWordsTest() ) {
							$text = $page["title"] . "?";
							$html .= "<li><a href=\"/wiki/" . urlencode($url) . "\">" . htmlspecialchars(Answer::s2q($text)) . "</a></li>";
						}
					}
				}

				$wgMemc->set($mkey, $html, self::CACHE_EXPIRE);
			}
		}

		if (empty($html)) {
			$html = wfMsg("no_{$key}");
		}

		wfProfileOut(__METHOD__);
		return $html;
	}

	function homepage_new_questions_tag($input, $argv, $parser) {
		global $wgParserCacheExpireTime;
		$wgParserCacheExpireTime = self::CACHE_EXPIRE;

		return self::homepage_new_questions();
	}

	function homepage_new_questions($is_ajax = false) {
		$title = wfMsgWithFallback( 'unanswered_category' );
		return self::_homepage_questions("homepage_new_questions", $title, /* ignore cache */ $is_ajax);
	}

	function homepage_recently_answered_questions_tag($input, $argv, $parser) {
		global $wgParserCacheExpireTime;
		$wgParserCacheExpireTime = self::CACHE_EXPIRE;

		return self::homepage_recently_answered_questions();
	}

	function homepage_recently_answered_questions($is_ajax = false) {
		$title = wfMsgWithFallback( 'answered_category' );
		return self::_homepage_questions("homepage_recently_answered_questions", $title, /* ignore cache */ $is_ajax);
	}

	function _homepage_questions($key, $title, $ignore_cache = false) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		$mkey =  wfMemcKey("HPL", $key);
		$html = $ignore_cache ? "" : $wgMemc->get($mkey);
		if (empty($html)) {
			$req = new FauxRequest(
				array(
					"action"      => "query",
					"list"        => "categorymembers",
					"cmtitle"     => "Category:" . $title,
					"cmnamespace" =>  0,
					"cmprop"      => "title|timestamp",
					"cmsort"      => "timestamp",
					"cmdir"       => "desc",
					"cmlimit"     =>  5,
				)
			);
			$api = new ApiMain($req);
			$api->execute();
			$res = $api->GetResultData();

			if ($res["query"]["categorymembers"]) {
				foreach ($res["query"]["categorymembers"] as $recent_q => $ignore_me) {
					$page = $res["query"]["categorymembers"][$recent_q];
					$url  = str_replace(" ", "_", $page["title"]);
					$oQuestion = new DefaultQuestion($url);
					if ( !is_null($oQuestion) && !$oQuestion->badWordsTest() && !$oQuestion->filterWordsTest() ) {
						$text = $page["title"] . "?";
						$html .= "<li><a href=\"/wiki/" . htmlspecialchars($url) . "\">" . htmlspecialchars(Answer::s2q($text)) . "</a></li>";
					}
				}
			}

			$wgMemc->set($mkey, $html, self::CACHE_EXPIRE);
		}

		wfProfileOut(__METHOD__);
		return $html;
	}
}
