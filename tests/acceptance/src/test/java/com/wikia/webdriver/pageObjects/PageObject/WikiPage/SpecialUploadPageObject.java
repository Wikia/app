package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.pageObjects.PageObject.WikiBasePageObject;

public class SpecialUploadPageObject extends WikiBasePageObject {

	
	@FindBy(css="input[name='wpUploadFile']") 
	private WebElement BrowseForFileInput;
	@FindBy(css="div.thumbinner canvas") 
	private WebElement FilePreview;
	@FindBy(css="input[name='wpIgnoreWarning']") 
	private WebElement IgnoreAnyWarnings;
	@FindBy(css="input.mw-htmlform-submit[value*='Upload']") 
	private WebElement UploadFileInput;
	
	public SpecialUploadPageObject(WebDriver driver, String wikiname) {
		super(driver, wikiname);
		
		PageFactory.initElements(driver, this);
	}

	/**
	 * Selects given file in upload browser. 
	 * 
	 * 
	 * @author Michal Nowierski
	 * ** @param file Look at folder acceptancesrc/src/resources/ImagesForUploadTests
	 *  */
	public void TypeInFileToUploadPath(String file){
	sendKeys(BrowseForFileInput, System.getProperty("user.dir")+"\\src\\resources\\ImagesForUploadTests"+file);
	
	}

	public void verifyFilePreviewAppeared(String string) {
		waitForElementByElement(FilePreview);
	}

	public void CheckIgnoreAnyWarnings() {
		waitForElementByElement(IgnoreAnyWarnings);
		click(IgnoreAnyWarnings);
		
	}

	public void ClickOnUploadFile() {
		waitForElementByElement(UploadFileInput);
		click(UploadFileInput);
	}

	public void waitForFilePage(String file) {
		waitForStringInURL("File:"+file);
		
	}


}
