package com.wikia.webdriver.TestCases;

import org.openqa.selenium.WebDriver;
import org.testng.annotations.Test;

import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.DriverProvider.DriverProvider;
import com.wikia.webdriver.Templates.TestTemplate;
import com.wikia.webdriver.pageObjects.PageObject.BasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.HomePageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;
import com.wikia.webdriver.pageObjects.PageObject.Hubs.EntertainmentHubPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialUploadPageObject;

public class ImageServing extends TestTemplate {

	@Test
	public void ImageServingTest()
	{
	WikiBasePageObject wiki = new WikiBasePageObject(driver, "preview.mediawiki119");
	System.out.println("nie za szybko");
	SpecialNewFilesPageObject wikiSpecialNF = wiki.OpenSpecialNewFiles();
	
	CommonFunctions.logIn("Michaltester", "1tester.");
	System.out.println("nie za szybko2");
	wikiSpecialNF.ClickOnAddaPhoto();
	wikiSpecialNF.TypeInFileToUploadPath("Image001");
	wikiSpecialNF.ClickOnUploadaPhoto();

	
	}}
