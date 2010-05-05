<?php

/**
 * Activity feed repackaged as MW api and served as feed... (-8
 *
 * @see ApiFeedWatchlist (a lot of c&p from there)
 * @author Przemek Piotrowski <nef@wikia-inc.com>
 */
class ApiFeedActivityFeed extends ApiBase {

	public function __construct($main, $action) {
		parent :: __construct($main, $action);
	}

	public function getCustomPrinter() {
		return new ApiFormatFeedWrapper($this->getMain());
	}

	public function execute() {
		global $wgFeedClasses, $wgSitename, $wgServer;

		try {
			$params = $this->extractRequestParams();

			$fauxReqArr = array(
				"action" => "query",
				"list"   => "activityfeed",
			);

			$fauxReq = new FauxRequest($fauxReqArr);
			$module = new ApiMain($fauxReq);
			$module->execute();
			$data = $module->getResultData();

			$feedItems = array();
			foreach ((array)$data["query"]["activityfeed"] as $info) {
				$feedItems[] = $this->createFeedItem($info);
			}

			$feed = new $wgFeedClasses[$params["feedformat"]] ("{$wgSitename} - activity feed", "", $wgServer);
			ApiFormatFeedWrapper :: setResult($this->getResult(), $feed, $feedItems);

		} catch (Exception $e) {
			$this->getMain()->setCacheMaxAge(0);

			$feedFormat = isset($params["feedformat"]) ? $params["feedformat"] : "rss";
			$feed = new $wgFeedClasses[$feedFormat] ("{$wgSitename} - error - activity feed", "", $wgServer);

			if ($e instanceof UsageException) {
				$errorCode = $e->getCodeString();
			} else {
				$errorCode = "internal_api_error";
			}

			$errorText = $e->getMessage();
			$feedItems[] = new FeedItem("Error ($errorCode)", $errorText, "", "", "");
			ApiFormatFeedWrapper :: setResult($this->getResult(), $feed, $feedItems);
		}
	}

	private function createFeedItem($info) {
		// FIXME check is object etc.
		$titleStr = $info["title"];
		$title = Title :: newFromText($titleStr);
		$titleUrl = $title->getFullUrl();

		$comment = $info["comment"];
		$timestamp = $info["timestamp"];
		$user = $info["user"];

		return new FeedItem($titleStr, $comment, $titleUrl, $timestamp, $user);
	}

	public function getAllowedParams() {
		global $wgFeedClasses;

		return array(
			"feedformat" => array(
				ApiBase :: PARAM_DFLT => "rss",
				ApiBase :: PARAM_TYPE =>  array_keys($wgFeedClasses),
			),
			"foo" => null,
		);
	}

	public function getParamDescription() {
		return array(
			"feedformat" => "The format of the feed",
			"foo"        => "bar",
		);
	}

	public function getDescription() {
		return "This module returns activity feed as a feed";
	}

	public function getExamples() {
		return array(
			"api.php?action=feedactivityfeed",
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
