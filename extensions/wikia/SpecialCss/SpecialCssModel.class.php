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
	 * @desc Regex pattern used to extract "CSS Updates" headline
	 *
	 * @see SpecialCssModel::filterRevisionsData()
	 */
	const UPDATE_HEADLINE_PATTERN = '/<h3>.*%s.*<\/h3>/m';

	/**
	 * @desc Regex pattern used to extract "CSS Updates" section
	 *
	 * @see SpecialCssModel::getCssUpdateSection()
	 */
	const UPDATE_SECTION_PATTERN = '/<h3>.*%s.*<\/h3>[^$]*/m';

	/**
	 * @desc Regex pattern used to extract H1-H3 headlines
	 *
	 * @see SpecialCssModel::getCssUpdateSection()
	 */
	const UPDATE_H3_TO_H1_PATTERN = '/<\/h3>(.*?)(<h[1-3]{1}>|$)/s';

	/**
	 * @desc Regex pattern to replace link to community page (pages which link starts with '/' after parse)
	 *
	 * @see SpecialCssModel::truncateAndParse
	 */
	const COMMUNITY_LINK_PATTERN = '/href="\/(.*?)"/';

	/**
	 * @desc Limit of characters per one post snippet
	 */
	const SNIPPET_CHAR_LIMIT = 150;

	/**
	 * @desc Memcache key for CSS Updates
	 */
	const MEMC_KEY = 'css-chrome-updates-v2.2';

	/**
	 * @desc Memcache key suffix for CSS Updates headline
	 */
	const MEMC_KEY_HEADLINE_SUFFIX = 'css-updates-headline';

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
	 * @return string
	 */
	public function getCssFileInfo() {
		$out = false;
		/** @var $cssArticle Article */
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
	 * @desc Returns Wikia.css article's content
	 *
	 * @return string
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
	 * @desc Compares passed title with Wikia.css title
	 *
	 * @param $title
	 * @return bool
	 */
	public function isWikiaCssTitle($title) {
		return Title::compare($title, $this->getCssFileTitle()) === 0;
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

			$db = wfGetDB( DB_MASTER );
			$currentRevision = Revision::loadFromTitle( $db, $cssTitle );

			// we handle both - edit and creation conflicts below
			if ( !empty( $currentRevision ) && ( $editTime != $currentRevision->getTimestamp() ) ) {
				$result = '';
				$currentText = $currentRevision->getText();

				if ( !$editTime ) {
					// the css did not exist when the editor was started, so the base revision for
					// parallel edits is an empty file
					$baseText = '';
				} else {
					$baseText = Revision::loadFromTimestamp(
						$db,
						$this->getCssFileTitle(),
						$editTime
					)->getText();
				}

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
			$page = new WikiPage( $cssTitle );
			$status = $page->doEdit($content, $summary, $flags, false, $user);
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
				$cssUpdatesPosts = $cssRevisionsData = [];
				$cssUpdatesPostsData = $this->getCssPostsApiData($postsParams);

				if ( !empty( $cssUpdatesPostsData ) ) {
					foreach ( $cssUpdatesPostsData as $cssUpdatePostData ) {
						$cssRevisionsData += $this->getCssRevisionsApiData( $cssUpdatePostData['pageid'], $revisionsParams );
					}
					$filteredRevisionData = $this->filterRevisionsData( $cssRevisionsData );
					$cssUpdatesPosts = array_map( [ $this, 'prepareCssUpdateData' ], $filteredRevisionData );
				}

				return $cssUpdatesPosts;
			}
		);

		return $cssUpdatesPosts;
	}

	/**
	 * @desc Get url to community wiki to page with all CSS updates
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
	 * @desc Get url to community wiki
	 *
	 * @return url
	 */
	public function getCommunityUrl() {
		return WikiFactory::DBtoUrl($this->getCommunityDbName());
	}

	private function filterRevisionsData( $cssRevisionsData ) {
		$filtered = [];

		foreach( $cssRevisionsData as $revisionData ) {
			$content = isset( $revisionData['revisions'][0]['*'] ) ? $revisionData['revisions'][0]['*'] : '';
			if( $this->isCssHeadlineIn( $content ) ) {
				$filtered[] = $revisionData;
			}
		}

		return $filtered;
	}

	/**
	 * @desc Returns an array with correct elements from given api results
	 *
	 * @param array $postData results from API call with request of posts (articles) list in a category
	 *
	 * @return array
	 */
	private function prepareCssUpdateData( $postData ) {
		$cssUpdatePost = [];
		$communityWikiId = WikiFactory::DBtoID( $this->getCommunityDbName() );

		$blogTitle = GlobalTitle::newFromText( $postData['title'], NS_MAIN, $communityWikiId );
		$blogTitleText = $blogTitle->getText();

		$lastRevisionUser = isset( $postData['revisions'][0]['user'] ) ? $postData['revisions'][0]['user'] : null;
		$timestamp = isset( $postData['revisions'][0]['timestamp'] ) ? $postData['revisions'][0]['timestamp'] : null;
		$blogUser = $this->getUserFromTitleText( $blogTitleText, $lastRevisionUser );
		$userPage = GlobalTitle::newFromText( $blogUser, NS_USER, $communityWikiId );

		if( !is_null( $lastRevisionUser ) &&
			!is_null( $timestamp ) &&
			$blogTitle instanceof GlobalTitle &&
			$userPage instanceof GlobalTitle
		) {
			// $postData['revisions'][0]['*'] is being checked in SpecialCssModel::filterRevisionsData()
			// which is called before this method
			$sectionText = $postData['revisions'][0]['*'];

			$cssUpdateText = $this->truncateAndParseLinks( $this->getCssUpdateSection( $sectionText ) );
			$cssUpdatePost = [
				'title' => $this->getAfterLastSlashText( $blogTitleText ),
				'url' => $this->appendHeadlineAnchor( $blogTitle->getFullURL() ),
				'userAvatar' => AvatarService::renderAvatar( $blogUser, 25 ),
				'userUrl' => $userPage->getFullUrl(),
				'userName' => $blogUser,
				'timestamp' => $timestamp,
				'text' => $cssUpdateText,
			];
		}

		return $cssUpdatePost;
	}

	private function isCssHeadlineIn( $wikitext ) {
		$headline = $this->getCssUpdateHeadline();
		$pattern = sprintf( self::UPDATE_HEADLINE_PATTERN, $headline );

		return preg_match( $pattern, $wikitext );
	}

	/**
	 * @desc Gets "CSS Updates" headline and adds it to the url
	 *
	 * @param String $url
	 *
	 * @return string
	 */
	private function appendHeadlineAnchor( $url ) {
		$headline = $this->getCssUpdateHeadline();
		$url .= '#' . Sanitizer::escapeId( $headline, 'noninitial' );

		return $url;
	}

	/**
	 * @desc Retrives part of the blog post's content and returns it
	 *
	 * @param String $blogPostWikitext content of a blog post
	 *
	 * @return String
	 */
	private function getCssUpdateSection( $blogPostWikitext ) {
		wfProfileIn( __METHOD__ );
		$output = '';
		$pattern = sprintf( self::UPDATE_SECTION_PATTERN, $this->getCssUpdateHeadline() );
		preg_match( $pattern, $blogPostWikitext, $matches );

		if (!empty($matches)) {
			preg_match( self::UPDATE_H3_TO_H1_PATTERN, $matches[0], $matches );
			if (isset($matches[1])) {
				$output = $matches[1];
				$output = trim($output);
			}
		}

		wfProfileOut( __METHOD__ );
		return $output;
	}

	/**
	 * @desc Truncates given wiki text, added ellipsis at the end, parses truncated text and returns it
	 *
	 * @param GlobalTitle|Title $title mediawiki article's title
	 * @param String $wikitext wikitext which is going to be truncated
	 *
	 * @return String
	 */
	private function truncateAndParseLinks( $wikitext ) {
		$userLang = $this->wg->Lang;

		$wikitext = $this->convertLocalToInterwikiLinks( $wikitext );

		$wikitext = $userLang->truncateHTML( $wikitext, self::SNIPPET_CHAR_LIMIT, wfMessage( 'ellipsis' )->text() );

		return $wikitext;
	}

	/**
	 * @desc Returns "CSS Updates" headline for selected language
	 *
	 * @return String | null
	 */
	protected function getCssUpdateHeadline() {
		$lang = $this->getCssUpdateLang();

		$headline = WikiaDataAccess::cache( wfSharedMemcKey(
				self::MEMC_KEY,
				self::MEMC_KEY_HEADLINE_SUFFIX,
				$lang
			),
			60 * 60 * 24,
			function() use ( $lang ) {
				$headline = $this->wg->Lang->getMessageFor(
					'special-css-community-update-headline',
					$lang
				);

				return $headline;
			}
		);

		return $headline;
	}

	/**
	 * @desc Change local links in wiki text to interwiki links based
	 *
	 * @param String $wikitext
	 * @param String $communityLang
	 *
	 * @return String
	 */
	private function convertLocalToInterwikiLinks($wikitext) {
		$communityUrl = $this->getCommunityUrl();

		$wikitext = preg_replace( self::COMMUNITY_LINK_PATTERN, 'href="' . $communityUrl . '$1"', $wikitext);

		return $wikitext;
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
		$slashPosition = strrpos($titleText, '/');

		if( $slashPosition !== false ) {
			$result = substr( $titleText, $slashPosition );
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
	private function getCssRevisionsApiData($id, $params) {
		$defaultParams = $this->getDefaultRevisionParams($id);
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
		if ( empty($this->dbName) ) {
			$lang = $this->getCssUpdateLang();
			$this->dbName = $this->getDbNameByLang($lang);
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
		$langCode = $this->wg->Lang->getCode();

		if ( !array_key_exists($langCode, $this->wg->CssUpdatesLangMap) ) {
			$langCode = self::CSS_DEFAULT_LANG;
		}

		return $langCode;
	}

	/**
	 * @desc Returns database name for getting CSS updates in selected language
	 *
	 * @param string $lang language code
	 * @return string database name
	 */
	private function getDbNameByLang($lang) {
		global $wgCssUpdatesLangMap;

		$dbName = isset($wgCssUpdatesLangMap[$lang]) ? $wgCssUpdatesLangMap[$lang] : $wgCssUpdatesLangMap[self::CSS_DEFAULT_LANG];

		return $dbName;
	}

	public function isMinorEditDefault() {
		return $this->wg->User->getBoolOption('minordefault');
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
	 * @param array $ids an array with page ids
	 *
	 * @return array
	 */
	private function getDefaultRevisionParams( $id = '' ) {
		return [
			'action' => 'query',
			'prop' => 'revisions',
			'rvprop' => 'content|user|timestamp',
			'rvparse' => 1,
			'pageids' => $id
		];
	}
}
