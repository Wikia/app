<?php
class PopularBlogPostsModule extends Module {

	var $body;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		global $wgParser;

		$input = "	<title>Popular Blog Posts</title>
					<type>box</type>
					<order>date</order>";

		$time = date('Ymd', strtotime("-1 week")) . '000000'; // 7 days ago
//		$time = '20091212000000';  // testing
		$params = array (
			    "summary" => true,
				"timestamp" => $time,
				"count" => 50,
				"displaycount" => 4,
				"order" => "comments"
//				"style" => "add additionalClass if necessary"
		);

		$this->body = BlogTemplateClass::parseTag($input, $params, $wgParser);

		wfProfileOut(__METHOD__);
	}

}
