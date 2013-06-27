<?php
class SpecialCssModel extends WikiaModel {
	/**
	 * @desc The article page name of CSS file of which content we display in the editor
	 */
	const CSS_FILE_NAME = 'Wikia.css';

	/**
	 * @desc Default language for CSS Updates
	 */
	const CSS_DEFAULT_LANG = 'en';

	/**
	 * @desc User avatar size
	 */
	const USER_AVATAR_SIZE = 25;
	
	/**
	 * @desc The category of blogposts we pull data from
	 */
	const UPDATES_CATEGORY = 'CSS_Updates';
	
	/**
	 * @desc The section number we pull content from
	 */
	const UPDATE_SECTION_IN_BLOGPOST = 2;
	
	/**
	 * @desc Regex pattern used to extract h3 tags
	 * 
	 * @see SpecialCssModel::removeHeadline(removeFirstH3 
	 * @see SpecialCssModel::addAnchorToPostUrl(getAnchorFromWikitext
	 */
	const WIKITEXT_H3_PATTERN = '/([^=]|^)={3}([^=]+)={3}([^=]|$)/';
	
	/**
	 * @desc Limit of characters per one post snippet
	 */
	const SNIPPET_CHAR_LIMIT = 150;
	
	/**
	 * @desc Memcache key for CSS Updates
	 */
	const MEMC_KEY = 'css-chrome-updates';

