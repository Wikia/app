<?php

class LatestPhotosHelper {

	const BLACKLIST_MESSAGE = 'Photosblacklist';

	public function getTemplateData($element) {
		$returnVal = [];
		if (isset($element['file'])) {
			$file = $element['file'];
			$fileTitle = $file->getTitle();

			$returnVal = [
				'image_key' => $fileTitle->getDBKey(),
				'date' => wfTimestamp(TS_ISO_8601, $file->timestamp)
			];
		}

		return $returnVal;
	}

	public function getImageData($element) {
		$returnVal = [];
		if ( isset($element['title']) ) {
			$title = $this->getTitleFromText($element['title']);
			$returnVal = [
				'url' => $title->getLocalUrl(),
				'file' => wfFindFile ( $title )
			];
		}
		return $returnVal;
	}

	public function filterImages($element) {
		$file = $element['file'];
		$returnValue = true;

		if (isset($file->title) && !$this->isVideo($file)) {
			// filter by filetype and filesize (RT #42075)
			$minor_type = $file->minor_mime;
			$renderable = $file->canRender();
			$width = $file->width;
			$height = $file->height;
			$name = $file->title->getPrefixedText();
			// Don't try to display WikiCommons Remote files (RT# 75588)
			if (get_class($file) == "ForeignAPIFile") {
				$returnValue = false;
			}
			if ($renderable == false) { #covers all docs, audio, and binaries
				$returnValue = false;
			}
			if ($minor_type == 'x-bmp') { # exception, because imagemagick is dumb
				$returnValue = false;
			}
			if ($width < 100) {
				$returnValue = false;
			}
			if ($height < 100) {
				$returnValue = false;
			}

			if( $returnValue ) { #only do this semi-expensive check if we're still in the running
				// RT #70016: check blacklist
				if ($this->isImageBlacklisted($name)) {
					wfDebug(__METHOD__ . ": {$name} blacklisted\n");
					$returnValue = false;
				}
			}
		} else {
			$returnValue = false;
		}

		return $returnValue;
	}

	private function isImageBlacklisted($filename) {
		$blacklist = $this->getBlacklist();
		return !empty($blacklist[$filename]);
	}

	private function getBlacklist() {
		wfProfileIn(__METHOD__);
		static $blacklist = null;

		if (is_null($blacklist)) {
			$lines = getMessageForContentAsArray(self::BLACKLIST_MESSAGE);
			$blacklist = [];

			if (!empty($lines)) {
				foreach($lines as $line) {
					$image = Title::newFromText(trim($line, "* "), NS_FILE);
					if (!empty($image)) {
						$blacklist[ $image->getPrefixedText() ] = 1;
					}
				}

				wfDebug(__METHOD__ . ": blacklist loaded\n");
			}
			else {
				wfDebug(__METHOD__ . ": blacklist is empty\n");
			}
		}

		wfProfileOut(__METHOD__);
		return $blacklist;
	}

	protected function getTitleFromText($text) {
		return Title::newFromText($text);
	}

	protected function isVideo($file) {
		return WikiaFileHelper::isVideoFile($file);
	}
}
