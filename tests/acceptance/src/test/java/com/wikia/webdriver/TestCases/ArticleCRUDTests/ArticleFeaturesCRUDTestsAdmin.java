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
	private String videoURL2 = "http://www.youtube.com/watch?v=pmPDl7JqmR0&feature=fvst";
	private String Caption = "QAWebdriverCaption1";
	private String Caption2 = "QAWebdriverCaption2";
	private String pageName;
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_001", "ArticleFeaturesCRUDAdmin", "Smoke"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 007  Adding galleries to an article in edit mode
	public void ArticleCRUDAdmin_001_AddingGallery()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionGallery("Center");//error!!!
		edit.gallerySetPhotoOrientation(2);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("gallery");
		WikiArticlePageObject article = edit.clickOnPublishButtonPreview();
		article.verifyTheObjectOnThePage("gallery");
		edit = article.edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_002", "ArticleFeaturesCRUDAdmin"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 007  Adding galleries to an article in edit mode
	public void ArticleCRUDAdmin_002_ModifyGallery()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionGallery("Center");//error!!!
		edit.gallerySetPhotoOrientation(2);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("gallery");
		WikiArticlePageObject article = edit.clickOnPublishButtonPreview();
		article.verifyTheObjectOnThePage("gallery");
		article.verifyGalleryPosion("center");
		edit = article.edit();
		edit.clickModifyButtonGallery();
		edit.waitForObjectModalAndClickAddAphoto("Gallery");
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(8);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionGallery("Right");
		edit.gallerySetPhotoOrientation(3);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery");
		article = edit.clickOnPublishButton();
		article.verifyGalleryPosion("right");
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_003", "ArticleFeaturesCRUDAdmin"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 007  Adding galleries to an article in edit mode
	public void ArticleCRUDAdmin_003_DeleteGallery()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionGallery("Center");//error!!!
		edit.gallerySetPhotoOrientation(2);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("gallery");
		WikiArticlePageObject article = edit.clickOnPublishButtonPreview();
		article.verifyTheObjectOnThePage("gallery");
		article.verifyGalleryPosion("center");
		edit = article.edit();
		edit.clickRemoveButtonGallery();
		edit.leftClickOkButton();
		edit.verifyTheGalleryNotOnTheArticleEditMode();
		article = edit.clickOnPublishButton();
		article.verifyTheGalleryNotOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_004", "ArticleFeaturesCRUDAdmin", "Smoke"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 008 Adding slideshows to an article in edit mode
	public void ArticleCRUDAdmin_004_AddingSlideshow()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionSlideshow("Center");
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("slideshow");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slideshow");
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheObjectOnThePage("slideshow");
		edit = article.edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_009", "ArticleFeaturesCRUDAdmin"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 008 Adding slideshows to an article in edit mode
	public void ArticleCRUDAdmin_005_ModifySlideshow()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionSlideshow("Center");
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("slideshow");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slideshow");
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheObjectOnThePage("slideshow");
		article.verifySlideshowPosition("center");
		edit = article.edit();
		edit.clickModifyButtonSlideshow();
		edit.waitForObjectModalAndClickAddAphoto("GallerySlideshow");
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(8);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionSlideshow("Right");
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("slideshow");
		article = edit.clickOnPublishButton();
		article.verifyTheObjectOnThePage("slideshow");
		article.verifySlideshowPosition("right");
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userNameStaff, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_006", "ArticleFeaturesCRUDAdmin"})
	public void ArticleCRUDAdmin_006_DeleteSlideshow()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetPositionSlideshow("Center");
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("slideshow");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slideshow");
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheObjectOnThePage("slideshow");
		article.verifySlideshowPosition("center");
		edit = article.edit();
		edit.clickRemoveButtonSlideshow();
		edit.leftClickOkButton();
		edit.verifyTheSlideshowNotOnTheArticleEditMode();
		article = edit.clickOnPublishButton();
		article.verifyTheSlideshowNotOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_007", "ArticleFeaturesCRUDAdmin", "Smoke"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 009 Adding sliders to an article in edit mode
	public void ArticleCRUDAdmin_007_AddingSlider()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetSliderPosition(2);
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery-slider");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slider");
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheObjectOnThePage("slider");
		edit = article.edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName, driver);	
	}
	
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_008", "ArticleFeaturesCRUDAdmin"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 009 Adding sliders to an article in edit mode
	public void ArticleCRUDAdmin_008_ModifySlider()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetSliderPosition(2);//Vertical
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery-slider");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slider");//publish 
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheObjectOnThePage("slider");
		article.verifySliderThumbnailsPosition("vertical");
		edit = article.edit();
		edit.clickModifyButtonSlider();
		edit.waitForObjectModalAndClickAddAphoto("GallerySlider");
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(8);
		edit.galleryClickOnSelectButton();
		edit.gallerySetSliderPosition(1);//Horizontal
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery-slider");
		article = edit.clickOnPublishButton();
		article.verifyTheObjectOnThePage("slider");
		article.verifySliderThumbnailsPosition("horizontal");
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName, driver);	
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_009", "ArticleFeaturesCRUDAdmin"})
	public void ArticleCRUDAdmin_009_DeleteSlider()
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
		edit.searchImageInLightBox("image");
		edit.galleryCheckImageInputs(4);
		edit.galleryClickOnSelectButton();
		edit.gallerySetSliderPosition(2);//Vertical
		edit.galleryClickOnFinishButton();
		edit.verifyObjectInEditMode("gallery-slider");
		edit.clickOnPreviewButton();
		edit.verifyTheObjectOnThePreview("slider");//publish 
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheObjectOnThePage("slider");
		article.verifySliderThumbnailsPosition("vertical");
		edit = article.edit();
		edit.clickRemoveButtonSlider();
		edit.leftClickOkButton();
		edit.verifyTheSliderNotOnTheArticleEditMode();
		article = edit.clickOnPublishButton();
		article.verifyTheSlideshowNotOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_010", "ArticleFeaturesCRUDAdmin", "Smoke"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 010 Adding videos to an article in edit mode
	public void ArticleCRUDAdmin_010_AddingVideo()
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
		edit.verifyVideoInEditMode(Caption);
		edit.clickOnPreviewButton();
		edit.verifyTheVideoOnThePreview();
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheVideoOnThePage();
		edit = article.edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}	
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_011", "ArticleFeaturesCRUDAdmin"})
	public void ArticleCRUDAdmin_011_ModifyVideo()
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
		edit.verifyVideoInEditMode(Caption);
		edit.clickOnPreviewButton();
		edit.verifyTheVideoOnThePreview();
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheVideoOnThePage();
		edit = article.edit();
		edit.clickModifyButtonVideo();
		edit.waitForVideoDialog();
		edit.typeVideoCaption(Caption2);
		edit.clickAddAvideo();
		edit.verifyVideoInEditMode(Caption2);
		article = edit.clickOnPublishButton();
		article.verifyTheVideoOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_012", "ArticleFeaturesCRUDAdmin"})
	public void ArticleCRUDAdmin_012_DeleteVideo()
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
		edit.verifyVideoInEditMode(Caption);
		edit.clickOnPreviewButton();
		edit.verifyTheVideoOnThePreview();
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.verifyTheVideoOnThePage();
		edit = article.edit();
		edit.clickRemoveButtonVideo();
		edit.leftClickOkButton();
		edit.verifyTheVideoNotOnTheArticleEditMode();
		article = edit.clickOnPublishButton();
		article.verifyTheVideoNotOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_013", "ArticleFeaturesCRUDAdmin", "Smoke"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 004 Adding images to an article in edit mode
	public void ArticleCRUDAdmin_013_AddingImage()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Image");
		edit.waitForModalAndClickAddThisPhoto();
		edit.typePhotoCaption(Caption);
		edit.clickOnAddPhotoButton2();
		edit.verifyThatThePhotoAppears(Caption);
		edit.clickOnPreviewButton();
		edit.verifyTheImageOnThePreview();
		edit.verifyTheCaptionOnThePreview(Caption);
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.VerifyTheImageOnThePage();
		edit = article.edit();
		edit.deleteArticleContent();
		article = edit.clickOnPublishButton();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_014", "ArticleFeaturesCRUDAdmin"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 005 Modifying images in an article in edit mode
	public void ArticleCRUDAdmin_014_ModifyImage()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Image");
		edit.waitForModalAndClickAddThisPhoto();
		edit.typePhotoCaption(Caption);
		edit.clickOnAddPhotoButton2();
		edit.verifyThatThePhotoAppears(Caption);
		edit.clickModifyButtonOfImage(Caption);
		edit.typePhotoCaption(Caption2);
		edit.clickOnAddPhotoButton2();
		edit.verifyThatThePhotoAppears(Caption2);
		edit.clickOnPreviewButton();
		edit.verifyTheImageOnThePreview();
		edit.verifyTheCaptionOnThePreview(Caption2);
		WikiArticlePageObject article = edit.clickOnPublishButtonInPreviewMode();
		article.VerifyTheImageOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups={"ArticleFeaturesCRUDAdmin_015", "ArticleFeaturesCRUDAdmin"})
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 005 Modifying images in an article in edit mode
	public void ArticleCRUDAdmin_015_DeleteImage()
	{
		CommonFunctions.logOut(Properties.userName, driver);
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		pageName = "QAarticle"+wiki.getTimeStamp();
		wiki.openWikiPage();
		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
		edit.deleteArticleContent();
		edit.clickOnVisualButton();
		edit.clickOnAddObjectButton("Image");
		edit.waitForModalAndClickAddThisPhoto();
		edit.typePhotoCaption(Caption);
		edit.clickOnAddPhotoButton2();
		edit.verifyThatThePhotoAppears(Caption);
		WikiArticlePageObject article = edit.clickOnPublishButton();
		article.VerifyTheImageOnThePage();
		edit = article.edit();
		edit.clickRemoveButtonOfImage(Caption);
		edit.leftClickOkButton();
		edit.verifyTheImageNotOnTheArticleEditMode();
		article = edit.clickOnPublishButton();
		article.verifyTheImageNotOnThePage();
		article.deleteArticle(pageName);
		article.openArticle(pageName);
		article.verifyDeletedArticlePage(pageName);
		CommonFunctions.logOut(Properties.userName2, driver);
	}	
	
