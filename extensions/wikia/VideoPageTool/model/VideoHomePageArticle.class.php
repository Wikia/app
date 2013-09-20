<?php
/**
 * Class VideoHomePageArticle
 *
 * This is a fake article object so we can fool MediaWiki into showing our custom VideoPage content in place of
 * a normal article page call
 */

class VideoHomePageArticle extends Article {

	/**
	 * @desc Render hubs page
	 */
	public function view() {
		wfProfileIn(__METHOD__);

		// Get all the MW stuff out of the way first
		parent::view();


		$vpt_html = F::app()->sendRequest('VideoPageController', 'index');
		$page_html = $out->getHTML();
		$out->clearHTML();

		// Put the original page below the vpt home page
		$html = $vpt_html . $page_html;

		// Uncomment to eliminate the original page from output
		//$html = $vpt_html;

		$out->addHTML( $html );

		wfProfileOut(__METHOD__);
	}
}
