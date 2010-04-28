<?php

class ImageLightbox {

	/**
	 * Handle AJAX request and return bigger version of requested image
	 */
	static public function ajax() {
		global $wgTitle, $wgBlankImgUrl;

		wfProfileIn(__METHOD__);

		// limit dimensions of returned image
		global $wgRequest;
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
		$height = max($thumb->getHeight(), 200);
		$width = max($thumb->getWidth(), 200);

		wfLoadExtensionMessages('ImageLightbox');

		// render HTML
		$tmpl = new EasyTemplate(dirname(__FILE__));
		$tmpl->set_vars(array(
			'height' => $height,
			'href' => $wgTitle->getLocalUrl(),
			'name' => $wgTitle->getText(),
			'thumbUrl' => $thumb->url,
			'wgBlankImgUrl' => $wgBlankImgUrl,
			'width' => $width,
		));

		$html = $tmpl->render('ImageLightbox');

		$res = array(
			'html' => $html,
			'width' => $width,
		);

		wfProfileOut(__METHOD__);

		return $res;
	}
}
