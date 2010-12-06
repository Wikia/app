<?php

class ImageLightbox {

	/**
	 * Add global JS variable indicating this extension is enabled (RT #47665)
	 */
	static public function addJSVariable(&$vars) {
		$vars['wgEnableImageLightboxExt'] = true;
		return true;
	}

	/**
	 * Handle AJAX request and return bigger version of requested image
	 */
	static public function ajax() {
		global $wgTitle, $wgBlankImgUrl, $wgRequest;
		wfProfileIn(__METHOD__);

		// limit dimensions of returned image to fit browser's viewport
		$maxWidth = $wgRequest->getInt('maxwidth', 500) - 20;
		$maxHeight = $wgRequest->getInt('maxheight', 300) - 150;

		$image = wfFindFile($wgTitle);

		if (empty($image)) {
			wfProfileOut(__METHOD__);
			return array();
		}

		// get original dimensions of an image
		$width = $image->getWidth();
		$height = $image->getHeight();

		// don't try to make image larger
		if ($width > $maxWidth or $height > $maxHeight) {
			$width = $maxWidth;
			$height = $maxHeight;
		}

		// generate thumbnail
		$thumb = $image->getThumbnail($width, $height);

		$thumbHeight = $thumb->getHeight();
		$thumbWidth = $thumb->getWidth();

		// lightbox should not be smaller then 200x200
		$wrapperHeight = max($thumbHeight, 200);
		$wrapperWidth = max($thumbWidth, 200);

		// render HTML
		wfLoadExtensionMessages('ImageLightbox');

		$tmpl = new EasyTemplate(dirname(__FILE__));
		$tmpl->set_vars(array(
			'href' => $wgTitle->getLocalUrl(),
			'name' => $wgTitle->getText(),
			'thumbHeight' => $thumbHeight,
			'thumbUrl' => $thumb->url,
			'thumbWidth' => $thumbWidth,
			'wgBlankImgUrl' => $wgBlankImgUrl,
			'wrapperHeight' => $wrapperHeight,
			'wrapperWidth' => $wrapperWidth,
		));

		$html = $tmpl->render('ImageLightbox');

		$res = array(
			'html' => $html,
			'title' => $wgTitle->getText(),
			'width' => $wrapperWidth,
		);

		wfProfileOut(__METHOD__);
		return $res;
	}
}
