<?php
class LatestPhotosModule extends Module {

	var $thumbUrls;
	var $wgBlankImgUrl;
	var $enableScroll;
	var $enableEmptyGallery;
	var $total;

	public function executeIndex() {
		global $wgUser, $wgTitle, $wgOut, $wgStylePath, $wgLang;

		$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/LatestPhotos.scss"));
		// Moved to StaticChute.
		//$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/LatestPhotos.js"></script>');

		wfProfileIn(__METHOD__);

		// get the count of images on this wiki
		$this->total = $wgLang->formatNum(SiteStats::images());

		// api service

		$params = array(
			'action' => 'query',
			'list' => 'logevents',
			'letype' => 'upload',
			'leprop' => 'title',
			'lelimit' => 100,   // fixme: change this to 10 after testing
		);

		$apiData = ApiService::call($params);

		if (empty($apiData)) {
			wfProfileOut(__METHOD__);
			return false;
		}
		$imageList = $apiData['query']['logevents'];

		$fileList = array_map(array($this, "getImageData"), $imageList);
		$fileList = array_filter($fileList, array($this, "filterImages"));

		$this->thumbUrls = array_map(array($this, 'getTemplateData'), $fileList);
		// fixme: remove this after testing
		$this->thumbUrls = array_reverse($this->thumbUrls);  // just for testing
		
		while (count($this->thumbUrls) > 10) array_pop ($this->thumbUrls);
		
		if (count($this->thumbUrls) < 3) {
			$this->enableScroll = false;
		}
		else {
			$this->enableScroll = true;
		}
		
		if (count($this->thumbUrls)  <= 0) {
			$this->enableEmptyGallery = true;
			
		}

		wfProfileOut(__METHOD__);
	}

	private function getTemplateData($element) {

		$thumb = $element['file']->getThumbnail(75, 75);
		$retval = array ("file_url" => $element['url'], "thumb_url" => $thumb->getUrl());
		return $retval;
	}

 	private function getImageData($element) {
		$retval = array();
		if (isset($element['title'])) {
			$title = Title::newFromText($element['title']);
			$retval = array('url' => $title->getFullUrl(), 'file' => wfFindFile ( $title ));
		}
		return $retval;
	}

	private function filterImages($element) {
		$file = $element['file'];
		if (isset($file->title)) {

			// filter by filetype and filesize (RT #42075)
			$type = $file->minor_mime;
			$width = $file->width;
			$height = $file->height;
			// FIXME: why is 'ogg' showing up as an image type?
			if ($type == 'ogg') return false;
			if ($width < 100) return false;
			if ($height < 100) return false;
		} else {
			return false;
		}
		return true;
	}
}