<?php
class SpecialCssModel extends WikiaModel {
	const CSS_FILE_NAME = 'Wikia.css';
	const CC_SERVER_NAME = 'http://community.lukaszk.wikia-dev.com/';
	const CC_CITY_ID = 117;

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
		return $cssArticle->getContent();
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
	 * @return string
	 */
	public function getSpecialCssUrl($full = false) {
		wfProfileIn(__METHOD__);
		
		$title = $this->getSpecialCssTitle();
		if( !$full ) {
			$url = $title->getLocalURL();
		} else {
			$url = $title->getFullUrl();
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

	public function getCssBlogData($params = []) {
		$cssBlogs = [];

		$cssBlogsJson = $this->getCssBlogJsonData($params);

		if ( $cssBlogsJson ) {
			foreach ( $cssBlogsJson as $blog ) {
				$blogTitle = GlobalTitle::newFromText($blog->title, $blog->ns, self::CC_CITY_ID);
				$cssBlogs[] = [
					'title' => $blogTitle->getText(),
					'blogUrl' => $blogTitle->getFullURL()
				];
			}
		}

		return $cssBlogs;
	}

	private function getCssBlogJsonData($params) {
		$blogs = json_decode( Http::get($this->createApiUrl($params)) );
		return $blogs->query->categorymembers;
	}

	private function createApiUrl($params) {
		$url = self::CC_SERVER_NAME . 'api.php?' . http_build_query( $this->prepareParameters($params));
		return $url;
	}

	private function prepareParameters($params) {
		$apiParams = $this->getDefaultParams();

		if ( !empty($params) ) {
			$apiParams = array_merge($apiParams, $params);
		}

		return $apiParams;
	}

	private function getDefaultParams() {
		return [
			'format' => 'json',
			'action' => 'query',
			'list' => 'categorymembers',
			'cmtitle' => 'Category:Staff_blogs',
			'cmlimit' => '20',
			'cmsort' => 'timestamp',
			'cmdir' => 'desc'
		];
	}
}
