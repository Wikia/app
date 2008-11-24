<?php

/**
 * @addto SpecialPages
 *
 * @author Adrian Wieczorek
 */
class BlogListingCreatePage extends SpecialPage {

	private $mFormData;

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
			//$this->parseFormData();
			//if(count($this->mFormErrors) > 0 || !empty($this->mRenderedPreview)) {
			//	$this->renderForm();
			//}
			//else {
				//$this->savePost();
			//}
		}
		else {
			$this->renderForm();
		}

	}

	private function renderForm() {
		global $wgOut, $wgScriptPath;

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
			'blogPostCategories' => $this->mFormData['blogPostCategories'] )
		);

		$sBlogCategoryCloud = $oTmpl->execute("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			'categoryCloudTitle' => wfMsg('create-blog-listing-page-categories-title'),
			'cloud' => new TagCloud(),
			'cols' => 10,
			'pageCategories' => $this->mFormData['pageCategories'] )
		);

		$sPageCategoryCloud = $oTmpl->execute("createPostCategoryCloud");

		$oTmpl->set_vars( array(
			"title" => $this->mTitle,
			"formErrors" => $this->mFormErrors,
			"formData" => $this->mFormData,
			"preview" => $this->mRenderedPreview,
			"blogCategoryCloud" => $sBlogCategoryCloud,
			"pageCategoryCloud" => $sPageCategoryCloud )
		);

		$wgOut->addHTML( $oTmpl->execute("createBlogListingForm") );

		return;
	}


}
