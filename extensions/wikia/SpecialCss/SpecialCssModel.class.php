<?php
class SpecialCssModel extends WikiaModel {
	const CSS_FILE_NAME = 'Wikia.css';

	/**
	 * @var array List of skins for which we would like to use SpecialCss for editing css file
	 */
	public static $supportedSkins = array( 'oasis' );

	/**
	 * @desc Retruns css file name
	 * 
	 * @return string
	 */
	public function getCssFileName() {
		return self::CSS_FILE_NAME;
	}

	/**
	 * @desc Returns Wikia.css article's content
	 * 
	 * @return Return|string
	 */
	public function getCssFileContent() {
		$cssArticle = $this->getCssFileArticle( $this->getCssFileArticleId() );
		return ($cssArticle instanceof Article) ? $cssArticle->getContent() : '';
	}

	/**
	 * @desc Returns Title instance for Wikia.css article or null
	 * 
	 * @return null|Title
	 */
	public function getCssFileTitle() {
		return Title::newFromText( $this->getCssFileName(), NS_MEDIAWIKI);
	}

	/**
	 * @desc Returns article id of Wikia.css or null
	 * 
	 * @return int|null
	 */
	public function getCssFileArticleId() {
		wfProfileIn(__METHOD__);
		
		$title = $this->getCssFileTitle();
		$articleId = null;
		
		if( $title instanceof Title ) {
			$articleId = $this->getCssFileTitle()->getArticleId();
		}

		wfProfileOut(__METHOD__);
		return $articleId;
	}

	/**
	 * @desc Returns an article instance from given article id
	 * 
	 * @param $articleId
	 * @return Article|null
	 */
	public function getCssFileArticle($articleId) {
		return Article::newFromID($articleId);
	}

	/**
	 * @desc Compares passed article id with Wikia.css article id
	 * 
	 * @param $articleId
	 * @return bool
	 */
	public function isWikiaCssArticle($articleId) {
		return ($articleId == $this->getCssFileArticleId() );
	}

	/**
	 * @desc Returns url for Special:CSS page
	 *
	 * @param bool $full
	 * @param array|null $params optional associative array with query parameters
	 * @return string
	 */
	public function getSpecialCssUrl($full = false, $params = null) {
		wfProfileIn(__METHOD__);
		
		$title = $this->getSpecialCssTitle();
		if( !$full ) {
			$url = $title->getLocalURL( $params );
		} else {
			$url = $title->getFullUrl( $params );
		}

		wfProfileOut(__METHOD__);
		return $url;
	}

	/**
	 * @desc Returns Title instance for Special:CSS page
	 * 
	 * @return Title
	 */
	public function getSpecialCssTitle() {
		return SpecialPage::getTitleFor('CSS');
	}

	/**
	 * @desc Saving CSS content
	 *
	 * @param string $content
	 * @param string $summary
	 * @param bool $isMinor
	 * @param User $user
	 * @return bool if saving was successful
	 */
	public function saveCssFileContent($content, $summary, $isMinor, $user) {
		$cssTitle = $this->getCssFileTitle();
		$flags = 0;
		if ( $cssTitle instanceof Title) {
			$aid = $cssTitle->getArticleID( Title::GAID_FOR_UPDATE );
			$flags |= ( $aid == 0 ) ? EDIT_NEW : EDIT_UPDATE;
			if ( $isMinor ) {
				$flags |= EDIT_MINOR;
			}
			$article = new Article($cssTitle);
			$status = $article->doEdit($content, $summary, $flags, false, $user);
			return $status;
		}
		return Status::newFatal('special-css-saving-internal-error');
	}
}
