<?php
class LatestPhotosModule extends Module {

	var $thumbUrls;
	var $wgBlankImgUrl;
	var $enableScroll;
	var $enableEmptyGallery;
	var $total;

	var $wgSingleH1;

	public function executeIndex() {
		global $wgUser, $wgTitle, $wgOut, $wgStylePath, $wgMemc, $wgSingleH1;

		// Moved to oasis.scss (to be less requests)
		//$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/LatestPhotos.scss"));

		// Moved to StaticChute.
		//$wgOut->addScript('<script src="'. $wgStylePath .'/oasis/js/LatestPhotos.js"></script>');

		// get the count of images on this wiki
		$this->total = SiteStats::images();

		// Pull the list of images from memcache first
		$this->thumbUrls = $wgMemc->get(LatestPhotosModule::memcacheKey());
		if (empty($this->thumbUrls)) {

			// api service

			$params = array(
				'action' => 'query',
				'list' => 'logevents',
				'letype' => 'upload',
				'leprop' => 'title',
				'lelimit' => 50,
			);

			$apiData = ApiService::call($params);

			if (empty($apiData)) {
				wfProfileOut(__METHOD__);
				return false;
			}
			$imageList = $apiData['query']['logevents'];

			$fileList = array_map(array($this, "getImageData"), $imageList);
			$fileList = array_filter($fileList, array($this, "filterImages"));

			// make sure the list of images is unique and limited to 11 images (12 including the see all image)
			$shaList = array();
			$uniqueList = array();
			foreach ($fileList as $data) {
				$sha = $data['file']->sha1;
				if (! array_key_exists($sha, $shaList)) {
					$shaList[$sha] = true;
					$uniqueList[] = $data;
				}
				if (count($uniqueList) > 10) break;
			}

			$this->thumbUrls = array_map(array($this, 'getTemplateData'), $uniqueList);
			$wgMemc->set(LatestPhotosModule::memcacheKey(), $this->thumbUrls);
		}

		if (count($this->thumbUrls) < 3) {
			$this->enableScroll = false;
		}
		else {
			$this->enableScroll = true;
		}

		if (count($this->thumbUrls)  <= 0) {
			$this->enableEmptyGallery = true;
		}
	}

	private function getTemplateData($element) {

		if (! isset($element['file'])) return array();

		$file = $element['file'];

		// crop the images correctly using extension:imageservice
		$is = new imageServing(array(), 82);
		$thumb_url = wfReplaceImageServer($file->getThumbUrl( $is->getCut($file->width, $file->height)."-".$file->name));
		$userName = $file->user_text;

		$retval = array (
			"file_url" => $element['url'],
			"image_url" => $file->getUrl(),
			"thumb_url" => $thumb_url,
			"image_filename" => $file->getTitle()->getFullText(),
			"user_href" => View::link(Title::newFromText($userName, NS_USER), $userName),
			"links" => $this->getLinkedFiles($file->name),
			"date" => wfTimeFormatAgo($file->timestamp));
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

	private function getLinkedFiles ( $name ) {
		global $wgUser;

		// The ORDER BY ensures we get NS_MAIN pages first
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
					array( 'imagelinks', 'page' ),
					array( 'page_namespace', 'page_title' ),
					array( 'il_to' => $name, 'il_from = page_id' ),
					__METHOD__,
					array( 'LIMIT' => 2, 'ORDER BY' => 'page_namespace ASC' )
			   );

		$sk = $wgUser->getSkin();
		$links = array();

		// link where this page is used...
		if ( $s = $res->fetchObject() ) {
			$page_title = Title::makeTitle( $s->page_namespace, $s->page_title );
			$links[] = $sk->link( $page_title, null, array( 'class' => 'wikia-gallery-item-posted' ) );
		}
		// if used in more than one place, add "more" link
		if ( $s = $res->fetchObject() ) {
			$file_title = Title::makeTitle( NS_FILE, $name );

			$links[] = '<a href="' . $file_title->getLocalUrl() .
				'#filelinks" class="wikia-gallery-item-more">' .
				wfMsg( 'oasis-latest-photos-more-dotdotdot' ) . '</a>';
		}

		return $links;
	}

	private static function memcacheKey() {
		global $wgDevelEnvironment;
		$mKey = wfMemcKey('mOasisLatestPhotos');
		if(!empty($wgDevelEnvironment)){
			$mKey = wfMemcKey('mOasisLatestPhotos', $_SERVER['SERVER_NAME']);
		}
		return $mKey;
	}

    public static function onImageUpload(&$image) {
		global $wgMemc;
		$wgMemc->delete(LatestPhotosModule::memcacheKey());
		return true;
    }

    public static function onImageDelete(&$file, $oldimage, $article, $user, $reason) {
		global $wgMemc;
		$wgMemc->delete(LatestPhotosModule::memcacheKey());
		return true;
    }

}
