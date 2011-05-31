<?php
class PopularBlogPostsModule extends Module {

	var $body;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		global $wgParser, $wgMemc, $wgLang;

		$mcKey = wfMemcKey( "OasisPopularBlogPosts", $wgLang->getCode() );
		$tempBody = $wgMemc->get($mcKey);
		if (substr($tempBody, 0, 9) == '<p><br />') {
			$tempBody = '<p>'.substr($tempBody, 9);
		}
		$this->body = $tempBody;
		if (empty ($this->body)) {
			$input = "	<title>" .wfMsg('oasis-popular-blogs-title') ."</title>
						<type>box</type>
						<order>date</order>";

			$time = date('Ymd', strtotime("-1 week")) . '000000'; // 7 days ago
//			$time = '20091212000000';  // use this value for testing if there are no recent posts
			$params = array (
					"summary" => true,
					"paging" => false,
					"timestamp" => $time,
					"count" => 50,
					"displaycount" => 4,
					"order" => "comments"
	//				"style" => "add additionalClass if necessary"
			);

			$this->body = BlogTemplateClass::parseTag($input, $params, $wgParser);
			$wgMemc->set ($mcKey, $this->body, 60*60);  // cache for 1 hour
		}

		wfProfileOut(__METHOD__);
	}

}
