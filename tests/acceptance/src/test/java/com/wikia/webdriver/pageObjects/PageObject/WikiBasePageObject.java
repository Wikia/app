package com.wikia.webdriver.pageObjects.PageObject;

import java.util.List;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Logging.PageObjectLogging;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialNewFilesPageObject;
import com.wikia.webdriver.pageObjects.PageObject.WikiPage.SpecialUploadPageObject;

public class WikiBasePageObject extends HomePageObject {
	private String wikiname;

	public WikiBasePageObject(WebDriver driver, String wikiname) {
		super(driver);
		this.wikiname = wikiname;
		}

	public String getWikiName() {
		return wikiname;
	}
	
	public SpecialNewFilesPageObject OpenSpecialNewFiles() {
		driver.get("http://"+wikiname+".wikia.com/Special:NewFiles");
		return new SpecialNewFilesPageObject(driver, wikiname);
	}


	public SpecialUploadPageObject OpenSpecialUpload() {
		driver.get("http://"+wikiname+".wikia.com/Special:Upload");
		return new SpecialUploadPageObject(driver, wikiname);
	}
	
}
