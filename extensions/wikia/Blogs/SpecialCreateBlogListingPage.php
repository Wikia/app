<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class CreateBlogListingPage extends SpecialPage {

	private $mTagBody = '';
	private $mRenderedPreview;

	protected $mFormData = array();
	protected $mFormErrors = array();
	protected $mPreviewTitle = '';
	protected $mPostArticle = null;

	const defaultListingCount = 10;

	public function __construct() {
		// initialise messages
		parent::__construct( 'CreateBlogListingPage' /*class*/, '' /*restriction*/, true);
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		$user = $this->getUser();
		$request = $this->getRequest();
		$output = $this->getOutput();

		wfRunHooks( 'beforeBlogListingForm', array( &$this, $request->getVal('article') ) );

		if( !$user->isLoggedIn() ) {
			$output->showErrorPage( 'create-blog-no-login', 'create-blog-login-required', array(wfGetReturntoParam()));
			return;
		}

		if( $user->isBlocked() ) {
			throw new UserBlockedError( $user->mBlock );
		}

		if( wfReadOnly() ) {
			$output->readOnlyPage();
			return;
		}

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CreateBlogListingPage' );

		$output->setPageTitle( wfMessage( 'create-blog-listing-title' )->text() );

		if( $request->wasPosted() ) {
			$this->parseFormData();
			if (count($this->mFormErrors) > 0 || !empty($this->mRenderedPreview)) {
				$this->renderForm();
			} else {
				$this->save();
			}
		}
		else {
			if( $request->getVal('article') != null ) {
				$this->parseTag(urldecode( $request->getVal('article') ));
			}
			$this->renderForm();
		}
		wfProfileOut( __METHOD__ );

	}

	protected function getCategoriesAsText ($aCategories) {
		global $wgContLang;

		$sText = '';
		$sCategoryNSName = $wgContLang->getFormattedNsText( NS_CATEGORY );

		foreach($aCategories as $sCategory) {
			if(!empty($sCategory)) {
				$sText .= "\n[[" . $sCategoryNSName . ":" . $sCategory . "]]";
			}
		}

		return $sText;
	}


	public function setFormData($sKey, $value) {
		wfProfileIn( __METHOD__ );
		$this->mFormData[$sKey] = $value;
		wfProfileOut( __METHOD__ );
	}

	protected function parseFormData() {
		wfProfileIn( __METHOD__ );
		$request = $this->getRequest();

		$this->mFormData['listingTitle'] = $request->getVal('blogListingTitle');
		$this->mFormData['listingCategories'] = $request->getVal('wpCategoryTextarea1');
		$this->mFormData['listingAuthors'] = $request->getVal('blogListingAuthors');
		$this->mFormData['listingSortBy'] = $request->getVal('blogListingSortBy');
		$this->mFormData['listingPageCategories'] = $request->getVal('wpCategoryTextarea2');
		$this->mFormData['listingType'] = $request->getVal('listingType');
		$this->mFormData['isExistingArticleEditAllowed'] = $request->getVal('articleEditAllowed');

		if(empty($this->mFormData['listingTitle'])) {
			$this->mFormErrors[] = wfMessage( 'create-blog-empty-title-error' )->text();
		}
		else {
			$oPostTitle = Title::newFromText( $this->mFormData['listingTitle'], NS_BLOG_LISTING );

			if(!($oPostTitle instanceof Title)) {
				$this->mFormErrors[] = wfMessage( 'create-blog-invalid-title-error' )->text();
			}
			elseif ( $oPostTitle->isProtected( 'edit' ) && !$oPostTitle->userCan( 'edit' ) ) {
				if ( $oPostTitle->isSemiProtected() ) {
					$this->mFormErrors[] = wfMessage( 'semiprotectedpagewarning' )->parse();
				} else {
					$this->mFormErrors[] = wfMessage( 'protectedpagewarning' )->parse();
				}
			}
			else {
				$this->mPostArticle = new Article($oPostTitle, 0);
				if($this->mPostArticle->exists() && ($this->mFormData['listingType'] == 'plain') && !$this->mFormData['isExistingArticleEditAllowed']) {
					$this->mFormErrors[] = wfMessage( 'create-blog-article-already-exists' )->text();
				}
			}
		}

		if(!count($this->mFormErrors)) {
			$this->buildTag();
		}

		if(!count($this->mFormErrors) && $request->getVal('wpPreview')) {
			if($this->mFormData['listingType'] == 'plain') {
				$this->mRenderedPreview = BlogTemplateClass::parseTag($this->mTagBody, array(), new Parser);
			}
			else {
				$this->mRenderedPreview = '<pre>' . htmlspecialchars($this->mTagBody) . '</pre>';
			}
		}
		wfProfileOut( __METHOD__ );
	}

	protected function renderForm() {
		wfProfileIn( __METHOD__ );
		global $wgExtensionsPath;
		$output = $this->getOutput();

		$output->addScript( '<script type="text/javascript" src="' . $wgExtensionsPath . '/wikia/Blogs/js/categoryCloud.js"><!-- categoryCloud js --></script>');

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

	$sQuery = "SELECT replace(replace(cl_to,'_News',''),'_Opinions','') AS cl_to, count(*) AS count
 FROM `categorylinks` cl1
 WHERE cl_from in (select page_id from page where page_namespace = '" . NS_BLOG_ARTICLE . "')
 GROUP BY cl_to
 ORDER BY
 count DESC
 LIMIT 0,10";

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMessage( 'create-blog-listing-blog-post-categories-title' )->text(),
			'cloud' => new TagCloud(10, $sQuery),
			'cols' => 10,
			'cloudNo' => 1,
			'textCategories' => (isset($this->mFormData['listingCategories'])) ? $this->mFormData['listingCategories'] : "" )
		);

		$sBlogCategoryCloud = $oTmpl->render("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMessage( 'create-blog-listing-page-categories-title' )->text(),
			'cloud' => new TagCloud(),
			'cols' => 10,
			'cloudNo' => 2,
			'textCategories' => (isset($this->mFormData['listingPageCategories'])) ? $this->mFormData['listingPageCategories'] : "")
		);

		$sPageCategoryCloud = $oTmpl->render("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			"title" => $this->mTitle,
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mRenderedPreview,
			"sortByKeys" => BlogTemplateClass::$aBlogParams['order']['pattern'],
			"blogCategoryCloud" => $sBlogCategoryCloud,
			"pageCategoryCloud" => $sPageCategoryCloud )
		);

		$output->addHTML( $oTmpl->render("createBlogListingForm") );

		wfProfileOut( __METHOD__ );
	}

	protected function save() {
		wfProfileIn( __METHOD__ );
		$output = $this->getOutput();

		if($this->mFormData['listingType'] == 'box') {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"tagBody" => $this->mTagBody)
			);

			$output->addHTML( $oTmpl->render("createListingConfirm") );
		}
		else {
			$sPageBody = $this->mTagBody;

			if(!empty($this->mFormData['listingPageCategories'])) {
				// add categories
				$aCategories = preg_split ("/\|/", $this->mFormData['listingPageCategories'], -1);
				$sPageBody .= $this->getCategoriesAsText($aCategories);
			}

			$this->mPostArticle->doEdit($sPageBody, wfMessage( 'blog-listing-created' )->inContentLanguage()->text() );

			$aListingCategories = explode('|', $this->mFormData['listingCategories']);
			$aListingAuthors = explode(',', $this->mFormData['listingAuthors']);

			wfRunHooks( 'BlogListingSave', array( $this->mFormData['listingTitle'], $aListingCategories, $aListingAuthors ) );

			$output->redirect($this->mPostArticle->getTitle()->getFullUrl());
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 *   Adding the page to the category BlogListingPage ensures that it is purged when new blogs are posted
	 */

	private function buildTag() {
		wfProfileIn( __METHOD__ );
		$this->mTagBody = "<bloglist summary=\"true\" timestamp=\"true\" count=" . self::defaultListingCount . ">\n";
		$this->buildTagContent();
		$this->mTagBody.= "</bloglist>\n";
		$this->mTagBody.= "[[Category:BlogListingPage]]";
		wfProfileOut( __METHOD__ );
	}

	public function parseTag($sTitle) {
		wfProfileIn( __METHOD__ );
		$oTitle = Title::newFromText($sTitle, NS_BLOG_LISTING);
		$oArticle = new Article($oTitle, 0);
		$sArticleBody = $oArticle->getContent();

		$aMatches = null;
		preg_match('/<bloglist[^>]*>(.*)<\/bloglist>/siU', $sArticleBody, $aMatches);

		if(isset($aMatches[1]) && !empty($aMatches)) {
			BlogTemplateClass::parseTag($aMatches[1], array(), new Parser);
			$aOptions = BlogTemplateClass::getOptions();

			//echo "<pre>"; print_r($aOptions); echo "</pre>";

			$sPageCategories = '';
			foreach(array_keys($oTitle->getParentCategories()) as $sCategoryFullName) {
				$aCategoryNameParts = explode(':', $sCategoryFullName);
				if(!empty($aCategoryNameParts[1])) {
					$sPageCategories .= (!empty($sPageCategories) ? "|" : "") . strtr($aCategoryNameParts[1], '_', ' ');
				}
			}

			$sListingCategories = '';
			foreach(BlogTemplateClass::getCategoryNames() as $sCategoryName) {
				$sListingCategories .= (!empty($sListingCategories) ? "|" : "") . strtr($sCategoryName, '_', ' ');
			}

			$this->mFormData['listingTitle'] = $aOptions['title'];
			$this->mFormData['listingCategories'] = $sListingCategories;
			$this->mFormData['listingSortBy'] = array_search($aOptions['order'], BlogTemplateClass::$aBlogParams['order']['pattern']);
			$this->mFormData['listingType'] = $aOptions['type'];
			$this->mFormData['listingPageCategories'] = $sPageCategories;
			$this->mFormData['isExistingArticleEditAllowed'] = 1;
		}
		else {
			$this->mFormErrors[] = wfMessage( 'create-blog-listing-tag-format-not-recognized-on-page')->text() . ": <a href=\"" . $oTitle->getFullUrl() . "\">" . $oTitle->getFullText() . "</a>";
		}
	}

	public function buildTagContent() {
		$aListingCategories = explode('|', $this->mFormData['listingCategories']);
		$aListingAuthors = explode(',', $this->mFormData['listingAuthors']);

		if (isset($this->mFormData['listingTitle'])) {
			$this->mTagBody .= "<title>" . $this->mFormData['listingTitle'] . "</title>\n";
		}
		if (isset($this->mFormData['listingType'])) {
			$this->mTagBody .= "<type>" . $this->mFormData['listingType'] . "</type>\n";
		}
		if (isset($this->mFormData['listingSortBy'])) {
			$this->mTagBody .= "<order>" . $this->mFormData['listingSortBy'] . "</order>\n";
		}

		if (!empty($aListingCategories) && is_array($aListingCategories)) {
			foreach($aListingCategories as $sCategoryName) {
				if(!empty($sCategoryName)) {
					$this->mTagBody .= "<category>" . $sCategoryName . "</category>\n";
				}
			}
		}
		if (!empty($aListingAuthors) && is_array($aListingAuthors)) {
			foreach($aListingAuthors as $sAuthorName) {
				if(!empty($sAuthorName)) {
					$this->mTagBody .= "<author>" . trim($sAuthorName) . "</author>\n";
				}
			}
		}

		return $this->mTagBody;
	}

	public static function axBlogListingCheckMatches() {
		$request = $this->getRequest();

		$oSpecialPage = new CreateBlogListingPage;

		$oSpecialPage->setFormData('listingCategories', $request->getVal('categories'));
		$oSpecialPage->setFormData('listingAuthors', $request->getVal('authors'));
		$oSpecialPage->setFormData('listingType', 'count');

		return (string) BlogTemplateClass::parseTag($oSpecialPage->buildTagContent(), array(), new Parser);
	}

}
