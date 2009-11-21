<?php
////
// Author: Sean Colombo
// Date: 20091120
//
// This extension extends both CategoryPage and CategoryViewer in a way which provides more hooks to allow greater flexibility
// for modifying the sections on the category pages in MediaWiki as well as the order of those sections.
//
// To modify the content of the sections, hook into the FlexibleCategoryViewer hooks, to modify the order of those sections
// hook into the FlexibleCategoryPage hooks for openShowCategory and closeShowCategory.
//
// All hooks available in this extension:
//	FlexibleCategoryPageView
//	FlexibleCategoryPage::openShowCategory
//	FlexibleCategoryPage::closeShowCategory
//	FlexibleCategoryViewer::getCategoryTop
//	FlexibleCategoryViewer::getSubcategorySection
//	FlexibleCategoryViewer::getPagesSection
//	FlexibleCategoryViewer::getImageSection
//	FlexibleCategoryViewer::getOtherSection
//	FlexibleCategoryViewer::getCategoryBottom
////

///// BEGIN - SETUP HOOKS /////
$wgHooks['CategoryPageView'][] = 'flexibleCategoryViewer_overrideCategoryPage';
///// END - SETUP HOOKS /////

////
// This function hijacks the normal CategoryPageView functionality and by returning false,
// prevents the default.  In effect, this makes FlexibleCategoryViewer take the place of CategoryPage
// and therefore lets it use the FlexibleCategoryViewer instead of the normal CategoryViewer.
////
function flexibleCategoryViewer_overrideCategoryPage(&$categoryArticle) {
	//FIXME: Is there an easier way to turn categoryArticle into a FlexibleCategoryPage without making it reload by title?
	$catPage = new FlexibleCategoryPage($categoryArticle->getTitle());
	$catPage->view();

	return false;
} // end flexibleCategoryViewer_overrideCategoryPage()

////
// This class strives to extend CategoryPage in a way that doesn't modify its core functionality and still
// allows CategoryPage (which is part of core MediaWiki) to be upgraded in the future.  The purpose of
// this class is just to add more hooks for modifying the functionality of the category page.
////
class FlexibleCategoryPage extends CategoryPage{
	var $flexibleViewer;

	////
	// Executed in place of the original CategoryPage::view().
	//
	// This function differs from CategoryPage in that it instantiates a FlexibleCategoryViewer
	// and allows it to do initialization so that the openShowCategory() and closeShowCategory()
	// can be hooked into and then use the FlexibleCategoryViewer to output elements of the page
	// in whatever order is appropriate to the desired uses (instead of the default behavior of
	// CategoryPage and CategoryViewer which do nothing before the Article::view() and then
	// the specific order of elements afterwards in CategoryPage::closeShowCategory()).
	////
	function view(){
		global $wgRequest, $wgUser;

		$diff = $wgRequest->getVal( 'diff' );
		$diffOnly = $wgRequest->getBool( 'diffonly', $wgUser->getOption( 'diffonly' ) );

		if ( isset( $diff ) && $diffOnly )
			return Article::view();

		if( !wfRunHooks( 'FlexibleCategoryPageView', array( &$this ) ) )
			return;

		// This initialization of setting up the viewer
		global $wgOut, $wgRequest;
		$from = $wgRequest->getVal( 'from' );
		$until = $wgRequest->getVal( 'until' );

		$this->flexibleViewer = new FlexibleCategoryViewer( $this->mTitle, $from, $until );

		if ( NS_CATEGORY == $this->mTitle->getNamespace() ) {
			$this->openShowCategory();
		}

		Article::view();

		if ( NS_CATEGORY == $this->mTitle->getNamespace() ) {
			$this->closeShowCategory();
		}
	} // end view()

	////
	// Called on the category page prior to showing the article.  Should return any HTML that is desired to be added to the page.
	//
	// Runs the 'FlexibleCategoryViewer::openShowCategory' hook.  If the functions attached to that hook
	// do not return false, then this function will call its parent in CategoryPage.
	//
	// Generally, the way a hook would change the output of the page here would be to use the global wgOut
	// variable and call its addHTML() function.
	////
	function openShowCategory(){
		if(wfRunHooks( 'FlexibleCategoryPage::openShowCategory', array( &$this ) )){
			global $wgOut;
			$wgOut->addHTML(parent::openShowCategory());
		}
	} // end openShowCategory()

