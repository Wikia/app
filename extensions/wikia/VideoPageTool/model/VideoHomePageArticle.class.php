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

		// Don't show the category bar
		F::app()->wg->SuppressArticleCategories = true;

		// Get all the MW stuff out of the way first
		parent::view();

		$out = $this->getContext()->getOutput();

		$html = F::app()->renderView( 'VideoHomePageController', 'index' );
		$out->clearHTML();

		$html .= F::app()->renderView( 'VideoHomePage', 'partners' );

		$out->addHTML( $html );

		wfProfileOut(__METHOD__);
	}
}
