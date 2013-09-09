<?php
/**
 * Class VideoPagePage
 *
 * This class exists just to be a fake page object for the fake article object we construct in VideoPageArticle.php
 * It does not do anything but is necessary to satisfy MediaWiki
 *
 */

class VideoPagePage extends WikiPage {
	public function exists() {
		return true;
	}

	public function getID() {
		return -1;
	}
}