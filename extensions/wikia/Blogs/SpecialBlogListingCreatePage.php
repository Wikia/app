<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class BlogListingCreatePage extends SpecialBlogPage {

	private $mTagBody = '';

	public function __construct() {
		global $wgExtensionMessagesFiles;

		// initialise messages
		$wgExtensionMessagesFiles['BlogListingCreatePage'] = dirname(__FILE__) . '/Blogs.i18n.php';
		wfLoadExtensionMessages('BlogListingCreatePage');

		parent::__construct( 'BlogListingCreatePage' /*class*/, 'bloglistingcreatepage' /*restriction*/, true);
	}

	public function execute() {
		global $wgOut, $wgUser, $wgRequest;

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'BlogListingCreatePage' );

		$wgOut->setPageTitle( wfMsg('create-blog-listing-title') );

		if($wgRequest->wasPosted()) {
			$this->parseFormData();
			if(count($this->mFormErrors) > 0 || !empty($this->mRenderedPreview)) {
				$this->renderForm();
			}
			else {
				$this->save();
			}
		}
		else {
			$this->renderForm();
		}

	}

	protected function parseFormData() {
		global $wgUser, $wgRequest, $wgOut, $wgParser;

		$this->mFormData['listingTitle'] = $wgRequest->getVal('blogListingTitle');
		$this->mFormData['listingCategories'] = $wgRequest->getVal('wpCategoryTextarea1');
		$this->mFormData['listingAuthors'] = $wgRequest->getVal('blogListingAuthors');
		$this->mFormData['listingSortBy'] = $wgRequest->getVal('blogListingSortBy');
		$this->mFormData['listingPageCategories'] = $wgRequest->getVal('wpCategoryTextarea2');
		$this->mFormData['listingType'] = $wgRequest->getVal('listingType');

		if(empty($this->mFormData['listingTitle'])) {
			$this->mFormErrors[] = wfMsg('create-blog-empty-title-error');
		}
		else {
			$oPostTitle = Title::newFromText( $this->mFormData['listingTitle'], NS_MAIN );

			if(!($oPostTitle instanceof Title)) {
				$this->mFormErrors[] = wfMsg('create-blog-invalid-title-error');
			}
			else {
				$this->mPostArticle = new Article($oPostTitle, 0);
				if($this->mPostArticle->exists()) {
					$this->mFormErrors[] = wfMsg('create-blog-article-already-exists');
				}
			}
		}

		if(!count($this->mFormErrors)) {
			$this->buildTag();
		}

		if(!count($this->mFormErrors) && $wgRequest->getVal('wpPreview')) {
			$this->mRenderedPreview = BlogTemplateClass::parseTag($this->mTagBody, array(), $wgParser);
		}

	}

	protected function renderForm() {
		global $wgOut, $wgScriptPath;

		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/extensions/wikia/Blogs/js/categoryCloud.js"><!-- categoryCloud js --></script>');
		$wgOut->addHTML( '<link rel="stylesheet" type="text/css" href="' . $wgScriptPath . '/extensions/wikia/Blogs/css/BlogCreateForm.css" />' );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

	$sQuery = "SELECT replace(replace(cl_to,'_News',''),'_Opinions','') AS cl_to, count(*) AS count
 FROM `categorylinks` cl1
 WHERE cl_from in (select page_id from page where page_namespace = '" . NS_BLOG_ARTICLE . "')
 GROUP BY cl_to
 ORDER BY
 count DESC
 LIMIT 0,10";

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMsg('create-blog-listing-blog-post-categories-title'),
			'cloud' => new TagCloud(10, $sQuery),
			'cols' => 10,
			'cloudNo' => 1,
			'textCategories' => $this->mFormData['listingCategories'] )
		);

		$sBlogCategoryCloud = $oTmpl->execute("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMsg('create-blog-listing-page-categories-title'),
			'cloud' => new TagCloud(),
			'cols' => 10,
			'cloudNo' => 2,
			'textCategories' => $this->mFormData['listingPageCategories'] )
		);

		$sPageCategoryCloud = $oTmpl->execute("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			"title" => $this->mTitle,
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mRenderedPreview,
			"sortByKeys" => BlogTemplateClass::$aBlogParams['order']['pattern'],
			"blogCategoryCloud" => $sBlogCategoryCloud,
			"pageCategoryCloud" => $sPageCategoryCloud )
		);

		$wgOut->addHTML( $oTmpl->execute("createBlogListingForm") );

		return;
	}

	protected function save() {
		global $wgOut;
		if($this->mFormData['listingType'] == 'box') {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"tagBody" => $this->mTagBody)
			);

			$wgOut->addHTML( $oTmpl->execute("createListingConfirm") );
		}
		else {
			$sPageBody = $this->mTagBody;

			if(!empty($this->mFormData['listingPageCategories'])) {
				// add categories
				$aCategories = preg_split ("/\|/", $this->mFormData['listingPageCategories'], -1);
				$sPageBody .= $this->getCategoriesAsText($aCategories);
			}

			$this->mPostArticle->doEdit($sPageBody, "Blog listing page created." );

			$wgOut->redirect($this->mPostArticle->getTitle()->getFullUrl());
		}
	}

	private function buildTag() {
		$this->mTagBody = "<bloglist>\n";
		$this->buildTagContent();
		$this->mTagBody.= "</bloglist>\n";
	}

	private function buildTagContent() {
		$aListingCategories = explode('|', $this->mFormData['listingCategories']);
		$aListingAuthors = explode(',', $this->mFormData['listingAuthors']);

		$this->mTagBody .= "<title>" . $this->mFormData['listingTitle'] . "</title>\n";
		$this->mTagBody .= "<type>" . $this->mFormData['listingType'] . "</type>\n";
		$this->mTagBody .= "<order>" . $this->mFormData['listingSortBy'] . "</order>\n";

		foreach($aListingCategories as $sCategoryName) {
			if(!empty($sCategoryName)) {
				$this->mTagBody .= "<category>" . $sCategoryName . "</category>\n";
			}
		}
		foreach($aListingAuthors as $sAuthorName) {
			if(!empty($sAuthorName)) {
				$this->mTagBody .= "<author>" . $sAuthorName . "</author>\n";
			}
		}
	}

	public function axBlogListingCheckMatches() {
		global $wgRequest, $wgParser;

		$this->mFormData['listingCategories'] = $wgRequest->getVal('categories');
		$this->mFormData['listingAuthors'] = $wgRequest->getVal('authors');
		$this->mFormData['listingType'] = 'count';

		$this->buildTagContent();

		return (string) BlogTemplateClass::parseTag($this->mTagBody, array(), $wgParser);
	}

}
