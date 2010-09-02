<?php
class PopularBlogPostsModule extends Module {

	var $body;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		global $wgParser;

		$input = "	<title>Popular Blog Posts</title>
					<type>box</type>
					<order>date</order>";

		$params = array (
			    "summary" => true,
				"timestamp" => true,
				"count" => 4,
		);

		$this->body = BlogTemplateClass::parseTag($input, $params, $wgParser);

		wfProfileOut(__METHOD__);
	}

}
