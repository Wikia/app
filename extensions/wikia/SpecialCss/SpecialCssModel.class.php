<?php
class SpecialCssModel extends WikiaModel {
	const CSS_FILE_NAME = 'Wikia.css';
	const CC_CITY_ID = 177;

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
		$ids = $this->getBlogsIds($cssBlogsJson);
		$cssUserJson = $this->getCssRevisionsJsonData($ids, $params);

		if ( $cssBlogsJson ) {
			foreach ( $cssBlogsJson as $blog ) {
				$blogUser = $cssUserJson[$blog['pageid']]['revisions'][0]['user'];
				$blogTitle = GlobalTitle::newFromId($blog['pageid'], self::CC_CITY_ID, 'wikia');
				$userPage = GlobalTitle::newFromText($blogUser, NS_USER, self::CC_CITY_ID);
				$cssBlogs[] = [
					'title' => $this->getCleanTitle($blogTitle->getText()),
					'url' => $blogTitle->getFullURL(),
					'userAvatar' => AvatarService::renderAvatar($blogUser, 25),
					'userUrl' => $userPage->getFullUrl(),
					'userName' => $blogUser,
					'timestamp' => $this->getFormattedTimestamp($cssUserJson[$blog['pageid']]['revisions'][0]['timestamp']),
					'text' => $cssUserJson[$blog['pageid']]['revisions'][0]['*']
				];
			}
		}

		return $cssBlogs;
	}
	
	private function getCleanTitle($titleText) {
		$result = $titleText;
		$slashPosition = mb_strpos($titleText, '/');
		
		if( $slashPosition !== false ) {
			$slashPosition++;
			$result = mb_strcut($titleText, $slashPosition);
		}
		
		return $result;
	}
	
	private function getFormattedTimestamp($timestamp) {
		return wfTimestamp(TS_ISO_8601, $timestamp);
	}

	private function getCssBlogJsonData($params) {
		$defaultParams = $this->getDefaultBlogParams();
		$params = array_merge($defaultParams, $params);
		$blogs = $this->getApiData($params);

		return isset( $blogs['query']['categorymembers'] ) ? $blogs['query']['categorymembers'] : [];
	}

	private function getCssRevisionsJsonData($ids, $params) {
		$defaultParams = $this->getDefaultRevisionParams($ids);
		$params = array_merge($defaultParams, $params);
		$revisions = $this->getApiData($params);

		return isset( $revisions['query']['pages'] ) ? $revisions['query']['pages'] : [];
	}

	private function getApiData($params) {
		global $wgDevelEnvironment;
		$dbName = 'wikia';

		if ( $wgDevelEnvironment ) {
			$dbName = 'community';
		}

		$data = ApiService::foreignCall($dbName, $params);

		return $data;
	}

	private function getBlogsIds($cssBlogsJson) {
		$pageIds = [];

		foreach ( $cssBlogsJson as $blog ) {
			$pageIds[] = $blog['pageid'];
		}

		$ids = implode('|', $pageIds);

		return $ids;
	}

	private function getDefaultBlogParams() {
		return [
			'format' => 'json',
			'action' => 'query',
			'list' => 'categorymembers',
			'cmtitle' => 'Category:Technical_Updates',
			'cmlimit' => '20',
			'cmsort' => 'timestamp',
			'cmdir' => 'desc'
		];
	}

	private function getDefaultRevisionParams($ids) {
		return [
			'format' => 'json',
			'action' => 'query',
			'prop' => 'revisions',
			'rvprop' => 'content|user|timestamp',
			'pageids' => $ids
		];
	}
}
