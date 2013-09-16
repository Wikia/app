<?php
/**
 * Class VideoHomePagePage
 *
 * This class exists just to be a fake page object for the fake article object we construct in VideoHomePageArticle.php
 * It does not do anything but is necessary to satisfy MediaWiki
 *
 */

class VideoHomePagePage extends WikiPage {
	public function exists() {
		return true;
	}

	public function getId() {
		return -1;
	}
}