	////
	// Called at the category page after showing the article.
	//
	// Runs the 'FlexibleCategoryViewer::closeShowCategory' hook.  If the functions attached to that hook
	// do not return false, then this function will call its parent in CategoryPage.
	//
	// Generally, the way a hook would change the output of the page here would be to use the global wgOut
	// variable and call its addHTML() function.
	////
	function closeShowCategory() {
		if(wfRunHooks( 'FlexibleCategoryPage::closeShowCategory', array( &$this ) )){
			global $wgOut;
			
			// We don't use the parent function here because much of the initilization for parent's getHTML is duplicate
			// code to what is now done in FlexibleCategoryViewer::init().
			$wgOut->addHTML( $this->flexibleViewer->getHTML() );
		}
	}

} // end class FlexibleCategoryPage

class FlexibleCategoryViewer extends CategoryViewer{
	var $isInitialized = false;

	////
	// Extracted initialization code from CategoryViewer's getHTML() now that the class
	// has been made flexible in a way that many uses may decide not to use getHTML() and instead
	// may fetch the components in whatever order they desire.
	////
	function init(){
		global $wgOut, $wgCategoryMagicGallery, $wgCategoryPagingLimit;
		wfProfileIn( __METHOD__ );

		$wgOut->getRedirect(); // wgOut is a StubObject so it isn't initialized until some method is called, therefore we call a method here so that mNoGallery can be used on the next line
		$this->showGallery = $wgCategoryMagicGallery && !$wgOut->mNoGallery;

		$this->clearCategoryState();
		$this->doCategoryQuery();
		$this->finaliseCategoryState();
		$this->isInitialized = true;
		wfProfileOut( __METHOD__ );
	}

	////
	// Displays the category page's pieces in the same order that CategoryViewer would.  The various
	// hooks and the extracted initialization make it so that other code can easily change what each piece
	// looks like.  To change the order, the hooks on FlexibleCategoryPage must be used.
	////
	function getHTML(){
		wfProfileIn( __METHOD__ );
		if(!$this->isInitialized){
			$this->init();
		}

		$r = $this->getCategoryTop() .
			$this->getSubcategorySection() .
			$this->getPagesSection() .
			$this->getImageSection() .
			$this->getOtherSection() .
			$this->getCategoryBottom();

		// Give a proper message if category is empty
		if ( $r == '' ) {
			$r = wfMsgExt( 'category-empty', array( 'parse' ) );
		}

		wfProfileOut( __METHOD__ );
		return $r;
	} // end getHTML()

	// SECTIONS OF THE VIEW WHICH CALL THEIR CORRESPONDING CategoryViewer FUNCTIONS AFTER
	// FIRST ALLOWING FOR HOOKS TO INTERCETP AND OPTIONALLY STOP DEFAULT BEHAVIOR.

	function getCategoryTop(){
		if(!$this->isInitialized){
			$this->init();
		}
		$r = '';
		if(wfRunHooks( "FlexibleCategoryViewer::getCategoryTop", array( &$this, &$r ) )){
			$r .= parent::getCategoryTop();
		}
		return $r;
	} // end getCategoryTop()

	function getSubcategorySection() {
		if(!$this->isInitialized){
			$this->init();
		}
		$r = '';
		if(wfRunHooks( "FlexibleCategoryViewer::getSubcategorySection", array( &$this, &$r ) )){
			$r .= parent::getSubcategorySection();
		}
		return $r;
	} // end getSubcategorySection()
	
	function getPagesSection() {
		if(!$this->isInitialized){
			$this->init();
		}
		$r = '';
		if(wfRunHooks( "FlexibleCategoryViewer::getPagesSection", array( &$this, &$r ) )){
			$r .= parent::getPagesSection();
		}
		return $r;
	} // end getPagesSection()
	
	function getImageSection() {
		if(!$this->isInitialized){
			$this->init();
		}
		$r = '';
		if(wfRunHooks( "FlexibleCategoryViewer::getImageSection", array( &$this, &$r ) )){
			$r .= parent::getImageSection();
		}
		return $r;
	} // end getImageSection()
	
	////
	// While there is already a hook on CategoryViewer for getOtherSection, adding this hook will allow implementing classes to have
	// hooks all stemming from the same class instead of having messy-looking code and having to remember which class has which
	// hooks.
	////
	function getOtherSection() {
		if(!$this->isInitialized){
			$this->init();
		}
		$r = '';
		if(wfRunHooks( "FlexibleCategoryViewer::getOtherSection", array( &$this, &$r ) )){
			$r .= parent::getOtherSection();
		}
		return $r;
	} // end getOtherSection()
	
	function getCategoryBottom() {
		if(!$this->isInitialized){
			$this->init();
		}
		$r = '';
		if(wfRunHooks( "FlexibleCategoryViewer::getCategoryBottom", array( &$this, &$r ) )){
			$r .= parent::getCategoryBottom();
		}
		return $r;
	} // end getCategoryBottom()

} // end class FlexibleCategoryViewer
