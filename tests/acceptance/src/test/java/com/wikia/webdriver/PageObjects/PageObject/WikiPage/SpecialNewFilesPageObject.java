package com.wikia.webdriver.PageObjects.PageObject.WikiPage;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

import com.wikia.webdriver.Common.Logging.PageObjectLogging;
import com.wikia.webdriver.PageObjects.PageObject.WikiBasePageObject;

public class SpecialNewFilesPageObject extends WikiBasePageObject{


	@FindBy(css="header[id='WikiaPageHeader'] a.wikia-button") 
	private WebElement AddAphotoButton;
	@FindBy(css="input[name='wpUploadFile']") 
	private WebElement BrowseForFileInput;
	@FindBy(css="div.step-1 input[value*='Upload']") 
	private WebElement UploadFileInput;
	@FindBy(css="div.advanced a") 
	private WebElement MoreOrFewerOptions;
	@FindBy(css="div.toggles input[name='wpIgnoreWarning']") 
	private WebElement IgnoreAnyWarnings;
	@FindBy(css="section[id='UploadPhotosWrapper']") 
	private WebElement UploadPhotoDialog;
	
	private String WikiaPreviewImgCssSelector = "div.wikia-gallery span.wikia-gallery-item img";

	public SpecialNewFilesPageObject(WebDriver driver, String Domain) {
		
		super(driver, Domain);
		
		PageFactory.initElements(driver, this);
	}


	
	public void ClickOnAddaPhoto() {
		waitForElementByElement(AddAphotoButton);
		AddAphotoButton.click();
		PageObjectLogging.log("ClickOnAddaPhoto", "Click on add a photo button", true, driver);
	}
	
	public void ClickOnUploadaPhoto() {
		waitForElementByElement(UploadFileInput);
		UploadFileInput.click();
		PageObjectLogging.log("ClickOnUploadaPhoto", "Click on upload a photo button", true, driver);
	}
	
	public void ClickOnMoreOrFewerOptions() {
		waitForElementByElement(MoreOrFewerOptions);
		MoreOrFewerOptions.click();
		PageObjectLogging.log("ClickOnMoreOrFewerOptions", "Click on More or Fewer options (depends on which of those two is currently visible)", true, driver);
		
	}
	public void CheckIgnoreAnyWarnings() {
		waitForElementByElement(IgnoreAnyWarnings);
		IgnoreAnyWarnings.click();
		PageObjectLogging.log("CheckIgnoreAnyWarnings", "Check 'Ignore Any Warnings' option", true, driver);
		
	}

	/**
	 * Selects given image in upload browser. 
	 * 
	 * @author Michal Nowierski
	 * ** @param file file to Be uploaded
	 * <p> Look at folder acceptancesrc/src/test/resources/ImagesForUploadTests - this is where those files are stored
	 *  */ 
	public void TypeInFileToUploadPath(String file){
	sendKeys(BrowseForFileInput, System.getProperty("user.dir")+"\\src\\test\\resources\\ImagesForUploadTests\\"+file);
	}

	public void waitForFile(String FileName) {
		driver.navigate().refresh();
		waitForValueToBePresentInElementsAttributeByCss(WikiaPreviewImgCssSelector, "src", FileName);
		PageObjectLogging.log("waitForFile", "Verify if "+FileName+" has been succesfully uploaded", true, driver);

		
	}













	
}
