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
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialUploadPageObject;

public class ImageServing extends TestTemplate {
	private String file = "Image001.jpg";
	private String wikiName = "mediawiki119";
	@Test
	public void ImageServingTest()
	{
	
	WikiBasePageObject wiki = new WikiBasePageObject(driver, wikiName);
//	SpecialNewFilesPageObject wikiSpecialNF = wiki.OpenSpecialNewFiles();
//	
//	CommonFunctions.logIn("Michaltester", "1tester.");
//	wikiSpecialNF.ClickOnAddaPhoto();
//	wikiSpecialNF.ClickOnMoreOrFewerOptions();
//	wikiSpecialNF.CheckIgnoreAnyWarnings();
//	wikiSpecialNF.ClickOnMoreOrFewerOptions();
//	
//	wikiSpecialNF.TypeInFileToUploadPath(file);
//	wikiSpecialNF.ClickOnUploadaPhoto();
//	wikiSpecialNF.waitForFile(file);
//
	SpecialUploadPageObject wikiSpecialU = wiki.OpenSpecialUpload();
	CommonFunctions.logIn("Michaltester", "1tester.");
	wikiSpecialU.TypeInFileToUploadPath("Image001.jpg");
	wikiSpecialU.verifyFilePreviewAppeared("Image001.jpg");
	wikiSpecialU.CheckIgnoreAnyWarnings();
	FilePageObject filePage = wikiSpecialU.ClickOnUploadFile("Image001.jpg");
	filePage.VerifyCorrectFilePage();
	

	}}
