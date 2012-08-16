package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.DriverProvider.DriverProvider;
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
	private String username = "Michaltester";
	private String password = "1tester.";
	private String file = "Image001.jpg";
	private String[] ListOfFiles = {"Image001.jpg","Image002.jpg", "Image003.jpg", "Image004.jpg", "Image005.jpg", "Image006.jpg", "Image007.jpg", "Image008.jpg", "Image009.jpg", "Image010.jpg"};
	private String wikiName = "mediawiki119";
	private String wikiArticle = "QAautoPage";
	private String Caption = "QAcaption1";
	private String Caption2 = "QAcaption2";
	
	
//	@Test(groups = {"ImageServing"}) 
	public void ImageServing001_SpecialNewFilesTest()
	{
	
		startBrowser();
	WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
	SpecialNewFilesPageObject wikiSpecialNF = wiki.OpenSpecialNewFiles();
	
	CommonFunctions.logIn(username, password);
	wikiSpecialNF.ClickOnAddaPhoto();
	wikiSpecialNF.ClickOnMoreOrFewerOptions();
	wikiSpecialNF.CheckIgnoreAnyWarnings();
	wikiSpecialNF.ClickOnMoreOrFewerOptions();
	
	wikiSpecialNF.TypeInFileToUploadPath(file);
	wikiSpecialNF.ClickOnUploadaPhoto();
	wikiSpecialNF.waitForFile(file); 
	stopBrowser();
	}
	
//	@Test(groups = {"ImageServing"}) 
	public void ImageServing002_SpecialUploadTest()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
		 SpecialUploadPageObject wikiSpecialU = wiki.OpenSpecialUpload();
		CommonFunctions.logIn(username, password);
		wikiSpecialU.TypeInFileToUploadPath(file);
		wikiSpecialU.verifyFilePreviewAppeared(file);
		wikiSpecialU.CheckIgnoreAnyWarnings();
		FilePageObject filePage = wikiSpecialU.ClickOnUploadFile(file);
		filePage.VerifyCorrectFilePage();
		CommonFunctions.logOut(username);
		stopBrowser();
	}
//	@Test(groups = {"ImageServing"}) 
	public void ImageServing003_SpecialMultipleUploadTest()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
		SpecialMultipleUploadPageObject wikiSpecialMU = wiki.OpenSpecialMultipleUpload();
		CommonFunctions.logIn(username, password);
		wikiSpecialMU.TypeInFilesToUpload(ListOfFiles);
		wikiSpecialMU.CheckIgnoreAnyWarnings();
		wikiSpecialMU.ClickOnUploadFile();
		wikiSpecialMU.VerifySuccessfulUpload(ListOfFiles);
		CommonFunctions.logOut(username);
		stopBrowser();
	}
//	@Test(groups = {"ImageServing"}) 
	// Test Case 004 Adding images to an article in edit mode
	public void ImageServing004_AddingImages()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(username, password);
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
		CommonFunctions.logOut(username);
		stopBrowser();
	}
	
//	@Test(groups = {"ImageServing"}) 
	// Test Case 005 Modifying images in an article in edit mode
	public void ImageServing005_ModifyingImages()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(username, password);
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
		CommonFunctions.logOut(username);
		stopBrowser();
		
	}
	
	@Test(groups = {"ImageServing"}) 
	// Test Case 006  Removing images in an article in edit mode
	public void ImageServing006_RemovingImages()
	{
		startBrowser();
		WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
		WikiArticlePageObject article = wiki.OpenArticle(wikiArticle);
		CommonFunctions.logIn(username, password);
		WikiArticleEditMode editArticle = article.Edit();
		editArticle.ClickOnAddObjectButton("Image");
		editArticle.WaitForModalAndClickAddThisPhoto();
		editArticle.TypeCaption(Caption);
		editArticle.ClickOnAddPhotoButton2();
		editArticle.HoverCursorOverImage(Caption);
		editArticle.ClickRemoveButtonOfImage(Caption);
		editArticle.LeftClickCancelButton();
		editArticle.VerifyModalDisappeared();  
		editArticle.HoverCursorOverImage(Caption);
		editArticle.ClickRemoveButtonOfImage(Caption);
		editArticle.LeftClickOkButton();
		editArticle.VerifyModalDisappeared();
		editArticle.VerifyTheImageNotOnThePage();
		article = editArticle.ClickOnPublishButton();
		article.VerifyTheImageOnThePage();
		editArticle = article.Edit();
		editArticle.deleteArticleContent();
		article = editArticle.ClickOnPublishButton();
		CommonFunctions.logOut(username);
		stopBrowser();
	}

	

	}
