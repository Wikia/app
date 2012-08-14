package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.google.common.io.FileBackedOutputStream;
import com.wikia.webdriver.Common.CommonFunctions;
import com.wikia.webdriver.pageObjects.PageObject.FilePageObject;
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
	sendKeys(BrowseForFileInput, System.getProperty("user.dir")+"\\src\\test\\resources\\ImagesForUploadTests\\"+file);
	
	}

	public void verifyFilePreviewAppeared(String string) {
		waitForElementByElement(FilePreview);
	}

	public void CheckIgnoreAnyWarnings() {
		waitForElementByElement(IgnoreAnyWarnings);
//		CommonFunctions.scrollToElement(IgnoreAnyWarnings);
		IgnoreAnyWarnings.click();
		
	}

	public FilePageObject ClickOnUploadFile(String file) {
		waitForElementByElement(UploadFileInput);
		UploadFileInput.click();
		return new FilePageObject(driver, file);
	}




}