	protected $dbName;
	
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
	public function getCssFileInfo() {
		$out = false;
		$cssArticle = $this->getCssFileArticle( $this->getCssFileArticleId() );
		if ($cssArticle instanceof Article) {
			$out = [
				'content' => $cssArticle->getContent(),
				'lastEditTimestamp' => $cssArticle->getTimestamp()
			];
		}
		return $out;
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
	 * If there is more recent edit it will try to merge text and save.
	 * Returns false when conflict is found and cannot be resolved
	 *
	 * @param string $content
	 * @param string $summary
	 * @param bool $isMinor
	 * @param int $editTime timestamp
	 * @param User $user
	 * @return Status|bool
	 */
	public function saveCssFileContent($content, $summary, $isMinor, $editTime, $user) {
		$cssTitle = $this->getCssFileTitle();
		$flags = 0;
		if ( $cssTitle instanceof Title) {
			$aid = $cssTitle->getArticleID( Title::GAID_FOR_UPDATE );
			$flags |= ( $aid == 0 ) ? EDIT_NEW : EDIT_UPDATE;
			if ( $isMinor ) {
				$flags |= EDIT_MINOR;
			}
			$article = new Article($cssTitle);

			// handle conflict
			if ($editTime && $editTime != $article->getTimestamp()) {
				$result = '';
				$currentText = $article->getText();

				$baseText = Revision::loadFromTimestamp(
					wfGetDB(DB_MASTER),
					$this->getCssFileTitle(),
					$editTime
				)->getText();

				// remove windows endlines from input before merging texts
				$content = str_replace("\r", "", $content);

				if (wfMerge( $baseText, $content, $currentText, $result )) {
					// This conflict can be resolved
					$content = $result;
				} else {
					// We have real conflict here
					return false;
				}
			}
			$status = $article->doEdit($content, $summary, $flags, false, $user);
			return $status;
		}
		return Status::newFatal('special-css-saving-internal-error');
	}

	/**
	 * @desc Returns an array of 20 last CSS updates
	 *
	 * @param array $postsParams parameters for api to fetch blog data
	 * @param array $revisionsParams parameters for api to fetch revisions data including user info
	 * @return array
	 */
	public function getCssUpdatesData($postsParams = [], $revisionsParams = []) {
		$dbName = $this->getCommunityDbName();
		$cssUpdatesPosts = WikiaDataAccess::cache(
			wfSharedMemcKey(
				self::MEMC_KEY,
				$dbName
			),
			60 * 60 * 24,
			function () use ($postsParams, $revisionsParams) {
				$cssUpdatesPosts = [];
				$cssUpdatesPostsData = $this->getCssPostsApiData($postsParams);

				if ( !empty( $cssUpdatesPostsData ) ) {
					$ids = $this->getBlogsIds( $cssUpdatesPostsData );
					$cssRevisionsData = $this->getCssRevisionsApiData( $ids, $revisionsParams );

					foreach ( $cssUpdatesPostsData as $postData ) {
						$cssUpdatesPosts[] = $this->prepareCssUpdateData($cssRevisionsData, $postData);
					}
				}
				
				return $cssUpdatesPosts;
			}
		);

		return $cssUpdatesPosts;
	}

	/**
	 * Get url to community wiki to page with all CSS updates
	 *
	 * @return string
	 */
	public function getCssUpdatesUrl() {
		$title = GlobalTitle::newFromText(
			self::UPDATES_CATEGORY,
			NS_CATEGORY,
			WikiFactory::DBtoId($this->getCommunityDbName())
		);

		return $title->getFullURL();
	}

	/**
	 * @desc Returns an array with correct elements from given api results
	 * 
	 * @param array $cssRevisionsData results from API call with request of revision's info
	 * @param array $postData results from API call with request of posts (articles) list in a category
	 * 
	 * @return array
	 */
	private function prepareCssUpdateData($cssRevisionsData, $postData) {
		$cssUpdatePost = [
			'title' => '',
			'url' => '',
			'userAvatar' => '',
			'userUrl' => '',
			'userName' => '',
			'timestamp' => '',
			'text' => '',
		];
		
		$pageId = $postData['pageid'];
		$blogTitle = GlobalTitle::newFromText( $postData['title'], NS_MAIN, WikiFactory::COMMUNITY_CENTRAL );
		$blogTitleText = $blogTitle->getText();

		$lastRevisionUser = $cssRevisionsData[$pageId]['revisions'][0]['user'];
		$blogUser = $this->getUserFromTitleText( $blogTitleText, $lastRevisionUser);
		$userPage = GlobalTitle::newFromText( $blogUser, NS_USER, WikiFactory::COMMUNITY_CENTRAL );

		if( $blogTitle instanceof GlobalTitle && $userPage instanceof GlobalTitle ) {
			$timestamp = $cssRevisionsData[$pageId]['revisions'][0]['timestamp'];
			$sectionText = $cssRevisionsData[$pageId]['revisions'][0]['*'];

			$cssUpdatePost = [
				'title' => $this->getAfterLastSlashText( $blogTitleText ),
				'url' => trim( $this->getFormattedUrl($blogTitle->getFullURL()) . $this->getAnchorFromWikitext( $sectionText ) ),
				'userAvatar' => AvatarService::renderAvatar( $blogUser, 25 ),
				'userUrl' => $userPage->getFullUrl(),
				'userName' => $blogUser,
				'timestamp' => $this->wg->Lang->date( wfTimestamp( TS_MW, $timestamp ) ),
				'text' => $this->getPostSnippet($blogTitle, $sectionText),
			];
		}
		
		return $cssUpdatePost;
	}

	/**
	 * @desc Removes wikitext H3, truncates $sectionText and parse wikitext
	 * 
	 * @param Title $blogTitle
	 * @param String $sectionText
	 * 
	 * @return String
	 */
	private function getPostSnippet($blogTitle, $sectionText) {
		$output = $this->removeFirstH3( $sectionText );
		$output = $this->wg->Lang->truncate( $output, self::SNIPPET_CHAR_LIMIT, wfMessage( 'ellipsis' )->text() );
		$output = $this->getParsedText($output, $blogTitle);
		
		return $output;
	}

	/**
	 * @desc Gets first H3 tag content and makes an anchor of it if found
	 * 
	 * @param String $sectionText
	 * 
	 * @return string
	 */
	private function getAnchorFromWikitext( $sectionText ) {
		$anchor = '';
		$firstH3Tag = $this->getFirstH3Tag( $sectionText );
		
		if( !empty( $firstH3Tag ) ) {
			$anchor .= '#' . str_replace(' ', '_', $firstH3Tag);
		}
		
		return $anchor;
	}

	/**
	 * @desc Removes wikitext's H3 tags from given text
	 * 
	 * @param String $text
	 * @return mixed
	 */
	private function removeFirstH3($text) {
		$firstH3Tag = $this->getFirstH3Tag( $text );
		
		if( !empty( $firstH3Tag ) ) {
			$wikitextFirstH3Tag = '===' . $firstH3Tag . '===';
			$text = str_replace( $wikitextFirstH3Tag, '', $text );
		}
		
		return $text;
	}

	/**
	 * @desc Uses regural expression to find first wikitext h3 tag (i.e. "=== this is a wikitext h3 tag ===") and returns it if found
	 * 
	 * @param String $wikitext
	 * 
	 * @return string
	 */
	private function getFirstH3Tag($wikitext) {
		$firstH3Tag = '';
		$wikitextH3Tags = [];

		if( preg_match( self::WIKITEXT_H3_PATTERN, $wikitext, $wikitextH3Tags ) && !empty( $wikitextH3Tags[2] ) ) {
			$firstH3Tag = $wikitextH3Tags[2];
		}

		return $firstH3Tag;
	}

	/**
	 * @desc Parse given wiki text and returns the HTML output
	 * 
	 * @param String $text
	 * @param Title $title
	 * 
	 * @return mixed
	 */
	private function getParsedText( $text, $title ) {
		$output = $this->wg->Parser->parse( $text, $title, new ParserOptions() ); /** @var ParserOutput $output */
		return $output->getText();
	}

	/**
	 * @desc Removes from given string first slash and the string before it
	 * 
	 * @param String $titleText
	 *
	 * @return string
	 */
	private function getAfterLastSlashText($titleText) {
		$result = $titleText;
		$slashPosition = mb_strrpos($titleText, '/');
		
		if( $slashPosition !== false ) {
			$slashPosition++;
			$result = mb_strcut( $titleText, $slashPosition );
		}
		
		return trim( $result, '/' );
	}

	/**
	 * @desc Gets username from title's text
	 * 
	 * @param String $titleText Title::getText() result moslty
	 * @param String $fallbackUser 
	 * 
	 * @return string
	 */
	private function getUserFromTitleText($titleText, $fallbackUser) {
		$userName = str_replace( $this->getAfterLastSlashText($titleText), '', $titleText );
		$userName = trim( $userName, '/' );
		$userName = $this->getAfterLastSlashText($userName);
		$userArray = explode(':', $userName);
		
		if( count($userArray) > 1 ) {
			$userName = $userArray[1];
		} 
		
		if( empty($userName) ) {
			$userName = $fallbackUser;
		}
		
		return $userName;
	}

	/**
	 * @desc Only for devboxes - change url to community central
	 */
	private function getFormattedUrl($url) {
		global $wgDevelEnvironment;
		if ( $wgDevelEnvironment ) {
			$url = str_replace('http://wikia.', 'http://community.', $url);
		}
		return $url;
	}

	/**
	 * @desc Returns information about 20 last CSS updates (page id, namespace and post title)
	 *
	 * @param array $params: action, list, cmtitle, cmlimit, cmsort, cmdir which are send to MW API: http://en.wikipedia.org/w/api.php
	 * @return array
	 */
	private function getCssPostsApiData($params) {
		$defaultParams = $this->getDefaultBlogParams();
		$params = array_merge($defaultParams, $params);
		$blogs = $this->getApiData($params);

		return isset( $blogs['query']['categorymembers'] ) ? $blogs['query']['categorymembers'] : [];
	}

	/**
	 * @desc Returns information about 20 last revisions of CSS updates (user name, timestamp, post content)
	 *
	 * @param array $ids array of integers which are page ids
	 * @param array $params: action, prop, rvprop, rvsection, pageids which are send to MW API: http://en.wikipedia.org/w/api.php 
	 * 
	 * @return array
	 */
	private function getCssRevisionsApiData($ids, $params) {
		$defaultParams = $this->getDefaultRevisionParams($ids);
		$params = array_merge($defaultParams, $params);
		$revisions = $this->getApiData($params);

		return isset( $revisions['query']['pages'] ) ? $revisions['query']['pages'] : [];
	}

	/**
	 * @desc Returns data from API based on parameters
	 *
	 * @param array $params more documentation: http://en.wikipedia.org/w/api.php
	 * 
	 * @return mixed
	 */
	private function getApiData($params) {
		$dbName = $this->getCommunityDbName();
		$data = ApiService::foreignCall($dbName, $params);

		return $data;
	}

	/**
	 * Get community wiki db name from which we'll take blog posts for css update
	 *
	 * @return string
	 */
	public function getCommunityDbName() {
		global $wgDevelEnvironment;

		if ( empty($this->dbName) ) {
			$lang = $this->getCssUpdateLang();
			$this->dbName = $this->getDbNameByLang($lang);

			if ( $wgDevelEnvironment  ) {
				$this->dbName = $this->getMockedDbNameByLang($lang);
			}
		}

		return $this->dbName;
	}

	/**
	 * @desc Returns language code for CSS updates.
	 * If user preferred language is not supported, then is set to default (english)
	 *
	 * @return string language code
	 */
	public function getCssUpdateLang() {
		global $wgLang, $wgCssUpdatesLangMap;

		$langCode = $wgLang->getCode();

		if ( !array_key_exists($langCode, $wgCssUpdatesLangMap) ) {
			$langCode = self::CSS_DEFAULT_LANG;
		}

		return $langCode;
	}

	/**
	 * @desc Returns database name for getting CSS updates in selected language
	 *
	 * @param $lang language code
	 * @return string database name
	 */
	private function getDbNameByLang($lang) {
		global $wgCssUpdatesLangMap;

		$dbName = isset($wgCssUpdatesLangMap[$lang]) ? $wgCssUpdatesLangMap[$lang] : $wgCssUpdatesLangMap[self::CSS_DEFAULT_LANG];

		return $dbName;
	}

	/**
	 * @desc Returns mocked database name for getting CSS updates in selected language
	 *
	 * @param $lang language code
	 * @return string database name
	 */
	private function getMockedDbNameByLang($lang) {
		$wgCssUpdatesLangMap = $this->getMockedLangMap();

		return $wgCssUpdatesLangMap[$lang];
	}


	/**
	 * @desc Returns array with page ids based on blog data from api
	 *
	 * @param $cssBlogsJson
	 * @return string
	 */
	private function getBlogsIds($cssBlogsJson) {
		$pageIds = [];

		foreach ( $cssBlogsJson as $blog ) {
			$pageIds[] = $blog['pageid'];
		}

		$ids = implode('|', $pageIds);

		return $ids;
	}

	/**
	 * @desc Returns default parameters for fetching blog data
	 *
	 * @return array
	 */
	private function getDefaultBlogParams() {
		return [
			'action' => 'query',
			'list' => 'categorymembers',
			'cmtitle' => 'Category:' . self::UPDATES_CATEGORY,
			'cmlimit' => '20',
			'cmsort' => 'timestamp',
			'cmdir' => 'desc'
		];
	}

	/**
	 * @desc Returns default parameters for fetching revision data
	 *
	 * @param string $ids page ids separated by '|'
	 * @return array
	 */
	private function getDefaultRevisionParams($ids = '') {
		return [
			'action' => 'query',
			'prop' => 'revisions',
			'rvprop' => 'content|user|timestamp',
			'rvsection' => self::UPDATE_SECTION_IN_BLOGPOST,
			'pageids' => $ids
		];
	}

	/**
	 * @desc Mapping language to database name for devboxes
	 *
	 * @return array
	 */
	private function getMockedLangMap() {
		// There is no database copy for FR, RU and IT on devboxes
		return array (
			'en' => 'community',
			'pl' => 'pl.community',
			'de' => 'de.community',
			'fr' => 'frfr',
			'es' => 'es.community',
			'ru' => 'ruwikia',
			'it' => 'it',
		);
	}
}
