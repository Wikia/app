package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;

import com.wikia.webdriver.Logging.PageObjectLogging;

public class FilePageObject extends BasePageObject{
	
		private String fileName;

		public FilePageObject(WebDriver driver, String fileName) {
			super(driver);
			this.fileName = fileName;
			}

		public String getWikiName() {
			return fileName;
		}
		
		public void VerifyCorrectFilePage() {
			PageObjectLogging.log("VerifyCorrectFilePage", "Verify that the page represents "+fileName+" file", true, driver);
			waitForStringInURL("File:"+fileName);
		}
}
