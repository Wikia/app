package com.wikia.webdriver.TestCases;

import org.testng.annotations.Test;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Core.Global;
import com.wikia.webdriver.Common.Properties.Properties;
import com.wikia.webdriver.Common.Templates.TestTemplate;
import com.wikia.webdriver.PageObjects.PageObject.FilePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.SpecialMultipleUploadPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.SpecialUploadPageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticleEditMode;
import com.wikia.webdriver.PageObjects.PageObject.WikiPage.WikiArticlePageObject;
//https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving

public class ImageServing extends TestTemplate {
	private String file = "Image001.jpg";
	private String[] ListOfFiles = {"Image001.jpg","Image002.jpg", "Image003.jpg", "Image004.jpg", "Image005.jpg", "Image006.jpg", "Image007.jpg", "Image008.jpg", "Image009.jpg", "Image010.jpg"};
	private String wikiArticle = "QAautoPage";
	private String Caption = "QAcaption1";
	private String Caption2 = "QAcaption2";
	private String videoURL = "http://www.youtube.com/watch?v=pZB6Dg1RJ_o";
	private String videoURL2 = "http://www.youtube.com/watch?v=TTchckhECwE";
	private String videoURL2name = "What is love (?) - on piano (Haddway)";
	
	
	@Test(groups = {"ImageServing001"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	public void ImageServing001_SpecialNewFilesTest()
	{

	CommonFunctions.MoveCursorTo(0, 0);
	WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
	SpecialNewFilesPageObject wikiSpecialNF = wiki.OpenSpecialNewFiles();
	
	
	CommonFunctions.logIn(Properties.userName2, Properties.password2);
	wikiSpecialNF.ClickOnAddaPhoto();
	wikiSpecialNF.ClickOnMoreOrFewerOptions();
	wikiSpecialNF.CheckIgnoreAnyWarnings();
	wikiSpecialNF.ClickOnMoreOrFewerOptions();
	
	wikiSpecialNF.TypeInFileToUploadPath(file);
	wikiSpecialNF.ClickOnUploadaPhoto();
	wikiSpecialNF.waitForFile(file); 

	}
	
	@Test(groups = {"ImageServing002"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	public void ImageServing002_SpecialUploadTest()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		SpecialUploadPageObject wikiSpecialU = wiki.OpenSpecialUpload();
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		wikiSpecialU.TypeInFileToUploadPath(file);
		wikiSpecialU.verifyFilePreviewAppeared(file);
		wikiSpecialU.CheckIgnoreAnyWarnings();
		FilePageObject filePage = wikiSpecialU.ClickOnUploadFile(file);
		filePage.VerifyCorrectFilePage();
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	@Test(groups = {"ImageServing003"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	public void ImageServing003_SpecialMultipleUploadTest()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		SpecialMultipleUploadPageObject wikiSpecialMU = wiki.OpenSpecialMultipleUpload();
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		wikiSpecialMU.TypeInFilesToUpload(ListOfFiles);
		wikiSpecialMU.CheckIgnoreAnyWarnings();
		wikiSpecialMU.ClickOnUploadFile();
		wikiSpecialMU.VerifySuccessfulUpload(ListOfFiles);
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	@Test(groups = {"ImageServing004"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 004 Adding images to an article in edit mode
	public void ImageServing004_AddingImages()
	{
//		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Image");
		editArticle.waitForModalAndClickAddThisPhoto();
		editArticle.typePhotoCaption(Caption);
		editArticle.clickOnAddPhotoButton2();
		editArticle.verifyThatThePhotoAppears(Caption);
		editArticle.clickOnPreviewButton();
		editArticle.verifyTheImageOnThePreview();
		editArticle.verifyTheCaptionOnThePreview(Caption);
		article = editArticle.clickOnPublishButtonInPreviewMode();
		article.VerifyTheImageOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.clickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2, driver);
	}
	
	@Test(groups = {"ImageServing005"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 005 Modifying images in an article in edit mode
	public void ImageServing005_ModifyingImages()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Image");
		editArticle.waitForModalAndClickAddThisPhoto();
		editArticle.typePhotoCaption(Caption);
		editArticle.clickOnAddPhotoButton2();
		editArticle.clickModifyButtonOfImage(Caption);
		editArticle.typePhotoCaption(Caption2);
		editArticle.clickOnAddPhotoButton2();
		editArticle.verifyThatThePhotoAppears(Caption2);
		editArticle.clickOnPreviewButton();
		editArticle.verifyTheImageOnThePreview();
		editArticle.verifyTheCaptionOnThePreview(Caption2);
		article = editArticle.clickOnPublishButtonInPreviewMode();
		article.VerifyTheImageOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.clickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2, driver);
		CommonFunctions.MoveCursorTo(0, 0);
	}
	
	@Test(groups = {"ImageServing006"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 006  Removing images in an article in edit mode
	public void ImageServing006_RemovingImages()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Image");
		editArticle.waitForModalAndClickAddThisPhoto();
		editArticle.typePhotoCaption(Caption);
		editArticle.clickOnAddPhotoButton2();
		editArticle.hoverCursorOverImage(Caption);
		editArticle.clickRemoveButtonOfImage(Caption);
		editArticle.leftClickCancelButton();
//		editArticle.VerifyModalDisappeared();  
		editArticle.hoverCursorOverImage(Caption);
		editArticle.clickRemoveButtonOfImage(Caption);
		editArticle.leftClickOkButton();
//		editArticle.VerifyModalDisappeared();
//		editArticle.VerifyTheImageNotOnTheArticleEditMode();
		article = editArticle.clickOnPublishButton();
//		article.VerifyTheImageNotOnThePage();
		
		CommonFunctions.logOut(Properties.userName2, driver);
		CommonFunctions.MoveCursorTo(0, 0);
	}

	@Test(groups = {"ImageServing007"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 007  Adding galleries to an article in edit mode
	public void ImageServing007_AddingGalleries()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Gallery");
		editArticle.waitForObjectModalAndClickAddAphoto("Gallery");
		editArticle.galleryCheckImageInputs(4);
		editArticle.galleryClickOnSelectButton();
		editArticle.gallerySetPosition("Gallery", "Center");
		editArticle.gallerySetPhotoOrientation(2);
		editArticle.galleryClickOnFinishButton();
		editArticle.verifyObjectInEditMode("gallery");
		editArticle.clickOnPreviewButton();
		editArticle.verifyTheObjectOnThePreview("gallery");
		article = editArticle.clickOnPublishButtonInPreviewMode();
		article.VerifyTheObjetOnThePage("gallery");
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.clickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2, driver);
		CommonFunctions.MoveCursorTo(0, 0);
	}
	
	@Test(groups = {"ImageServing008"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 008 Adding slideshows to an article in edit mode
	public void ImageServing008_AddingSlideshow()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Slideshow");
		editArticle.waitForObjectModalAndClickAddAphoto("GallerySlideshow");
		editArticle.galleryCheckImageInputs(4);
		editArticle.galleryClickOnSelectButton();
		editArticle.gallerySetPosition("Slideshow", "Center");
		editArticle.galleryClickOnFinishButton();
		editArticle.verifyObjectInEditMode("slideshow");
		editArticle.clickOnPreviewButton();
		editArticle.verifyTheObjectOnThePreview("slideshow");
		article = editArticle.clickOnPublishButtonInPreviewMode();
		article.VerifyTheObjetOnThePage("slideshow");
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.clickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2, driver);
	
	}
	
	@Test(groups = {"ImageServing009"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 009 Adding sliders to an article in edit mode
	public void ImageServing009_AddingSliders()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Slider");
		editArticle.waitForObjectModalAndClickAddAphoto("GallerySlider");
		editArticle.galleryCheckImageInputs(4);
		editArticle.galleryClickOnSelectButton();
		editArticle.gallerySetSliderPosition(2);
		editArticle.galleryClickOnFinishButton();
		editArticle.verifyObjectInEditMode("gallery-slider");
		editArticle.clickOnPreviewButton();
		editArticle.verifyTheObjectOnThePreview("slider");
		article = editArticle.clickOnPublishButtonInPreviewMode();
		article.VerifyTheObjetOnThePage("slider");
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.clickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2, driver);
		
	}
	
	@Test(groups = {"ImageServing010"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 010 Adding videos to an article in edit mode
	public void ImageServing010_AddingVideo()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.clickOnAddObjectButton("Video");
		editArticle.waitForVideoModalAndTypeVideoURL(videoURL);
		editArticle.clickVideoNextButton();
		editArticle.waitForVideoDialog();
		editArticle.typeVideoCaption(Caption);
		editArticle.clickAddAvideo();
		editArticle.waitForSuccesDialogAndReturnToEditing();
		editArticle.verifyVideoInEditMode();
		editArticle.clickOnPreviewButton();
		editArticle.verifyTheVideoOnThePreview();
		article = editArticle.clickOnPublishButtonInPreviewMode();
		article.VerifyTheVideoOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.clickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2, driver);
		
	}
	
	@Test(groups = {"ImageServing011"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 011 Adding related videos through Related Video (RV) module
	public void ImageServing011_AddingVideoThroughRV()
	{
		CommonFunctions.MoveCursorTo(0, 0);
		//delete the given video from RV module on QAAutopage using MediaWiki:RelatedVideosGlobalList (message article), by its name (videoURL2name variable)
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Global.DOMAIN);
		WikiArticlePageObject RVmoduleMessage = wiki.OpenArticle("MediaWiki:RelatedVideosGlobalList");
		CommonFunctions.logIn(Properties.userNameStaff, Properties.passwordStaff);
		WikiArticleEditMode RVmoduleMessageEdit = RVmoduleMessage.Edit();		
		RVmoduleMessageEdit.deleteUnwantedVideoFromMessage(videoURL2name);
		RVmoduleMessage = RVmoduleMessageEdit.clickOnPublishButton();
		// after deletion start testing
		WikiArticlePageObject article = RVmoduleMessage.OpenArticle(wikiArticle);
		article.VerifyRVModulePresence();
		article.ClickOnAddVideoRVModule();
		article.TypeInVideoURL(videoURL2);
		article.ClickOnRVModalAddButton();
//		article.WaitForProcessingToFinish();
		article.VerifyVideoAddedToRVModule(videoURL2name);
	
		CommonFunctions.logOut(Properties.userName2, driver);
		
	}
	

	}

