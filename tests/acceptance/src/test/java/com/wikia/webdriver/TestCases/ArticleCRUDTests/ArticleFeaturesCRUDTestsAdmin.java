package com.wikia.webdriver.TestCases.ArticleCRUDTests;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticleEditMode;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class ArticleFeaturesCRUDTestsAdmin extends TestTemplate
{
	private String videoURL = "http://www.youtube.com/watch?v=pZB6Dg1RJ_o";
	private String Caption = "QAcaption1";
	private String pageName;
	
	@Test(groups={"ArticleCRUDAdmin_011", "ArticleCRUDAdmin"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 007  Adding galleries to an article in edit mode
	public void ArticleCRUDAdmin_011_AddingGallery_Admin()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Gallery");
		edit.waitForObjectModalAndClickAddAphoto("Gallery");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionGallery("Center");//error!!!
		edit.gallerySetPhotoOrientation(2);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("gallery");
		WikiArticlePageObject article = edit.clickOnPublishButtonPreview();
		article.VerifyTheObjectOnThePage("gallery");
		edit = article.Edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
		CommonFunctions.MoveCursorTo(0, 0);
	}
	
	@Test(groups={"ArticleCRUDAdmin_012", "ArticleCRUDAdmin"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 008 Adding slideshows to an article in edit mode
	public void ArticleCRUDAdmin_012_AddingSlideshow_Admin()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Slideshow");
		edit.waitForObjectModalAndClickAddAphoto("GallerySlideshow");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionSlideshow("Center");
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("slideshow");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slideshow");
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.VerifyTheObjectOnThePage("slideshow");
		edit = article.Edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	@Test(groups={"ArticleCRUDAdmin_013", "ArticleCRUDAdmin"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 009 Adding sliders to an article in edit mode
	public void ArticleCRUDAdmin_013_AddingSlider_Admin()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Slider");
		edit.waitForObjectModalAndClickAddAphoto("GallerySlider");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetSliderPosition(2);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery-slider");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slider");
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.VerifyTheObjectOnThePage("slider");
		edit = article.Edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName, driver);	
	}
	
	@Test(groups={"ArticleCRUDAdmin_014", "ArticleCRUDAdmin"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 010 Adding videos to an article in edit mode
	public void ArticleCRUDAdmin_014_AddingVideo_Admin()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Video");
		edit.waitForVideoModalAndTypeVideoURL(videoURL);
		edit.clickVideoNextButton();
		edit.waitForVideoDialog();
		edit.typeVideoCaption(Caption);
		edit.clickAddAvideo();
		edit.waitForSuccesDialogAndReturnToEditing();
		edit.verifyVideoInEditMode();
		edit.clickOnPreviewButton();
		edit.verifyTheVideoOnThePreview();
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.VerifyTheVideoOnThePage();
		edit = article.Edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle();
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}	


}
