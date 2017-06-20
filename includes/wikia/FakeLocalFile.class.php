<?php

class FakeLocalFile extends LocalFile {

	function recordUpload2( $oldver, $comment, $pageText, $props = false, $timestamp = false, $user = null ) {
		if (!$props) {
			$props = $this->repo->getFileProps($this->getVirtualUrl());
		}

		$this->setProps($props);
		$this->purgeThumbnails();
		$this->saveToCache();

		return true;
	}

	function upgradeRow() {}
	function doDBInserts() {}

	// BAC-1221: don't send purge requests for images matching "Temp_file_" pattern
	function purgeEverything() {}
}
