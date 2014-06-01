<?php

class FakeLocalFile extends LocalFile {

	function recordUpload2( $oldver, $comment, $pageText, $props = false, $timestamp = false ) {
		global $wgUser;

		wfProfileIn(__METHOD__);

		$dbw = $this->repo->getMasterDB();
		if (!$props) {
			$props = $this->repo->getFileProps($this->getVirtualUrl());
		}

		$this->setProps($props);
		$this->purgeThumbnails();
		$this->saveToCache();

		wfProfileOut(__METHOD__);
		return true;
	}

	function upgradeRow() {}
	function doDBInserts() {}
}
