package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;

public class SpecialUploadPageObject extends WikiBasePageObject {

	private String wikiname;
	
	public SpecialUploadPageObject(WebDriver driver, String wikiname) {
		super(driver, wikiname);
		this.wikiname = wikiname;
		PageFactory.initElements(driver, this);
	}
	 

}
