package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
//https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.Common.Global;
import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Properties.Properties;
import com.wikia.webdriver.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.FilePageObject;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialMultipleUploadPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialUploadPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.WikiArticleEditMode;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.WikiArticlePageObject;

public class ImageServing extends TestTemplate {
	private String file = "Image001.jpg";
	private String[] ListOfFiles = {"Image001.jpg","Image002.jpg", "Image003.jpg", "Image004.jpg", "Image005.jpg", "Image006.jpg", "Image007.jpg", "Image008.jpg", "Image009.jpg", "Image010.jpg"};
	private String Domain = Global.DOMAIN;
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
	
		startBrowser();
	WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
	SpecialNewFilesPageObject wikiSpecialNF = wiki.OpenSpecialNewFiles();
	
	CommonFunctions.logIn(Properties.userName2, Properties.password2);
	wikiSpecialNF.ClickOnAddaPhoto();
	wikiSpecialNF.ClickOnMoreOrFewerOptions();
	wikiSpecialNF.CheckIgnoreAnyWarnings();
	wikiSpecialNF.ClickOnMoreOrFewerOptions();
	
	wikiSpecialNF.TypeInFileToUploadPath(file);
	wikiSpecialNF.ClickOnUploadaPhoto();
	wikiSpecialNF.waitForFile(file); 
	stopBrowser();
	}
	
	@Test(groups = {"ImageServing002"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	public void ImageServing002_SpecialUploadTest()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		 SpecialUploadPageObject wikiSpecialU = wiki.OpenSpecialUpload();
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		wikiSpecialU.TypeInFileToUploadPath(file);
		wikiSpecialU.verifyFilePreviewAppeared(file);
		wikiSpecialU.CheckIgnoreAnyWarnings();
		FilePageObject filePage = wikiSpecialU.ClickOnUploadFile(file);
		filePage.VerifyCorrectFilePage();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
	}
	@Test(groups = {"ImageServing003"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	public void ImageServing003_SpecialMultipleUploadTest()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		SpecialMultipleUploadPageObject wikiSpecialMU = wiki.OpenSpecialMultipleUpload();
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		wikiSpecialMU.TypeInFilesToUpload(ListOfFiles);
		wikiSpecialMU.CheckIgnoreAnyWarnings();
		wikiSpecialMU.ClickOnUploadFile();
		wikiSpecialMU.VerifySuccessfulUpload(ListOfFiles);
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
	}
	@Test(groups = {"ImageServing004"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 004 Adding images to an article in edit mode
	public void ImageServing004_AddingImages()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Image");
		editArticle.WaitForModalAndClickAddThisPhoto();
		editArticle.TypeCaption(Caption);
		editArticle.ClickOnAddPhotoButton2();
		editArticle.VerifyThatThePhotoAppears(Caption);
		editArticle.ClickOnPreviewButton();
		editArticle.VerifyTheImageOnThePreview();
		editArticle.VerifyTheCaptionOnThePreview(Caption);
		article = editArticle.ClickOnPublishButtonInPreviewMode();
		article.VerifyTheImageOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
	}
	
	@Test(groups = {"ImageServing005"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving
	// Test Case 005 Modifying images in an article in edit mode
	public void ImageServing005_ModifyingImages()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Image");
		editArticle.WaitForModalAndClickAddThisPhoto();
		editArticle.TypeCaption(Caption);
		editArticle.ClickOnAddPhotoButton2();
		editArticle.ClickModifyButtonOfImage(Caption);
		editArticle.TypeCaption(Caption2);
		editArticle.ClickOnAddPhotoButton2();
		editArticle.VerifyThatThePhotoAppears(Caption2);
		editArticle.ClickOnPreviewButton();
		editArticle.VerifyTheImageOnThePreview();
		editArticle.VerifyTheCaptionOnThePreview(Caption2);
		article = editArticle.ClickOnPublishButtonInPreviewMode();
		article.VerifyTheImageOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
		
	}
	
	@Test(groups = {"ImageServing006"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 006  Removing images in an article in edit mode
	public void ImageServing006_RemovingImages()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Image");
		editArticle.WaitForModalAndClickAddThisPhoto();
		editArticle.TypeCaption(Caption);
		editArticle.ClickOnAddPhotoButton2();
		editArticle.HoverCursorOverImage(Caption);
		editArticle.ClickRemoveButtonOfImage(Caption);
		editArticle.LeftClickCancelButton();
//		editArticle.VerifyModalDisappeared();  
		editArticle.HoverCursorOverImage(Caption);
		editArticle.ClickRemoveButtonOfImage(Caption);
		editArticle.LeftClickOkButton();
//		editArticle.VerifyModalDisappeared();
//		editArticle.VerifyTheImageNotOnTheArticleEditMode();
		article = editArticle.ClickOnPublishButton();
		article.VerifyTheImageOnThePage();
		
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
	}

	@Test(groups = {"ImageServing007"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 007  Adding galleries to an article in edit mode
	public void ImageServing007_AddingGalleries()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Gallery");
		editArticle.WaitForObjectModalAndClickAddAphoto("Gallery");
		editArticle.CheckGalleryImageInputs(4);
		editArticle.GalleryClickOnSelectButton();
		editArticle.GalleryClickOnFinishButton();
		editArticle.VerifyObjectInEditMode("gallery");
		editArticle.ClickOnPreviewButton();
		editArticle.VerifyTheObjectOnThePreview("gallery");
		article = editArticle.ClickOnPublishButtonInPreviewMode();
		article.VerifyTheObjetOnThePage("gallery");
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
		
	}
	
	@Test(groups = {"ImageServing008"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 008 Adding slideshows to an article in edit mode
	public void ImageServing008_AddingSlideshow()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Slideshow");
		editArticle.WaitForObjectModalAndClickAddAphoto("GallerySlideshow");
		editArticle.CheckGalleryImageInputs(4);
		editArticle.GalleryClickOnSelectButton();
		editArticle.GalleryClickOnFinishButton();
		editArticle.VerifyObjectInEditMode("slideshow");
		editArticle.ClickOnPreviewButton();
		editArticle.VerifyTheObjectOnThePreview("slideshow");
		article = editArticle.ClickOnPublishButtonInPreviewMode();
		article.VerifyTheObjetOnThePage("slideshow");
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
		
	}
	
	@Test(groups = {"ImageServing009"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 009 Adding sliders to an article in edit mode
	public void ImageServing009_AddingSliders()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Slider");
		editArticle.WaitForObjectModalAndClickAddAphoto("GallerySlider");
		editArticle.CheckGalleryImageInputs(4);
		editArticle.GalleryClickOnSelectButton();
		editArticle.GalleryClickOnFinishButton();
		editArticle.VerifyObjectInEditMode("gallery-slider");
		editArticle.ClickOnPreviewButton();
		editArticle.VerifyTheObjectOnThePreview("slider");
		article = editArticle.ClickOnPublishButtonInPreviewMode();
		article.VerifyTheObjetOnThePage("slider");
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
		
	}
	
	@Test(groups = {"ImageServing010"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 010 Adding videos to an article in edit mode
	public void ImageServing010_AddingVideo()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Video");
		editArticle.WaitForVideoModalAndTypeVideoURL(videoURL);
		editArticle.ClickVideoNextButton();
		editArticle.WaitForVideoDialogAndClickAddAvideo();
		editArticle.WaitForSuccesDialogAndReturnToEditing();
		editArticle.VerifyVideoInEditMode();
		editArticle.ClickOnPreviewButton();
		editArticle.VerifyTheVideoOnThePreview();
		article = editArticle.ClickOnPublishButtonInPreviewMode();
		article.VerifyTheVideoOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
		
	}
	
	@Test(groups = {"ImageServing011"}) 
//	https://internal.wikia-inc.com/wiki/QA/Core_Features_and_Testing/Manual_Regression_Tests/Image_Serving	
	// Test Case 011 Adding related videos through Related Video (RV) module
	public void ImageServing011_AddingVideoThroughRV()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, Domain);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(Properties.userName2, Properties.password2);
		article.VerifyRVModulePresence();
		article.ClickOnAddVideoRVModule();
		article.TypeInVideoURL(videoURL2);
		article.ClickOnRVModalAddButton();
//		article.WaitForProcessingToFinish();
		article.VerifyVideoAddedToRVModule(videoURL2name);
		//delete all videos from RV module on QAAutopage using RelatedVideos:QAautoPage (message article)
		WikiArticlePageObject RVmoduleMessage = article.OpenArticle("RelatedVideos:"+wikiArticle);
		WikiArticleEditMode RVmoduleMessageEdit = RVmoduleMessage.Edit();
		RVmoduleMessageEdit.deleteArticleContent();
		RVmoduleMessage = RVmoduleMessageEdit.ClickOnPublishButton();
		// after deletion start testing
		
		CommonFunctions.logOut(Properties.userName2);
		stopBrowser();
		
	}
	

	}