//	@Test(groups={"ArticleFeaturesCRUDAdmin_016", "ArticleFeaturesCRUDAdmin"})
//	public void ArticleCRUDAdmin_016_AddTable()
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		pageName = "QAarticle"+wiki.getTimeStamp();
//		wiki.openWikiPage();
//		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
//		edit.deleteArticleContent();
//		edit.clickOnVisualButton();
//		edit.clickOnAddTableButton();
//		edit.verifyTableModal();
//		edit.clickOKonTableModal();
//		edit.verifyTableAppears();
//		WikiArticlePageObject article = edit.clickOnPublishButton();
//		article.VerifyTheTableOnThePage();
//		CommonFunctions.logOut(Properties.userName2, driver);		
//	}	
//	
//	@Test(groups={"ArticleFeaturesCRUDAdmin_017", "ArticleFeaturesCRUDAdmin"})
//	public void ArticleCRUDAdmin_017_EditTable()
//	{
//		CommonFunctions.logOut(Properties.userName, driver);
//		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
//		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
//		pageName = "QAarticle"+wiki.getTimeStamp();
//		wiki.openWikiPage();
//		WikiArticleEditMode edit = wiki.createNewArticle(pageName, 1);
//		edit.deleteArticleContent();
//		edit.clickOnVisualButton();
//		edit.clickOnAddTableButton();
//		edit.verifyTableModal();
//		edit.clickOKonTableModal();
//		edit.verifyTableAppears();
//		WikiArticlePageObject article = edit.clickOnPublishButton();
//		article.VerifyTheTableOnThePage();
//		edit = article.edit();
//		edit.verifyTableAppears();
//		edit.tablePupulateCell(1,1, "first");
//		edit.tablePupulateCell(1,2, "second");
//		edit.tablePupulateCell(2,1, "third");
//		edit.tablePupulateCell(2,2, "fourth");
//		edit.tablePupulateCell(3,1, "fifth");
//		edit.tablePupulateCell(3,2, "sixth");
//		
//		CommonFunctions.logOut(Properties.userName2, driver);		
//	}	
	

	


	


}