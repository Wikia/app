package com.wikia.webdriver.pageObjects.PageObject;

import org.openqa.selenium.WebDriver;

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
			waitForStringInURL("File:"+fileName);
		}
}
