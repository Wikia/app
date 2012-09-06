package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Core.CommonFunctions;
import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.FilePageObject;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

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
		sendKeys(BrowseForFileInput, System.getProperty("user.dir")+"\\src\\test\\resources\\ImagesForUploadTests\\"+file);
		PageObjectLogging.log("TypeInFileToUploadPath", "Type file "+file+" to Special:Upload upload path", true, driver);
	
	}

	public void verifyFilePreviewAppeared(String string) {
		waitForElementByElement(FilePreview);
		PageObjectLogging.log("verifyFilePreviewAppeared", "Verify that file preview appeared", true, driver);
	}

	public void CheckIgnoreAnyWarnings() {
		waitForElementByElement(IgnoreAnyWarnings);
		CommonFunctions.scrollToElement(IgnoreAnyWarnings);
//		CommonFunctions.scrollToElement(IgnoreAnyWarnings);
		IgnoreAnyWarnings.click();
		PageObjectLogging.log("CheckIgnoreAnyWarnings", "Check 'Ignore Any Warnings' option", true, driver);
		
	}

	public FilePageObject ClickOnUploadFile(String file) {
		waitForElementByElement(UploadFileInput);
		UploadFileInput.click();
		PageObjectLogging.log("ClickOnUploadFile", "Click on Upload file button. The method returns FilePageObject", true, driver);
		return new FilePageObject(driver, file);
	}




}
