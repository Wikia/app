<?php
class WikiaHubsV3Page extends WikiPage {
	public function exists() {
		return true;
	}

	public function getID() {
		// this Page does not exists in DB but it should be indexed by google because it contains content
		return -1;
	}
}
