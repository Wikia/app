package com.wikia.webdriver.pageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
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
	 * ** @param file file to Be uploaded
	 * <p> Look at folder acceptancesrc/src/test/resources/ImagesForUploadTests - this is where those files are stored
	 *  */ 
	
	public void TypeInFileToUploadPath(String file){
		PageObjectLogging.log("TypeInFileToUploadPath", "Type file "+file+" to Special:Upload upload path", true, driver);
		sendKeys(BrowseForFileInput, System.getProperty("user.dir")+"\\src\\test\\resources\\ImagesForUploadTests\\"+file);
	
	}

	public void verifyFilePreviewAppeared(String string) {
		PageObjectLogging.log("verifyFilePreviewAppeared", "Verify that file preview appeared", true, driver);
		waitForElementByElement(FilePreview);
	}

	public void CheckIgnoreAnyWarnings() {
		PageObjectLogging.log("CheckIgnoreAnyWarnings", "Check 'Ignore Any Warnings' option", true, driver);
		waitForElementByElement(IgnoreAnyWarnings);
		CommonFunctions.scrollToElement(IgnoreAnyWarnings);
//		CommonFunctions.scrollToElement(IgnoreAnyWarnings);
		IgnoreAnyWarnings.click();
		
	}

	public FilePageObject ClickOnUploadFile(String file) {
		PageObjectLogging.log("ClickOnUploadFile", "Click on Upload file button. The method returns FilePageObject", true, driver);
		waitForElementByElement(UploadFileInput);
		UploadFileInput.click();
		return new FilePageObject(driver, file);
	}




}
